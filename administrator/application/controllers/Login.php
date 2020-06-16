<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');


// Deklarasi pembuatan class login
class Login extends CI_Controller {

  

    //konstruktor
    function __construct() {
        parent::__construct();
        
        

        // Jika session data dan username dan password sesuai dengan yang ada didalam database
        // maka halaman admin akan dibuka
        if($this->session->userdata('username') AND $this->session->userdata('password') AND $this->session->userdata('level') == 'admin') {
            redirect(base_url('admin'));
        }
        $this->load->model(array('Login_model'));
        
    }


    // Fungsi untuk menampilkan halaman utama login 
    function index() {
        $data['title'] = "Login page";
        $this->load->view('templates/header', $data);
        $this->load->view('login');
        $this->load->view('templates/footer'); // Menampilkan halaman utama login
    }

    // Fungsi untuk melakukan proses login
    function proses() {
        
        // Melakukan validasi input username dan password
        $this->form_validation->set_rules('username', 'username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'required|trim|xss_clean');
        
        // Jika validasi input username dan password bernilai false
        // maka user/admin diminta melakukan input ulang
        if($this->form_validation->run() == FALSE) {
          
            $data['title'] = "Login page";
        $this->load->view('templates/header', $data);
        $this->load->view('login');
        $this->load->view('templates/footer'); // Menampilkan halaman utama login 
        }
        // Jika validasi input username dan password bernilai false
        // maka user/admin diminta melakukan input ulang

        else {
            // input username dan password dengan fungsi post
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Memberi variable baru untuk input username dan password
            $user = $username;
            $pass = md5($password);

            // Melakukan cek ke database, apakah username dan password yang diinputkan sudah cocok atauu tidak
            $cek = $this->Login_model->cek($user, $pass);

            // Jika usernname dan password yang diinputkan cocok
            if($cek->num_rows() > 0){

                // Buat session username, email, dan level untuk nantinya ditampilkan
                foreach($cek->result() as $qad) {
                    $sess_data['username'] = $qad->username;
                    $sess_data['email'] = $qad->email;
                    $sess_data['level'] = $qad->level;
                    $this->session->set_userdata($sess_data);
                }

                if ($sess_data['level'] == 'admin') {
                    $this->session->set_flashdata('success', 'Login Berhasil !');
                    redirect(base_url('admin'));
                } else {
                    $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
                    redirect(base_url('login'));
                }
            }

            // Jika username dan password yang diinputkan tidak cocok
            // Maka akan muncul pesan 'Username atau Password yang anda masukkan salah'
            else{
                $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
                redirect(base_url('login'));
            }
        }

    }

}
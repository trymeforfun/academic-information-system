<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');


class Users extends CI_Controller{

    function __construct(){
        parent:: __construct();
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    function index(){
        
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }
        
        $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = array(
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $rowAdm->username,
            'email' => $rowAdm->email,
            'level' => $rowAdm->level,
        );
        $dataAdm['title'] = 'User list';
        $this->load->view('header_list', $dataAdm); 
        $this->load->view('users/users_list');
        $this->load->view('footer_list');
        
    }
    
    
    // Fungsi JSON
    public function json(){
        header('Content-Type: application/json');
        echo $this->Users_model->json();
    }
    
    // fungsi menampilkan create user 
    
    
    // Fungsi menampilkan form users
    public function update($id){
        // Jika data dan username tidak ada maka akan dialihkan kehalaman login 
        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }
        
        // menampilkan data berdasarkan id nya yaitu username
        $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = array(
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $rowAdm->username,
            'email' => $rowAdm->email,
            'level' => $rowAdm->level,
            'title' => 'Update User'
        );
        
        // Menampilkan data berdasarkan id nya yaitu username
        $row = $this->Users_model->get_by_id($id);
        
        // Jika idnya dipilih maka data tahun akademik semester ditampilkan kedalam menu users
        if($row){
            $data = array(
                'button' => ' Update',
                'back' => site_url('users'),
                'action' => site_url('users/update_action'),
                'username' => set_value('username', $row->username),
                'password' => set_value('password'),
                'email' => set_value('email', $row->email),
                'level' => set_value('level', $row->level),
                'blokir' => set_value('blokir', $row->blokir)
            );
            
            $this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data user
            $this->load->view('users/users_form', $data);
            $this->load->view('footer', $dataAdm);
            
        }
        // Jika  id nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
        else { $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
            
        }
        
    }
    
    // Fungsi untuk melakukan aksi update data
    public function update_action()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }
        
        $this->_rules(); // rules bahwa form harus diisi
        // Jika form users belum diisi dengan benar maka sistem akan meminta user untuk menginput ulang 
        if($this->form_validation->run() == FALSE ){
            $this->update($this->input->post('username', TRUE));
        } else {
            $data = array(
                'username' => $this->input->post('username', TRUE),
                'password' => md5($this->input->post('password', TRUE)),
                'email' => $this->input->post('email', TRUE),
                'level' => $this->input->post('level', TRUE),
                'blokir' => $this->input->post('blokir', TRUE),
                'id_sessions' => md5($this->input->post('password', TRUE))
            );
            
            $this->Users_model->update($this->input->post('username', TRUE), $data);
            $this->session->set_flashdata('message', 'Create record success');
            redirect(site_url('users'));
        }        
    }

    // Fungsi untuk melakukan upadate delete data berdasarkan id yang dipilih
    
    
    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan delete)
    public function _rules()
    {
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('level', 'level', 'trim|required');
        $this->form_validation->set_rules('blokir', 'blokir', 'trim|required');
        $this->form_validation->set_rules('username', 'username', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    
    
    
    
    
    
}

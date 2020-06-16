<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Auth extends CI_Controller{

    
    function index() {
        
        $data['title'] = "Login page";
        $this->load->view('templates/header', $data);
        $this->load->view('login');
        $this->load->view('templates/footer'); // Menampilkan halaman utama login

        
    }

    
    
    function registration(){

        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]|matches[password2]', 
        ['matches' => 'Password dont match!',
        'min_length' => 'Password too Short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');
        
        
        if ($this->form_validation->run() == false){
            $data['title'] = "Registration page";
            $this->load->view('templates/header', $data);
            $this->load->view('registration');
            $this->load->view('templates/footer');          
        } else {
            $data = [
            'username' => $this->input->post('username', TRUE),
                'password' => md5($this->input->post('password', TRUE)),
                'email' => $this->input->post('email', TRUE),
                'level' => user,
                'blokir' => N,
                'id_sessions' => md5($this->input->post('password', TRUE))
            ];

            $this->db->insert('users',$data);
            $this->session->set_flashdata('message','<div class = "alert alert-success" role="alert"> Your account has been registered! Please Login </div>'  );
            redirect('Auth/index');
        }

    }



}
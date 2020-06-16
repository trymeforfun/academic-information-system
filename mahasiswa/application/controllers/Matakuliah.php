<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Matakuliah extends CI_Controller 
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Matakuliah_model');
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }

        $row = $this->Users_model->get_by_id($this->session->userdata['username']);
        $data = [
            'title' => 'Matakuliah List',
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $row->username,
            'email' => $row->email,
            'level' => $row->level
        ];
        
        $this->load->view('header_list', $data);
        $this->load->view('matakuliah/matakuliah_list');
        $this->load->view('footer_list');
        
    }
    
    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Matakuliah_model->json();
    }


}
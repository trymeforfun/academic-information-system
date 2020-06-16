<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Admin extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('Users_model');
        // $this->load->library('form_validation');
        // $this->load->library('datatables');
    }

    function index(){
        $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = array(
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $rowAdm->username,
            'email' => $rowAdm->email,
            'level' => $rowAdm->level,
        );
        $this->load->view('beranda', $dataAdm);
        
    }
} 
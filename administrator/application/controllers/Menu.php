<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Menu extends CI_Controller{


    function __construct(){

        parent:: __construct();
        $this->load->model('Menu_model');
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
            'level' => $rowAdm->level
        );
        $dataAdm['title'] = 'Menu list';
        $this->load->view('header_list', $dataAdm); 
        $this->load->view('menu/menu_list');
        $this->load->view('footer_list');
        
    }

    public function json(){

        header('Content-Type: application/json');
        echo $this->Menu_model->json();

    }

    public function create(){
        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }

        $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = array(
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $rowAdm->username,
            'email' => $rowAdm->email,
            'level' => $rowAdm->level,
        );
        $dataAdm['title'] = 'Menu form';

        $data = [
            'button' => ' Create',
            'back' => site_url('menu'),
            'action' => site_url('menu/create_action'),
            'id_menu' => set_value('id_menu'),
            'nama_menu' => set_value('nama_menu'),
            'link' => set_value('link'),
            'icon' => set_value('icon'),
            'main_menu' => set_value('main_menu')
        ];

        $this->load->view('header', $dataAdm); 
        $this->load->view('menu/menu_form', $data);
        $this->load->view('footer');

    }

    public function create_action(){
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }
        $this->_rules(); // rules bahwa form harus diisi
        // Jika form users belum diisi dengan benar maka sistem akan meminta user untuk menginput ulang 
        if($this->form_validation->run() == FALSE ){
            $this->create();
        } else {
            $data = array(
                'nama_menu' => $this->input->post('nama_menu', TRUE),
                'link' => $this->input->post('link', TRUE),
                'icon' => $this->input->post('icon', TRUE),
                'main_menu' => $this->input->post('main_menu', TRUE)
            );
            
            $this->Menu_model->insert($data);
            $this->session->set_flashdata('message', 'Create record success');
            redirect(site_url('menu'));
        }
    }

        public function update($id){
            if(!isset($this->session->userdata['username'])){
                redirect(base_url('login'));
            }

            $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
            $dataAdm = array(
                'title' => 'Menu Update',
                'wa' => 'Web Administrator',
                'univ' => 'Universitas Harapan Kita',
                'username' => $rowAdm->username,
                'email' => $rowAdm->email,
                'level' => $rowAdm->level
                
            );
            $row = $this->Menu_model->get_by_id($id);

            if($row){
                $data = [
                    'button' => ' Update',
                    'back' => site_url('menu'),
                    'action' => site_url('menu/update_action'),
                    'id_menu' => set_value('id_menu', $row->id_menu),
                    'nama_menu' => set_value('nama_menu', $row->nama_menu),
                    'link' => set_value('link', $row->link),
                    'icon' => set_value('icon', $row->icon),
                    'main_menu' => set_value('main_menu', $row->main_menu)
                ];
                $this->load->view('header', $dataAdm); 
                $this->load->view('menu/menu_form', $data);
                $this->load->view('footer');
        
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
            }


        }

            public function update_action(){
                if(!isset($this->session->userdata['username'])){
                    redirect(base_url("login"));
                }
                
                $this->_rules(); // rules bahwa form harus diisi
                // Jika form users belum diisi dengan benar maka sistem akan meminta user untuk menginput ulang 
                if($this->form_validation->run() == FALSE ){
                    $this->update($this->input->post('username', TRUE));
                } else {
                    $data = array(
                        'nama_menu' => $this->input->post('nama_menu', TRUE),
                        'link' => $this->input->post('link', TRUE),
                        'icon' => $this->input->post('icon', TRUE),
                        'main_menu' => $this->input->post('blokir', TRUE),
                    );
                    
                    $this->Menu_model->update($this->input->post('id_menu', TRUE), $data);
                    $this->session->set_flashdata('message', 'Create record success');
                    redirect(site_url('users'));
                }        
            }

   public function delete($id) {

        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }

        $row = $this->Menu_model->get_by_id($id);

        // Jika id tersedia maka akan dihapus
        if($row){
            $this->Menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('menu'));
        }
        // Jika id yang akan dihapus tidak tersedia maka  akan muncul pesan error
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('menu'));
        }

    }
    
    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan delete)
    public function _rules()
    {
        $this->form_validation->set_rules('nama_menu', 'nama_menu', 'trim|required');
        $this->form_validation->set_rules('link', 'link', 'trim|required');
        $this->form_validation->set_rules('icon', 'icon', 'trim|required');
        $this->form_validation->set_rules('main_menu', 'main_menu', 'trim|required');
        $this->form_validation->set_rules('id_menu', 'id_menu', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }



}
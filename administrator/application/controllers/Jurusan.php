<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Jurusan extends CI_Controller {

    function __construct(){

        parent:: __construct();
        $this->load->model('Jurusan_model');
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->library('datatables'); 
    }

    public function index(){
        
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
        $dataAdm['title'] = 'Majors List';
        $this->load->view('header_list', $dataAdm); 
        $this->load->view('jurusan/jurusan_list');
        $this->load->view('footer_list');
        
    }

    public function json(){

        header('Content-Type: application/json');
        echo $this->Jurusan_model->json();

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
            'level' => $rowAdm->level
        );
        $dataAdm['title'] = 'Majors form';

        $data = [
            'button' => ' Create',
            'back' => site_url('jurusan'),
            'action' => site_url('jurusan/create_action'),
            'id_jurusan' => set_value('id_jurusan'),
            'kode_jurusan' => set_value('kode_jurusan'),
            'nama_jurusan' => set_value('nama_jurusan')
            
        ];

        $this->load->view('header', $dataAdm); 
        $this->load->view('jurusan/jurusan_form', $data);
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
                'kode_jurusan' => $this->input->post('kode_jurusan', TRUE),
                'nama_jurusan' => $this->input->post('nama_jurusan', TRUE),
                
            );
            
            $this->Jurusan_model->insert($data);
            $this->session->set_flashdata('message', 'Create record success');
            redirect(site_url('jurusan'));
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
            $row = $this->Jurusan_model->get_by_id($id);

            if($row){
                $data = [
                    'button' => ' Update',
                    'back' => site_url('jurusan'),
                    'action' => site_url('jurusan/update_action'),
                    'id_jurusan' => set_value('id_jurusan'),
                    'kode_jurusan' => set_value('kode_jurusan'),
                    'nama_jurusan' => set_value('nama_jurusan')
                ];
                $this->load->view('header', $dataAdm); 
                $this->load->view('jurusan/jurusan_form', $data);
                $this->load->view('footer');
        
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jurusan'));
            }


        }

            public function update_action(){
                if(!isset($this->session->userdata['username'])){
                    redirect(base_url("login"));
                }
                
                $this->_rules(); // rules bahwa form harus diisi
                // Jika form users belum diisi dengan benar maka sistem akan meminta user untuk menginput ulang 
                if($this->form_validation->run() == FALSE ){
                    $this->update($this->input->post('id_jurusan', TRUE));
                } else {
                    $data = array(
                        'kode_jurusan' => $this->input->post('kode_jurusan', TRUE),
                        'nama_jurusan' => $this->input->post('nama_jurusan', TRUE)
                        
                    );
                    
                    $this->Jurusan_model->update($this->input->post('id_jurusan', TRUE), $data);
                    $this->session->set_flashdata('message', 'Create record success');
                    redirect(site_url('jurusan'));
                }        
            }

   public function delete($id) {

        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }

        $row = $this->Jurusan_model->get_by_id($id);

        // Jika id tersedia maka akan dihapus
        if($row){
            $this->Jurusan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jurusan'));
        }
        // Jika id yang akan dihapus tidak tersedia maka  akan muncul pesan error
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jurusan'));
        }

    }
    
    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan delete)
    public function _rules()
    {
        $this->form_validation->set_rules('nama_jurusan', 'nama_jurusan', 'trim|required');
        $this->form_validation->set_rules('kode_jurusan', 'kode_jurusan', 'trim|required');
        $this->form_validation->set_rules('id_jurusan', 'id_jurusan', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }




}
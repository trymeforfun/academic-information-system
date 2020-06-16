<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Prodi extends CI_Controller 
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Prodi_model');
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
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $row->username,
            'email' => $row->email,
            'level' => $row->level
        ];
        
        $this->load->view('header_list', $data);
        $this->load->view('prodi/prodi_list');
        $this->load->view('footer_list');
        
    }
    
    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Prodi_model->json();
    }
    
    public function create()
    {
        if(!isset($this->session->userdata['username'])){
                    redirect(base_url("login"));
        }
        $row = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = [
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $row->username,
            'email' => $row->email,
            'level' => $row->level
        ];

        $data = [
            'button' => ' Create',
            'back' => site_url('prodi'),
            'action' => site_url('prodi/create_action'),
            'id_prodi' => set_value('id_prodi'),
            'kode_prodi' => set_value('kode_prodi'),
            'nama_prodi' => set_value('nama_prodi'),
            'id_jurusan' => set_value('id_jurusan')
        ];

        $this->load->view('header', $dataAdm);
        $this->load->view('prodi/prodi_form', $data);
        $this->load->view('footer');
        
    }

    public function create_action()
    {
        if(!isset($this->session->userdata['username'])){
                    redirect(base_url("login"));
        }
        $this->_rules();
        
        if($this->form_validation->run() == FALSE){
            $this->create();
        } else {
            $data = [
                'id_prodi' => $this->input->post('id_prodi', TRUE),
                'kode_prodi' => $this->input->post('kode_prodi', TRUE),
                'nama_prodi' => $this->input->post('nama_prodi', TRUE),
                'id_jurusan' => $this->input->post('id_jurusan', TRUE)
            ];

            $this->Prodi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Succes' );
            redirect(site_url('prodi'));
        }

    }

    public function update($id) {

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
            $row = $this->Prodi_model->get_by_id($id);

            if($row){
                $data = [
                    'button' => ' Update',
                    'back' => site_url('prodi'),
                    'action' => site_url('prodi/update_action'),
                    'id_prodi' => set_value('id_prodi'),
                    'kode_prodi' => set_value('kode_prodi'),
                    'nama_prodi' => set_value('nama_prodi'),
                    'id_jurusan' => set_value('id_jurusan')
                ];
                $this->load->view('header', $dataAdm); 
                $this->load->view('prodi/prodi_form', $data);
                $this->load->view('footer');
        
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prodi'));
            }


        }

            public function update_action(){
                if(!isset($this->session->userdata['username'])){
                    redirect(base_url("login"));
                }
                
                $this->_rules(); // rules bahwa form harus diisi
                // Jika form users belum diisi dengan benar maka sistem akan meminta user untuk menginput ulang 
                if($this->form_validation->run() == FALSE ){
                    $this->update($this->input->post('id_prodi', TRUE));
                } else {
                    $data = array(

                        'id_prodi' => $this->input->post('id_prodi', TRUE),
                        'kode_prodi' => $this->input->post('kode_prodi', TRUE),
                        'nama_jurusan' => $this->input->post('nama_jurusan', TRUE),
                        'id_jurusan' => $this->input->post('id_jurusan', TRUE)
                        
                    );
                    
                    $this->Prodi_model->update($this->input->post('id_prodi', TRUE), $data);
                    $this->session->set_flashdata('message', 'Create record success');
                    redirect(site_url('prodi'));
                }        
            }

   public function delete($id) {

        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }

        $row = $this->Prodi_model->get_by_id($id);

        // Jika id tersedia maka akan dihapus
        if($row){
            $this->Prodi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('prodi'));
        }
        // Jika id yang akan dihapus tidak tersedia maka  akan muncul pesan error
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('prodi'));
        }

    }
    
    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan delete)
    public function _rules()
    {
        $this->form_validation->set_rules('id_prodi', 'id_prodi', 'trim|required');
        $this->form_validation->set_rules('nama_prodi', 'nama_prodi', 'trim|required');
        $this->form_validation->set_rules('kode_prodi', 'kode_prodi', 'trim|required');
        $this->form_validation->set_rules('id_jurusan', 'id_jurusan', 'trim|required');
        $this->form_validation->set_rules('id_prodi', 'id_prodi', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

        
        
    



}
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
    
    public function read($id)
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }
        
        $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
        $dataAdm = [
            'wa' => 'Web Administrator',
            'univ' => 'Universitas Harapan Kita',
            'username' => $rowAdm->username,
            'email' => $rowAdm->email,
            'level' => $rowAdm->level
        ];

        $sql = "SELECT * FROM prodi, matakuliah WHERE prodi.id_prodi = matakuliah.id_prodi AND matakuliah.kode_matakuliah = '$id'";
        
        $row = $this->db->query($sql)->row();
        
        if($row){
            $data = [
                'button' => ' Read',
                'back' => site_url('matakuliah'),
                'kode_matakuliah' => $row->kode_matakuliah,
                'nama_matakuliah' => $row->nama_matakuliah,
                'sks' => $row->sks,
                'semester' => $row->semester,
                'jenis' => $row->jenis,
                'nama_prodi' => $row->nama_prodi,
            ];
            
                    $this->load->view('header', $dataAdm);
                    $this->load->view('matakuliah/matakuliah_read', $data);
                    $this->load->view('footer');

            
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matakuliah'));
        }
        
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
            'back' => site_url('matakuliah'),
            'action' => site_url('matakuliah/create_action'),
            'kode_matakuliah' => set_value('kode_matakuliah'),
            'nama_matakuliah' => set_value('nama_matakuliah'),
            'sks' => set_value('sks'),
            'semester' => set_value('semester'),
            'jenis' => set_value('jenis'),
            'id_prodi' => set_value('id_prodi'),
        ];

        $this->load->view('header', $dataAdm);
        $this->load->view('matakuliah/matakuliah_form', $data);
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
                'kode_matakuliah' => $this->input->post('kode_matakuliah', TRUE),
                'nama_matakuliah' => $this->input->post('nama_matakuliah', TRUE),
                'sks' => $this->input->post('sks', TRUE),
                'semester' => $this->input->post('semester', TRUE),
                'jenis' => $this->input->post('jenis', TRUE),
                'id_prodi' => $this->input->post('id_prodi', TRUE)
            ];

            $this->Matakuliah_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Succes' );
            redirect(site_url('matakuliah'));
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
            $row = $this->Matakuliah_model->get_by_id($id);

            if($row){
                $data = [
                    'button' => ' update',
                    'back' => site_url('matakuliah'),
                    'action' => site_url('matakuliah/update_action'),
                    'kode_matakuliah' => set_value('kode_matakuliah'),
                    'nama_matakuliah' => set_value('nama_matakuliah'),
                    'sks' => set_value('sks'),
                    'semester' => set_value('semester'),
                    'jenis' => set_value('jenis'),
                    'id_prodi' => set_value('id_prodi'),
                ];
                $this->load->view('header', $dataAdm); 
                $this->load->view('matakuliah/matakuliah_form', $data);
                $this->load->view('footer');
        
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matakuliah'));
            }


        }

            public function update_action(){
                if(!isset($this->session->userdata['username'])){
                    redirect(base_url("login"));
                }
                
                $this->_rules(); // rules bahwa form harus diisi
                // Jika form users belum diisi dengan benar maka sistem akan meminta user untuk menginput ulang 
                if($this->form_validation->run() == FALSE ){
                    $this->update($this->input->post('kode_matakuliah', TRUE));
                } else {
                    $data = array(
                        'kode_matakuliah' => $this->input->post('kode_matakuliah', TRUE),
                        'nama_matakuliah' => $this->input->post('nama_matakuliah', TRUE),
                        'sks' => $this->input->post('sks', TRUE),
                        'semester' => $this->input->post('semester', TRUE),
                        'jenis' => $this->input->post('jenis', TRUE),
                        'id_prodi' => $this->input->post('id_prodi', TRUE)
                        
                    );
                    
                    $this->Matakuliah_model->update($this->input->post('kode_matakuliah', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update record success');
                    redirect(site_url('matakuliah'));
                }        
            }

   public function delete($id) {

        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }

        $row = $this->Matakuliah_model->get_by_id($id);

        // Jika id tersedia maka akan dihapus
        if($row){
            $this->Matakuliah_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('matakuliah'));
        }
        // Jika id yang akan dihapus tidak tersedia maka  akan muncul pesan error
        else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matakuliah'));
        }

    }
    
    // Fungsi rules atau aturan untuk pengisian pada form (create/input dan delete)
    public function _rules()
    {
        $this->form_validation->set_rules('kode_matakuliah', 'kode_matakuliah', 'trim|required');
        $this->form_validation->set_rules('nama_matakuliah', 'nama_matakuliah', 'trim|required');
        $this->form_validation->set_rules('sks', 'sks', 'trim|required');
        $this->form_validation->set_rules('semester', 'semester', 'trim|required');
        $this->form_validation->set_rules('jenis', 'jenis', 'trim|required');
        $this->form_validation->set_rules('id_prodi', 'id_prodi', 'trim|required');
        $this->form_validation->set_rules('kode_matakuliah', 'kode_matakuliah', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

        
        
    



}
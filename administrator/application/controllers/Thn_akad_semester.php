<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Thn_akad_semester extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Thn_akad_semester_model');
        $this->load->model('Users_model');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
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
        $dataAdm['title'] = 'Academic Year';
        $this->load->view('header_list', $dataAdm); 
        $this->load->view('thn_akad_semester/thn_akad_semester_list');
        $this->load->view('footer_list');      
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Thn_akad_semester_model->json();
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
            'back' => site_url('thn_akad_semester'),
            'action' => site_url('thn_akad_semester/create_action'),
            'id_thn_akad' => set_value('id_thn_akad'),
            'thn_akad' => set_value('thn_akad'),
            'semester' => set_value('semester'),
        ];
        
        $this->load->view('header', $dataAdm);
        $this->load->view('thn_akad_semester/thn_akad_semester_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }
        
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = [
                'thn_akad' => $this->input->post('thn_akad', TRUE),
                'semester' => $this->input->post('semester', TRUE)
            ];
            
            $this->Thn_akad_semester_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Succes');
            redirect(site_url('thn_akad_semester'));
        }
    }
    
    public function update($id)
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
        
        $row = $this->Thn_akad_semester_model->get_by_id($id);
        
        if ($row) {
            $data = [
                'button' => ' Update',
                'back' => site_url('thn_akad_semester'),
                'action' => site_url('thn_akad_semester/update_action'),
                'id_thn_akad' => set_value('id_thn_akad', $row->id_thn_akad),
                'thn_akad' => set_value('thn_akad', $row->thn_akad),
                'semester' => set_value('semester', $row->semester),
            ];
            
            $this->load->view('header', $dataAdm);
            $this->load->view('thn_akad_semester/thn_akad_semester_form', $data);
            $this->load->view('footer');
        }
    }
    
    public function update_action()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }
        
        $this->_rules();
        
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_thn_akad', TRUE));
        } else {
            $data = [
                'thn_akad' => $this->input->post('thn_akad', TRUE),
                'semester' => $this->input->post('semester', TRUE)
            ];
            
            $this->Thn_akad_semester_model->update($this->input->post('id_thn_akad') ,$data);
            $this->session->set_flashdata('message', 'Update Record Succes');
            redirect(site_url('thn_akad_semester'));
            
        }
        
    }
    
    public function aktif_action($id)
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }
        
        $row = $this->Thn_akad_semester_model->get_by_id($id);
        
        if ($row) {
            $this->Thn_akad_semester_model->update_tidakAktif($id);
            $this->Thn_akad_semester_model->update_aktif($id);
            
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('thn_akad_semester'));
        } else {
            
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thn_akad_semester'));
            
        }
    }
    
    public function delete($id)
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url("login"));
        }

        $row = $this->Thn_akad_semester_model->get_by_id($id);

        // Jika id tersedia maka akan dihapus
        if($row){
            $this->Thn_akad_semester_model->delete($id);
                $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('thn_akad_semester'));
            
        // Jika id yang akan dihapus tidak tersedia maka  akan muncul pesan error
        }else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thn_akad_semester'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('thn_akad', 'thn_akad', 'trim|required');
        $this->form_validation->set_rules('semester', 'semester', 'trim|required');
        $this->form_validation->set_rules('id_thn_akad', 'id_thn_akad', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
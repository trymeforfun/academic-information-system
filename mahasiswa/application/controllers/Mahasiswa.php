<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->load->model('Users_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->library('datatables');
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
        $dataAdm['title'] = 'Majors List';
        $this->load->view('header_list', $dataAdm); 
        $this->load->view('mahasiswa/mahasiswa_list');
        $this->load->view('footer_list');      
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Mahasiswa_model->json();
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

        $row = $this->Mahasiswa_model->get_by_id($id);
        
        if($row){
            $data = [
                'button' => ' Read',
                'back' => site_url('mahasiswa'),
                'nim' => $row->nim,
                'nama_lengkap' => $row->nama_lengkap,
                'nama_panggilan' => $row->nama_panggilan,
                'alamat' => $row->alamat,
                'email' => $row->email,
                'telp' => $row->telp,
                'tempat_lahir' => $row->tempat_lahir,
                'tgl_lahir' => $row->tgl_lahir,
                'jenis_kelamin' => $row->jenis_kelamin,
                'agama' => $row->agama,
                'photo' => $row->photo,
                'id_prodi' => $row->id_prodi,
            ];
            
                    $this->load->view('header', $dataAdm);
                    $this->load->view('mahasiswa/mahasiswa_read', $data);
                    $this->load->view('footer');

            
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mahasiswa'));
        }
        
    }

   
        
        public function update($id)
        {
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
            
            $row = $this->Mahasiswa_model->get_by_id($id);
            
            if ($row) {
                $data = [
                    'button' => ' Update',
                    'back' => site_url('mahasiswa'),
                    'action' => site_url('mahasiswa/update_action'),
                    'nim' => set_value('nim', $row->nim),
                    'nama_lengkap' => set_value('nama_lengkap', $row->nama_lengkap),
                    'nama_panggilan' => set_value('nama_panggilan', $row->nama_panggilan),
                    'alamat' => set_value('alamat', $row->alamat),
                    'email' => set_value('email', $row->email),
                    'telp' => set_value('telp', $row->telp),
                    'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
                    'tgl_lahir' => set_value('tgl_lahir', $row->tgl_lahir),
                    'agama' => set_value('agama', $row->agama),
                    'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
                    'photo' => set_value('photo', $row->photo),
                    'id_prodi' => set_value('id_prodi', $row->id_prodi),
                ];
                
                $this->load->view('header', $dataAdm);
                $this->load->view('mahasiswa/mahasiswa_form', $data);
                $this->load->view('footer');
                
            } else {
                $this->session->set_flashdata('message', 'Record Not Found');
                redirect(site_url('mahasiswa'));
            }
        }

        public function update_action()
        {
            if(!isset($this->session->userdata['username'])){
                redirect(base_url("login"));
            }
            
            $this->_rules();

            if ($this->form_validation->run() == FALSE) {
                $this->update($this->input->post('nim', TRUE));
            } else {
                $config['upload_path'] = './images/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name'] = url_title($this->input->post('nim'));
            
            $this->upload->initialize($config);
            
            if(!empty($_FILES['photo']['name'])){

                unlink("./images/". $this->input->post('photo'));

                if($this->upload->do_upload('photo')){
                    $photo = $this->upload->data();
                    $dataphoto = $photo['file_name'];
                    $this->load->library('upload', $config);
                    $data = [
                        'nim' => $this->input->post('nim', TRUE),
                        'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                        'nama_panggilan' => $this->input->post('nama_panggilan', TRUE),
                        'alamat' => $this->input->post('alamat', TRUE),
                        'email' => $this->input->post('email', TRUE),
                        'telp' => $this->input->post('telp', TRUE),
                        'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                        'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
                        'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                        'agama' => $this->input->post('agama', TRUE),
                        'photo' => $dataphoto,
                        'id_prodi' => $this->input->post('id_prodi', TRUE),
                    ];

                    $this->Mahasiswa_model->update($this->input->post('nim', TRUE), $data);
                } 
                
                $this->session->set_flashdata('message', 'Update Record Success');
                redirect(site_url('mahasiswa'));
            } else {
                $data = [
                    'nim' => $this->input->post('nim', TRUE),
                    'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                    'nama_panggilan' => $this->input->post('nama_panggilan', TRUE),
                    'alamat' => $this->input->post('alamat', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'telp' => $this->input->post('telp', TRUE),
                    'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                    'tgl_lahir' => $this->input->post('tgl_lahir', TRUE),
                    'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                    'agama' => $this->input->post('agama', TRUE),
                    'id_prodi' => $this->input->post('id_prodi', TRUE),
                ];
                $this->Mahasiswa_model->update($this->input->post('nim', TRUE), $data);
                $this->session->set_flashdata('message', 'Update Record Success');
                redirect(site_url('mahasiswa'));
          }
        }   
     }       
     
     

     public function _rules()
    {
        $this->form_validation->set_rules('nim', 'nim', 'trim|required');
        $this->form_validation->set_rules('nama_lengkap', 'nama_lengkap', 'trim|required');
        $this->form_validation->set_rules('nama_panggilan', 'nama_panggilan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('telp', 'telp', 'trim|required');
        $this->form_validation->set_rules('tempat_lahir', 'tempat_lahir', 'trim');
        $this->form_validation->set_rules('tgl_lahir', 'tgl_lahir', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'trim|required');
        $this->form_validation->set_rules('agama', 'agama', 'trim|required');
        $this->form_validation->set_rules('id_prodi', 'id_prodi', 'trim|required');
        $this->form_validation->set_rules('nim', 'nim', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
        
 }
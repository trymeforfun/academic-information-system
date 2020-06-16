<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Krs extends CI_Controller 
{   
    

    function __construct()
    {
        parent::__construct();
        $this->load->model('Krs_model');
        $this->load->model('Mahasiswa_model');
        $this->load->model('Prodi_model');
        $this->load->model('Users_model');
        $this->load->model('Thn_akad_semester_model');
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
        
        $data = [
            'button' => ' Proses',
            'back' =>   site_url('krs'),
            'action' => site_url('krs/krs_action'),
            'nim' => set_value('nim'),
            'id_thn_akad' => set_value('id_thn_akad')
        ];

        $dataAdm['title'] = 'KRS';
        $this->load->view('header', $dataAdm); 
        $this->load->view('krs/mhs_form', $data);
        $this->load->view('footer');      
    }
    
    public function krs_action()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }
        
        $this->_rulesKrs();
        
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $nim = $this->input->post('nim', TRUE);
            $thn_akad = $this->input->post('id_thn_akad', TRUE);
            
            if ($this->Mahasiswa_model->get_by_id($nim) == null) {
                exit ('Nomor Mahasiswa ini belum terdaftar');
            }
            
            $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
            $dataAdm = array(
                'wa' => 'Web Administrator',
                'univ' => 'Universitas Harapan Kita',
                'username' => $rowAdm->username,
                'email' => $rowAdm->email,
                'level' => $rowAdm->level
            );
            
            $data = [
                'action' => site_url('krs/daftar_krs_action'),
                'nim' => $nim,
                'id_thn_akad' => $thn_akad,
                'nama_lengkap' => $this->Mahasiswa_model->get_by_id($nim)->nama_lengkap
            ];
            
            $dataKrs = [
                'button' => 'Create',
                'back' => site_url('krs'),
                'krs_data' => $this->baca_krs($nim, $thn_akad),
                'nim' => $nim,
                'id_thn_akad' => $thn_akad,
                'thn_akad' => $this->Thn_akad_semester_model->get_by_id($thn_akad)->thn_akad,
                'semester' => $this->Thn_akad_semester_model->get_by_id($thn_akad)->semester==1?'Ganjil':'Genap',
                'nama_lengkap' => $this->Mahasiswa_model->get_by_id($nim)->nama_lengkap,
                'prodi' => $this->Prodi_model->get_by_id($this->Mahasiswa_model->get_by_id($nim)->id_prodi)->nama_prodi
            ];
            
            $this->load->view('header', $dataAdm);
            $this->load->view('krs/krs_list', $dataKrs);
            $this->load->view('footer');
        }
        
    }
    
    public function baca_krs($nim,$thn_akad)
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }
        
        $this->db->select('k.id_krs,k.kode_matakuliah,m.nama_matakuliah,m.sks');
            $this->db->from('krs as k');
            $this->db->where('k.nim', $nim);
            $this->db->where('k.id_thn_akad', $thn_akad);
            $this->db->join('matakuliah as m', 'm.kode_matakuliah = k.kode_matakuliah');
            $krs = $this->db->get()->result();
            return $krs;
        }
        
        public function _rulesKrs()
        {
            $this->form_validation->set_rules('nim', 'nim', 'trim|required|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('id_thn_akad', 'id_thn_akad', 'trim|required');
        }
        
        public function create($nim, $th)
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
            
            $data = [
                'judul' => 'Tambah',
                'button' => 'Create',
                'back' => site_url('krs'),
                'action' => site_url('krs/create_action'),
                'id_krs' => set_value('id_krs'),
                'id_thn_akad' => $th,
                'thn_akad_smt' => $this->Thn_akad_semester_model->get_by_id($th)->thn_akad,
                'semester' => $this->Thn_akad_semester_model->get_by_id($th)->semester==1?'Ganjil':'Genap',
                'nim' => $nim,
                'kode_matakuliah' => set_value('kode_matakuliah')
            ];
            
            $this->load->view('header', $dataAdm);
            $this->load->view('krs/krs_form', $data);
            $this->load->view('footer');
        }
        
        public function create_action()
        {
            if(!isset($this->session->userdata['username'])){
                redirect(base_url('login'));
            }
            
            $this->_rules();
            
            if ($this->form_validation->run() == FALSE) {
                $this->create($this->input->post('nim', TRUE), $this->input->post('id_thn_akad', TRUE));
            } else {
                $nim = $this->input->post('nim', TRUE);
                $thn_akad = $this->input->post('id_thn_akad', TRUE);
                $kode_matakuliah = $this->input->post('id_kode_matakuliah', TRUE);
                
                $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
                $dataAdm = array(
                    'wa' => 'Web Administrator',
                    'univ' => 'Universitas Harapan Kita',
                    'username' => $rowAdm->username,
                    'email' => $rowAdm->email,
                    'level' => $rowAdm->level
                );
                
                $data = [
                    'action' => site_url('krs/daftar_krs_action'),
                    'nim' => $nim,
                    'id_thn_akad' => $thn_akad,
                    'kode_matakuliah' => $kode_matakuliah
                ];
                
                $this->Krs_model->insert($data);
                
                $dataKrs = [
                    'button' => 'Create',
                    'back' => site_url('krs'),
                    'krs_data' => $this->baca_krs($nim, $thn_akad),
                'nim' => $nim,
                'id_thn_akad' => $thn_akad,
                'thn_akad' => $this->Thn_akad_semester_model->get_by_id($thn_akad)->thn_akad,
                'semester' => $this->Thn_akad_semester_model->get_by_id($thn_akad)->semester==1?'Ganjil':'Genap',
                'nama_lengkap' => $this->Mahasiswa_model->get_by_id($nim)->nama_lengkap,
                'prodi' => $this->Prodi_model->get_by_id($this->Mahasiswa_model->get_by_id($nim)->id_prodi)->nama_prodi
            ];
            $this->session->set_flashdata('message', 'Create Record Succes');
            
            $this->load->view('header', $dataAdm);
            $this->load->view('krs/krs_list', $dataKrs);
            $this->load->view('footer');
            
            
        }
        
        
    }
    
    public function update($id)
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
        
        $row = $this->Krs_model->get_by_id($id);
        $th = $row->id_thn_akad;
        
        if ($row) {
            $data = [
                'judul' => 'Ubah',
                'button' => 'Update',
                'back' => site_url('krs'),
                    'action' => site_url('krs/update_action'),
                    'id_krs' => set_value('id_krs', $row->id_krs),
                    'id_thn_akad' => set_value('id_thn_akad', $row->id_thn_akad),
                    'nim' => set_value('nim', $row->nim),
                    'kode_matakuliah' => set_value('kode_matakuliah', $row->kode_matakuliah),
                    'thn_akad_smt' => $this->Thn_akad_semester_model->get_by_id($th)->thn_akad,
                    'semester' => $this->Thn_akad_semester_model->get_by_id($th)->semester==1?'Ganjil':'Genap',
                ];
                
                        $this->load->view('header', $dataAdm);
                        $this->load->view('krs/krs_form', $data);
                        $this->load->view('footer');
                    } else {
                        $this->session->set_flashdata('message', 'Record Not Found');
                    }
                    
                }
                
                public function update_action()
                {
                    if(!isset($this->session->userdata['username'])){
                        redirect(base_url('login'));
                    }
                    
                $this->_rules();
                
                if ($this->form_validation->run() == FALSE) {
                    $this->update($this->input->post('id_krs', TRUE));
                } else {
                    $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
                    $dataAdm = array(
                        'wa' => 'Web Administrator',
                        'univ' => 'Universitas Harapan Kita',
                        'username' => $rowAdm->username,
                        'email' => $rowAdm->email,
                        'level' => $rowAdm->level
                    );
                    
                    $id_krs = $this->input->post('id_krs', TRUE);
                    $nim = $this->input->post('nim', TRUE);
                    $id_thn_akad = $this->input->post('id_thn_akad', TRUE);
                    $kode_mk = $this->input->post('id_kode_matakuliah', TRUE);

                    $data = [
                        'id_krs' => $id_krs,
                        'id_thn_akad' => $id_thn_akad,
                        'nim' => $nim,
                        'kode_matakuliah' => $kode_mk,
                    ];
                    
                    $this->Krs_model->update($id_krs, $data);
                    $this->session->set_flashdata('message', 'Update Record Succes');

                    $dataKrs = [
                        'krs_data' =>$this->baca_krs($nim,$id_thn_akad),
                        'nim' => $nim,
                        'id_thn_akad' => $id_thn_akad,
                        'thn_akad' => $this->Thn_akad_semester_model->get_by_id($id_thn_akad)->thn_akad,
                        'semester' => $this->Thn_akad_semester_model->get_by_id($id_thn_akad)->semester==1?'Ganjil':'Genap',
                        'nama_lengkap' => $this->Mahasiswa_model->get_by_id($nim)->nama_lengkap,
                        'prodi' => $this->Prodi_model->get_by_id($this->Mahasiswa_model->get_by_id($nim)->id_prodi)->nama_prodi
                    ];

                    $this->load->view('header', $dataAdm);
                    $this->load->view('krs/krs_list', $dataKrs);
                    $this->load->view('footer');
                }    
            }
            
            public function delete($id)
            {
                if(!isset($this->session->userdata['username'])){
                    redirect(base_url('login'));
                }

                $row = $this->Krs_model->get_by_id($id);
                $nim = $this->Krs_model->get_by_id($id)->nim;
                $id_thn_akad = $this->Krs_model->get_by_id($id)->id_thn_akad;

                if ($row) {
                    $this->Krs_model->delete($id);
                    $this->session->set_flashdata('message', 'Delete Record Success');
                } else {
                    $this->session->set_flashdata('message', 'Record Not Found');
                }

                $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
                $dataAdm = array(
                    'wa' => 'Web Administrator',
                    'univ' => 'Universitas Harapan Kita',
                    'username' => $rowAdm->username,
                    'email' => $rowAdm->email,
                    'level' => $rowAdm->level
                );

                
                $dataKrs = [
                    'button' => 'Tambah',
                    'back' => site_url('krs'),
                    'krs_data' =>$this->baca_krs($nim,$id_thn_akad),
                    'nim' => $nim,
                    'id_thn_akad' => $id_thn_akad,
                    'thn_akad' => $this->Thn_akad_semester_model->get_by_id($id_thn_akad)->thn_akad,
                    'semester' => $this->Thn_akad_semester_model->get_by_id($id_thn_akad)->semester==1?'Ganjil':'Genap',
                    'nama_lengkap' => $this->Mahasiswa_model->get_by_id($nim)->nama_lengkap,
                    'prodi' => $this->Prodi_model->get_by_id($this->Mahasiswa_model->get_by_id($nim)->id_prodi)->nama_prodi
                ];

                $this->load->view('header', $dataAdm);
                $this->load->view('krs/krs_list', $dataKrs);
                $this->load->view('footer');

            }

            public function _rules()
            {
                $this->form_validation->set_rules('nim', 'nim', 'trim|required');
                $this->form_validation->set_rules('kode_matakuliah', 'kode_matakuliah', 'trim|required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
            }
            
            
        
            
        }
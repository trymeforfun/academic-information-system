<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Nilai extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Transkrip_model');
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->helper('my_function');
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
            'button' => 'Proses',
            'action' => site_url('nilai/nilaiKhs_action'),
            'nim' => set_value('nim'),
            'id_thn_akad' => set_value('id_thn_akad')
        ];
        
        $this->load->view('header', $dataAdm); 
        $this->load->view('nilai/nilaiKhs_form', $data);
        $this->load->view('footer');
    }
    
    public function nilaiKhs_action()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }

        $this->_rulesKhs();

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $nim = $this->input->post('nim', TRUE);
            $thn_akad = $this->input->post('id_thn_akad', TRUE);

            $sql = "SELECT krs.id_thn_akad
                        ,  krs.kode_matakuliah
                        ,  matakuliah.nama_matakuliah
                        ,  matakuliah.sks
                        ,  krs.nilai
                    FROM krs
                    INNER JOIN matakuliah
                    ON (krs.kode_matakuliah = matakuliah.kode_matakuliah)
                    WHERE krs.nim = $nim AND krs,id_thn_akad = $thn_akad";

            $query = $this->db->query($sql)->result();

            $smt = $this->db->select('thn_akad, semester')
                        ->from('thn_akad_semester')
                        ->where(array('id_thn_akad' => $thn_akad))->get->row();

            $query_str = "SELECT mahasiswa.nim
                               , mahasiswa.nama_lengkap
                               , prodi.nama_prodi
                          FROM mahasiswa 
                          INNER JOIN prodi
                          ON (mahasiswa.id_prodi = prodi.id_prodi);";
            
            $mhs = $this->db->query($query_str)->row();

            if ($smt->semester == 1) {
                $tampilSemester = "Ganjil";
            } else {
                $tampilSemester = "Genap";
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
                'button' => ' Detail',
                'back' => site_url('nilai'),
                'mhs_data' => $nim,
                'mhs_nama' => $mhs->nama_lengkap,
                'mhs_prodi'=> $mhs->nama_prodi,
                'thn_akad' => $smt->thn_akad."(". $tampilSemester .")"
            ];

            $this->load->view('header', $dataAdm); 
            $this->load->view('nilai/Khs', $data);
            $this->load->view('footer');
        }
    }

    public function _rulesKhs()
    {
        $this->form_validation->set_rules('nim', 'nim', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('id_thn_akad', 'id_thn_akad', 'trim|required');
    }
    
    public function rulesTranskrip()
    {
        $this->form_validation->set_rules('nim', 'nim', 'trim|required|min_length[10]|max_length[10]');
    }

    public function buatTranskrip()
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
            'button' => 'Proses',
            'action' => site_url('nilai/buatTranskrip_action'),
            'nim' => set_value('nim'),
        ];
        
        $this->load->view('header', $dataAdm); 
        $this->load->view('nilai/buatTranskrip_form', $data);
        $this->load->view('footer');
    }
    
    public function buatTranskrip_action()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }
        $this->_rulesTranskrip();
        if ($this->form_validation->run() == FALSE) {
            $this->buatTranskrip();
        } else {
            $nim = $this->input->post('nim', TRUE);

            $this->db->select('*');
            $this->db->from('krs');
            $this->where('nim', $nim);

            $query = $this->db->get();
            foreach ($query->result() as $value) {
                cekNilai($value->nim, $value->kode_matakuliah, $value->nilai);
            }

            $this->db->select('t.kode_matakuliah,m.kode_matakuliah,m.sks,t.nilai');
            $this->db->from('transkrip as t');
            $this->db->join('matakuliah as m', 'm.kode_matakuliah = t.kode_matakuliah');
            $trans = $this->db->get()->result();

            $mhs = $this->db->select('nama_lengkap,id_prodi')
                            ->from('mahasiswa')
                            ->where(['nim'=>$nim])
                            ->get()->row();

            $prodi = $this->db->select('nama_prodi')
                              ->from('prodi')
                              ->where(['id_prodi'=>$mhs->id_prodi])
                              ->get()->row()->nama_prodi;
            
            $data = [
                'trans' => $trans,
                'nim' => $nim,
                'nama' => $mhs->nama_lengkap,
                'prodi' => $prodi
            ];
            
            $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
            $dataAdm = array(
                'wa' => 'Web Administrator',
                'univ' => 'Universitas Harapan Kita',
                'username' => $rowAdm->username,
                'email' => $rowAdm->email,
                'level' => $rowAdm->level
            );

            $this->load->view('header', $dataAdm); 
            $this->load->view('nilai/buatTranskrip', $data);
            $this->load->view('footer');
        }
    }

    public function inputNilai()
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
            'button' => 'Proses',
            'action' => site_url('nilai/inputNilai'),
            'back' => site_url('nilai/inputNilai_action'),
            'kode_matakuliah' => set_value('kode_matakuliah'),
            'id_thn_akad' => set_value('id_thn_akad')
        ];
        
        $this->load->view('header', $dataAdm); 
        $this->load->view('nilai/inputNilai_form', $data);
        $this->load->view('footer');
    }
    
    public function inputNilai_action()
    {
        if(!isset($this->session->userdata['username'])){
            redirect(base_url('login'));
        }

        $this->_rulesInputNilai();
        
        if ($this->form_validation->run() == FALSE) {
            $this->inputNilai();
        } else {
            $kode_mk = $this->input->post('kode_matakuliah', TRUE);
            $id_thn_akad = $this->input->post('id_thn_akad', TRUE);
            
            $this->db->select('k.id_krs, k.nim, m.nama_lengkap, k.nilai, d.nama_matakuliah');
            $this->db->from('krs as k');
            $this->db->join('mahasiswa as m', 'm.nim = k.nim');
            $this->db->join('matakuliah as d', 'k.kode_matakuliah = d.matakuliah');
            $this->db->where('k.id_thn_akad', $id_thn_akad);
            $this->db->where('k.kode_matakuliah', $kode_mk);
            $qry = $this->db->get()->result();

            $data = [
                'button' => 'input',
                'back' => site_url('nilai/inputNilai'),
                'list_nilai' => $qry,
                'action' => site_url('nilai/simpan_action'),
                'kode_matakuliah' => $kode_mk,
                'id_thn_akad' => $id_thn_akad
            ];

            
            $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
            $dataAdm = array(
                'wa' => 'Web Administrator',
                'univ' => 'Universitas Harapan Kita',
                'username' => $rowAdm->username,
                'email' => $rowAdm->email,
                'level' => $rowAdm->level
            );

            $this->load->view('header', $dataAdm); 
            $this->load->view('nilai/listNilai', $data);
            $this->load->view('footer');

        }
        
    }

    public function simpan_action()
    {
        if (!isset($this->session->userdata['username'])) {
            redirect(base_url('login'));
        }

        $nilaiLis = array();
        $id_krs = $_POST['id_krs'];
        $nilai = $_POST['nilai'];

        for ($i=0; $i < sizeof($id_krs); $i++) { 
            $this->db->set('nilai', $nilai[$i])->where('id_krs',$id_krs[$i])->update('krs');
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
                'id_krs' => $id_krs,
                'button' => 'input',
                'back' => site_url('nilai/inputNilai')
            ];

            $this->load->view('header', $dataAdm); 
            $this->load->view('nilai/nilai', $data);
            $this->load->view('footer');

    }

        public function _rulesInputNilai()
        {
            $this->form_validation->set_rules('kode_matakuliah', 'kode_matakuliah', 'trim|required');
            $this->form_validation->set_rules('id_thn_akad', 'id_thn_akad', 'trim|required');
        }
}
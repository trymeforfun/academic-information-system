<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

// Deklarasi pembuatan class Menu model
class Matakuliah_model extends CI_Model{

    // property bersifat public
    public $table = 'matakuliah';
    public $id = 'kode_matakuliah';
    public $order = 'DESC';
    public $hasil = '';

   function __construct() {
        parent:: __construct();
    }

    function json(){
        $username = $this->session->userdata['username'];
        $this->datatables->select("matakuliah.sks, matakuliah.kode_matakuliah, matakuliah.nama_matakuliah, prodi.nama_prodi, matakuliah.jenis, (CASE WHEN m.jenis ='U' THEN 'Umum' WHEN m.jenis ='W' THEN 'Wajib' ELSE 'Pilihan' END) as namaJenis");
        $this->datatables->from('matakuliah, prodi, mahasiswa');
        $this->datatables->where('mahasiswa.nim =' . $username);
        $this->datatables->where('mahasiswa.id_prodi = prodi.id_prodi');
        $this->datatables->where('matakuliah.id_prodi = mahasiswa.id_prodi');
        $this->datatables->add_column('action',anchor(site_url('matakuliah/read/$1'), '<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')." ".anchor(site_url('matakuliah/update/$1'), '<button type="button" class="btn btn-warning"><i class="fa fa-pencil aria-hidden="true"></i></button>')." ".anchor(site_url('matakuliah/delete/$1'), '<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javascript: return confirm(\' Are You Sure ? \')"'), 'kode_matakuliah');
        return $this->datatables->generate();
    }

    function get_all(){
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // Menampilkan semua data berdasarkan id nya 
    function get_by_id($id){
         $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function total_rows($q = NULL){
        $this->db->like('kode_matakuliah', $q);
        $this->db->or_like('kode_matakuliah', $q);
        $this->db->or_like('nama_matakuliah', $q);
        $this->db->or_like('sks', $q);
        $this->db->or_like('semester', $q);
        $this->db->or_like('jenis', $q);
        $this->db->or_like('id_prodi', $q);
        $this->db->from($this->table);
        return $this->db->count_all_result();
    }
    
    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL){
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_matakuliah', $q);
        $this->db->or_like('kode_matakuliah', $q);
        $this->db->or_like('nama_matakuliah', $q);
        $this->db->or_like('sks', $q);
        $this->db->or_like('semester', $q);
        $this->db->or_like('jenis', $q);
        $this->db->or_like('id_prodi', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Menambahkan data kedalam database
   




}
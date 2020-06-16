<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

// Deklarasi pembuatan class users moodel
class Users_model extends CI_Model {

    // Properti yang bersifat public
    public $table = 'users';
    public $id = 'username';
    public $order = 'DESC';

    // Konstrulktor 
    function __construct()
    {
        parent::__construct();
    }

    // Tabel dengan nama user
    function json(){
        $username = $this->session->userdata['username'];
        // $this->load->library('datatables');
        $this->datatables->select('users.username, users.password, users.email, users.level, users.blokir, users.id_sessions,mahasiswa.nama_lengkap');
        $this->datatables->from('users, mahasiswa');
        $this->datatables->where('users.username = '. $username);
        $this->datatables->where('users.username = mahasiswa.nim ');
        $this->datatables->add_column('action',anchor(site_url('users/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>'),'username');
            return $this->datatables->generate();
    }

    // Menampilkan smemua data 
    function get_all(){
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // Menampilkan semua data berdasarkan id nya 
    function get_by_id($id){
         $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // Menampilkan jumlah data
    function total_rows($q = NULL){
        $this->db->like('username', $q);
        $this->db->or_like('username', $q);
        $this->db->or_like('password', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('level', $q);
        $this->db->or_like('blokir', $q);
        $this->db->or_like('id_sessions', $q);
        $this->db->from($this->table);
        return $this->db->count_all_result();
    }
    
    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL){
        $this->db->order_by($this->id, $this->order);
        $this->db->like('username', $q);
        $this->db->or_like('username', $q);
        $this->db->or_like('password', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('level', $q);
        $this->db->or_like('blokir', $q);
        $this->db->or_like('id_sessions', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Menambahkan data kedalam database

    // Merubah data kedalam database
    function update($id, $data){
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // Menghapus data kedalam database

}
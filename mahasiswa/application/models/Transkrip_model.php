<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Transkrip_model extends CI_Model{


    public $table = 'Transkrip';
    public $id = 'id_transkrip';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
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

    function insert($data){
        $this->db->insert($this->table, $data);
    }

    // Merubah data kedalam database
    function update($id, $data){
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // Menghapus data kedalam database
    function delete($id){
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }




}
<?php
if(!defined('BASEPATH'))
exit('No direct script access allowed');

class Prodi_model extends CI_Model {

    public $table = 'prodi';
    public $id = 'id_prodi';
    public $order = 'DESC';


    function __construct()
    {
        parent::__construct();
    }

    function json()
    {
        $this->datatables->select('id_prodi, kode_prodi, nama_prodi, nama_jurusan');
        $this->datatables->from('prodi');
        $this->datatables->join(' jurusan', 'prodi.id_jurusan = jurusan.id_jurusan');
        $this->datatables->add_column('action',anchor(site_url('prodi/update/$1'), '<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')." ".anchor(site_url('prodi/delete/$1'), '<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javascript: return confirm(\' Are You Sure ? \')"'), 'id_prodi');
    }

    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function total_rows($q = NULL)
    {
        $this->db->like('id_prodi', $q);
            $this->db->or_like('kode_prodi', $q);
            $this->db->or_like('nama_prodi', $q);
            $this->db->or_like('id_jurusan', $q);
            $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*');
        $this->db->from('prodi');
        $this->db->join('jurusan', 'prodi.id_jurusan = jurusan.id_jurusan');
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table); 
    }
}
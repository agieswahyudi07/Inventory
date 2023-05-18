<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeModel extends Model
{
    protected $table      = 'ms_type';
    protected $primaryKey = 'type_id';
    protected $allowedFields = ['type_id', 'type_name', 'type_code', 'created_at', 'updated_at'];

    public function get_all_data()
    {
        $query = $this->db->query('SELECT * FROM ' . $this->table);
        return $query->getResult();
    }

    public function getAllDataDescending()
    {
        $builder = $this->db->table($this->table);
        $builder->orderBy('type_id', 'DESC');
        return $builder->get()->getResult();
    }

    public function get_data_index()
    {
        $builder = $this->db->table('ms_type');
        $builder->orderBy('type_id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_data($id)
    {
        $table = $this->db->table('ms_type');
        $query = $table->where('type_id', $id)->get();

        return $query->getResultArray();
    }

    public function updateData($id, $data)
    {
        $table = $this->db->table('ms_type');
        $where = ['type_id' => $id];
        $query = $table->update($data, $where);
        return $query;
    }

    public function deleteData($id)
    {
        $table = $this->db->table('ms_type');
        $where = ['type_id' => $id];
        $query = $table->delete($where);
        return $query;
    }

    public function insert_type($data)
    {
        $this->insert($data);
        return $this->insertID();
    }
}

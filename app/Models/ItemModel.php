<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table      = 'ms_item';
    protected $primaryKey = 'item_id';
    protected $allowedFields = ['item_id', 'item_name', 'item_code', 'item_price', 'category_id', 'brand_id', 'type_id', 'created_at', 'updated_at'];

    public function get_data_index()
    {
        $builder = $this->db->table('ms_item');
        $builder->orderBy('item_id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function get_all_data()
    {
        $query = $this->db->query('SELECT * FROM ' . $this->table);
        return $query->getResult();
    }

    public function getAllDataDescending()
    {
        $builder = $this->db->table($this->table);
        $builder->orderBy('item_id', 'DESC');
        return $builder->get()->getResult();
    }

    public function get_data($id)
    {
        $table = $this->db->table('ms_item');
        $query = $table->where('item_id', $id)->get();

        return $query->getResultArray();
    }

    public function updateData($id, $data)
    {
        $table = $this->db->table('ms_item');
        $where = ['item_id' => $id];
        $query = $table->update($data, $where);
        return $query;
    }

    public function deleteData($id)
    {
        $table = $this->db->table('ms_item');
        $where = ['item_id' => $id];
        $query = $table->delete($where);
        return $query;
    }

    public function insert_item($data)
    {
        $this->insert($data);
        return $this->insertID();
    }
}

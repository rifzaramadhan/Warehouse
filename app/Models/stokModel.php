<?php

namespace App\Models;

use CodeIgniter\Model;

class stokModel extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'idbarang';
    protected $useTimestamps = true;
    protected $allowedFields = ['namabarang', 'deskripsi', 'qty'];

    public function getStok()
    {

        return $this->findAll();
    }

    public function getStockbyid($id)
    {
        return $this->where(['idbarang' => $id])->first();
    }

    public function inputStock($input)
    {
        return $this->save($input);
    }

    public function hapusStock($id_barang)
    {
        return $this->delete(['idbarang' => $id_barang]);
    }
}

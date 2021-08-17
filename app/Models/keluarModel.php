<?php

namespace App\Models;

use CodeIgniter\Model;

class keluarModel extends Model
{
    protected $table = 'keluar';
    protected $primaryKey = 'idkeluaar';
    protected $useTimestamps = true;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('keluar');
    }
    public function getKeluar()
    {
        $this->builder->select('idkeluar, keluar_qty, tanggal, penerima, namabarang');
        $this->builder->join('stock', 'stock.idbarang = keluar.idkeluar_brg');
        return $this->builder->get()->getResultArray();
    }

    public function getKeluarbyid($idKeluar)
    {
        $this->builder->select('idkeluar, keluar_qty, tanggal, penerima, namabarang, idkeluar_brg');
        $this->builder->join('stock', 'stock.idbarang = keluar.idkeluar_brg');
        return $this->builder->getWhere(['idkeluar' => $idKeluar])->getFirstRow('array');
    }

    public function inputKeluar($inputKeluar)
    {
        return $this->builder->insert($inputKeluar);
    }

    public function hapusKeluar($idKeluar)
    {
        return $this->builder->delete(['idkeluar' => $idKeluar]);
    }

    public function updateKeluar($inputKeluar, $id)
    {
        return $this->builder->update($inputKeluar, ['idkeluar' => $id]);
    }
}

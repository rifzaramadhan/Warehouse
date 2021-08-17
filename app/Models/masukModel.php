<?php

namespace App\Models;

use CodeIgniter\Model;

class masukModel extends Model
{
    protected $table = 'masuk';
    protected $primaryKey = 'idmasuk';
    protected $useTimestamps = true;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('masuk');
    }
    public function getMasuk()
    {
        $this->builder->select('idmasuk, masuk_qty, tanggal, keterangan, namabarang');
        $this->builder->join('stock', 'stock.idbarang = masuk.idmasuk_brg');
        return $this->builder->get()->getResultArray();
    }

    public function getMasukbyid($idMasuk)
    {
        $this->builder->select('idmasuk, masuk_qty, tanggal, keterangan, namabarang, idmasuk_brg');
        $this->builder->join('stock', 'stock.idbarang = masuk.idmasuk_brg');
        return $this->builder->getWhere(['idmasuk' => $idMasuk])->getFirstRow('array');
    }

    public function inputMasuk($inputMasuk)
    {
        return $this->builder->insert($inputMasuk);
    }

    public function hapusMasuk($idmasuk)
    {
        return $this->builder->delete(['idmasuk' => $idmasuk]);
    }

    public function updateMasuk($inputMasuk, $id)
    {
        return $this->builder->update($inputMasuk, ['idmasuk' => $id]);
    }
}

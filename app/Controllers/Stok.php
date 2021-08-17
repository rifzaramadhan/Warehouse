<?php

namespace App\Controllers;

use App\Models\StokModel;

class Stok extends BaseController
{
    protected $stokModel;
    protected $validasi;

    public function __construct()
    {
        $this->stokModel = new StokModel();
    }

    public function index()
    {
        $data = [
            'title' => "SI Inventory | Stock Barang",
            'stok' => $this->stokModel->getStok()
        ];
        return view('stokView/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => "SI Inventory | Tambah Stock",
            'validation' => \Config\Services::validation()
        ];

        return view('stokView/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_barang' => [
                'rules' => 'required|is_unique[stock.namabarang]',
                'errors' => [
                    'required' => 'Nama Stock Harus Diisi',
                    'is_unique' => 'Nama Stock Sudah Ada'
                ]
            ],
        ])) {
            return redirect()->to('/stok/create')->withInput();
        }

        $input = [
            'namabarang'    => $this->request->getVar('nama_barang'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'qty'           => "0"
        ];

        $this->stokModel->inputStock($input);
        session()->setFlashdata('Pesan', 'Data berhasil ditambahkan.');
        return redirect()->to('/stok');
    }

    public function delete()
    {
        $id_barang =  $this->request->getVar('idbarang');
        $this->stokModel->hapusStock($id_barang);

        session()->setFlashdata('Pesan', 'Data berhasil dihapus.');
        return redirect()->to('/stok');
    }

    public function edit($id)
    {
        $data = [
            'title' => "SI Inventory | Ubah Stock",
            'stok' => $this->stokModel->getStockbyid($id),
            'validation' => \Config\Services::validation()
        ];

        return view('stokView/edit', $data);
    }

    public function update($id)
    {
        $idLama = $this->stokModel->getStockbyid($this->request->getVar('id'));
        if ($idLama['idbarang'] == $this->request->getVar('id')) {
            $ruleStok = 'required';
        } else {
            $ruleStok = 'required|is_unique[sn_perangkat.sn]';
        }
        if (!$this->validate(
            [
                'nama_barang' => [
                    'rules' => $ruleStok,
                    'errors' => [
                        'required' => 'Nama Barang Harus diisi. ',
                        'is_unique' => 'Nama Barang Sudah Ada'
                    ]
                ],
            ]
        )) {
            return redirect()->to('/stok/edit/' . $this->request->getVar('id'))->withInput();
        }

        $input = [
            'idbarang'      => $id,
            'namabarang'    => $this->request->getVar('nama_barang'),
            'deskripsi'     => $this->request->getVar('deskripsi')

        ];

        $this->stokModel->inputStock($input);
        session()->setFlashdata('Pesan', 'Data berhasil diubah.');
        return redirect()->to('/stok');
    }
}

<?php

namespace App\Controllers;

use App\Models\KeluarModel;
use App\Models\StokModel;

class Keluar extends BaseController
{
    protected $keluarModel;
    protected $stokModel;
    protected $validasi;

    public function __construct()
    {
        $this->keluarModel = new KeluarModel;
        $this->stokModel = new StokModel;
    }

    public function index()
    {
        $data = [
            'title'     => 'SI Inventory | Barang Keluar',
            'keluar'    =>  $this->keluarModel->getKeluar()
        ];
        return view('keluarView/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'SI Inventory | Tambah Data Keluar',
            'stok' => $this->stokModel->getStok(),
            'keluar' => $this->keluarModel->getKeluar(),
            'validation' => \Config\Services::validation()

        ];
        return view('keluarView/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_barang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Barang Harus Diisi',
                ]
            ],
            // 'tanggal' => [
            //     'rules' => 'required|valid_date[m/d/Y]',
            //     'errors' => [
            //         'required' => 'Nama Stock Harus Diisi',
            //         'valid_date' => 'Format Tanggal Salah',
            //     ]
            // ],
            'penerima' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penerima Harus Diisi',
                ]
            ],
            'qty' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Quantity Harus Diisi',
                    'numeric'   => 'Inputan Harus Angka'
                ]
            ],
        ])) {
            return redirect()->to('/keluar/create')->withInput();
        }
        //Quantity
        $id = $this->request->getVar('nama_barang');
        $qty = $this->stokModel->getStockbyid($id);

        $qtyKeluar = $this->request->getVar('qty');

        //Cek Jumlah Quantity
        if ($qtyKeluar < $qty['qty']) {
            $ruleKeluar = $qty['qty'] - $qtyKeluar;
        } else if ($qtyKeluar > $qty['qty']) {
            session()->setFlashdata('PesanStok', 'Quantity Stok Tidak Mencukupi');
            return redirect()->to('/keluar/create');
        }

        $input = [
            'idbarang'  => $qty['idbarang'],
            'qty'       => $ruleKeluar
        ];

        $inputKeluar = [
            'idkeluar_brg'  => $id,
            'keluar_qty'    => $qtyKeluar,
            'tanggal'       => $this->request->getVar('tanggal'),
            'penerima'      => $this->request->getVar('penerima')
        ];

        $this->stokModel->inputStock($input);
        $this->keluarModel->inputKeluar($inputKeluar);

        session()->setFlashdata('Pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/keluar');
    }

    public function delete()
    {
        $idKeluar = $this->request->getVar('idkeluar');
        $keluar = $this->keluarModel->getKeluarbyid($idKeluar);
        $qty = $this->stokModel->getStockbyid($keluar['idkeluar_brg']);

        $hapusQty = $keluar['keluar_qty'] + $qty['qty'];

        $input = [
            'idbarang'  => $qty['idbarang'],
            'qty'       => $hapusQty
        ];

        $this->stokModel->inputStock($input);
        $this->keluarModel->hapusKeluar($idKeluar);

        session()->setFlashdata('Pesan', 'Data berhasil dihapus.');
        return redirect()->to('/keluar');
    }

    public function edit($id)
    {
        $idkeluar = $this->keluarModel->getKeluarbyid($id);
        $data = [
            'title'         => 'SI Inventory | Ubah Barang Keluar',
            'validation'    => \Config\Services::validation(),
            'keluar'         => $this->keluarModel->getKeluarbyid($id),
            'stok'          => $this->stokModel->getStockbyid($idkeluar['idkeluar_brg'])
        ];

        return view('keluarView/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_barang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Barang Harus Diisi',
                ]
            ],
            // 'tanggal' => [
            //     'rules' => 'required|valid_date[m/d/Y]',
            //     'errors' => [
            //         'required' => 'Nama Stock Harus Diisi',
            //         'valid_date' => 'Format Tanggal Salah',
            //     ]
            // ],
            'penerima' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penerima Harus Diisi',
                ]
            ],
            'qty' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Quantity Harus Diisi',
                    'numeric'   => 'Inputan Harus Angka'
                ]
            ],
        ])) {
            return redirect()->to('/keluar/edit/' . $this->request->getVar($id))->withInput();
        }

        $qty = $this->request->getVar('qty');
        $stokKeluar = $this->keluarModel->getKeluarbyid($id);
        $stok = $this->stokModel->getStockbyid($stokKeluar['idkeluar_brg']);

        //cek kondisi update quantity        
        if ($qty < $stokKeluar['keluar_qty']) {
            $qtyTemp = $stokKeluar['keluar_qty'] - $qty;
            $ruleKeluar = $stok['qty'] + $qtyTemp;
        } else if ($qty >= $stokKeluar['keluar_qty']) {
            $qtyTemp = $qty - $stokKeluar['keluar_qty'];
            $ruleKeluar = $stok['qty'] - $qtyTemp;
        }

        $input = [
            'idbarang'  => $stok['idbarang'],
            'qty'       => $ruleKeluar
        ];

        $this->stokModel->inputStock($input);

        $inputKeluar = [
            'idkeluar'      => $id,
            'idkeluar_brg'  => $this->request->getVar('nama_barang'),
            'keluar_qty'    => $qty,
            'tanggal'       => $this->request->getVar('tanggal'),
            'penerima'      => $this->request->getVar('penerima')
        ];

        $this->keluarModel->updateKeluar($inputKeluar, $id);

        session()->setFlashdata('Pesan', 'Data berhasil diubah.');
        return redirect()->to('/keluar');
    }
}

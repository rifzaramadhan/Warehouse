<?php

namespace App\Controllers;

use App\Models\MasukModel;
use App\Models\StokModel;

class Masuk extends BaseController
{
    protected $masukModel;
    protected $stokModel;
    protected $validasi;

    public function __construct()
    {
        $this->masukModel = new MasukModel;
        $this->stokModel = new StokModel;
    }
    public function index()
    {
        $data = [
            'title' => "SI Inventory | Barang Masuk",
            'masuk' => $this->masukModel->getMasuk()
        ];
        return view('masukView/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => "SI Inventory | Barang Masuk",
            'stok' => $this->stokModel->getStok(),
            'masuk' => $this->masukModel->getMasuk(),
            'validation' => \Config\Services::validation()

        ];
        return view('masukView/create', $data);
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
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan Harus Diisi',
                ]
            ],
            'qty' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required'  => 'Quantity Harus Diisi',
                    'numeric'   => 'Inputan Harus Angka'
                ]
            ],
        ])) {
            return redirect()->to('/masuk/create')->withInput();
        }
        // Menambah Quantity
        $id = $this->request->getVar('nama_barang');
        $qty = $this->stokModel->getStockbyid($id);

        $qtyForm = $this->request->getVar('qty');
        $qtyMasuk = $qty['qty'] + $qtyForm;
        //dd($qtyMasuk);
        $inputMasuk = [
            'idmasuk_brg'   => $id,
            'tanggal'       => $this->request->getVar('tanggal'),
            'keterangan'    => $this->request->getVar('keterangan'),
            'masuk_qty'     => $qtyForm
        ];
        $input = [
            'idbarang'  => $id,
            'qty'       => $qtyMasuk
        ];

        $this->masukModel->inputMasuk($inputMasuk);
        $this->stokModel->inputStock($input);

        session()->setFlashdata('Pesan', 'Data berhasil ditambahkan.');
        return redirect()->to('/masuk');
    }

    public function delete()
    {
        $idMasuk = $this->request->getVar('idmasuk');
        $masuk = $this->masukModel->getMasukbyid($idMasuk);
        $qty = $this->stokModel->getStockbyid($masuk['idmasuk_brg']);
        $hapusQty = $qty['qty'] - $masuk['masuk_qty'];
        //dd($qty['idbarang']);
        $input = [
            'idbarang'  => $qty['idbarang'],
            'qty'       => $hapusQty
        ];

        $this->stokModel->inputStock($input);
        $this->masukModel->hapusMasuk($idMasuk);

        session()->setFlashdata('Pesan', 'Data berhasil dihapus.');
        return redirect()->to('/masuk');
    }

    public function edit($id = null)
    {
        $idmasuk = $this->masukModel->getMasukbyid($id);
        $data = [
            'title'         => 'SI Inventory | Ubah Barang Masuk',
            'validation'    => \Config\Services::validation(),
            'masuk'         => $this->masukModel->getMasukbyid($id),
            'stok'          => $this->stokModel->getStockbyid($idmasuk['idmasuk_brg'])
        ];

        return view('masukView/edit', $data);
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
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan Harus Diisi',
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
            return redirect()->to('/masuk/edit' . $this->request->getVar($id))->withInput();
        }
        $qty = $this->request->getVar('qty');
        $idMasuk_brg = $this->request->getVar('nama_barang');
        $stokMasuk = $this->masukModel->getMasukbyid($id);
        $stokQty = $this->stokModel->getStockbyid($stokMasuk['idmasuk_brg']);



        //Kondisi Update Quantity
        if ($qty <= $stokMasuk['masuk_qty']) {
            $qtyTemp = $stokMasuk['masuk_qty'] - $qty;
            $ruleMasuk = $stokQty['qty'] - $qtyTemp;
        } else if ($qty > $stokMasuk['masuk_qty']) {
            $qtyTemp = $qty - $stokMasuk['masuk_qty'];
            $ruleMasuk = $stokQty['qty'] + $qtyTemp;
        }


        $qtyTemp = $this->stokModel->getStockbyid($idMasuk_brg);
        $ruleMasuk = $qty + $qtyTemp['qty'];



        $input = [
            'idbarang'  => $idMasuk_brg,
            'qty'       => $ruleMasuk
        ];

        $inputMasuk = [
            'idmasuk'       => $id,
            'idmasuk_brg'   => $this->request->getVar('nama_barang'),
            'tanggal'       => $this->request->getVar('tanggal'),
            'keterangan'    => $this->request->getVar('keterangan'),
            'masuk_qty'     => $qty
        ];
        //dd($inputMasuk);
        $this->stokModel->inputStock($input);
        $this->masukModel->updateMasuk($inputMasuk, $id);

        session()->setFlashdata('Pesan', 'Data berhasil diubah.');
        return redirect()->to('/masuk');
    }
}

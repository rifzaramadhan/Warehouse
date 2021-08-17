<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Barang Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Barang Masuk</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Barang Masuk Perusahaan </h4>
                            <!-- <button type="button" class="btn btn-block btn-outline-success btn-flat" style="height:45px;width:85px;float:left">Tambah</button> -->
                        </div>

                        <!-- /.card-header -->
                        <div class="swal" data-swal="<?= session()->get('Pesan'); ?>"></div>

                        <!-- HTTP Spoofing for Delete -->
                        <form action="<?= base_url(); ?>/masuk/delete" method="POST" class="d-inline" id="formDelete">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="idmasuk" id="coba" value="">
                        </form>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Qty</th>
                                        <th>
                                            <div style="text-align: center;">
                                                <button type="button" class="btn btn-success btn-flat" style="text-align:center;" onclick="document.location='<?= base_url('masuk/create'); ?>'">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($masuk as $a) : ?>
                                        <tr>
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= $a['namabarang']; ?></td>
                                            <td><?= $a['tanggal']; ?></span></td>
                                            <td><?= $a['keterangan']; ?></td>
                                            <td><?= $a['masuk_qty']; ?></td>
                                            <td>
                                                <div class="btn-group" style="text-align: center;">
                                                    <button type="button" class="btn btn-info btn-flat" onclick="document.location='#'"><i class="fas fa-search"></i></button>
                                                    <button type="button" class="btn btn-warning btn-flat" onclick="document.location='<?= base_url(); ?>/masuk/edit/<?= $a['idmasuk']; ?>'"><i class="fas fa-edit"></i></button>
                                                    <button type="submit" class="btn btn-danger btn-flat" onclick="sweetdelete('<?= $a['idmasuk']; ?>')"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Qty</th>
                                        <th>
                                            <div style="text-align: center;">
                                                <button type="button" class="btn btn-success btn-flat" style="text-align:center;" onclick="document.location='<?= base_url('masuk/create'); ?>'">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection(); ?>
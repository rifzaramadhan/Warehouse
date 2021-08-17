<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Form Ubah Data Barang Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-3"></div>
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= base_url(); ?>/masuk/update/<?= $masuk['idmasuk']; ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" value="<?= $masuk['idmasuk']; ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select class="form-control select2bs4 <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>" name="nama_barang" id="nama_barang" disabled="disabled" style="width: 100%;">
                                        <option value="<?= $stok['idbarang']; ?>"><?= $stok['namabarang']; ?></option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_barang'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Date:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal" value="<?= $masuk['tanggal']; ?>" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_barang">Keterangan</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" placeholder="Keterangan.." name="keterangan" id="keterangan" value="<?= $masuk['keterangan']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('keterangan'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : ''; ?>" placeholder="qty" name="qty" id="qty" value="<?= $masuk['masuk_qty'] ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('qty'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <div class="col-md-3">
                    <a class="btn btn-app" href="<?= base_url('masuk'); ?>">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?= $this->endSection(); ?>
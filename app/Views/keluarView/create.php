<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Form Tambah Barang Keluar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Keluar</li>
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
                        <div class="swaldeny" data-swaldeny="<?= session()->get('PesanStok'); ?>"></div>
                        <!-- form start -->
                        <form action="<?= base_url('keluar/save'); ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select class="form-control select2bs4 <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>" name="nama_barang" id="nama_barang" value="<?= old('nama_barang'); ?>">
                                        <?php foreach ($stok as $a) : ?>
                                            <option value="<?= $a['idbarang']; ?>"><?= $a['namabarang']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_barang'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Date:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_barang">Penerima</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('penerima')) ? 'is-invalid' : ''; ?>" placeholder="Penerima .." name="penerima" id="penerima" value="<?= old('penerima'); ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('penerima'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : ''; ?>" placeholder="qty" name="qty" id="qty" value="<?= old('qty'); ?>">
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
                    <a class="btn btn-app" href="<?= base_url('keluar'); ?>">
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
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">

        <?= $this->session->flashdata('pesan'); ?>
          
          <form action="<?= base_url('user/ubahpassword')?>" method="post">
          <div class="form-group">
            <label for="password_lama">Password Lama</label>
            <input type="password" class="form-control" id="password_lama" name="password_lama">
            <?= form_error('password_lama', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
          <div class="form-group">
            <label for="password_baru">Password Baru</label>
            <input type="password" class="form-control" id="password_baru" name="password_baru">
            <?= form_error('password_baru', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
          <div class="form-group">
            <label for="ulangi_password">Ulangi Password</label>
            <input type="password" class="form-control" id="ulangi_password" name="ulangi_password">
            <?= form_error('ulangi_password', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-success">Ubah Password</button>&nbsp;&nbsp;
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
        </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 
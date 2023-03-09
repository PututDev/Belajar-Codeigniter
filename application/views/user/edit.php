<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">

        <?= form_open_multipart('user/edit');?>

        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email'];?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Your Name</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'];?>">
            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-2">Gambar</div>
            <div class="col-sm-10">
                <div class="row">
                     <div class="col-sm-3">
                        <img src="<?= base_url('assets/img/profile/').$user['image'];?>" class="img-thumbnail">
                    </div>
                    <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="customFile">Pilih File</label>
                        </div>
            </div>
        </div>

        <div class="form-group row justify-content-end mt-3">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-success">Edit</button>
            </div>
        </div>
        
        </form>

        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 
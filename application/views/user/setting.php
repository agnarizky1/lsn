<h5><b>User Settings</b></h5>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- <form action="<?= base_url('user/change_setting') ?>" enctype="multipart/form_data" id="editProfile" method="post"> -->
                <?= form_open_multipart('user/change_setting') ?>
                <div class="row justify-content-center">
                    <div class="col-md-4 col-lg-3 col-sm-3 col-4">
                        <img src="<?= base_url('assets/img/user/' . $user->img) ?>" alt="image user" width="100%" class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-10 mt-3">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" required class="form-control" value="<?= $user->nama ?>" id="inputEmail3" placeholder="Nama">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?= $user->email ?>" name="email" class="form-control" id="inputEmail3" placeholder="Email" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Foto</label>
                            <div class="col-sm-9">
                                <input type="file" id="foto" name="foto" class="form-control" id="inputEmail3">
                            </div>
                        </div>

                        <button class="btn btn-primary" id="toSubmit" type="submit">Save</button>
                        <button class="btn btn-success" type="button" id="changePassword"><i class="fa fa-key"></i> Ubah Password</button>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- UPLOAD FILE KTP -->
    <div class="col-12 mt-3 mb-3">
        <div class="card">
            <div class="card-body">
                <!-- <form action="<?= base_url('user/upload_ktp') ?>" enctype="multipart/form_data" id="editProfile" method="post"> -->
                <?= form_open_multipart('user/upload_ktp') ?>
                <div class="row justify-content-center">
                    <div class="col-md-4 col-lg-3 col-sm-3 col-4">
                        <img src="<?= base_url('assets/img/ktp/' . $user->file_ktp) ?>" alt="image user" width="100%" class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-10 mt-3">
                        <input type="text" value="<?= $user->email ?>" name="email" class="form-control" id="inputEmail3" placeholder="Email" hidden disabled>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">File KTP</label>
                            <div class="col-sm-9">
                                <input type="file" id="file_ktp" name="file_ktp" class="form-control" id="inputEmail3">
                            </div>
                        </div>
                        <button class="btn btn-primary" id="toSubmit" type="submit">Save</button>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- END UPLOAD FILE KTP -->
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            </div>
            <form action="<?= base_url('user/change_password') ?>" id="formPass" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Password lama</label>
                        <input type="password" name="old_pass" id="old_pass" class="form-control">
                        <small class="text-danger" id="err_old"></small>
                    </div>

                    <div class="form-group">
                        <label>Password baru</label>
                        <input type="password" name="new_pass" id="new_pass" class="form-control">
                        <small class="text-danger" id="err_new"></small>
                    </div>

                    <div class="form-group">
                        <label>Ulangi password baru</label>
                        <input type="password" name="re_new" id="re_new" class="form-control">
                        <small class="text-danger" id="err_re"></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="toChange">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#changePassword').click(function() {
        $('#exampleModal').modal('show');
        $('#exampleModalLabel').html('Ubah Password');
        $('#old_pass').val('');
        $('#new_pass').val('');
        $('#re_new').val('');
        $('#err_old').html('');
        $('#err_new').html('');
        $('#err_re').html('');
    });

    $('#formPass').submit(function(e) {
        e.preventDefault();
        $('#toChange').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#toChange').attr('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#toChange').html('Save');
                $('#toChange').removeAttr('disabled');


                if (d.type == 'validation') {
                    if (d.err_old == '') {
                        $('#err_old').html('');
                    } else {
                        $('#err_old').html(d.err_old);
                    }

                    if (d.err_new == '') {
                        $('#err_new').html('');
                    } else {
                        $('#err_new').html(d.err_new);
                    }

                    if (d.err_re == '') {
                        $('#err_re').html('');
                    } else {
                        $('#err_re').html(d.err_re);
                    }

                } else if (d.type == 'result') {
                    $('#err_old').html('');
                    $('#err_new').html('');
                    $('#err_re').html('');

                    if (d.success == false) {
                        toastr["error"](d.msg, "Error");
                    } else {
                        $('#old_pass').val('');
                        $('#new_pass').val('');
                        $('#re_new').val('');
                        $('#exampleModal').modal('hide');

                        toastr["success"](d.msg, "Success");
                    }
                }
            },
            error: function(xhr) {
                $('#toChange').html('Save');
                $('#toChange').removeAttr('disabled');

                if (xhr.status === 0) {
                    toastr["error"]("No internet access", "Error");
                } else if (xhr.status == 404) {
                    toastr["error"]("Page not found", "Error");
                } else if (xhr.status == 500) {
                    toastr["error"]("Internal server error", "Error");
                } else {
                    toastr["error"]("Unknow error", "Error");
                }
            }
        });
    });
</script>
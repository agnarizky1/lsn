<div class="container-fluid" id="container-wrapper">

    <div class="row">
        <div class="col-lg-8">

            <?= form_open_multipart('master/edit_user/' .  $edit_user->id_user); ?>
            <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $edit_user->nama; ?>">
                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" value="<?= $edit_user->email; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <select class="custom-select" id="status" name="status">
                        <?php if ($edit_user->status == 1) { ?>
                            <option value="1" selected>Aktif</option>
                            <option value="">Tidak Aktif</option>
                        <?php } else { ?>
                            <option value="0" selected>Tidak Aktif</option>
                            <option value="1">Aktif</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="id_role" class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-10">
                    <select class="custom-select" id="id_role" name="id_role">
                        <option value="" selected disabled>Pilih Role</option>
                        <?php foreach ($role as $r) : ?>
                            <option value="<?= $r['id_role'] ?>"><?= $r['nama_role'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">Foto</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <img src="<?= base_url('assets/img/user/' . $edit_user->img) ?>" id="gambar_load" class="img-thumbnail">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="file" name="img" id="img" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>

            <?= form_close() ?>
        </div>

    </div>
</div>

<script>
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#gambar_load').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#img").change(function() {
        bacaGambar(this);
    });
</script>
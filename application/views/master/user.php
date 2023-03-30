<div class="container-fluid" id="container-wrapper">

    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Users</h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary bg-gradient-primary float-right" data-toggle="modal" data-target="#exampleModal" id="#myBtn">
                        Tambah Data
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($all_user as $u) :
                            ?>
                                <tr>
                                    <td><?= $no++ ?></a></td>
                                    <td><?= $u['nama'] ?></td>
                                    <td><?= $u['email'] ?></td>
                                    <?php if ($u['status'] == 1) { ?>
                                        <td><span class="badge badge-success">Aktif</span></td>
                                    <?php } else { ?>
                                        <td><span class="badge badge-danger">Tidak Aktif</span></td>
                                    <?php } ?>
                                    <td><?= $u['nama_role'] ?></a></td>
                                    <td>
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalDetail<?= $u['id_user'] ?>">
                                                Detail
                                            </button>
                                            <a class="dropdown-item" href="<?= base_url('master/edit_user/') . $u['id_user'] ?>">Edit</a>
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalHapus<?= $u['id_user'] ?>">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
    <!--Row-->

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/user') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="password1" name="password1">
                        <?= form_error('password1', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Repeat Password:</label>
                        <input type="password" class="form-control" id="password2" name="password2">
                    </div>
                    <div class="form-group">
                        <label>Status:</label>
                        <select class="custom-select" id="status" name="status">
                            <option value="" selected disabled>Pilih Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Role:</label>
                        <select class="custom-select" id="id_role" name="id_role">
                            <option value="" selected disabled>Pilih Role</option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id_role'] ?>"><?= $r['nama_role'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<?php foreach ($all_user as $u) { ?>
    <div class="modal fade" id="modalDetail<?= $u['id_user'] ?> " tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('master/user') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama:</label>
                            <p><?= $u['nama'] ?></p>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Email:</label>
                            <p><?= $u['email'] ?></p>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <?php if ($u['status'] == 1) { ?>
                                <p>Aktif</p>
                            <?php } else { ?>
                                <p>Tidak Aktif</p>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Role:</label>
                            <p><?= $u['nama_role'] ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Hapus -->
<?php foreach ($all_user as $u) { ?>
    <div class="modal fade" id="modalHapus<?= $u['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Apakah anda ingin menghapus data <?= $u['nama'] ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="<?= base_url('master/delete_user/' . $u['id_user']) ?>" type="submit" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
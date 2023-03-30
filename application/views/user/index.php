<h5><b>Profile</b></h5>

<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-4 col-lg-3 col-sm-3 col-4">
                        <img src="<?= base_url('assets/img/user/' . $user->img) ?>" alt="image user" width="100%" class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 col-sm-12">
                        <table class="table table-bordered mt-3">
                            <h5>Account User</h5>
                            <hr>
                            <tr>
                                <th>Nama</th>
                                <td><?= $user->nama ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $user->email ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td><?= $user->nama_role ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 col-sm-12">
                        <table class="table table-bordered mt-3">
                            <h5 class="mt-3">Biodata</h5>
                            <hr>
                            <tr>
                                <th>NIK</th>
                                <td><?= $user->nik ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td><?= $user->tanggal_lahir ?></td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td><?= $user->tempat_lahir ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td><?= $user->jenis_kelamin ?></td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td><?= $user->provinsi ?></td>
                            </tr>
                            <tr>
                                <th>Kabupaten</th>
                                <td><?= $user->kabupaten ?></td>
                            </tr>
                            <tr>
                                <th>Desa</th>
                                <td><?= $user->desa ?></td>
                            </tr>
                            <tr>
                                <th>Dusun</th>
                                <td><?= $user->dusun ?></td>
                            </tr>
                            <tr>
                                <th>RT / RW</th>
                                <td><?= $user->rt ?> / <?= $user->rw ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $user->alamat_lengkap ?></td>
                            </tr>
                            <tr>
                                <th>File KTP</th>
                                <td><?= $user->file_ktp ?></td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td><?= $user->no_telp ?></td>
                            </tr>
                            <tr>
                                <th>Status Organisasi</th>
                                <td><?= $user->status_organisasi ?></td>
                            </tr>
                            <tr>
                                <th>Status Kepengurusan</th>
                                <td><?= $user->status_kepengurusan ?></td>
                            </tr>
                            <tr>
                                <th>Kelompok Pengajian</th>
                                <td><?= $user->nama_kelompok_pengajian ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
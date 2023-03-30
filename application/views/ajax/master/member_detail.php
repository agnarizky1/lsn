<style>
    .detail-ktp {
      cursor: pointer;
    }
</style>

<div class="text-center">
    <img src="<?= base_url('assets/img/user/') . $data->img ?>" alt="img-user" width="150px" class="img-thumbnail rounded-circle shadow-sm">
</div>

<table class="table table-bordered mt-3 table-hover">
    <tr>
        <th>NIK</th>
        <td><?= $data->nik ?></td>
    </tr>
    <tr>
        <th>Nama Lengkap</th>
        <td><?= $data->nama ?></td>
    </tr>
    <tr>
        <th>Tempat, Tanggal Lahir</th>
        <td><?= $data->tempat_lahir ?>, <?php $date = date_create($data->tanggal_lahir); echo date_format($date, 'd F Y') ?></td>
    </tr>
    <tr>
        <th>Jenis Kelamin</th>
        <td><?= $data->jenis_kelamin ?></td>
    </tr>
    <tr>
        <th>Provinsi</th>
        <td><?= $data->provinsi ?></td>
    </tr>
    <tr>
        <th>Kabupaten</th>
        <td><?= $data->kabupaten ?></td>
    </tr>
    <tr>
        <th>Kecamatan</th>
        <td><?= $data->kecamatan ?></td>
    </tr>
    <tr>
        <th>Kelurahan / Desa</th>
        <td><?= $data->desa ?></td>
    </tr>
    <tr>
        <th>Dusun</th>
        <td><?= $data->dusun ?></td>
    </tr>
    <tr>
        <th>Rw / Rt</th>
        <td><?= $data->rw ?> / <?= $data->rt ?></td>
    </tr>
    <tr>
        <th>Alamat Lengkap</th>
        <td><?= $data->alamat_lengkap ?></td>
    </tr>
    <tr>
        <th>Status Organisasi</th>
        <td><?= $data->status_organisasi ?></td>
    </tr>
    <tr>
        <th>Status Kepengurusan</th>
        <td><?= $data->status_kepengurusan ?></td>
    </tr>
    <tr>
        <th>Nama Kelompok Pengajian</th>
        <td><?= $data->nama_kelompok_pengajian ?></td>
    </tr>
    <tr>
        <th>Role User</th>
        <td><?= $data->nama_role ?></td>
    </tr>
    <tr>
        <th>Foto KTP</th>
        <td>
            <?php if($data->file_ktp == null){ ?>   
                <i>KTP belum di upload</i>
            <?php } else { ?>
                <img src="<?= base_url('assets/img/ktp/') . $data->file_ktp ?>" class="detail-ktp" alt="file_ktp" width="100px">
            <?php } ?>
        </td>
    </tr>
    
</table>
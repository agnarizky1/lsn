<table class="table table-bordered" id="theTable">
    <thead>
        <tr class="bg-dark text-light">
            <th>#</th>
            <th>Nama Role</th>
            <th>Status</th>
            <th>Akses Menu</th>
            <th><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        $a = 1;
        $b = 1;
        foreach($data as $d){ ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $d->nama_role ?></td>
            <td>
                <?php if($d->status == 1){ ?>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input status" id="customSwitch<?= $a++ ?>" checked value="<?= md5(sha1($d->id_role)) ?>" data-type="2">
                        <label class="custom-control-label" for="customSwitch<?= $b++ ?>">Aktif</label>
                    </div>
                <?php } else { ?>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input status" id="customSwitch<?= $a++ ?>" value="<?= md5(sha1($d->id_role)) ?>" data-type="1">
                        <label class="custom-control-label" for="customSwitch<?= $b++ ?>">Nonaktif</label>
                    </div>
                <?php } ?>
            </td>
            <td class="text-center">
                <button class="btn btn-sm btn-info access-menu" data-id="<?= $d->id_role ?>">Lihat Akses</button>
            </td>
            <td>
                <button class="btn btn-sm btn-danger delete" data-id="<?= md5(sha1($d->id_role)) ?>"><i class="fa fa-trash"></i></button>
                <button class="btn btn-sm btn-primary edit" data-id="<?= md5(sha1($d->id_role)) ?>" data-role="<?= $d->nama_role ?>"><i class="fa fa-edit"></i></button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#theTable').dataTable();
</script>
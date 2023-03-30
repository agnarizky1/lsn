<table class="table table-bordered" id="theTable">
    <thead>
        <tr class="bg-dark text-light">
            <th>#</th>
            <th>Nama Cabang</th>
            <th><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach($data as $d){ ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $d->nama_cabang ?></td>
                <td>
                    <button class="btn btn-sm btn-primary edit" data-id="<?= md5(sha1($d->id_cabang)); ?>" data-cabang="<?= $d->nama_cabang ?>"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger delete" data-id="<?= md5(sha1($d->id_cabang)); ?>"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#theTable').dataTable();
</script>
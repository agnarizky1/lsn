<h5><b>Master Role User</b></h5>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-sm btn-success mb-3" id="add_Role"><i class="fa fa-plus"></i> Tambah</button>
                <div id="load_data"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title titleModal" id="exampleModalLabel">Modal title</h5>
       
      </div>
      <form action="" method="post" id="formPost">
      <div class="modal-body">
            <input type="hidden" name="id_role" id="id_role">

            <div class="form-group">
                <label>Nama Role</label>
                <input type="text" name="role" id="role" class="form-control">
                <small class="text-danger" id="err_role"></small>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="toSubmit">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Akses Menu</h5>
      </div>
      <form action="<?= base_url('master/change_access_menu') ?>" method="post" id="formAccess">
      <div class="modal-body">
        <input type="hidden" name="id_role" id="id_role_access">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-primary text-light">
                    <th>List menu</th>
                    <th>Access menu sekarang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                        $a = 1;
                        $b = 1;
                        foreach($list_menu as $lm){ ?>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="check[]" class="custom-control-input check-menu" id="customCheck<?=$a++?>" value="<?= $lm->id_menu ?>">
                            <label class="custom-control-label" for="customCheck<?=$b++?>">
                                <i class="<?= $lm->icon ?>"></i> <?= $lm->nama_menu ?>
                            </label>
                        </div>
                        <?php } ?>
                    </td>
                    <td>
                        <ul id="showListMenu">

                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="subAccess" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
    $(document).ready(function(){
        load_data();
    });

    $('#add_Role').click(function(){
        $('#exampleModal').modal('show');
        $('.titleModal').html('Tambah Role');
        $('#role').val('');
        $('#err_role').html('');
        $('#formPost').attr('action', '<?= base_url('master/add_role') ?>');
    });

    $('#formPost').submit(function(e){
        e.preventDefault();
        $('#toSubmit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#toSubmit').attr('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#toSubmit').html('Save');
                $('#toSubmit').removeAttr('disabled');

                    if(d.type == 'validation'){
                        if(d.err_role == ''){
                            $('#err_role').html('');
                        } else {
                            $('#err_role').html(d.err_role);
                        }
                    } else if(d.type == 'result'){
                        $('#err_role').html('');


                        if(d.success == false){
                            toastr["error"](d.msg, "Error");
                        } else {
                            $('#role').val('');
                            $('#exampleModal').modal('hide');
                        
                            toastr["success"](d.msg, "Success");
                            setTimeout(() => {
                                load_data();
                            }, 1700);
                        }
                    }

            },
            error: function(xhr){
                $('#toSubmit').html('Save');
                $('#toSubmit').removeAttr('disabled');

                    if(xhr.status === 0){
                        toastr["error"]("No internet access", "Error");
                    } else if(xhr.status == 404){
                        toastr["error"]("Page not found", "Error");
                    } else if(xhr.status == 500){
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
            }
        });

    });

    $(document).on('change', '.status', function(){
        let tipe = $(this).data('type');
        let id = $(this).val();

        $.ajax({
            url: '<?= base_url('master/change_status_role') ?>',
            data: {
                id: id,
                type: tipe,
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.success == true){
                    toastr["success"](d.msg, "Success");
                    load_data();
                } else {
                    toastr["error"](d.msg, "Error");
                }
            },
            error: function(xhr){
               
               if(xhr.status === 0){
                   toastr["error"]("No internet access", "Error");
               } else if(xhr.status == 404){
                   toastr["error"]("Page not found", "Error");
               } else if(xhr.status == 500){
                   toastr["error"]("Internal server error", "Error");
               } else {
                   toastr["error"]("Unknow error", "Error");
               }
            }
        });

    });

    $(document).on('click', '.edit', function(){
        $('#exampleModal').modal('show');
        $('.titleModal').html('Edit Role');
        $('#role').val('');
        $('#err_role').html('');
        $('#formPost').attr('action', '<?= base_url('master/edit_role') ?>');

        let id = $(this).data('id');
        let role = $(this).data('role');
        $('#role').val(role);
        $('#id_role').val(id);
    });

    $(document).on('click', '.delete', function(){
        let con = confirm('Apakah anda yakin untuk menghapus data ini?');
        let id = $(this).data('id');

        if(con){
            $.ajax({
                url: '<?= base_url('master/delete_role') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.success == true){
                        toastr["success"](d.msg, "Success");
                        load_data();
                    } else {
                        toastr["error"](d.msg, "Error");
                    }
                },
                error: function(xhr){
                    if(xhr.status === 0){
                        toastr["error"]("No internet access", "Error");
                    } else if(xhr.status == 404){
                        toastr["error"]("Page not found", "Error");
                    } else if(xhr.status == 500){
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
                }
            });
        } 
    });

    $(document).on('click', '.access-menu', function(){
        $('#modalAccess').modal('show');
        let id = $(this).data('id');
        $('#id_role_access').val(id);
        $('.check-menu').prop('checked', false);

        $.ajax({
            url: '<?= base_url('master/load_access_menu') ?>',
            data: {id: id},
            type: 'POST',
            success: function(d){
                $('#showListMenu').html(d);
            },
            error: function(xhr){
             
              if(xhr.status === 0){
                  toastr["error"]("No internet access", "Error");
              } else if(xhr.status == 404){
                  toastr["error"]("Page not found", "Error");
              } else if(xhr.status == 500){
                  toastr["error"]("Internal server error", "Error");
              } else {
                  toastr["error"]("Unknow error", "Error");
              }
           }
        });

    });

    $('#formAccess').submit(function(e){
        e.preventDefault();
        $('#subAccess').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#subAccess').attr('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){

                $('#subAccess').html('Save');
                $('#subAccess').removeAttr('disabled');
                $('#modalAccess').modal('hide');

                $('.check-menu').prop('checked', false);

                if(d.success == true){
                    toastr["success"](d.msg, "Success");
                    load_data();
                } else {
                    toastr["error"](d.msg, "Error");
                }
            },
            error: function(xhr){
               
                $('#subAccess').html('Save');
                $('#subAccess').removeAttr('disabled');
                $('#modalAccess').modal('hide');
                $('.check-menu').prop('checked', false);


               if(xhr.status === 0){
                   toastr["error"]("No internet access", "Error");
               } else if(xhr.status == 404){
                   toastr["error"]("Page not found", "Error");
               } else if(xhr.status == 500){
                   toastr["error"]("Internal server error", "Error");
               } else {
                   toastr["error"]("Unknow error", "Error");
               }
            }
        });

    });

    function load_data(){
        const loading_animation = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $('#load_data').html(loading_animation);

        $.ajax({
            url: '<?= base_url('ajax/get_data_role_user'); ?>',
            type: 'POST',
            success: function(d){
                $('#load_data').html(d);
            },
            error: function(xhr){
               
                    if(xhr.status === 0){
                        toastr["error"]("No internet access", "Error");
                    } else if(xhr.status == 404){
                        toastr["error"]("Page not found", "Error");
                    } else if(xhr.status == 500){
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
            }
        });

    }

</script>
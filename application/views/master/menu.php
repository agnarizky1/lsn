<h5><b>Master Menu</b></h5>

<div class="row">
    <div class="col-12">



    <div class="card">
        <div class="card-body">
              
                    <button class="btn btn-sm btn-success mb-3" id="addMenu"><i class="fa fa-plus"></i> Tambah</button>
                    <div id="load_menu"></div>
               
        </div>
    </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title titleMenu" id="exampleModalLabel">Modal title</h5>
      </div>
      <form action="" id="formMenu" method="post">
      <div class="modal-body">

      <input type="hidden" name="id_menu" id="id_menu">

      <div class="form-group">
        <label>Nama Menu</label>
        <input type="text" name="menu" id="menu" class="form-control">
        <small class="text-danger" id="err_menu"></small>
      </div>

      <div class="form-group">
        <label>Url Menu</label>
        <input type="text" name="url" id="url" class="form-control">
        <small class="text-danger" id="err_url"></small>

      </div>

      <div class="form-group">
        <label>Icon Menu</label>
        <input type="text" name="icon" id="icon" class="form-control">
        <small class="text-danger" id="err_icon"></small>
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="subMenu">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        load_data_menu();
    });

    $('#addMenu').click(function(){
        $('#modalMenu').modal('show');
        $('#formMenu').attr('action', '<?= base_url('master/add_menu') ?>');
        $('.titleMenu').html('Tambah Menu');
        $('#menu').val('');
        $('#url').val('');
        $('#icon').val('');
        $('#err_menu').html('');
        $('#err_icon').html('');
        $('#err_url').html('');
    });

    $(document).on('click', '.edit-menu', function(){
        $('#formMenu').attr('action', '<?= base_url('master/edit_menu') ?>');
        $('.titleMenu').html('Edit Menu');
        $('#menu').val('');
        $('#url').val('');
        $('#icon').val('');
        $('#err_menu').html('');
        $('#err_icon').html('');
        $('#err_url').html('');

        let id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('master/get_menu_row') ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#modalMenu').modal('show');
                $('#menu').val(d.nama_menu);
                $('#url').val(d.url);
                $('#icon').val(d.icon);
                $('#id_menu').val(id);
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

    $(document).on('click', '.delete-menu', function(){
        let con = confirm('Apakah anda yakin untuk menghapus data ini?');
        let id = $(this).data('id');

        if(con){
            $.ajax({
                url: '<?= base_url('master/delete_menu') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.success == true){
                        toastr["success"](d.msg, "Success");
                        load_data_menu();
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

    $(document).on('change', '.status', function(){
        let tipe = $(this).data('type');
        let id = $(this).val();

        $.ajax({
            url: '<?= base_url('master/change_status_menu') ?>',
            data: {
                id: id,
                type: tipe,
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.success == true){
                    toastr["success"](d.msg, "Success");
                    load_data_menu();
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

    $('#formMenu').submit(function(e){
        e.preventDefault();
        $('#subMenu').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('#subMenu').attr('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#subMenu').html('Save');
                $('#subMenu').removeAttr('disabled');


                    if(d.type == 'validation'){
                        if(d.err_menu == ''){
                            $('#err_menu').html('');
                        } else {
                            $('#err_menu').html(d.err_menu);
                        }

                        if(d.err_icon == ''){
                            $('#err_icon').html('');
                        } else {
                            $('#err_icon').html(d.err_icon);
                        }

                        if(d.err_url == ''){
                            $('#err_url').html('');
                        } else {
                            $('#err_url').html(d.err_url);
                        }

                    } else if(d.type == 'result'){
                        $('#err_menu').html('');
                        $('#err_url').html('');
                        $('#err_icon').html('');

                        if(d.success == false){
                            toastr["error"](d.msg, "Error");
                        } else {
                            $('#menu').val('');
                            $('#url').val('');
                            $('#icon').val('');
                            $('#modalMenu').modal('hide');
                        
                            toastr["success"](d.msg, "Success");
                            load_data_menu();
                           
                        }
                    }
            },
            error: function(xhr){
                $('#subMenu').html('Save');
                $('#subMenu').removeAttr('disabled');

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

    function load_data_menu(){
        const loading_animation = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $('#load_menu').html(loading_animation);

        $.ajax({
            url: '<?= base_url('ajax/get_data_menu'); ?>',
            type: 'POST',
            success: function(d){
                $('#load_menu').html(d);
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
<h5><b>Master Anak Cabang</b></h5>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-sm btn-success mb-3" id="toAdd"><i class="fa fa-plus"></i> Tambah</button>
                <div id="load_data"></div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title titleModal" id="exampleModalLabel">Modal title</h5>
      </div>
      <form action="" id="formCabang" method="post">
      <div class="modal-body">

        <input type="hidden" name="id_cabang" id="id_cabang">
        <div class="form-group">
            <label>Nama Cabang</label>
            <input type="text" name="cabang" id="cabang" class="form-control">
            <small class="text-danger" id="err_cabang"></small>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="toSubmit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
    $(document).ready(function(){
        load_data();
    });

    $('#toAdd').click(function(){
        $('#exampleModal').modal('show');
        $('.titleModal').html('Tambah Anak Cabang');
        $('#formCabang').attr('action', '<?= base_url('master/add_cabang') ?>');
        $('#cabang').val('');
        $('#err_cabang').html('');
    });

    $('#formCabang').submit(function(e){
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
                        if(d.err_cabang == ''){
                            $('#err_cabang').html('');
                        } else {
                            $('#err_cabang').html(d.err_cabang);
                        }
                } else if(d.type == 'result'){
                    $('#err_cabang').html('');
                    if(d.success == false){
                        toastr["error"](d.msg, "Error");
                    } else {
                        toastr["success"](d.msg, "Success");
                        $('#cabang').val('');
                        $('#exampleModal').modal('hide');
                        load_data();
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

    $(document).on('click', '.edit', function(){
        let id = $(this).data('id');
        let val = $(this).data('cabang');
        $('#exampleModal').modal('show');
        $('.titleModal').html('Edit Anak Cabang');
        $('#formCabang').attr('action', '<?= base_url('master/edit_cabang') ?>');
        $('#cabang').val(val);
        $('#id_cabang').val(id);
        $('#err_cabang').html('');
    });

    $(document).on('click', '.delete', function(){
        let id = $(this).data('id');
        let con = confirm('Apakah anda yakin untuk menghapus data ini?');
        if(con){
            $.ajax({
                url: '<?= base_url('master/delete_cabang') ?>',
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

    function load_data(){
        const loading_animation = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $('#load_data').html(loading_animation);

        $.ajax({
            url: '<?= base_url('ajax/get_data_cabang'); ?>',
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
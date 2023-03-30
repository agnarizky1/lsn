<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/toastr/build/toastr.min.css') ?>">

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/toastr/build/toastr.min.js') ?>"></script>
    <title>Forgot Password</title>
</head>

<body style="background: #147019">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-lg-5 mt-3">
                <div class="card shadow mt-5">
                    <div class="card-body">
                        <h3 class="text-center" style="color: #000000"><b>Forgot Your Password ?</b></h3>

                        <form class="user" method="post" action="<?= base_url('auth/changepassword'); ?>">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Enter New Password...">
                                <?= form_error('password1', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password...">
                                <?= form_error('password2', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Change Password
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="scs_msg" data-msg="<?= $this->session->flashdata('message_scs') ?>"></div>
    <div id="err_msg" data-msg="<?= $this->session->flashdata('message_err') ?>"></div>

    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1700",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>


    <script>
        let success = $('#scs_msg').data('msg');
        let error = $('#err_msg').data('msg');

        if (success) {
            toastr["success"](success, "Success");
        }
        if (error) {
            toastr["error"](error, "Error");
        }
    </script>
</body>

</html>
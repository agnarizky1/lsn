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
                        <form action="<?= base_url('auth/forgotpassword') ?>" id="formLogin" method="post">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                                </div>

                                <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" name="email" id="email">
                            </div>
                            <small class="text-danger" id="err_email"></small>



                            <a href="<?= base_url('auth/forgotpassword') ?>"><small>Sign In?</small></a>
                            <button class="btn btn-danger float-right mt-3" id="toLogin" type="submit">Login</button>
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
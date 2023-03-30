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
    <title>Login</title>
</head>

<body style="background: #147019">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-lg-5 mt-3">
                <div class="card shadow mt-5">
                    <div class="card-body">
                        <h3 class="text-center" style="color: #000000"><b>Login Page</b></h3>
                        <form action="<?= base_url('auth/validation_login') ?>" id="formLogin" method="post">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                                </div>

                                <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" name="email" id="email">
                            </div>
                            <small class="text-danger" id="err_email"></small>


                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                                </div>

                                <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" id="password" name="password">
                            </div>
                            <small class="text-danger" id="err_password"></small>

                            <a href="<?= base_url('auth/forgotpassword') ?>"><small>Lupa Password?</small></a>
                            <button class="btn btn-danger float-right mt-3" id="toLogin" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        $('#formLogin').submit(function(e) {
            e.preventDefault();
            $('#toLogin').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#toLogin').attr('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d) {
                    $('#toLogin').html('Login');
                    $('#toLogin').removeAttr('disabled');

                    if (d.type == 'validation') {
                        if (d.err_email == '') {
                            $('#err_email').html('');
                        } else {
                            $('#err_email').html(d.err_email);
                        }

                        if (d.err_pass == '') {
                            $('#err_password').html('');
                        } else {
                            $('#err_password').html(d.err_pass);
                        }
                    } else if (d.type == 'result') {
                        $('#err_email').html('');
                        $('#err_password').html('');


                        if (d.success == false) {
                            toastr["error"](d.msg, "Error");
                        } else {
                            $('#email').val('');
                            $('#password').val('');

                            toastr["success"](d.msg, "Success");
                            setTimeout(() => {
                                window.location.href = d.redirect;
                            }, 1700);
                        }
                    }
                },
                error: function(xhr) {
                    $('#toLogin').html('Login');
                    $('#toLogin').removeAttr('disabled');

                    if (xhr.status === 0) {
                        toastr["error"]("No internet access", "Error");
                    } else if (xhr.status == 404) {
                        toastr["error"]("Page not found", "Error");
                    } else if (xhr.status == 500) {
                        toastr["error"]("Internal server error", "Error");
                    } else {
                        toastr["error"]("Unknow error", "Error");
                    }
                }
            });

        });
    </script>
</body>

</html>
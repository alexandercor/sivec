<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syvec | Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <?= link_tag("$miUrlBase/plugins/fontawesome-free/css/all.min.css")?>
    <?= link_tag("$miUrlBase/plugins/icheck-bootstrap/icheck-bootstrap.min.css")?>
    <?= link_tag("$miUrlBase/dist/css/adminlte.min.css")?>
    <?= link_tag("resources/bandel/web/css/assets.css")?>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card">
                <div class="card-header">
                    <div class="login-logo">
                        <a href="<?= base_url();?>home"><b>Admin</b>Sys</a>
                    </div>
                </div>
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Ingresa tus datos para acceder a tu cuenta</p>

                    <form id="frm_login" action="<?= base_url()?>login" method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <input type="text" id="txtLogSendUsu" name="txtLogSendUsu" class="form-control" placeholder="Usuario">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <input type="password" id="txtLogSendPas" name="txtLogSendPas" class="form-control" placeholder="Contraseña">
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-check-circle"></i> Ingresar </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="div_errors" class="error_danger"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= script_tag("$miUrlBase/plugins/jquery/jquery.min.js") ?>
        <?= script_tag("$miUrlBase/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>
        <?= script_tag("$miUrlBase/dist/js/adminlte.min.js") ?>

        <script>
            $(() => {
                
            })

            $('#frm_login').on('submit', function (e) { 
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                })
                .done( function(data){
                    const { status, msg, urlDestino, errors } = data;
                    if(status){
                        $(location).attr('href', urlDestino);
                    }else{
                        let items = '';
                        for(const key in errors){
                            items += `<p>${errors[key]}</p>`;
                        }
                        $('#div_errors').html(`<div class="alert">${items}</div>`);
                    }
                })
                .fail( function(jqXHR){
                    console.log(jqXHR)
                });
   
            });
        </script>

    </body>
</html>

 <!DOCTYPE html>
<html>
    <head>
          
        <meta charset="utf-8">

        <!-- CSS -->
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css"
            type="text/css" rel="stylesheet" />
        <link href="<?= base_url() ?>assets/css/shop-homepage.css"
            type="text/css" rel="stylesheet" />
        <link href="<?= base_url() ?>assets/css/tienda.css" type="text/css"
            rel="stylesheet" />



        <title>Tienda virtual</title>

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= site_url('home') ?>">Mi Tienda</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse"
                    id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= site_url('home/ShowAboutView') ?>">Sobre mi</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                Cesta <span id="cartTotalPrice"></span> 
                                <span class="caret"></span> 
                            </a>
                            <div class="dropdown-menu" role="menu">
                                
                                <div class="col-md-12">
                                    <table id="table_cart" class="table table-hover">
                                        
                                    </table>
                                    <p>
                                        <a href="<?= site_url('cartController/GetCartView') ?>"
                                            class="btn btn-success btn-sm pull-right"><i
                                            class="glyphicon glyphicon-shopping-cart"></i>Mas detalles</a>
                                    </p>
                                </div>
                            

                            </div></li>

                        <li class="dropdown user-dropdown"><a href="#"
                            class="dropdown-toggle" data-toggle="dropdown"><i
                                class="glyphicon glyphicon-user"></i> <?= isset($user['userName']) ? $user['userName'] : 'Identificate' ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            <?php  if (isset($user['userName'])) { ?>

                                <li><a
                                    href="<?= site_url('userController/UserPanel/') ?><?= $user['idUser'] ?>"><i
                                        class="glyphicon glyphicon-th-large"></i> Panel de usuario</a>
                                </li>

                                <li class="divider"></li>

                                <li><a href="<?= site_url('userController/logoutUser') ?>"><i
                                        class="glyphicon glyphicon-log-out"></i> Cerrar sesión</a>
                                </li>

                            <?php } else { ?>

                                <li><a href="<?= site_url('userController/LoginUserForm/') ?>"><i
                                        class="glyphicon glyphicon-log-in"></i> Iniciar sesión</a>
                                </li>

                                <li><a href="<?= site_url('userController/CreateUserForm/') ?>"><i
                                        class="glyphicon glyphicon-log-in"></i> Nueva cuenta</a>
                                </li>

                            <?php  } ?>
                                                        
                        </ul></li>
                    </ul>
                </div>

                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <div class="container">
            <div class="row"><?= $bodyView ?></div>
        </div>

         <div class="footer">
            <p>Moises Campon Garcia (c)</p>
        </div>
    
        <!--JAVASCRIPT-->
        <script src="<?= base_url() ?>assets/js/jquery-1.11.1.min.js"
        type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"
            type="text/javascript"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        <script type="text/javascript">
            $(document).ready(function(){   
                $.ajax({
                    url: '<?= site_url('/cartController/GetCartData/') ?>' 
                }).done(function(data){
                    $('#cartTotalPrice').html(data.totalPrice + '€');
                });
            });
        </script>
    </body>
</html>

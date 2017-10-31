<?php
//include_once("controllers/lock.php"); 

/*session_start();
if($_SESSION['ss_id_usuario'] == NULL ||  $_SESSION['ss_id_usuario'] == ""){
    echo "No cuentas con una sesión";
    header('Location: index.html');
    die();
}*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>Actualización Geográfica</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> <!-- movil -->
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>  <!-- caracteres -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- compativilidad -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- dispositivos -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">     -->
    <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/3.15/themes/css/cartodb.css" />
    <script src="http://libs.cartocdn.com/cartodb.js/v3/3.15/cartodb.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.3/leaflet.draw.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.3/leaflet.draw.js"></script>
    
    <!--     <link type="text/css" rel="stylesheet" href="css/style.css">
    <link type="text/css" rel="stylesheet" href="css/main2.css"> -->

    <script src="main.js" type="text/javascript"></script>
    
    <link href="js/s2/select2.min.css" rel="stylesheet" />
    <script src="js/s2/select2.min.js"></script>
    <script type="text/javascript">
        $('select').select2();
    </script>
    <!-- leaflets -->
    <!-- <link href="js/leaflet/leaflet.css" rel="stylesheet">
    <script src="js/leaflet/leaflet.js"></script> -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" type="text/css" href="css/animate/animate.css"/> -->
    <link rel="stylesheet" type="text/css" href="css/header2.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" href="js/leaflet-beautify/leaflet-beautify-marker-icon.css">
    <script src="js/leaflet-beautify/leaflet-beautify-marker-icon.js"></script>

</head>
<body>
    <header id="Header">
        <div class="header-element">
            <div class="header-menu">
                <div class="menu-controls">
                    <button type="button" class="btn btn-default" >         <!-- <button type="button" class="btn btn-default" id="Show-sidebar"> -->
                        <i class="fa fa-navicon"></i>
                    </button>
                </div>
                <div class="menu-access version-main">
                    <button type="button" class="btn btn-default" id="Show-menu">
                        <i class="fa fa-gears"></i>
                    </button>
                </div>
            </div>
            <div class="header-logo">
                <a href="/">
                    <strong>Plataforma CDMX</strong>
                    <span>Reconstrucción</span>
                </a>
            </div>
            <div id="Lights_Inicio" class="header-options">
                <div class="inner" style="">
                    <div class="labelInit">
                        ACTUALIZACIÓN DE PUNTOS GEOGRÁFICOS <span class="totalRiesgo"></span>
                    </div>

                    <!-- <div class="labelCity">Captura de información adicional</div> -->
                </div>
            </div>

            <div class="header-cdmx">
                <img src="images/Logo-cdmx.png" alt="CDMX" width="120">
            </div>
        </div>
    </header>
    <br><br>
    <br><br>
    <article>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 columna">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Filtros</h3>
                            </div>
                            <div class="panel-body">
                                <form class="form-inline">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 columna">
                                            <div class="form-group">
                                                <p>Delegación a elegir:</p>
                                                <select style="width: 230px;" class="js-example-basic-single form-control" name="selectDel" id="selectDel" >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 columna">
                                            <div class="form-group">
                                                <p>Colonia a elegir:</p>
                                                <select style="width: 230px;" class="js-example-basic-single2 form-control" name="selectCol" id="selectCol">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 columna" >
                                            <div class="form-group">
                                                    <div id="callefilter" style="display: none;">
                                                    <p>Calle a elegir:</p>
                                                    <select style="width: 230px;" class="js-example-basic-single3 form-control" name="selectCal" id="selectCal">
                                                    </select>
                                                    </div>
                                                <!-- <input type="button" name="Buscar" value="Buscar" class="btn btn-info" id="dgiFilterSearch"> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 columna">
                                            <div class="form-group">
                                                <p>&nbsp; &nbsp;</p>
                                                <input type="button" name="Buscar" value="Buscar" class="btn btn-info" id="dgiFilterSearch">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 columna">
                                            <div id="resultado">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <div id="map" style="height: 700px;"></div>
                    </div>
                </div>
            </div>
        </section>
    </article>
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="copyright">
                        SIG-CDMX @ 2017 Gobierno de CDMX
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
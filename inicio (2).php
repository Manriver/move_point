<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<link rel="shortcut icon" href="http://cartodb.com/assets/favicon.ico" />
	<link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/3.15/themes/css/cartodb.css" />

	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/animate/animate.css"/>
	<link rel="stylesheet" type="text/css" href="./css/header2.css">
	<link rel="stylesheet" type="text/css" href="./css/main.css">

	<script type="text/infowindos" id="info">
		<div class="cartodb-popup v2">
			<a href="#close" class="cartodb-popup-close-button close">x</a>
			<div class="cartodb-popup-content-wrapper">
				<div class="cartodb-popup-content">
					<p>Registro </p>
					<label>{{idregistro}}</label>

				</div>
			</div>
			<div class="cartodb-popup-tip-container"></div>
		 </div>
	</script>

</head>
<body>
	<header id="Header">
        <div class="header-element">
            <div class="header-menu">
                <div class="menu-controls">
                    <button type="button" class="btn btn-default" >			<!-- <button type="button" class="btn btn-default" id="Show-sidebar"> -->
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
                        INMUEBLES CON SEMÁFORO AMARILLO <span class="totalRiesgo"></span>
                    </div>

                    <div class="labelCity">Captura de información adicional</div>
                </div>
            </div>

            <div class="header-cdmx">
                <img src="images/Logo-cdmx.png" alt="CDMX" width="120">
            </div>
        </div>
    </header>

    <div style="height: 69px;"  ></div>
    <div id="complementoBarraSuperior"></div>
    
    <?php
    ini_set('display_errors', 'Off');
    session_start();
	$id_perfil = $_SESSION['ss_id_perfil'];
	if($id_perfil == 61){
		$id_ente = 1;			//SI ES ADI
	}elseif($id_perfil == 62){
		$id_ente = 2;
	}elseif($id_perfil == 63){
		$id_ente = 3;
	}
    ?>
    <input type="hidden" id="id_ente" name="id_ente" value="<?php echo $id_ente?>"/>    

    <div id="opciones" class="btn-group-vertical" role="group" aria-label="Vertical button group">
    	<button id="busqueda" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
    	<button type="button" class="btn btn-default"><i class="fa fa-refresh"></i></button>
	</div>


    <div id="options" style="display: none">
        <div class="filtering">
            <button type="button" id="close_filter" class="pull-right" style="border-radius: 3px;">
                ×
            </button>
            <br />
            <div class="form-group">
                <label for="criterio">CRITERIO:</label>
                <select id="criterio" class="form-control text-uppercase input-sm" style="border: 1px solid #e90eb0; border-radius: 3px">
            		<option value="">SELECCIONE UN CRITERIO:</option>
            		<option value="1">POR DELEGACIÓN:</option>
            		<option value="2">POR CALLE:</option>
            		<option value="3">ID REGISTRO:</option>
            	</select>
            </div>
            <div id="deleg" class="form-group" style="display: none">
                <label for="">SELECCIONAR DELEGACIÓN:</label>
                <!-- <select class="form-control deleg text-uppercase input-sm" name="selectDel" style="border: 1px solid #e90eb0; border-radius: 3px"> -->
                <select id="dgiCmbDel" name="dgiCmbDel" class="form-control deleg text-uppercase input-sm" style="border: 1px solid #e90eb0; border-radius: 3px"></select>
                </select>
            </div>
            <div id="calle" class="form-group" style="display: none">
                <label for="">BUSCAR CALLE:</label>
                <input id="txtDireccion" name="txtDireccion" placeholder="calle, numero, colonia" class="form-control text-uppercase input-sm" autocomplete="off" type="text">
            </div>
            <div id="id_reg" class="form-group" style="display: none">
                <label for="">INGRESE EL ID:</label>
                <input id="idreg" name="idreg" placeholder="INGRESE EL ID" class="form-control text-uppercase input-sm" type="text">
            </div>
        </div>
    </div>


	<div class="mainMap">
		<!--<div id="dgiFilter" class="dgiFilter" style="display:none">
					<div id="dgiFlrDel">
						<p>Delegacion</p>
						<select id="dgiCmbDel" name="dgiCmbDel"></select>
					</div>
					<div id="dgiFlrCol">
						<p>Colonia</p>
						<select id="dgiCmbCol" name="dgiCmbCol">
							<option value=""></option>
						</select>
					</div>
					<button type="button" id="dgiFilterSearch">
						<i class="fa fa-hand-o-right" aria-hidden="true"></i>
						Ir a
					</button>
		</div> -->

		<div id="modal" class="modal fade" role="dialog">
			<div id="size" class="modal-dialog">
				<div class="modal-content">
					<div id="modal_header" class="modal-header">
						<button type="button" class="close btn-success" data-dismiss="modal">
							&times;
						</button>
						<h4 id="modal-title" class="modal-title"></h4>
					</div>
					<div id="modal_header2" class="modal-header">
						<h4 id="modal-title2" class="body_title"></h4>
					</div>
					<div class="modal-body">
						<div id="modal_body_title" ></div>
						<div id="modal_content">
							<ul class="nav nav-tabs">
								<li id="li1" class="active"><a href="#extra">Capturar Información</a></li>
								<li id="li2" ><a href="#dg">Datos Generales</a></li>
							</ul>
							<div class="tab-content">
								<div id="extra" class="tab-pane fade in active"></div>
								<div id="dg" class="tab-pane fade"></div>
							</div>
						</div>
						<br /><div id="alert"></div>
					</div>


					<!-- </div> -->
					<div id="modal_footer" class="modal-footer">
						<div id="btn_cerrar" style="display: inline-block">
							<button id="modal_cerrar" type="button" class="btn btn-default" data-dismiss="modal">
								Cerrar
							</button>
						</div>
						<div id="btn_accion" style="display: inline-block">
							<button data-accion="accion" type="button" class="btn">
								Accion
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="map"></div>
	</div>
	
	<div id="googlemap" style="width:300px;heigth:400px;"></div>

	<div style="display:none;" id="loading"></div>
	<div style="display:none;" id="loading2"></div>

	<script src="http://libs.cartocdn.com/cartodb.js/v3/3.15/cartodb.js"></script>
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script> -->
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.fileDownload/1.4.2/jquery.fileDownload.min.js"></script> -->
	<!-- <script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/notify/bootstrap-notify.min.js"></script>
	<script type="text/javascript" src="js/funciones.js"></script>
	<script type="text/javascript" src="scripts/functions.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2cjxQ5RpEyBg0BUAGiUKX3Lm5T2_0ySQ&libraries=places&callback=mapInit"></script>
	<script type="text/javascript" src="scripts/controls.js"></script>
	<script type="text/javascript" src="scripts/events.js"></script>
	<script type="text/javascript" src="scripts/maps.js"></script>
</body>
</html>


<?php
  function menu_activo($uri_activa='') 
  {
  	if($uri_activa==uri_string()) {
  		echo 'class="sel"';
  	}
  }
  ?>
  
  <div id="header" style="display:none">
  <div class="container">
    <div class="row">
      <div class="col-xs-6"><a href="<?php echo base_url(); ?>" class="logo-tv-azteca-noreste">TV Azteca Noreste</a></div>
      <div class="col-xs-6">
        <ul>
          <li><a href="<?php echo site_url('secciones/tvenvivo'); ?>" class="tvenvivo">TV En Vivo</a></li>
        </ul>
      </div>
    </div><!--/row-->
  </div><!--/container-->
</div><!--/header-->

<div id="menu-principal">
  <div id="fondo">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <a href="<?php echo base_url(); ?>" class="logo-tv-azteca-noreste-fijo">TV Azteca Noreste</a>
        <a class="tvenvivo" href="<?php echo site_url('secciones/tvenvivo'); ?>">TV En Vivo</a>
        <?php /* ?><a href="#" class="busqueda"><span class="glyphicon glyphicon-search"></span></a> */ ?>
        <ul>
          <!--li><a href="http://info7.mx" target="_blank">NOTICIAS</a></li-->
          <li><a href="<?php echo site_url('secciones/detalle/1'); ?>" <?php menu_activo('secciones/detalle/1'); ?>>DEPORTES</a></li>
          <li><a href="<?php echo site_url('secciones/detalle/2'); ?>" <?php menu_activo('secciones/detalle/2'); ?>>ENTRETENIMIENTO</a></li>
          <li><a href="<?php echo site_url('secciones/redes_sociales'); ?>" <?php menu_activo('secciones/redes_sociales'); ?>>REDES SOCIALES</a></li>
        </ul>
      </div>
    </div><!--/row-->
  </div><!--/container-->
  </div><!--/fondo-->
  <div id="busqueda" class="hidden">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <form class="form" role="search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar">
            <span class="input-group-btn">
              <button type="reset" class="btn btn-default btn-cerrar">
                <span class="glyphicon glyphicon-remove">
                  <span class="sr-only">Cerrar</span>
                </span>
              </button>
              <button type="submit" class="btn btn-default btn-buscar">
                <span class="glyphicon glyphicon-search">
                  <span class="sr-only">Buscar</span>
                </span>
              </button>
            </span>
          </div>
          </form>
        </div>
      </div><!--/row-->
    </div><!--/container-->
  </div><!--/busqueda-->
</div><!--/menu-principal-->
<div id="middle">
      <div class="container">

        <?php /*
        <div class="row" id="publicidad-central-listados">
          <div class="col-xs-12 text-center"><a href="#"><img src="http://dummyimage.com/780X120/f2f2f2/dddddd.png" alt="" /></a></div>
        </div><!--/publicidad-central--> */ ?>

        <div class="row" id="detalle-programa">
          <div class="col-xs-6">
            <h2><a href="<?php echo site_url('secciones/detalle/'.$seccion_id); ?>"><?php echo get_field_name('secciones', 'nombre', $seccion_id); ?></a> / <a href="<?php echo site_url('videos/lista/'.$seccion_id); ?>">Videos</a>
            	
            <?php if($this->uri->segment(4)): ?>
          	/ <a href="<?php echo site_url('videos/lista/'.$seccion_id.'/'.$this->uri->segment(4)); ?>"><?php echo get_field_name('categorias', 'nombre', $this->uri->segment(4)); ?></a>
            <?php endif; ?> 	
            </h2>
            <h1>VIDEOS</h1>
          </div><!--/indicador-->
          <div class="col-xs-6">
            <div id="ubicacion">
             
            </div><!--ubicacion-->
          </div><!--/redes-->
        </div><!--/detalle-programa-->

        <?php if(@$notas): ?>
        <div class="row" id="contenido">
          <div class="col-xs-12" id="listado-reportajes">
            <ul class="row">
              <?php foreach($notas as $nota): ?>
              <li class="col-xs-3"><a href="<?php echo site_url('videos/detalle/'. (int) $nota->id); ?>"><img src="<?php echo  get_thumb($nota->id, 'notas', $nota->imagen1, 560, 420);?>" alt="" /><span><?php echo trim($nota->titulo); ?></span><img class="btn-play" style="height: 60px; left: 50%; margin-left: -30px; margin-top: -58px;  position: absolute; top: 50%;  width: 60px;" alt="" src="assets/public/img/comunes/btn-play.png"></a></li>
              <?php endforeach; ?>
            </ul>
            <div class="text-center">
            	
              <ul class="pagination">
               <?php echo $pagination; ?>
              </ul>
              
            </div><!--/text-center-->
          </div><!--/listado-reportajes-->

          <div class="col-xs-3" id="publicidad-lateral" style="display:none;">
            <a href="#"><img src="http://dummyimage.com/240X90/f2f2f2/dddddd.png" alt="" /></a>
            <a href="#"><img src="http://dummyimage.com/240X90/f2f2f2/dddddd.png" alt="" /></a>
            <a href="#"><img src="http://dummyimage.com/240X90/f2f2f2/dddddd.png" alt="" /></a>
            <a href="#"><img src="http://dummyimage.com/240X350/f2f2f2/dddddd.png" alt="" /></a>
          </div><!--/publicidad-lateral-->

        </div><!--/contenido-->
        <?php else: ?>
        	<h1>No hay videos disponibles</h1>
        <?php endif; ?>

      </div><!--/container-->
    </div><!--/middle-->
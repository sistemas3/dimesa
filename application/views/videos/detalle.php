<?php if(!empty($nota->video_contenido)): ?>
<link href="http://jplayer.org/js/prettify/prettify-jPlayer.css" rel="stylesheet" type="text/css" />
<link href="assets/jplayer/skins/bluemonday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="assets/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="assets/jplayer/add-on/jquery.jplayer.inspector.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

	$("#jquery_jplayer_1").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				title: "<?php echo @$nota->titulo; ?>",
				m4v: "<?php echo get_video($nota->id, 'notas', $nota->video_contenido); ?>",
				poster: "<?php echo get_thumb($nota->id, 'notas', $nota->imagen1, 560, 420);?>"
			});
		},
		swfPath: "assets/jplayer",
		supplied: "webmv, ogv, m4v, mp4",
		size: {
			width: "640px",
			height: "360px",
			cssClass: "jp-video-360p"
		},
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true,
		solution:"flash,html"
	});

	//$("#jplayer_inspector").jPlayerInspector({jPlayer:$("#jquery_jplayer_1")});
});
//]]>
</script>
<?php endif; ?>

    <div id="middle">
      <div class="container">

        <?php /* <div class="row" id="publicidad-central-listados">
          <div class="col-xs-12 text-center"><a href="#"><img src="http://dummyimage.com/780X120/f2f2f2/dddddd.png" alt="" /></a></div>
        </div><!--/publicidad-central--> */ ?>

        <div class="row" id="detalle-programa">
          <div class="col-xs-6">
          	<?php
          	$categoria = !empty($nota->video_contenido) ? 'videos' : 'noticias';
          	?>
            <h2><a href="<?php echo site_url('secciones/detalle/'.$nota->seccion_id); ?>"><?php echo get_field_name('secciones', 'nombre', $nota->seccion_id); ?></a> / <a href="<?php echo site_url($categoria.'/lista/'.$nota->seccion_id.'/'.$nota->categoria_id); ?>"><?php echo get_field_name('categorias', 'nombre', $nota->categoria_id); ?></a> / <a href="<?php echo site_url($categoria.'/lista/'.$nota->seccion_id); ?>"><?php echo $categoria_nombre; ?></a></h2>
            <h1 style="margin-bottom:0px;"><?php echo trim($nota->titulo); ?></h1>
            
            <?php $f =  explode(" ", $nota->fecha_alta); ?>
            <span style="float:left; width:100%; margin-bottom:20px; font-size:12px; color:#666;">Fecha de publicación: <?php echo $f[0]; ?></span>
          </div><!--/indicador-->
          <div class="col-xs-6">
            <div id="ubicacion">
             
            </div><!--ubicacion-->
          </div><!--/redes-->
        </div><!--/detalle-programa-->

        <div class="row" id="contenido">
          <div class="col-xs-9" id="detalle-reportaje-episodio">
          	
          	
          	<?php if(empty($nota->video_contenido)): ?>
            
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <?php if(!empty($nota->imagen2)): ?>
    	<li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <?php endif; ?>
    
     <?php if(!empty($nota->imagen3)): ?>
    	<li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <?php endif; ?>
    
     <?php if(!empty($nota->imagen4)): ?>
    	<li data-target="#carousel-example-generic" data-slide-to="3"></li>
    <?php endif; ?>
    
     <?php if(!empty($nota->imagen5)): ?>
    	<li data-target="#carousel-example-generic" data-slide-to="4"></li>
    <?php endif; ?>
    
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
  
    <div class="item active">
      <img src="<?php echo get_thumb($nota->id, 'notas', $nota->imagen1, 560, 420);?>" class="foto center-block" alt="" />
    </div>
    
    <?php if(!empty($nota->imagen2)): ?>
    <div class="item">
      <img src="<?php echo get_thumb($nota->id, 'notas', $nota->imagen2, 560, 420);?>" class="foto center-block" alt="" />
    </div>
    <?php endif; ?>
    
    <?php if(!empty($nota->imagen3)): ?>
    <div class="item">
      <img src="<?php echo get_thumb($nota->id, 'notas', $nota->imagen2, 560, 420);?>" class="foto center-block" alt="" />
    </div>
    <?php endif; ?>
    
    <?php if(!empty($nota->imagen4)): ?>
    <div class="item">
      <img src="<?php echo get_thumb($nota->id, 'notas', $nota->imagen2, 560, 420);?>" class="foto center-block" alt="" />
    </div>
    <?php endif; ?>
    
    <?php if(!empty($nota->imagen5)): ?>
    <div class="item">
      <img src="<?php echo get_thumb($nota->id, 'notas', $nota->imagen2, 560, 420);?>" class="foto center-block" alt="" />
    </div>
    <?php endif; ?>
    
    
    
</div>
</div>
            
            <?php endif; ?>
            
         
            
            <!--<img src="http://dummyimage.com/560X420/fcf8e3/664C00.png&amp;text=560 x 420 - Foto opcional" class="foto center-block" alt="" />-->
            <p><?php echo trim($nota->contenido); ?></p>
            <?php /* <p class="text-center"><br /><a href="#">LINKS PARA COMPARTIR AQUÍ</a></p> */ ?>
            
            <?php if(!empty($nota->video_contenido)): ?>
            <div class="text-center video-player">
				<center>
				<div id="jp_container_1" class="jp-video" style="text-align: left !important;">
					<div class="jp-type-single">
						<div id="jquery_jplayer_1" class="jp-jplayer"></div>
						<div class="jp-gui">
							<div class="jp-video-play">
								<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
							</div>
							<div class="jp-interface">
								<div class="jp-progress">
									<div class="jp-seek-bar">
										<div class="jp-play-bar"></div>
									</div>
								</div>
								<div class="jp-current-time"></div>
								<div class="jp-duration"></div>
								<div class="jp-controls-holder">
									<ul class="jp-controls">
										<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
										<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
										<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
										<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
										<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
										<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
									</ul>
									<div class="jp-volume-bar">
										<div class="jp-volume-bar-value"></div>
									</div>
									<ul class="jp-toggles">
										<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
										<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
										<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
										<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
									</ul>
								</div>
								<div class="jp-details">
									<ul>
										<li><span class="jp-title"></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				</center>
            </div><!--/text-center-->
            <?php endif; ?>
            
            
            <p>
            
                <div id="disqus_thread"></div>
			    <script type="text/javascript">
			        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			        var disqus_shortname = 'tvaztecanoreste2'; // required: replace example with your forum shortname
			
			        /* * * DON'T EDIT BELOW THIS LINE * * */
			        (function() {
			            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			        })();
			    </script>
			    <noscript>Por favor activa el JavaScript para ver los <a href="http://disqus.com/?ref_noscript">comentarios por Disqus.</a></noscript>
			    <a href="http://disqus.com" class="dsq-brlink">comentarios por <span class="logo-disqus">Disqus</span></a>
			    	
            	
            </p>
            
            <p class="text-center"><a href="<?php echo site_url('noticias/lista/'.$nota->seccion_id); ?>">Regresar a reportajes</a></p>
          </div><!--/detalle-reportaje-episodio-->

          <div class="col-xs-3" id="publicidad-lateral">
        <a href="#"><img src="http://dummyimage.com/240X277/f2f2f2/dddddd.png" alt="" /></a>
        <a href="#"><img src="http://dummyimage.com/240X277/f2f2f2/dddddd.png" alt="" /></a>
          </div><!--/publicidad-lateral-->

        </div><!--/contenido-->

      </div><!--/container-->
    </div><!--/middle-->

<script type="text/javascript" src="http://jplayer.org/js/prettify/prettify-jPlayer.js"></script>

  
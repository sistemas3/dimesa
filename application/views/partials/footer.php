
    

<div id="footer">
  <div class="container">
    <div class="row">
      <div class="col-xs-9" id="mapa-sitio">
        <ul class="row">
          <li class="col-xs-3"><a href="http://info7.mx/a/" target="_blank">NOTICIAS</a>
            <ul>
              <li><a href="http://info7.mx/a/" target="_blank">INFO7</a></li>
              <li><a href="#"></a></li>
            </ul>
          </li>
          <li class="col-xs-3"><a href="<?php echo site_url('secciones/detalle/1') ?>">DEPORTES</a>
            <?php
            $programas = $this->mjson->get('footer', false, 'deportes');
            if(!$programas) {
              $this->db->where('seccion_id', 1);
              $programas = $this->db->get('programas')->result();
              $this->mjson->save('footer', false, $programas, 'deportes');
            }
            ?>
            <?php if($programas): ?>
            <ul>
              <?php foreach($programas as $p): ?>
              <li><a href="<?php echo site_url('programas/detalle/'.$p->id); ?>"><?php echo $p->nombre; ?></a></li>
              <?php endforeach ?>
              <li><a href="<?php echo site_url('noticias/lista/1'); ?>">Reportajes</a></li>
            </ul>
            <?php endif; ?>
          </li>
          <li class="col-xs-3"><a href="<?php echo site_url('secciones/detalle/2') ?>">ENTRETENIMIENTO</a>
            <?php
            $programas = $this->mjson->get('footer', false, 'entretenimiento');
            if(!$programas) {
              $this->db->where('seccion_id', 2);
              $programas = $this->db->get('programas')->result();
              $this->mjson->save('footer', false, $programas, 'entretenimiento');
            }
            ?>
            <?php if($programas): ?>
            <ul>
              <?php foreach($programas as $p): ?>
              <li><a href="<?php echo site_url('programas/detalle/'.$p->id); ?>"><?php echo $p->nombre; ?></a></li>
              <?php endforeach ?>
              <li><a href="<?php echo site_url('noticias/lista/2'); ?>">Reportajes</a></li>
            </ul>
            <?php endif; ?>
          </li>
          <li class="col-xs-3"><a href="#">AZTECA NORESTE</a>
            <ul>
              <li><a href="<?php echo site_url('secciones/contacto'); ?>">Contacto</a></li>
              <li><a href="<?php echo site_url('secciones/bolsa_trabajo'); ?>">Bolsa de Trabajo</a></li>
              <li><a href="<?php echo site_url('secciones/aviso_privacidad'); ?>">Aviso de Privacidad</a></li>
            </ul>
          </li>
        </ul>
      </div><!--/mapa-sitio-->
      <div class="col-xs-3" id="datos-contacto">
        <img src="assets/public/img/comunes/logo-tv-azteca-noreste-footer_b.png" alt="Azteca Noreste"  />
        <span>Azteca Noreste 2014.<br />Todos los Derechos Reservados.</span>
        <ul>
          <li>Síguenos:</li>
          <li><a href="https://www.facebook.com/AztecaNoreste" class="facebook" target="_blank">Facebook</a></li>
          <li><a href="https://twitter.com/aztecanoreste" class="twitter" target="_blank">Twitter</a></li>
          <li><a href="https://www.youtube.com/user/AztecaNoresteTv" class="youtube" target="_blank">YouTube</a></li>
        </ul>
      </div><!--/datos-contacto-->
    </div><!--/row-->
  </div><!--/container-->
</div><!--/footer-->
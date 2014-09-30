<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title><?php echo @$template['title']; ?></title>
	
	<base href="<?php echo real_base_url(); ?>" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
	<link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />


    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="assets/bootstrap/js/bootstrap.js"></script>
	<script src="assets/bootstrap/js/bootstrap-dropdown.js"></script>
	
  <style>

  body {
    background-color: #f5f5f5;
  }

  .box {
    font-size: 11px;
    margin: 11px 6px 6px 6px;
    padding:11px;
    background: #FFF;
    border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }

  #header {
    width:100%;
    height: 60px;
    background: #FFF;
    overflow: hidden;
  }

  #header .logo {
    float: left;
  }

  #header .buttons {
    float: right;
    padding:13px 10px 0px 0px;
  }
  </style>
</head>
<body>

<?php if(@$this->admin): ?>  

<div id="header" class="container" style="height: auto !important; background: #fff; ">
<img src="assets/img/logo.png" alt="TV Azteca" title="TV Azteca" class="logo" />
</div>


<div class="navbar navbar-inverse navbar-static-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="nav-collapse collapse">

        <ul class="nav">
        	
        
           <li class="<?php if($this->uri->segment(2)=='tipo_cambios') { echo 'active'; } ?>">
            <a href="<?php echo site_url('admin/tipo_cambios'); ?>">Tipo de cambio</a>
          </li>        
        </ul>

        <ul class="nav pull-right">
          <li class="">
            <a href="<?php echo site_url('admin/usuarios/logout'); ?>">Salir</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>


<?php endif; ?>


<div class="container">
<?php echo @$template['partials']['flashmessages']; ?>
</div>

<div class="container">
	<?php echo @$template['body']; ?>
</div>



</body>
</html>
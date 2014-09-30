<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <?php /* <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 * 
	 * <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> */ ?>
  <title><?php echo @$template['title']; ?></title>

	<base href="<?php echo real_base_url(); ?>" />
    <!-- Estilos -->
    <link href="assets/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/public/css/estilos.css" rel="stylesheet">
    <?php /* <link href="assets/public/css/__debug.css" rel="stylesheet"> */ ?>

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,400italic,600italic' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Analytics -->
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
  <script src="assets/js/jquery.js"></script>
  <?php echo @$template['partials']['metas']; ?>
  </head>
  <body>
  	<?php echo @$template['partials']['header']; ?>
	<?php echo @$template['body']?>
    <?php echo @$template['partials']['footer']; ?>
    <!-- JS -->
    <script src="assets/public/js/bootstrap.min.js"></script>
    <script src="assets/public/js/scripts.js"></script>
  </body>
</html>
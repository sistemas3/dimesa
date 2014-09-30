<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| ppr(string)
|--------------------------------------------------------------------------
|
| Sirve para imprimir arreglos, objetos, y demas de manera jerarquica 
|
*/
function ppr($string='') 
{
	echo '<pre>';
	print_r($string);
	echo '</pre>';
}

/*
|--------------------------------------------------------------------------
| pre_print_r(string)
|--------------------------------------------------------------------------
|
| Sirve para imprimir arreglos, objetos, y demas de manera jerarquica 
|
*/
function pre_print_r($string='') 
{
	echo '<pre>';
	print_r($string);
	echo '</pre>';
}

/*
|--------------------------------------------------------------------------
| photo(string, string)
|--------------------------------------------------------------------------
|
| Oculta la URL de la imagen y la imprime mediante PHP, solo por cuestiones
| de seguridad
|
*/
function photo($filename='', $folder=false)
{
	$path = ! $folder ? 'assets/img' : $folder;
	$file = $path . '/'. $filename;
	echo $file;
}

/*
|--------------------------------------------------------------------------
| bootstrap_files(void)
|--------------------------------------------------------------------------
|
| Crea las etiquetas necesarias para incluir todos los archivos de bootstrap
|
*/
function bootstrap_files()
{
	$bootstrap_folder = base_url() . 'assets/bootstrap/';
	echo '
		<link type="text/css" rel="stylesheet" href="'.$bootstrap_folder.'css/bootstrap.css" />
		<link type="text/css" rel="stylesheet" href="'.$bootstrap_folder.'css/bootstrap-responsive.css" />
		<script type="text/javascript" src="'.$bootstrap_folder.'js/bootstrap.js"></script>
	';
}

/*
|--------------------------------------------------------------------------
| set_flashmessage(string, string)
|--------------------------------------------------------------------------
|
| Recibe el tipo de mensaje y el contenido, a partir de esto crea una sesion
| para mostrar el mensaje en el el partial: 
|
| application/views/partials/flashmessages.php
|
*/
function set_flashmessage($type='info', $content='')
{
	$ci = &get_instance();
	return $ci->session->set_userdata('message', array('type'=>$type, 'content' => $content));
}

/*
|--------------------------------------------------------------------------
| redirect_to(void)
|--------------------------------------------------------------------------
|
| Si existe una variable get llamada redirect, la decodifica y redirige a su
| contenido, de lo contrario redirige a la pagina principal.
|
*/
function redirect_to()
{
	$url = '';
	$redirect = @$_GET['redirect'];
	
	if($redirect) {
		$url = base64_decode($redirect);
	} else {
		$url = '/';
	}

	redirect($url);

}

/*
|--------------------------------------------------------------------------
| is_current_page(void)
|--------------------------------------------------------------------------
|
| Con esta funcion se sabe si la URL del menu es igual a la actual y asi
| se le cambia el estilo al enlace, a activo.
|
*/
function is_current_page($url='')
{
	if($url == current_url()) {
		echo "active";
	} else {
		return false;
	}
}

/*
|--------------------------------------------------------------------------
| database_name(void)
|--------------------------------------------------------------------------
|
| Retorna el nombre de la base de datos.
|
*/
function database_name()
{
	$ci = &get_instance();
	$db = $ci->db;
	return (string) $db->database;
}

/*
|--------------------------------------------------------------------------
| set_flashmessage(string, string)
|--------------------------------------------------------------------------
|
| Crea un mensaje flash.
|
*/
function set_flash_message($content='', $type='success')
{
	$ci = &get_instance();
	$ci->session->set_userdata('message', array(
		'content' => $content,
		'type' => $type
	));
	return true;
}

/*
|--------------------------------------------------------------------------
| get_menu(void)
|--------------------------------------------------------------------------
|
| Retorna la estructura de las categorias, subcategorias y subsubcategorias.
|
*/
function get_menu()
{
	$ci = &get_instance();

	$ci->db->where('id !=', '1');
	$categorias = $ci->db->get('categorias')->result();
	foreach($categorias as $key => $value) {
		$ci->db->where('categoria_id', $value->id);
		$categorias[$key]->subcategorias = $ci->db->get('subcategorias')->result();
	}

	foreach($categorias as $key => $c) {
		$sc = $c->subcategorias;
		foreach($sc as $key2 => $value) {
			$ci->db->where('subcategoria_id', $value->id);
			$categorias[$key]->subcategorias[$key2]->subcsubcategorias = $ci->db->get('subsubcategorias')->result();
		}
	}

	return $categorias;
}

/*
|--------------------------------------------------------------------------
| get_categoria_name(int)
|--------------------------------------------------------------------------
|
| Retorna el nombre de la categoria perteneciente al id recibido
|
*/
function get_categoria_name($id=0) 
{
	$ci = &get_instance();
	$ci->db->where('id', $id);
	$c = $ci->db->get('categorias')->row();
	return $c->nombre;
}


/*
|--------------------------------------------------------------------------
| get_subcategoria_name(int)
|--------------------------------------------------------------------------
|
| Retorna el nombre de la subcategoria perteneciente al id recibido
|
*/
function get_subcategoria_name($id=0) 
{
	$ci = &get_instance();
	$ci->db->where('id', $id);
	$c = $ci->db->get('subcategorias')->row();
	return $c->nombre;
}

/*
|--------------------------------------------------------------------------
| get_subsubcategoria_name(int)
|--------------------------------------------------------------------------
|
| Retorna el nombre de la subsubcategoria perteneciente al id recibido
|
*/
function get_subsubcategoria_name($id=0) 
{
	$ci = &get_instance();
	$ci->db->where('id', $id);
	$c = $ci->db->get('subsubcategorias')->row();
	return $c->nombre;
}

/*
|--------------------------------------------------------------------------
| get_reviews_info(varchar)
|--------------------------------------------------------------------------
|
| Retorna un arreglo con el contenido de las calificaciones y comentarios de
| un producto en especifico, recibe el numero de material del producto.
|
*/
function get_reviews_info($parm=false)
{
	
	if( !is_array($parm) ) {
		$ci = &get_instance();
		$material = $parm;
		$reviews = $ci->mreviews->get_all_by('material', $material);
	} else {
		$reviews = $parm;
	}
	
	if(empty($reviews)) {
		$data = array();	
		$data['count_reviews'] = 0;
		$data['nombre_calificaciones'] = 'Sin calificar';
		$data['calificaciones'] = false;
		$data['porcentajes'] = false;
		$data['calificacion_promedio'] = array('calificacion'=>0, 'calificacion_nombre'=>'Sin calificar');	
		return $data;
	}
	
	$calificaciones = array(
			0=>'Sin calificar',
			1=>'Malo',
			2=>'Regular',
			3=>'Bueno',
			4=>'Muy Bueno',
			5=>'Excelente'
	);
	
	/*
	 * Declaramos el arreglo de las calificaciones promedio, cada calificacion comienza en 0%
	 * */
	$calificaciones_promedio = array(
		1=>0,
		2=>0,
		3=>0,
		4=>0,
		5=>0
	);
		
	/*
	 * Inicializamos el contador de calificaciones
	 * */
	$count = array();
		
	/*
	 * Promedio lo declaramos falso
	 * */
	$promedio = false;
		
	/*
	 * El numero total de calificaciones
	 * */
	$n = 0;
		
	/*
	 * Recorremos las calificaciones y asignamos a count, el indice de la calificacion, por ejemplo
	* Malo, Regular, Bueno...
	 * */
	foreach($calificaciones as $c) {
		$count[$c] = 0;
	}
		
	/*
	 * Si hay reviews, recoerremos cada review e incrementamos su calificacion de acuerdo a su indice
	 * */
	if(@$reviews) {
		foreach(@$reviews as $review) {
			@$count[$calificaciones[$review->calificacion]] +=1;
			$calificaciones_promedio[$review->calificacion] += 1;
			$n += 1;
		} 
	}
		
	/*
	* Declaramos la variable temporal sum, para calcular promedios
	 * */
        $sum = 0;
	$frecuencias = 0;
	/*
	 * Recorremos el arreglo calificaciones_promedio, y sumamos la calificacion de acuerdo a su indice
	 * 
	 * Por ejemplo, Malo = 1, Regular = 2, Bueno = 3.
	 * 
	 * Si alguien voto 2 malos y uno regular la suma seria: 1+1+2.
	 * */
	//ppr($calificaciones_promedio);
    //aa otra es que saques un promedio con frecuencias :$$$ es (7x1+1x2+2x3+5x4+1x5)/16 que es la suma de las frecuencias :$$$$ o sea del 7 1 2 5 1 :$$
	foreach($calificaciones_promedio as $key => $value) {
	        $sum += ($key * $value);
		$frecuencias += $value;
	}
	//ppr($sum/5);
	//exit;
		
	/*
	 * Redondeamos el promedio
	 * */
	$calificacion_promedio = (int) (round($sum / $frecuencias, 2));
	if ($calificacion_promedio > 5) $calificacion_promedio = 5;
		
	/*
	 * Declaramos el promedio total del producto y generamos un arreglo
	 * */
	$promedio = array(
		'calificacion' => $calificacion_promedio,
		'nombre_calificacion' => $calificaciones[$calificacion_promedio]
	);
		
		
	foreach($count as $key => $c) {
		if($n==0) {
			$porcentajes[$key] = 0;
		} else {
			$porcentajes[$key] = ($c/$n) * 100;
		}
			
		$porcentajes[$key] = round($porcentajes[$key], 2);
	}
	
	$data = array();	
	$data['count_reviews'] = $n;
	$data['nombre_calificaciones'] = $calificaciones;
	$data['calificaciones'] = $count;
	$data['porcentajes'] = $porcentajes;
	$data['calificacion_promedio'] = $promedio;	
	return $data;
		
}

/*
|--------------------------------------------------------------------------
| random_pic(array)
|--------------------------------------------------------------------------
|
| Mediante una serie de condiciones, busca un producto y retorna primer imagen
|
*/
function random_pic($where=array())
{
	$ci = &get_instance();
	$ci->db->where($where);
	$ci->db->order_by('id','random');
	$ci->db->limit(1);
	$row = $ci->db->get('productos')->row();
	return @$row->imagen1;
}

/*
|--------------------------------------------------------------------------
| mostrar_categoria(int)
|--------------------------------------------------------------------------
|
| Esta funcion valida que haya productos en cierta categoria y decide si
| se muestra o no
|
*/
function mostrar_categoria($id=0)
{
	$ci = &get_instance();
	$ci->db->where('categoria', $id);
	$count = $ci->db->get('productos')->num_rows();
	if($count==0) {
		return false;
	} else {
		return true;
	}
}

/*
|--------------------------------------------------------------------------
| mostrar_subcategoria(int)
|--------------------------------------------------------------------------
|
| Esta funcion valida que haya productos en cierta subcategoria y decide si
| se muestra o no
|
*/
function mostrar_subcategoria($id=0)
{
	$ci = &get_instance();
	$ci->db->where('subcategoria', $id);
	$count = $ci->db->get('productos')->num_rows();
	if($count==0) {
		return false;
	} else {
		return true;
	}
}

/*
|--------------------------------------------------------------------------
| mostrar_subsubcategoria(int)
|--------------------------------------------------------------------------
|
| Esta funcion valida que haya productos en cierta subsubcategoria y decide si
| se muestra o no
|
*/
function mostrar_subsubcategoria($id=0)
{
	$ci = &get_instance();
	$ci->db->where('subsubcategoria', $id);
	$count = $ci->db->get('productos')->num_rows();
	if($count==0) {
		return false;
	} else {
		return true;
	}
}


/*
|--------------------------------------------------------------------------
| get_slug(int, varchar)
|--------------------------------------------------------------------------
|
| Regresa el slug de un producto, categoria, subcategoria...
| recibe de parametros el id y la tabla donde buscara
|
*/
function get_slug($id=0, $table='categorias')
{
	$ci = &get_instance();
	$ci->db->where('id', $id);
	$row = $ci->db->get($table)->row();
	return @$row->slug;
}

/*
|--------------------------------------------------------------------------
| get_etiqueta(int)
|--------------------------------------------------------------------------
|
| Esta funcion imprime las etiquetas que dispone cierto producto
|
*/
function get_etiqueta($material=0)
{
	$ci = &get_instance();
	$ci->db->where('material', $material);
	$row = $ci->db->get('productos')->row();
	$estatus = explode(',', $row->estatus);
	
	$etiqueta_tag = '';
	
	$array_styles = array(
		'nuevo' => ' <div class="btn btn-success">NUEVO</div>',
		'oferta' => ' <div class="btn btn-danger">OFERTA</div>',
		'promocion' => ' <div class="btn btn-info">PROMOCI&Oacute;N</div>',
		'liquidacion' => ' <div class="btn btn-warning">LIQUIDACI&Oacute;N</div>',
	);
	
	foreach($estatus as $e) {
		$etiqueta_tag .= @$array_styles[@$e];
	}
	
	if($etiqueta_tag=='') {
		$etiqueta_tag = '<div class="btn btn-nada"></div>';
	}
	
	echo $etiqueta_tag;
}

/*
|--------------------------------------------------------------------------
| get_swap_list(int, varchar, int)
|--------------------------------------------------------------------------
|
| Obtiene los productos relacionados que pueden ser intercambiados en el carrito
|
*/
function get_swap_list($id='', $material='', $qty=1)
{
	$ci = &get_instance();
	$ci->db->where('material', $material);
	$producto = $ci->db->get('productos')->row();
	
	$data['id'] = $id;
	$data['qty'] = $qty;
	$data['match'] = $material;
	$data['productos'] = false;
	
	if(!$producto) return $data;
	if(empty($producto->articulos_relacionados)) return $data;
		
	//$relacionados = explode('|',$producto->articulos_relacionados);
	$relacionados = $ci->db->get_where('productos', array('articulos_relacionados' => $producto->articulos_relacionados))->result();
	/*$productos = array();
	foreach($relacionados as $relacionado) {
		$ci->db->where('material', $relacionado);
		$productos[] = $ci->db->get('productos')->row();
	}*/
		
	$data['productos'] = $relacionados;
	
	return $data;
		
}

/*
|--------------------------------------------------------------------------
| login_required(void)
|--------------------------------------------------------------------------
|
| Valida que el cliente este logeado, si no es asi lo redirige al login
|
*/
function login_required()
{
	$ci = &get_instance();
	if(!$ci->cliente) {
		$redirect_url = current_url() . '?' . @$_SERVER['QUERY_STRING'];
		$ci->session->set_userdata('redirect_after_login', $redirect_url);
		redirect('cliente/login');
	} else {
		return true;
	}
}

function get_pais($id) {
	$ci = &get_instance();
	$row = $ci->db->get_where('lista_paises', array('id'=>$id))->row();
	return @$row->opcion;
}

function get_estado($id) {
	$ci = &get_instance();
	$row = $ci->db->get_where('lista_estados', array('id'=>$id))->row();
	return @$row->opcion;
}

function get_municipio($id) {
	$ci = &get_instance();
	$row = $ci->db->get_where('lista_municipios', array('id'=>$id))->row();
	return @$row->opcion;
}

function db_dropdown()
{
	$ci = get_instance();

	$args =& func_get_args();

	if(count($args) == 3)
	{
		list($key, $value) = $args;
	}

	$q = $ci->db->select(array($key, $value))
				->get($args[2]);

	$options = array();

	foreach ($q->result() as $row)
	{
		$options[$row->{$key}] = $row->{$value};
	}

	return $options;
}

function get_no_pedido()
{
	$ci = get_instance();
	do {
		$no = rand(1000000, 9999999);
		$match = $ci->db->get_where('pedidos', array('no_pedido' => $no))->num_rows();
	} while($match != 0);
	return $no;
}

function slugify($text)
{
	
	
	$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	$text = utf8_decode($text);
	$text = strtr($text, utf8_decode($originales), $modificadas);
	$text = strtolower($text);
	 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}


function is_admin()
{
	$ci = &get_instance();
	
	if(@$ci->admin->tipo=='administrador') {
		return true;
	} else {
		return false;
	}
}

function seccion_admin()
{
	$ci = &get_instance();
	return $ci->admin->seccion_id;
}

function get_thumb($id=0, $type='notas', $filename='', $width=false, $height=false)
{
	$nid = base64_encode($id);
	$type = base64_encode($type);
	$pid = base64_encode($filename);
	
	if($width!=false) {
		$width = base64_encode($width);
	} 
	
	if($height!=false) {
		$height = base64_encode($height);
	} 
	
	if($width and !$height) {
		return site_url("files/thumb?nid=$nid&amp;type=$type&amp;pid=$pid&amp;width=$width");
		//return real_base_url()."files/thumb?nid=$nid&amp;type=$type&amp;pid=$pid&amp;width=$width";
	}
	
	if(!$height and !$width) {
		return site_url("files/thumb?nid=$nid&amp;type=$type&amp;pid=$pid");
		//return real_base_url()."files/thumb?nid=$nid&amp;type=$type&amp;pid=$pid";
	}
	
	if($height and $width) {
		return site_url("files/thumb?nid=$nid&amp;type=$type&amp;pid=$pid&amp;width=$width&amp;height=$height");
		//return real_base_url()."files/thumb?nid=$nid&amp;type=$type&amp;pid=$pid&amp;width=$width&amp;height=$height";
	}
	
}

function get_video($id=0, $type='notas', $filename='')
{
	$nid = base64_encode($id);
	$type = base64_encode($type);
	$vid = base64_encode($filename);
	
	$url_video = real_base_url()."files/video?nid=$nid&type=$type&vid=$vid";
	$r = file_get_contents($url_video);
	return $r;
	
}


function get_field_name($table='', $field='', $id=0) 
{
	$ci = &get_instance();
	$ci->db->where('id', $id);
	$c = $ci->db->get($table)->row();
	
	if(!$c) return 'No disponible';
	
	return $c->{$field};
}

function get_folder($id=0)
{
	return floor((int) $id / 100) * 100;
}

function make_dir($dir='')
{
	if(!is_dir("$dir")) {
		mkdir("$dir", 0777, true);
		chmod("$dir", 0777);
	}
}

function delete_dir($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!delete_dir($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

function real_base_url() {
	$ci = &get_instance();
	$base_url = $ci->config->item('real_base_url');
	return $base_url;
}

function get_month($month=0) {
	$m = '';
	switch( (int) ($month) ) {
		case 1: $m = 'Enero'; break;
		case 2: $m = 'Febrero'; break;
		case 3: $m = 'Marzo'; break;
		case 4: $m = 'Abril'; break;
		case 5: $m = 'Mayo'; break;
		case 6: $m = 'Junio'; break;
		case 7: $m = 'Julio'; break;
		case 8: $m = 'Agosto'; break;
		case 9: $m = 'Septiembre'; break;
		case 10: $m = 'Octubre'; break;
		case 11: $m = 'Noviembre'; break;
		case 12: $m = 'Diciembre'; break;
		default: $m = 'Enero'; break;
	}
	return $m;
}

function get_short_month($month=0) {
	$m = '';
	switch( (int) ($month) ) {
		case 1: $m = 'Ene'; break;
		case 2: $m = 'Feb'; break;
		case 3: $m = 'Mar'; break;
		case 4: $m = 'Abr'; break;
		case 5: $m = 'May'; break;
		case 6: $m = 'Jun'; break;
		case 7: $m = 'Jul'; break;
		case 8: $m = 'Ago'; break;
		case 9: $m = 'Sep'; break;
		case 10: $m = 'Oct'; break;
		case 11: $m = 'Nov'; break;
		case 12: $m = 'Dic'; break;
		default: $m = 'Ene'; break;
	}
	return $m;
}


function is_top_jquery() {
	$ci = &get_instance();
	if( 
	($ci->uri->segment(1)=='episodios' AND $ci->uri->segment(2)=='detalle') OR
	($ci->uri->segment(1)=='noticias' AND $ci->uri->segment(2)=='detalle') OR
	($ci->uri->segment(1)=='videos' AND $ci->uri->segment(2)=='detalle') OR
	($ci->uri->segment(1)=='secciones' AND $ci->uri->segment(2)=='tvenvivo')
	 ) {
		return true;
	} else {
		return false;
	}
}


?>
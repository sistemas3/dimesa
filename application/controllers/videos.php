<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos extends Public_Controller {

	public function index() { }
	
	public function detalle($id=0)
	{
		$data = array();
		$data_header = array();
		
		//-----------------------------------------------------------------
		//
		// Aqui se genera el archivo JSON, si existe en la carpeta lo lee,
		// sino lo crea.
		//
		//-----------------------------------------------------------------
		$noticia = $this->mjson->get('noticias/detalle', $id);
		
		if(!$noticia) {
			$this->db->where('id', (int) $id);
			$tmp_noticia = $this->db->get('notas')->row();
			if($tmp_noticia) {
				$this->mjson->save('noticias/detalle', $tmp_noticia->id, $tmp_noticia);
				$data['nota'] = $tmp_noticia;
			}
		} else {
			$data['nota'] = $noticia;
		}
		//-----------------------------------------------------------------
		
		//if(!$data['nota']) show_404();
		
		$meta_facebook = '<meta property="og:image" content="'.get_thumb($data['nota']->id, 'notas', $data['nota']->imagen1, 560, 420).'" />';
		$this->template->set_partial('metas', 'partials/metas', array('metas'=>$meta_facebook));
	
		$data_header['seccion_id'] = @$data['nota']->seccion_id;
		$this->template->set_partial('header', 'partials/header_seccion', $data_header);
		
		
		
		$this->template->title(@$data['nota']->titulo);
		$this->template->build('noticias/detalle', $data);
	}


	public function lista($seccion_id=0, $categoria_id=0)
	{
		$data = array();
		
		$this->load->library('pagination');
		
		
		//-----------------------------------------------------------------
		//
		// Total de registros
		//
		//-----------------------------------------------------------------
		
		// Si hay categoria se guarda en la carpeta correspondiente
		if($categoria_id!=0) {
			$total = $this->mjson->get("videos/lista/$seccion_id/$categoria_id", false, 'total');
		} else {
			// De lo contrario se guarda en raiz, en la carpeta de la seccion
			$total = $this->mjson->get("videos/lista/$seccion_id", false, 'total');
		}
		
		
		if(!$total) {
			$this->db->where('seccion_id', (int) mysql_real_escape_string($seccion_id));
			if($categoria_id!=0) {
				$this->db->where('categoria_id', (int) mysql_real_escape_string($categoria_id));
			}
			$this->db->where('video_contenido !=', '');
			$rows = $this->db->get('notas')->num_rows();
			
			// Si hay categoria se guarda en la carpeta correspondiente
			if($categoria_id!=0) {
				$this->mjson->save("videos/lista/$seccion_id/$categoria_id", false, $rows, 'total');
			} else {
				// De lo contrario se guarda en raiz, en la carpeta de la seccion
				$this->mjson->save("videos/lista/$seccion_id", false, $rows, 'total');
			}
	
		} else {
			$rows = $total;
		}
		//-----------------------------------------------------------------
		
		
		
		
		
		// Configuraciones de la paginacion
		$total_rows = $rows;
		$limit = 12;
		$offset = @$_GET['per_page'] ? @$_GET['per_page'] : 0;
		//----------------------------------
		
		
		
		
		//-----------------------------------------------------------------
		//
		// Total de registros
		//
		//-----------------------------------------------------------------
		
		// Si hay categoria se guarda en la carpeta correspondiente
		if($categoria_id!=0) {
			$notas = $this->mjson->get("videos/lista/$seccion_id/$categoria_id", false, $offset);
		} else {
			// De lo contrario se guarda en raiz, en la carpeta de la seccion
			$notas = $this->mjson->get("videos/lista/$seccion_id", false, $offset);
		}
		
		
		if(!$notas) {
			
			$this->db->where('seccion_id', (int) mysql_real_escape_string($seccion_id));
			if($categoria_id!=0) {
				$this->db->where('categoria_id', (int) mysql_real_escape_string($categoria_id));
			}
			$this->db->where('video_contenido !=', '');
			$this->db->limit($limit, $offset);
			$data['notas'] = $this->db->get('notas')->result();
	
			$data['seccion_id'] = $seccion_id;
			
			$this->db->where('id', (int) mysql_real_escape_string($seccion_id));
			$data['seccion'] = $this->db->get('secciones')->row();
			
			// Si hay categoria se guarda en la carpeta correspondiente
			if($categoria_id!=0) {
				$this->mjson->save("videos/lista/$seccion_id/$categoria_id", false, $data, $offset);
			} else {
				// De lo contrario se guarda en raiz, en la carpeta de la seccion
				$this->mjson->save("videos/lista/$seccion_id", false, $data, $offset);
			}
			
			$data = (object) $data;
	
		} else {
			$data = $notas;
		}
		//-----------------------------------------------------------------
		
		
		
		
		
		
		//------------------------------------------------------------------------------------------------
		//
		// Paginacion
		//
		//------------------------------------------------------------------------------------------------
		if($categoria_id!=0) {
			$config['base_url'] = site_url('videos/lista/'.$seccion_id.'/'.$categoria_id.'?');
		} else {
			$config['base_url'] = site_url('videos/lista/'.$seccion_id.'?');
		}
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit; 
		$config['use_page_numbers'] = FALSE;
		$config['page_query_string'] = TRUE;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$this->pagination->initialize($config); 
		$data->pagination = $this->pagination->create_links();
		//------------------------------------------------------------------------------------------------
		
		
		
		
		
		//------------------------------------------------------------------------------------------------
		//
		// Configuracion para el header de seccion
		//
		//------------------------------------------------------------------------------------------------
		$data_header['seccion_id'] = $seccion_id;
		$this->template->set_partial('header', 'partials/header_seccion', $data_header);
		//------------------------------------------------------------------------------------------------
		
		
		
		
		$this->template->title('Videos de ' . @$data->seccion->nombre);
		$this->template->build('videos/lista', $data);
	}



	/*
	// lista sin JSON
	public function lista($seccion_id=0, $categoria_id=0)
	{
		$data = array();
		
		$this->load->library('pagination');
		
		$this->db->where('seccion_id', (int) mysql_real_escape_string($seccion_id));
		if($categoria_id!=0) {
			$this->db->where('categoria_id', (int) mysql_real_escape_string($categoria_id));
		}
		$this->db->where('video_contenido !=', '');
		$rows = $this->db->get('notas')->num_rows();
		
		$total_rows = $rows;
		$limit = 30;
		$offset = @$_GET['per_page'] ? @$_GET['per_page'] : 0;
		
		
		$this->db->where('seccion_id', (int) mysql_real_escape_string($seccion_id));
		if($categoria_id!=0) {
			$this->db->where('categoria_id', (int) mysql_real_escape_string($categoria_id));
		}
		$this->db->where('video_contenido !=', '');
		$this->db->limit($limit, $offset);
		$data['notas'] = $this->db->get('notas')->result();

		$config['base_url'] = site_url('noticias/lista/'.$seccion_id.'?');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit; 
		$config['use_page_numbers'] = FALSE;
		$config['page_query_string'] = TRUE;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		
		$this->pagination->initialize($config); 
		
		$data['pagination'] = $this->pagination->create_links();
		$data['seccion_id'] = $seccion_id;
		
		$this->db->where('id', (int) mysql_real_escape_string($seccion_id));
		$seccion = $this->db->get('secciones')->row();
		
		//if(!$data['notas']) show_404();
		
		$data_header['seccion_id'] = $seccion_id;
		$this->template->set_partial('header', 'partials/header_seccion', $data_header);
		
		$this->template->title('Videos de ' . @$seccion->nombre);
		$this->template->build('videos/lista', $data);
	} */

}

/* End of file secciones.php */
/* Location: ./application/controllers/secciones.php */
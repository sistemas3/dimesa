<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipo_cambios extends Private_Controller {
	
	
	public function __construct()
	{
		parent::__construct();
	}

	public function redirect_to_index() 
	{
		redirect('admin/tipo_cambios/index');
	}
	
	public function index()
	{
		self::is_logged();

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('direnet');
			$crud->set_language('spanish');
			$crud->set_table('tipo_cambios');
			$crud->set_subject('Tipo cambio');
			$crud->unset_add();
			$crud->unset_delete();
			$crud->unset_export();
			$crud->unset_print();

			$crud->display_as(array(
				'precio_compra_dolar' => 'Precio compra dólar',
				'precio_venta_dolar' => 'Precio venta dólar',
				'ultima_actualizacion' => 'Última actualización'
			));
			
			$crud->field_type('ultima_actualizacion', 'invisible');
			$crud->callback_column('precio_compra_dolar', array($this, 'gc_pesos'));
			$crud->callback_column('precio_venta_dolar', array($this, 'gc_pesos'));
			$crud->callback_column('precio_compra_euro', array($this, 'gc_pesos'));
			$crud->callback_column('precio_venta_euro', array($this, 'gc_pesos'));
			
			$output = $crud->render();
			
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}

		$this->template->build('admin/tipo_cambios/index', $output);
	}

	public function gc_pesos($value, $row)
	{
		return '$'.number_format($value, 2);
	}
	
}



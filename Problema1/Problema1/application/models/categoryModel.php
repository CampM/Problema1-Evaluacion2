<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}


	/**
	 * Funcion encargada de devolver todas las categorias
	 *
	 * @return     <type>  Lista de categorias
	 */
	function GetCategoryList(){
    	return $this->db->where('isActive', true)->get('category')->result();
   }

}

/* End of file category.php */
/* Location: ./application/models/category.php */
?>
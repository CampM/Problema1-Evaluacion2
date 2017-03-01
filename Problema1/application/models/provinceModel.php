<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProvinceModel extends CI_Model {

	/**
     * Devuelve listado de provincias
     *
     * @return provinceList
     */
    public function GetProvinceList()
    {
        $provinceList = $this->db->get('province');
        
        return $provinceList->result_array();
    }
	

}

/* End of file provinceModel.php */
/* Location: ./application/models/provinceModel.php */
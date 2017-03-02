<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}


 /**
   * Devuelve un producto con id determinado
   *
   * @param      <type>  $idProduct  The identifier producto
   *
   * @return     <type>  The product by identifier.
   */
  public function GetProductById($idProduct)
  {
    return $this->db->where('idProduct',$idProduct)->where('isActive', true)->get('product')->row();
  } 

  /**
   * Devuelve la lista de productos para una categoria determinada
   *
   * @param      <type>   $category  The category
   * @param      integer  $limit     The limit
   * @param      integer  $offset    The offset
   *
   * @return     <type>   The product list.
   */
  public function GetProductList($category, $limit=99999, $offset=0)
  {
    if ($category != 0)
    {
        return $this->db->where('category_idCategory', $category)->where('isActive', true)->limit($limit, $offset)->get('product')->result();  
    }
    else
    {
        return $this->db->where('isActive', true)->limit($limit, $offset)->get('product')->result();  
    }
             
  }

  /**
   * Devuelve el total de productos que hay en una categoria determinada
   *
   * @param      <type>  $category  The category
   *
   * @return     <type>  The count product.
   */
  public function GetProductCount($category)
  {
    if ($category != 0){
        return $this->db->from('product')->where('category_idCategory', $category)->where('isActive', true)->count_all_results();
    }
    else
    {
        return $this->db->from('product')->where('isActive', true)->count_all_results();
    }
  }

  /**
   * Devuelve la la lista de productos destacados
   *
   * @param      <type>  $limit   The limit
   * @param      <type>  $offset  The offset
   *
   * @return     <type>  The featured count.
   */
  public function GetFeaturedList($limit, $offset)
  {
    $today = date('Y-m-d');
    $where = "isActive = 1
              AND
              ((dateFrom IS NULL AND dateTo IS NULL) 
              OR 
              (dateFrom <= '" . $today . "' AND dateTo >= '" . $today . "'))";
              
    return $this->db->select('*')->from('product')
      ->join('featured', 'product.idProduct = featured.product_idProduct')
      ->where($where)
      ->limit($limit, $offset)->get()->result();
  }

  /**
   * Devuelve el numero total de productos destacados
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function GetFeaturedCount()
  {
    return $this->db->count_all_results('featured');
  }
}



/* End of file productModel.php */
/* Location: ./application/models/productModel.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador principal, muetra listado de products
 */
class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
			$this->load->model('productModel');
			$this->load->model('categoryModel');
	}

	public function index($offset = 0)
	{ 
        $this->session->set_userdata("url", 'home');
        
		$limit = 5;

        $config['base_url'] = site_url() . '/home/index/';
        $config['total_rows'] = $this->productModel->GetFeaturedCount();
        $config['per_page'] = $limit;
        $config['num_links'] = 3;
        
        $this->pagination->initialize($config);
        
        $categoryList = $this->categoryModel->GetCategoryList();
        $productList = $this->productModel->GetFeaturedList($limit, $offset);
        $data['categoryList'] = $categoryList;
        $data['productList'] = $productList;
        $data['pagination'] = $this->pagination->create_links();
        $data['user'] = $this->session->userdata("login");

        $data['bodyView'] =  $this->load->view('products/productListView', $data, TRUE);
        $this->load->view('layout', $data);

    }
   	
    /**
     * Muestra la lista de productos con una categoria determinada
     *
     * @param      string   $idCategory  The identifier category
     * @param      integer  $offset      The offset
     */
   	public function ShowProductList ($idCategory, $offset = 0)
	{
		$limit = 5;

        $config['base_url'] = site_url() . '/home/ShowProductList/' . $idCategory . '/';
        $config['total_rows'] = $this->productModel->GetProductCount($idCategory);
        $config['per_page'] = $limit;
        $config['num_links'] = 3;
        $config["uri_segment"] = 4;
        
        $this->pagination->initialize($config);
        
        $categoryList = $this->categoryModel->GetCategoryList();
        $productList = $this->productModel->GetProductList($idCategory, $limit, $offset);
        
        $data['categoryList'] = $categoryList;
        $data['productList'] = $productList;
        $data['pagination'] = $this->pagination->create_links();
        $data['user'] = $this->session->userdata("login");

        $data['bodyView'] =  $this->load->view('products/productListView', $data, TRUE);
        $this->load->view('layout', $data);

    }

    /**
     * Muestra la informacion de un producto con id determinada
     *
     * @param      string  $idProduct  The identifier product
     */
    public function ShowProductById($idProduct)
    {
        $this->session->set_userdata("url", 'home/product/' . $idProduct . '');
        
        $categoryList = $this->categoryModel->GetCategoryList();
        $product = $this->productModel->GetProductById($idProduct);
        


        $data['categoryList'] = $categoryList;
        $data['product'] = $product;
        $data['user'] = $this->session->userdata("login");

        $data['bodyView'] = $this->load->view('/products/productView', $data, TRUE);
        $this->load->view('layout', $data);

    }

    /**
     * Muestra la vista de información del alumno
     */
    public function ShowAboutView(){

        $data['bodyView'] = $this->load->view('aboutView', '', TRUE);
        $this->load->view('layout', $data);
    }
}
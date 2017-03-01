<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends CI_Controller {

	private $form = array();

	public function index()
	{
		//$this->load->model('homeModel');
        $this->load->model('userModel');
        $this->load->model('orderModel');
	}

	/**
     * Devuelve el contenido del carro y la vista correspondiente
     */
    public function GetCartView()
    {
        $form['error'] = $this->session->flashdata('incorrect_cart');     

        $data['cart'] = $this->cart_library->GetCartData();
        $data['user'] = $this->session->userdata('login');
        $data['form'] = $form;

        $data['bodyView'] =  $this->load->view('cartView', '', TRUE);
        $this->load->view('layout', $data);
    }
    
    
    public function GetCartData(){
        header('Content-Type: application/json');
        echo json_encode($this->cart_library->GetCartData());
    }

}

/* End of file cartController.php */
/* Location: ./application/controllers/cartController.php */
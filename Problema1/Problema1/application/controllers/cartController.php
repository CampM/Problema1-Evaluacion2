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
    
    /**
     * Elimina un producto del carro
     *
     * @param      <type>  $id     The identifier
     */
    public function DeleteProduct($id){
    	$this->cartLibary->DeleteProduct($id);
       	redirect(site_url() . 'cartController/GetCartView');
        
    }

    /**
     * Elimina el contenido del carro
     */
    public function EmptyCart()
    {
        $cart = $this->cart_library->destroy();
        redirect(site_url() . 'cartController/GetCartView');
    }
    
    public function GetCartData(){
        header('Content-Type: application/json');
        echo json_encode($this->cart_library->GetCartData());
    }

    /**
     * inserta item al carrito 
     * llamada vía ajax
     * 
     * @param unknown $cantidad
     * @param unknown $idproducto
     */
    /*public function ajaxAddCart($cantidad, $idproducto)
    {
        $cantidadFinal = $cantidad;
        $producto = $this->home_model->getProducto($idproducto);
        $carrito = $this->cart_library->GetCartData();
    
        // comprobamos que hay stock
        if (intval($producto->stock) > 0) {
    
            if (! empty($carrito) && isset($carrito['items'][$idproducto])) {
                $cantidad1 = intval($carrito['items'][$idproducto]['cantidad']);
                $suma = $cantidad1 + intval($cantidad);
                $cantidadFinal = $producto->stock >= $suma ? $cantidad : $producto->stock;
            }
    
            $this->cart_library->InsertarItem(array(
                'id' => $idproducto,
                'cantidad' => $cantidadFinal,
                'precio' => $producto->precio,
                'nombre' => $producto->nombre
            ));
        }
    
        echo json_encode($this->cart_library->GetCartData());
    }*/
    
   /**
    * Actualiza la cantidad de un item 
    * del carrito
    * llamada vía ajax
    * 
    * @param unknown $cantidad
    * @param unknown $idproducto
    */
    /*public function ajaxUpdateCart($cantidad, $idproducto)
    {
        $cantidadFinal = $cantidad;
        $producto = $this->home_model->getProducto($idproducto);
        $carrito = $this->cart_library->GetCartData();
    
        // comprobamos que hay stock
        if (intval($producto->stock) > 0) {
    
            if (! empty($carrito) && isset($carrito['items'][$idproducto])) {
                $cantidad1 = intval($carrito['items'][$idproducto]['cantidad']);
                $suma = $cantidad1 + intval($cantidad);
                $cantidadFinal = $producto->stock >= $suma ? $cantidad : $producto->stock;
            }
    
            $this->cart_library->actualizaItem(array(
                'id' => $idproducto,
                'cantidad' => $cantidadFinal               
            ));
        }
    
        echo json_encode($this->cart_library->GetCartData());
    }*/

}

/* End of file cartController.php */
/* Location: ./application/controllers/cartController.php */
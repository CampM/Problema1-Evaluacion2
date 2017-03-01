<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_library
{
	protected $ci;
	private $_cart = array();

	public function __construct()
	{
        $this->ci =& get_instance();
        $this->ci->load->library('session');
        
        if ($this->ci->session->userdata('cart') == FALSE) {
            
            $this->_cart['totalPrice'] = 0;
            $this->_cart['totalProduct'] = 0;
            
            $this->ci->session->set_userdata('cart', serialize($this->_cart));
        }
        
        $this->_cart = unserialize($this->ci->session->userdata('cart'));
	}

	/**
	 * Actualiza los datos del carro
	 */
    private function UpdateCart()
    {
        
        $price = 0;
        $product = 0;
        
       
        foreach ($this->_cart['cartProductList'] as $row) {
            $price += ($row['price'] * $row['quantity']);
            $product += $row['quantity'];
        }
        
        $this->_cart = unserialize($this->ci->session->userdata('cart'));
       
        $this->_cart["totalProduct"] = $product;
        $this->_cart["totalPrice"] = $price;
        
       
        $this->ci->session->set_userdata('cart', serialize($this->_cart));
    }

    /**
     * Actualizacion de los productos del carro
     *
     * @param      array  $data   The data
     */
    public function UpdateCartProduct($data = array())
    {
        if (! is_array($data) or count($data) == 0) {
            return;
        }
        
        $idProduct = $data['id'];
        
        if (isset($this->_cart['cartProductList'][$idProduct])) {
            $this->_cart['cartProductList'][$idProduct]['quantity'] = $data['quantity'];
        }
        
        $this->ci->session->set_userdata('cart', serialize($this->_cart));
        
        $this->UpdateCart();
    }

    /**
     * Devuelve los datos del carro
     *
     * @return     boolean  The cartesian data.
     */
    public function GetCartData()
    {
        $cart = $this->_cart;
        
        return $cart == null ? null : $cart;
    }


   


}

/* End of file cartLibrary.php */
/* Location: ./application/libraries/cartLibrary.php */

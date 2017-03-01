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
	 * Añade un producto al carro
	 *
	 * @param      array|integer  $data   The data
	 */
    public function AddProductCart($data = array())
    {
        if (! is_array($data) or count($data) == 0) {
            return;
        }
        
        $idProduct = $data['id'];
        
        if (isset($this->_cart['cartProductList'][$idProduct])) {
            $this->_cart['cartProductList'][$idProduct]['quantity'] += $data['quantity'];
        } else {
            $this->_cart['cartProductList'][$idProduct]['idProduct'] = $idProduct;
            $this->_cart['cartProductList'][$idProduct]['quantity'] = $data['quantity'];
            $this->_cart['cartProductList'][$idProduct]['price'] = $data['price'];
            $this->_cart['cartProductList'][$idProduct]['name'] = $data['name'];
        }
        
        $this->ci->session->set_userdata('cart', serialize($this->_cart));
        
        $this->UpdateCart();
    }

    /**
     * Elimina un producto del carro
     *
     * @param      <type>  $id     The identifier
     */
    public function DeleteProduct($id)
    {
        if (isset($id) && ! empty($id)) {
            if (isset($this->_cart['cartProductList'][$id])) {
                unset($this->_cart['cartProductList'][$id]);
                
                $this->ci->session->set_userdata('cart', serialize($this->_cart));
                
                
                $this->UpdateCart();
            }
        }
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

    /**
     * Devuelve si en el carro existe un producto con determinado id
     *
     * @param      <type>  $idProduct  The identifier product
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    function ProductExist($idProduct){
        if (isset($this->_cart['cartProductList'][$idProduct])) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * Devuelve la cantidad existente en el carro de un producto con determinada id
     *
     * @param      <type>  $idProduct  The identifier product
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    function ItemQuantity($idProduct){
        if (isset($this->_cart['cartProductList'][$idProduct])) {
            return $this->_cart['cartProductList'][$idProduct]['quantity'];
        }else{
            return FALSE;
        }
    }

    /**
     * Destruye el carro
     *
     * Empties the cart and kills the session
     *
     * @access public
     * @return null
     */
    function destroy()
    {
        unset($this->_cart);

        $this->_cart['totalPrice'] = 0;
        $this->_cart['totalProduct'] = 0;
        
        $this->ci->session->unset_userdata('cart');
    }
}

/* End of file cartLibrary.php */
/* Location: ./application/libraries/cartLibrary.php */

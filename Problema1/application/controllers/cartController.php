<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends CI_Controller {

	private $form = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('productModel');
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

        $data['bodyView'] =  $this->load->view('cartView', $data, TRUE);
        $this->load->view('layout', $data);
    }
    
    /**
     * Elimina un producto del carro
     *
     * @param      <type>  $id     The identifier
     */
    public function DeleteProduct($id){
    	$this->cart_library->DeleteProduct($id);
       	redirect(site_url('cartController/GetCartView'));
        
    }

    /**
     * Elimina el contenido del carro
     */
    public function EmptyCart()
    {
        $cart = $this->cart_library->destroy();
        redirect(site_url('cartController/GetCartView'));
    }
    
    public function GetCartData(){
        header('Content-Type: application/json');
        echo json_encode($this->cart_library->GetCartData());
    }

    /**
     * Inserta una cantidad determinada de un producto con id determinado en el carro
     * Utiliza ajax
     *
     * @param      <type>  $quantity   The quantity
     * @param      <type>  $idProduct  The identifier product
     */
    public function AddItemCart($quantity, $idProduct)
    {
        $newQuantity = intval($quantity);

        if ($newQuantity > 0)
        {
            $product = $this->productModel->GetProductById($idProduct);
            $cart = $this->cart_library->GetCartData();
            $iva = $product->iva;
            if ($iva == NULL)
            {
                $iva = 1;
            }

            if (!empty($cart) && isset($cart['cartProductList'][$idProduct]))
            {
                $oldQuantity = intval($cart['cartProductList'][$idProduct]['quantity']);
                $newQuantity = $oldQuantity + $newQuantity;
            }

            if ($newQuantity > intval($product->stock))
            {
                $newQuantity = intval($product->stock);
            }


            if (!empty($cart) && isset($cart['cartProductList'][$idProduct]))
            {
                if ($newQuantity == 0)
                {
                    $this->cart_library->DeleteProduct($idProduct);
                }
                else
                {
                    $this->cart_library->UpdateCartProduct(array(
                        'id' => $idProduct,
                        'quantity' => $newQuantity
                    ));
                }
            }
            else
            {
                $this->cart_library->AddProductCart(array(
                    'id' => $idProduct,
                    'quantity' => $newQuantity,
                    'price' => $product->price * $iva,
                    'name' => $product->name
                ));
            }
        }

        header('Content-Type: application/json');
        echo json_encode(true);
    }
    
   /**
    * Actualiza en una cantidad determinada un producto de id determinada del carro
    * Utiliza ajax
    *
    * @param      <type>  $quantity   The quantity
    * @param      <type>  $idProduct  The identifier product
    */
    public function UpdateItemCart($quantity, $idProduct)
    {
        $totalQuantity = $quantity;
        $product = $this->productModel->GetProductById($idProduct);
        $cart = $this->cart_library->GetCartData();
    
        if (intval($product->stock) > 0) {
    
            if (! empty($cart) && isset($cart['productList'][$idProduct])) {
                $quantityInt = intval($cart['productList'][$idProduct]['quantity']);
                $total = $quantityInt + intval($quantity);
                $totalQuantity = $product->stock >= $total ? $quantity : $product->stock;
            }
            
            $this->cart_library->UpdateCartProduct(array(
                'id' => $idProduct,
                'quantity' => $totalQuantity               
            ));
        }

        $cart = $this->cart_library->GetCartData();

        $cart['newTotalRow'] = $totalQuantity * $product->price;

        header('Content-Type: application/json');
        echo json_encode($cart);
    }

}

/* End of file cartController.php */
/* Location: ./application/controllers/cartController.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderModel extends CI_Model {

	/**
	 * Devuelve un pedido con determinado id
	 *
	 * @param      <type>  $id     The identifier
	 *
	 * @return     <type>  The order by identifier.
	 */
    public function GetOrderById($id)
    {
    	return $this->db->where('idOrder', $id)->get('order')->result();
    }

    /**
     * Devuelve historial de pedidos procesados de un usuario con id determinada
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  The order.
     */
    public function GetOrderHistory($id)
    {
        return $this->db->where('user_idUser', $id)->where('stay', 'procesado')->or_where('stay', 'recibido')->get('order')->result();      
    }

    /**
     * Devuelve los pedidos no procesados de un usuario con id determinado
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  The order not process.
     */
    public function GetUnprocessedOrder($id)
    {
        return $this->db->where('user_idUser', $id)->where('stay', 'pendiente')->get('order')->result();
    }

    /**
     * Cancela un pedido sin procesar con determinada
     *
     * @param      string  $id     The identifier
     */
    public function CancelUnprocessedOrder($id)
    {
    	//Pedido sin procesar
        $order = $this->db->where('idOrder', $id)->where('stay', 'pendiente')->get('order')->result_array();

        //Comprobar si esta procesado
        if (true/*!empty($order)*/) {

            $lineList = $this->db->where('order_idOrder', $id)->get('orderline')->result_array();

            foreach ($lineList as $row) 
            {
                $product = $this->db->where('idProduct', $row['product_idProduct'])->get('product')->row_array();
                $updateProduct = array(
                    'stock' => $product['stock'] + $row['quantity']
                );

                $this->db->where('idProduct', $product['idProduct']);
                $this->db->update('product', $updateProduct);
            }

            $this->db->where('order_idOrder', $id);
            $this->db->delete('orderline');

            $this->db->where('idOrder', $id);
            $this->db->delete('order');
            
            if ($this->db->affected_rows() == 0)
                $this->session->set_flashdata('incorrect_order', 'El pedido nº '.$id.' no ha podido ser cancelado');
        }else{
            $this->session->set_flashdata('incorrect_order', 'El pedido ya está procesado o no existe');   
        }
    }

    /**
     * Obtiene los datos de una factura
     *
     * @param      <type>  $data   The data
     */
    public function GetInvoice($orderId)
    {
        $order = $this->db->where('idOrder', $orderId)->where('stay', 'pendiente')->get('order')->row_array();
        
        $lineList = $this->db->select('*')->from('orderline', 'product')->join('product', 'product.idProduct = orderline.product_idProduct')->where('order_idOrder', $orderId)->get()->result_array();

        return array(
            'order' => $order,
            'lineOrderList' => $lineList);
    }

    /**
     * Insertar un pedido en la bbdd
     *
     * @param      <type>  $data   The data
     */
    public function CreateOrder($data)
    {
        $this->db->insert('order', $data);

        return $this->db->insert_id();
    }

    /**
     * Inserta una linea de pedidos para un carro y orden determinados
     *
     * @param      <type>  $cart     The cartesian
     * @param      <type>  $idOrder  The identifier order
     */
    public function CreateOrderLine($cart, $idOrder)
    {
        $data = array();
        foreach ($cart['cartProductList'] as $idProduct => $item) {
            $data[] = array(
                'product_idProduct' => $idProduct,
                'order_idOrder' => $idOrder,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            );
        }
        $this->db->insert_batch('orderline', $data);
    }

    /**
     * Modifica el stock de BD dado los datos de un carrito
     *
     * @param      <type>  $cart     The cartesian
     * @param      <type>  $idOrder  The identifier order
     */
    public function UpdateStock($cart)
    {
        foreach ($cart['cartProductList'] as $idProduct => $item) {
            $product = $this->db->where('idProduct', $idProduct)->get('product')->row();
            $newStock = $product->stock - $item['quantity'];
            
            $data = array(
                'stock' => $newStock
            );

            $this->db->where('idProduct', $idProduct);
            $this->db->update('product', $data);
        }
    }

    /**
     * Devuelve las líneas de un pedido
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  The order line by identifier.
     */
    /*public function GetOrderLineById($id)
    {
        $sql = "select pe.*, p.*,l.*
        from pedido pe
        inner join linea_pedido l on l.idPedido = pe.idPedido
        inner join producto p on l.idProducto = p.idProducto
        where l.idPedido = $id";
        
        $orderline = $this->db->query($sql);
        
        return $orderline->result();
    }*/

}

/* End of file orderModel.php */
/* Location: ./application/models/orderModel.php */
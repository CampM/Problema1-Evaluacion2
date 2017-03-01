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
        return $this->db->where('user_idUser', $id)->where('stay', 'procesado')->get('order')->result();      
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
    public function CancelGetUnprocessedOrder($id)
    {
    	//Pedido sin procesar
        $order = $this->db->where('idOrder', $id)->where('stay', 'pendiente')->get('order');

        //Comprobar si esta procesado
        if (empty($order)) {
            $this->db->delete('order', $id);
            
            if ($this->db->affected_rows() == 0)
                $this->session->set_flashdata('incorrect_order', 'El pedido nº '.$id.' no ha podido ser cancelado');
        }else{
            $this->session->set_flashdata('incorrect_order', 'El pedido ya está procesado o no existe');   
        }
    }

    /**
     * Insertar un pedido en la bbdd
     *
     * @param      <type>  $data   The data
     */
    public function CreateOrder($data)
    {
        $this->db->insert('order', $data);

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
        foreach ($cart['items'] as $idProduc => $item) {
            $data[] = array(
                'idProduct' => $idProduct,
                'idOrder' => $idOrder,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            );
        }
        $this->db->insert_batch('orderline', $data);
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends CI_Controller {

	public function index()
	{
		
	}

	public function __construct()
	{
		parent::__construct();
		$this->load->model('provinceModel');
        $this->load->model('userModel');
        $this->load->model('orderModel');
        $this->load->model('productModel');
		//Do your magic here
	}

    /**
     * Prepara el pedido
     */
    public function CreateOrderData()
    {
        $login = $this->session->userdata("login");
        $cart = $this->cart_library->GetCartData();
        
        if ($cart['totalProduct'] > 0) {
            if ($login != false && $login['is_logued_in']) {
                
                $data['user'] = $login;
                $data['cart'] = $cart;
                

                $data['bodyView'] =  $this->load->view('order/orderView', $data, TRUE);
                $this->load->view('layout', $data);
            } else {
                $this->session->set_userdata("url", 'orderController/CreateOrderData');
                redirect(site_url('userController/LoginUserForm'));
            }
        } else {
            $this->session->set_flashdata('incorrect_cart', 'El carro de la compra está vacío');
            redirect(site_url() . 'cartController/GetCartView');
        }
    }

    /**
     * Carga los datos de la factura
     */
    public function Invoice($orderId)
    {
        $login = $this->session->userdata("login");
        $result = $this->orderModel->GetInvoice($orderId);

       
        $data['user'] = $login;
        $data['order'] = $result['order'];
        $data['lineOrderList'] = $result['lineOrderList'];

        $data['bodyView'] =  $this->load->view('order/invoceView', $data, TRUE);
        $this->load->view('layout', $data);
    }

    /**
     * Clave aleatoria que contendrá el formulario
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function token()
    {
        $token = md5(uniqid(rand(), true));
        $this->session->set_userdata('token', $token);
        return $token;
    }

     /**
      *Procesa el formulario de envio
     */
    public function ProcessorSendForm()
    {
        $login = $this->session->userdata("login");
        $cart = $this->cart_library->GetCartData();

        $user = $this->userModel->GetUserById($login['idUser']);

        $order = array(
            'stay' => 'pendiente',
            'quantity' => $cart['totalProduct'],
            'price' => $cart['totalPrice'],
            'orderDate' => date("Y-m-d"),
            'deliveredDate' => NULL,
            'user_idUser' => $user['idUser'],
            'name' => $user['name'],
            'surnames' => $user['surnames'],
            'email' => $user['email'],
            'dni' => $user['dni'],
            'address' => $user['address'],
            //'idProvince' => $user->province_idProvince,
            'cp' => $user['cp']
        );

        $id = $this->orderModel->CreateOrder($order);
        if (! empty($id)) {
            $this->orderModel->CreateOrderLine($cart, $id);
            $this->orderModel->UpdateStock($cart);
            $this->OrderEmail($id);

            redirect(site_url('cartController/EmptyCart'));
        }else{
            redirect(site_url('orderController/ProcessorSendForm'));
        }
    }

    /**
     * Comprueba el token del formulario
     *
     * @param unknown $string            
     * @return boolean
     */
    private function CheckToken($string)
    {
        if (! $this->input->post($string) && $this->input->post($string) == $this->session->userdata('token')) {
            redirect(site_url() . 'user');
        }
    }

    /**
     * Cancelar pedidos no procesados
     *
     * @param unknown $id            
     */
    public function CancelOrder($id)
    {
        if ($this->login->UserLoggedIn()) {
            if (isset($id) && ! empty($id)) {
                $this->orderModel->CancelUnprocessedOrder($id);
                redirect(site_url('userController/UserPanel'));
            }
        } else {
            $this->session->set_userdata("url", 'orderController/CancelOrder/' . $id . '');
            redirect(site_url('userController/LoginUser'));
        }
    }

    /**
     */
    public function OrderEmail($id)
    {
        $login = $this->session->userdata("login");
        $user = $this->userModel->GetUserById($login['idUser']);
        // Utilizando sendmail
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.iessansebastian.com';
        $config['smtp_user'] = 'aula4@iessanseastian.com';
        $config['smtp_pass'] = 'dawanyo2017';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        
        $this->email->initialize($config);
        $this->email->from('aula4@iessansebastian.com', 'Prueba Automática desde CI');
        $this->email->to($user['email']);
        
        $this->email->subject("Shopping Cart");
        $this->email->message('<html><body>Se le ha enviado la factura adjunta.</body></html>');
        $this->GenerarFacturaPDF($id, 'F');
        $this->email->attach(dirname(__DIR__) . '/upload' . '/' . 'factura_' . $id . '.pdf');
        $this->email->send();
        // echo $this->email->print_debugger();
    }


    /**
     * Comrpobar productos almacenados antes de ejecutar el pedido
     */
    private function CheckOrderStock()
    {
        $cart = $this->cartLibrary->GetCartData();
        $error;
        
        foreach ($cart['productList'] as $id => $lineProduct) {
            $quantity = $lineProduct['quantity'];
            
            $producto = $this->productModel->GetProduct($id);
            
            if ($quantity > $producto->stock) {
                $error[] = $id;
            }
        }
        
        if (! empty($error))
            $this->session->set_flashdata('stock_error', $error);
    }

    /**
     *
     * @param unknown $id            
     * @param number $proforma            
     * @param string $dest
     *            'I' muestra factura en navegador, 'F' guarda factura en disco
     */
    public function GenerarFacturaPDF($id, $dest = 'I')
    {
          
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Moises Campon Garcia');
            $pdf->SetTitle('Factura PDF PEDIDO' . $id);
            $pdf->SetSubject('Factura PDF');
            $pdf->SetKeywords('FACTURA, PDF');
                
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
            
            // set header and footer fonts
            $pdf->setHeaderFont(Array(
                PDF_FONT_NAME_MAIN,
                '',
                PDF_FONT_SIZE_MAIN
            ));
            $pdf->setFooterFont(Array(
                PDF_FONT_NAME_DATA,
                '',
                PDF_FONT_SIZE_DATA
            ));
            
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once (dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            
            // ---------------------------------------------------------
            
            $login = $this->session->userdata("login");
            $result = $this->orderModel->GetInvoice($id);

           
            $data['user'] = $login;
            $data['order'] = $result['order'];
            $data['lineOrderList'] = $result['lineOrderList'];

            $data['bodyView'] =  $this->load->view('order/invocePDFView', $data, TRUE);

            // add a page
            $pdf->AddPage();

            $html = $data['bodyView'];
            // Imprimimos el texto con writeHTMLCell()
            // $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            
            if ($dest == 'I')
            {
                $pdf->Output(site_url() . 'factura_' . $id . '.pdf', 'I');
            }
            else
            {
                $pdf->Output(dirname(__DIR__) . '/pdf' . '/' . 'factura_' . $id . '.upload', 'F');
            }
        
    }

}

/* End of file OrderController.php */
/* Location: ./application/controllers/OrderController.php */
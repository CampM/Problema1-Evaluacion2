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
     *
     * @param unknown $id            
     * @param number $proforma            
     * @param string $dest
     *            'I' muestra factura en navegador, 'F' guarda factura en disco
     */
    /*public function factura($id, $proforma = 0, $dest = 'I')
    {
        if ($this->login->UserLoggedIn()) {
            $order = $this->orderModel->getLineasById($id);
            if (empty($order))
                redirect(site_url() . 'user/paneluser');
            
            $fechaCreacion = $order[0]['creationDate'];
            
            $nomfactura = $proforma == 0 ? 'FACTURA' : ' FACTURA PROFORMA';
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Carlos Arteaga Virella');
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
            
            // add a page
            $pdf->AddPage();
            
            $pdf->DatosFacturacion($nomfactura);
            
            $html = '<table border="1">
             <tr>
                <td>Nº de Factura: ' . $id . '</td>
                <td>Fecha: ' . $fechaCreacion . '</td>
                <td>Forma de pago: --</td>        
            </tr>      
        </table>';
            // Imprimimos el texto con writeHTMLCell()
            // $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            
            $html1 = '<table border="1" style="width:100%">
        <tr>
            <td width="10%" bgcolor="#A1A1A1">Cod.</td>
            <td width="53%" bgcolor="#A1A1A1">Artículo</td>
            <td width="15%" bgcolor="#A1A1A1">Precio</td>
            <td width="7%" bgcolor="#A1A1A1">Und</td>
            <td width="15%" bgcolor="#A1A1A1">Total</td>
        </tr>';
            $cont = 0;
            foreach ($order as $linea) {
                $cont ++;
                $html1 .= '
                <tr>
                    <td>' . $linea['codigo'] . '</td>
                    <td  align="left">' . $linea['name'] . '</td>
                    <td  align="right">' . $linea['precio'] . '</td>
                    <td  align="center">' . $linea['quantity'] . '</td>
                    <td  align="right">' . intval($linea['quantity']) * intval($linea['precio']) . '</td>
                   
                </tr>';
                if ($cont == 30 || $cont == 60) {
                    $pdf->AddPage();
                    $pdf->DatosFacturacion($nomfactura);
                }
            }
            
            while ($cont < 30) {
                $cont ++;
                $html1 .= '<tr>
                <td></td>
                <td  align="left"></td>
                <td  align="right"></td>
                <td  align="center"></td>
                <td  align="right"></td>
                 
                </tr>';
            }
            $html1 .= '</table>';
            
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html1, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            // ---------------------------------------------------------
            
            $tabla3 = '<table border="1" style="width:100%">
            <tr>
                <td width="50%" bgcolor="#A1A1A1">SUBTOTAL</td>
                <td width="20%" bgcolor="#A1A1A1">IVA</td>
                <td width="30%" bgcolor="#A1A1A1">TOTAL</td>                   
            </tr>
        </table>';
            
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $tabla3, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'R', $autopadding = true);
            
            $tabla4 = '<table border="1" style="width:100%">
            <tr>
                <td width="50%" >12</td>
                <td width="20%" >2121</td>
                <td width="30%" >3232</td>                   
            </tr>
        </table>';
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $tabla4, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'R', $autopadding = true);
            
            if ($dest == 'F') {
                // guardamos factura
               // $pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/' . 'factura_' . $id . '.pdf', 'F');
               // $pdf->Output(dirname(__FILE__) . '/' . 'factura_' . $id . '.pdf', 'F'); 
                $pdf->Output(dirname(__DIR__) . '/pdf' . '/' . 'factura_' . $id . '.upload', 'F');
            } else {
                // generamos factura navegador
                $pdf->Output(site_url() . 'factura_' . $id . '.pdf', 'I');
            }
            
            // ============================================================+
            // END OF FILE
            // ============================================================+
        } else {
            $this->session->set_userdata('url', 'pedido/factura/' . $id . '');
            redirect(site_url() . 'user/loginuser');
        }
    }*/

    /**
     * Prepara el pedido
     */
    public function CreateOrderData()
    {
        $login = $this->session->userdata("login");
        $cart = $this->cartLibrary->GetCartData();
        
        if ($cart['totalProduct'] > 0) {
            if ($login != false && $login['is_logued_in']) {
                
                $user = $this->userModel->GetUserById($login['idUser']);
                $this->form['user'] = $user;
                $this->form['token'] = $this->token();
                
                $this->form["adressForm"] = form_open("OrderController/ProcessorSendForm", array(
                    "class" => "form-horizontal",
                    "name" => "ProcessorSendForm"
                ));
                $provinceList = $this->provinceModel->GetProvinceList();
                
                /*echo $this->twig->render('pedido/datos_pedido.twig', array(
                    'provinceList' => $provinceList,
                    'form' => $this->form,
                    'user' => $this->session->userdata('login'),
                    'cart' => $this->cartLibrary->GetCartData()
                ));*/
            } else {
                $this->session->set_userdata("url", 'orderController/CreateOrderData');
                //redirect(site_url() . 'user/loginuser');
            }
        } else {
            $this->session->set_flashdata('incorrect_cart', 'El carro de la compra está vacío');
            redirect(site_url() . 'cartController/GetCartView');
        }
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
        $this->CheckToken('token');
        
        //Validacion de los campos del formulario
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('surname', 'Surname', 'required');
        $this->form_validation->set_rules('dni', 'Dni', 'required|callback_dni_check');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cp', 'Postal Code', 'required|numeric|min_length[5]|max_length[5]');
        
        // Validacion del formulario
        if ($this->form_validation->run() == FALSE) {
            
            $this->form["name"] = form_error('name');
            $this->form["surname"] = form_error('surname');
            $this->form["dni"] = form_error('dni');
            $this->form["address"] = form_error('address');
            $this->form["cp"] = form_error('cp');
            
            $this->CreateOrderData();

        } else {

            $order = array(
                'description' => $this->input->post('description'),
                'creationDate' => date("Y-m-d"),
                'idUser' => $this->input->post('id'),
                'name' => $this->input->post('name'),
                'surname' => $this->input->post('surname'),
                'dni' => $this->input->post('dni'),
                'address' => $this->input->post('address'),
                'cp' => $this->input->post('cp'),
                'idProvince' => $this->input->post('province'),
                'stay' => 'unprocessed'
            );
            
            $this->session->set_userdata('order', $order);
            // y pedimos confirmación
            redirect(site_url() . 'orderController/ConfirmOrder');
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
     * Confirmacion del pedido
     */
    public function ConfirmOrder()
    {
        $login = $this->session->userdata("login");
        $this->form['user'] = $this->userModel->GetUserById($login['idUser']);
        $this->form['order'] = $this->session->userdata('order');
        
        $this->form['form_ConfirmOrder'] = form_open('orderController/ConfirmOrder', array(
            'class' => 'form-horizontal',
            'name' => 'confirmOrderForm'
        ));
        
        $this->form_validation->set_rules('condition', 'Conditions', 'required');
        
        // Validacion del formulario
        if ($this->form_validation->run() == FALSE) {

            $this->form['condition'] = form_error('condition');
            
            /*echo $this->twig->render('pedido/form_confirma_pedido.twig', array(
                'cart' => $this->cartLibrary->GetCartData(),
                'form' => $this->form,
                'user' => $this->session->userdata('login')
            ));*/
        } else {
            $this->CheckOrderStock();
            $error = $this->session->flashdata('stock_error');
            if (empty($error)) {
                $id = $this->orderModel->CreateOrder($this->session->userdata('order'));
                if (! empty($id)) {
                    $this->orderModel->CreateOrderLine($this->carrito->GetCartData(), $id);
                    $this->OrderEmail($id);
                    redirect(site_url() . 'cartController/EmptyCart');
                }
            }
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
                redirect(site_url() . 'userController/UserPanel');
            }
        } else {
            $this->session->set_userdata("url", 'orderController/CancelOrder/' . $id . '');
            redirect(site_url() . 'userController/LoginUser');
        }
    }

    /**
     */
    public function OrderEmail($id)
    {
        
        /*// Utilizando sendmail
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.iessansebastian.com';
        $config['smtp_user'] = 'aula4@iessansebastian.com';
        $config['smtp_pass'] = 'daw2alumno';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        
        $this->email->initialize($config);
        $this->email->from('aula4@iessansebastian.com', 'Prueba Automática desde CI');
        $this->email->to('arteaga.dev@gmail.com');
        
        $this->email->subject("Shopping Cart");
        $this->email->message($this->cuerpoEmail($id));
        $this->factura($id, 1, 'F');
        $this->email->attach(dirname(__DIR__) . '/upload' . '/' . 'factura_' . $id . '.pdf');
        $this->email->send();
        // echo $this->email->print_debugger();*/
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
     * Dibuja el cuerpo del email
     * con la factura del pedido
     *
     * @return string
     */
    /*private function cuerpoEmail($id)
    {
        $order = $this->orderModel->getLineasById($id);
        $fechaCreacion = $order[0]['creationDate'];
        
        $html = '<html>
            <head>
                <title>Shopping Cart</title>
            </head>
            <body>
                <img src="http://99designs.es/logo-design/store/16704/preview/6339080~3e7be7d060797973df4a43b5ba4994b4aac43d72-stocklarge" 
                    alt="Shooping Cart" height="500" width="800" />
                <p></p>
                <h2>Factura</h2>
                <hr />
                <div>
                <table border="1">
                    <tr>
                        <td>Nº de Factura: ' . $id . '</td>
                        <td>Fecha: ' . $fechaCreacion . '</td>
                        <td>Forma de pago: --</td>        
                    </tr>      
                </table>
                </div>
                <table border="1" style="width:100%">
                    <tr>
                        <td width="10%" bgcolor="#A1A1A1">Cod.</td>
                        <td width="53%" bgcolor="#A1A1A1">Artículo</td>
                        <td width="15%" bgcolor="#A1A1A1">Precio</td>
                        <td width="7%" bgcolor="#A1A1A1">Und</td>
                        <td width="15%" bgcolor="#A1A1A1">Total</td>
                    </tr>';
        foreach ($order as $linea) {
            $html .= '<tr>
                        <td>' . $linea['codigo'] . '</td>
                        <td  align="left">' . $linea['name'] . '</td>
                        <td  align="right">' . $linea['precio'] . '</td>
                        <td  align="center">' . $linea['quantity'] . '</td>
                        <td  align="right">' . intval($linea['quantity']) * intval($linea['precio']) . '</td>                   
                    </tr>';
        }
        $html .= '</table><div>';
        
        $html .= '<table border="1" style="width:100%">
                    <tr>
                        <td width="50%" bgcolor="#A1A1A1">SUBTOTAL</td>
                        <td width="20%" bgcolor="#A1A1A1">IVA</td>
                        <td width="30%" bgcolor="#A1A1A1">TOTAL</td>                   
                    </tr>
                 </table>';
        
        $html .= '<table border="1" style="width:100%">
                    <tr>
                        <td width="50%" >12</td>
                        <td width="20%" >2121</td>
                        <td width="30%" >3232</td>                   
                    </tr>
                    </table></div>
                    <p>********* NO RESPONDER A ESTE EMAIL *********</p> 
        </body>
      </html>';
        
        return $html;
    }*/

}

/* End of file OrderController.php */
/* Location: ./application/controllers/OrderController.php */
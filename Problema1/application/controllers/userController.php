<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	private $form = array();

	public function __construct()
	{
		parent::__construct();

		
        $this->load->model('provinceModel');
        $this->load->model('userModel');
        $this->load->model('orderModel');
		//Do your magic here
	}

    /**
     * Función crea formulario login
     */
    public function LoginUserForm()
    {
        $this->form["form_login"] = form_open("userController/ProcessorLoginForm", array(
            "class" => "form-horizontal",
            "name" => "ProcessorLoginForm"
        ));
        
        $this->form['token'] = $this->token();
        $data['form'] = $this->form;

        $data['bodyView'] =  $this->load->view('forms/loginForm', $data, TRUE);
        $this->load->view('layout', $data);
    }

	//COMENTAR
	public function UserPanel()
    {
        $login = $this->session->userdata("login");
        if ($this->login->UserLoggedIn()) {
            
            $this->form['error'] = $this->session->flashdata('incorrect_order');
            
            
            $unprocessedOrder = $this->orderModel->GetUnprocessedOrder($login['idUser']);
            $orderHistory = $this->orderModel->GetOrderHistory($login['idUser']);
            $user = $this->userModel->GetUserById($login['idUser']);            
            
            $data['form'] =  $this->form;
            $data['user'] =  $user;
            $data['unprocessedOrder'] =  $unprocessedOrder;
            $data['orderHistory'] =  $orderHistory;

            $data['bodyView'] =  $this->load->view('userPanelView', $data, TRUE);
            $this->load->view('layout', $data);

        } else {
            $this->session->set_userdata("url", 'userPanelView');
            redirect(site_url() . 'userController/LoginUserForm');
        }
    }

    public function DeactivateUser()
    {
        $login = $this->session->userdata("login");
        if ($this->login->UserLoggedIn()) {
            
            $data['isActive'] = 0;
            $user = $this->userModel->EditUser($data, $login['idUser']);
            
            $this->session->set_userdata("url", 'userPanelView');
            redirect(site_url('userController/LogoutUser'));

        } else {
            $this->session->set_userdata("url", 'userPanelView');
            redirect(site_url() . 'userController/LoginUserForm');
        }
    }
    
    /**
     * Verifica token
     *
     * @param      <type>  $string   The string
     */
    private function CheckToken($string)
    {
        if (! $this->input->post($string) && $this->input->post($string) == $this->session->userdata('token')) {
            redirect(site_url() . 'userController');
        }
    }

    /**
     * Procesa formularios de creación y edicion
     */

    public function ProcessorUserForm()
    {
        $this->CheckToken('token');

        $id = $this->input->post('id');

       //Validacion de los campos del formulario
        if (!isset($id) || empty($id)){
            $this->form_validation->set_rules('userName', 'UserName', 'required|is_unique[user.userName]');
            $this->form_validation->set_rules('pass', 'Password', 'trim|required|md5');
            $this->form_validation->set_rules('passConf', 'Password Confirmation', 'trim|required|matches[passConf]');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('surnames', 'Surnames', 'required');
        $this->form_validation->set_rules('dni', 'Dni', 'required|callback_dniCheck');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cp', 'Postal Code', 'required|numeric|min_length[5]|max_length[5]');
        $this->form_validation->set_rules('province', 'Province', 'required');

        // Validacion del formulario
        if ($this->form_validation->run() == FALSE) {
            
            $this->form["userName"] = form_error('userName');
            $this->form["pass"] = form_error('pass');
            $this->form["passConf"] = form_error('passConf');
            $this->form["email"] = form_error('email');
            $this->form["name"] = form_error('name');
            $this->form["surnames"] = form_error('surnames');
            $this->form["dni"] = form_error('dni');
            $this->form["address"] = form_error('address');
            $this->form["cp"] = form_error('cp');
            $this->form["province"] = form_error('province');
            
            if (isset($id) && !empty($id))
            {   
                $this->EditUserForm($this->input->post('id'));
            }
            else
            {
                $this->CreateUserForm();
            }
        } else {
            
            $user = array(
                'email' => $this->input->post('email'),
                'name' => $this->input->post('name'),
                'surnames' => $this->input->post('surnames'),
                'dni' => $this->input->post('dni'),
                'address' => $this->input->post('address'),
                'cp' => $this->input->post('cp'),
                'province_idProvince' => $this->input->post('province'),
                'rol' => 'user',
                'isActive' => true
            );
            
           
            // si existe id es edicion
            if (isset($id) && !empty($id)) {
               
                $this->userModel->EditUser($user, $id);
                redirect(site_url('userController/UserPanel/' . $id));   

            } else {
                
                $user['userName'] = $this->input->post('userName');
                $user['pass'] = $this->input->post('pass');

                $result = $this->userModel->CreateUser($user);
             
                if ($result) {
                    redirect(site_url() . '/cartController/GetCartView');
                } else {
                    $this->form['error'] = $this->session->flashdata('incorrect_user');
                    redirect(site_url() . $this->session->userdata("url") ? $this->session->userdata("url") : 'home');
                }
            }
        }
    }

    /**
     * Procesa el formulario de login de usuario
     */
    public function ProcessorLoginForm()
    {
        $this->CheckToken('tokenLogin');
        
        //Validacion de campos del formulario
        $this->form_validation->set_rules('userNameLogin', 'UserName', 'required');
        $this->form_validation->set_rules('passLogin', 'Password', 'trim|required|md5');
        
        $form["form_login"] = form_open("userController/ProcessorLoginForm", array(
            "class" => "form-horizontal",
            "name" => "ProcessorLoginForm"
        ));
        //Validacion del formulario
        if ($this->form_validation->run() == FALSE) {

            $this->form["error"] = 'User or password incorrect';
            $this->LoginUserForm();

        } else {
            
            $userName = $this->input->post('userNameLogin');
            $pass = $this->input->post('passLogin');
            $user = $this->userModel->LoginUser($userName, $pass);

            if ($user == TRUE) {
                $data = array(
                    'is_logued_in' => TRUE,
                    'idUser' => $user->idUser,
                    'userName' => $user->userName
                );

                $this->session->set_userdata("login", $data);
                redirect(site_url($this->session->userdata("url")));
            } else {
                $this->form["error"] = 'User or password incorrect';
                $this->LoginUserForm();
            }
        }
    }

    /**
     * Función encargada de crear el formulario de creacion o edicion de usuario
     */
    public function CreateUserForm()
    {
        $this->form['id'] = 0;
        
        $this->form["form_signup"] = form_open("userController/ProcessorUserForm", array(
            "class" => "form-horizontal",
            "name" => "ProcessorUserForm"
        ));
        
        $this->form['token'] = $this->token();
        $provinceList = $this->provinceModel->GetProvinceList();
        
        $data['provinceList'] = $provinceList;
        $data['form'] = $this->form;
        
        $data['bodyView'] =  $this->load->view('forms/userNewForm', $data, TRUE);
        $this->load->view('layout', $data);

    }

    /**
     * Función encargada de crear el formulario de creacion o edicion de usuario
     *
     * @param      integer|string  $id     The identifier
     */
    public function EditUserForm($id = 0)
    {
        if ($this->login->UserLoggedIn()) {           

            if (isset($id) && $id != 0) {

                $user = $this->userModel->GetUserById($id);

                if (! empty($user)) {
                    $this->form['id'] = $id;
                    $this->form["form_edit"] = form_open("userController/ProcessorUserForm", array(
                        "class" => "form-horizontal",
                        "name" => "ProcessorUserForm"
                    ));
                    
                    $this->form['token'] = $this->token();
                    $data['provinceList'] = $this->provinceModel->GetProvinceList();
                    $data['form'] = $this->form;
                    $data['userData']  = $user;
                    $data['user'] = $this->session->userdata("login");
                    

                    $data['bodyView'] =  $this->load->view('forms/userEditForm', $data, TRUE);
                    $this->load->view('layout', $data);
                    
                } else {
                    redirect(site_url() . 'home');
                }
            }
        } else {
            $this->session->set_userdata("url", 'userController/EditFormUser/' . $id . '');
            redirect(site_url() . 'userController/LoginUser');
        }
    }

    /**
     * Validacion del dni
     *
     * @param      <type>  $dni    The dni
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function DniCheck($dni)
    {
        $letter = strtoupper(substr($dni, -1));
        $number = substr($dni, 0, -1);
        $letterFormula = substr("TRWAGMYFPDXBNJZSQVHLCKE", $number % 23, 1);

        if ($letterFormula == $letter && strlen($letter) == 1 && strlen($number) == 8) {
            return TRUE;
        } else {
            $this->form_validation->set_message('dniCheck', 'Invalid dni');
            return FALSE;
        }
    }

    

    /**
     * Clave aleatoria que será la que contendrá el formulario
     *
     *
     * @return string
     */
    private function token()
    {
        $token = md5(uniqid(rand(), TRUE));
        $this->session->set_userdata('token', $token);
        return $token;
    }

    /**
     * Cerrar sesion
     */
    public function LogoutUser()
    {
        $this->session->set_userdata('url', 'home');
        $this->session->unset_userdata('login');
        $this->cart_library->destroy();
        redirect(site_url('home'));
    }



    /**
     *Funcion encargada de procesar el cambio de contraseña
     */
    public function ResetPass()
    {
        $this->form['token'] = $this->token();

        //Comprobar validacion de campos
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        //Comprobar validación del formulario
        if ($this->form_validation->run() == FALSE) {
            $this->form["email"] = form_error('email');
            
            $this->form["emailForm"] = form_open("", array(
                "class" => "form-horizontal"
            ));
            
            $data['form'] = $this->form;
            $data['bodyView'] = 'forms/userNewPassForm';

            $this->load->view('layout', $data);

        } else {
            $user = $this->userModel->GetUserByEmail($this->input->post('email'));
            
            if (! empty($user)) {
                
                $newPass = substr(md5(rand()), 0, "10"); 
                $newPass2 = md5($newPass); 
                
                $result = $this->userModel->EditUser(array(
                    'password' => $newPass
                	), $user['idUser']);

                if ($result == 1) {
                    
                    $email = $this->PassEmail($newPass);
                }
            }
        }
    }




    //Funcion encargada de enviar la nueva clave a traves del email
	private function PassEmail($pass)
    {
        
    }

}

/* End of file userController.php */
/* Location: ./application/controllers/userController.php */
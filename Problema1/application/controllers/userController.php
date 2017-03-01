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
        $this->form_validation->set_rules('userName', 'UserName', 'required');
        if (!isset($id) || empty($id)){
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
                'userName' => $this->input->post('userName'),
                'pass' => $this->input->post('pass'),
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
               
                $rows = $this->userModel->EditUser($user, $id);
                if ($rows == 1)
                    redirect(site_url() . 'home');                    
                else
                    redirect(site_url() . $this->session->userdata("url"));
            } else {
                
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
        
        $data['bodyView'] =  $this->load->view('forms/newUserForm', $data, TRUE);
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
                    $this->form['user'] = $user;
                    $this->form['id'] = $id;
                    
                    $this->form["editForm"] = form_open("userController/ProcessorUserForm", array(
                        "class" => "form-horizontal",
                        "name" => "ProcessorUserForm"
                    ));
                    
                    $this->form['token'] = $this->token();
                    $provinceList = $this->provinceModel->GetProvinceList();
                    
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
        redirect(site_url('home'));
    }


/* End of file userController.php */
/* Location: ./application/controllers/userController.php */
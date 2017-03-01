<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login
{
	protected $ci;

	private $_cart = array();

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	/**
	 * Funcion encargada de comprobar si hay un usuario logueado
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function UserLoggedIn()
    {
        $login = $this->ci->session->userdata("login");
        
        if ($login != false && $login['is_logued_in']) {
            return true;
        } else {
            return false;
        }
    }
	

}

/* End of file login.php */
/* Location: ./application/libraries/login.php */

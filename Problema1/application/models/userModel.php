<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Devuelve todos los datos de un usuario con nombre de usuario y email deterinados
     * 
     * @param string $userName            
     * @param string $email            
     */
    public function GetUser($userName, $email)
    {       
        return $this->db->where('userName',$userName)->or_where('email', $email)->get('user');
    }

    /**
     * Devuelve un usuario con un email determinado
     *
     * @param      <type>  $email  The email
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function GetUserByEmail($email)
    {       
        return $this->db->where('email', $email)->get('user')->result();
    }

    /**
     * Obtiene un usuario con un id determinado
     *
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  The user by identifier.
     */
    public function GetUserById($id){
        
        return $this->db->select('*')->from('user','province')->join('province', 'province.idProvince = user.province_idProvince')->where('idUser', $id)->get()->row_array();
    }

    /**
     * Inserta un usuario en bbdd
     *
     * @param      <type>   $data   The data
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function CreateUser($data)
    {
        // comprobacion si existe el usuario
        $user = $this->GetUser($data['userName'], $data['email']);
        if (!empty($user)) {
            $this->db->insert('user', $data);
            return true;
        } else {
            $this->session->set_flashdata('Incorrect_user', 'El usuario ya existe');
            return false;
        }
    }

    /**
     * Actualiza los datos determinados de un usuario con id determinada
     *
     * @param      <type>  $data   The data
     * @param      <type>  $id     The identifier
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function EditUser($data, $id){
        echo var_dump($data);
        $this->db->where('idUser',$id);
        $this->db->update('user', $data);     

        return $this->db->affected_rows();
        
    }

    /**
     * Login de un usuario con nombre de usuario y contraseña determinados
     *
     * @param      <type>   $userName  The user name
     * @param      <type>   $pass      The pass
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function LoginUser($userName, $pass)
    {
        $sql = $this->db->where('userName', $userName)->where('pass', $pass)->where('isActive', true)->get('user'); 
        

        if ($sql->num_rows() == 1) {
            return $sql->row();
        } else {
            $this->session->set_flashdata('Incorrect_user', 'Los datos introducidos son incorrectos');
            return false;
        }
    }

}



/* End of file userModel.php */
/* Location: ./application/models/userModel.php */
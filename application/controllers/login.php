<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $this->load->helper('url');
        $this->load->library('Func');
		$this->load->view('loginpage');
        if($this->func->login_check()){
            redirect('');
        }
        if(isset($_POST['username'],$_POST['password'])){
            if($this->_login($_POST['username'],$_POST['password'])){
                redirect('');
        }
    }
        else if(isset ($_SESSION['error']))
                echo $_SESSION['error'];
    }

    public function _login($username, $password)
    {
        session_start();
        $query=$this->db->query("SELECT * FROM members WHERE username='".$username."';");
        if($query->num_rows()==0){
            return false;
            $_SESSION['error']='login';
        }
        $password_db=$query->row()->password;
        $user_id = $query->row()->id;

        $password = hash('sha512', $password . "diogomoura13");
        if ($password_db == $password) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            return true;
        } else{
            $_SESSION['error']='login';
            return false;
        }
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
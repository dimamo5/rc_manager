<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Func {

    public function login_check()
    {
        $CI =& get_instance();
        session_start();
        if (isset($_SESSION['user_id'], $_SESSION['username'])) {
            $user_id = $_SESSION['user_id'];
        } else return false;

        $query =$CI->db->query("SELECT username FROM members WHERE id='".$user_id."';");
        if($query->num_rows()===0){
            return false;
        }
        $username=$query->row()->username;
        if ($username == $_SESSION['username']) {
            return true;
        } else {
            return false;
        }
    }
    public function logout()
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
        }
        session_destroy();
    }
}
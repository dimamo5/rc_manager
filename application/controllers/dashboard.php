<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function index(){
        $this->load->library('Func');
        $this->load->helper('url');
        if(!$this->func->login_check())
            redirect('/login');
        $this->load->view('header',array('username'=>$_SESSION['username']));
        $this->load->view('nav_bar/lateral',array('type'=>'main'));
        $this->load->view('dashboard');
        $this->load->view('footer');
    }
}

?>
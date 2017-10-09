<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        if ( ($_SESSION['role'] != 'Student')
            OR ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) ) redirect(base_url());

        //модель для роботи з БД
        $this->load->model('Admin_model', 'admin');
        //
        $this->load->library('kint/Kint');
    }


    // головна сторніка редагування журналу викладачем
    public function index()    {
        $header = ['navbar_text'=>'Журнал'];

        $this->load->view('student/header', $header);
        $this->load->view('student/main');
        $this->load->view('student/footer');
    }







}
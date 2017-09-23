<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector extends CI_Controller
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        if ( $_SESSION['role'] != 'Inspector' ) redirect(base_url());
        //модель для роботи з БД
        $this->load->model('Inspector_model', 'inspector');
        //
        $this->load->library('kint/Kint');
    }


    // головна сторніка
    public function index() {
        $header = ['navbar_brand'=>'Статистика'];
        $main = $this->inspector->base_teacher_statistics();
        $footer = ['js_file'=>'inspector-main.js'];

        $this->load->view('inspector/header', $header);
        $this->load->view('inspector/main', $main);
        $this->load->view('inspector/footer', $footer);
    }

}
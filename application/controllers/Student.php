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
        $this->load->model('Student_model', 'student');
        //
        $this->load->library('kint/Kint');
    }


    // головна сторніка редагування журналу викладачем
    public function index()    {
        $header = ['navbar_text'=>'Журнал'];
        $main['journal'] = $this->student->load_student_journal();
        $footer['js_file'] = 'student.js';

        $this->load->view('student/header', $header);
        $this->load->view('student/main', $main);
        $this->load->view('student/footer', $footer);
    }







}
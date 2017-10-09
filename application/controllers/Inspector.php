<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector extends CI_Controller
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        // перевіряємо чи має користувач доступ до методів класу
        if ( ($_SESSION['role'] != 'Inspector')
            OR ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) ) redirect(base_url());

        //модель для роботи з БД
        $this->load->model('Inspector_model', 'inspector');

        // Kint - debugging helper for PHP developers
        $this->load->library('kint/Kint');
    }


    // головна сторніка
    public function index() {
        $header = ['navbar_brand'=>'Статистика'];
        $main = $this->inspector->teacher_statistics_all();
        $footer = ['js_file'=>'inspector-main.js'];

        $this->load->view('inspector/header', $header);
        $this->load->view('inspector/main', $main);
        $this->load->view('inspector/footer', $footer);
    }


    // Для викладача
    public function teacher(){
        $header = ['navbar_brand'=>'Статистика'];
        $footer = ['js_file'=>'inspector-main.js'];

        if ($this->input->get('action') == 'openTeacher') {
            $main = $this->inspector->teacher_statistics();

            $this->load->view('inspector/header', $header);
            $this->load->view('inspector/teacher', $main);
            $this->load->view('inspector/footer', $footer);
        }
        elseif ($this->input->get('action') == 'openTeacherJournal') {
            $main = $this->inspector->teacher_statistics_journal();

            $this->load->view('inspector/header', $header);
            $this->load->view('inspector/teacher_journal', $main);
            $this->load->view('inspector/footer', $footer);
        }
        else $this->index();
    }

    //
    public function student(){
        $header = ['navbar_brand'=>'Статистика'];
        $footer = ['js_file'=>'inspector-main.js'];
        if ($this->input->get('action') == 'openStudentJournal') {
            $main = $this->inspector->student_statistics_journal();
            $main['student_name'] = $this->input->get('studentName');

            $this->load->view('inspector/header', $header);
            $this->load->view('inspector/student_journal', $main);
            $this->load->view('inspector/footer', $footer);
        }
        else{
            $main = $this->inspector->student_statistics();

            $this->load->view('inspector/header', $header);
            $this->load->view('inspector/student', $main);
            $this->load->view('inspector/footer', $footer);
        }
    }

} // END CLASS
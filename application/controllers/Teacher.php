<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {

    // constructor
    public function __construct() {
        parent::__construct();
        if ( !isset($_SESSION['open']) ) redirect(base_url());
        // підключаємо модель для роботи з базою даних
        $this->load->model('Teacher_model', 'teacher_model');

        //додатково для перевірки роботи
        $this->load->library('kint/Kint');
    } // end __construct


    // 1. головна сторніка викладачем - вибір журналу
    public function index() {
        // налаштування верхньої панелі
        $header = ['navbar_text'=>'Список груп', 'navbar_menu'=>'group'];
        // зчитуємо список доступних груп
        $value = $this->teacher_model->read_list_group_teacher();
        $main = ['list_gt'=> $value];

        // запамятовуємо список доступних груп і предметів для даного викладача
        $list_group = [];
        $list_subject = [];
        for($i=0; $i< count($value); $i++){
            $list_group[$i] = $value[$i]['id_group'];
            $list_subject[$i] = $value[$i]['id_subject'];
        };
        $_SESSION['list_group'] = array_unique($list_group);
        $_SESSION['list_subject'] = array_unique($list_subject);

        // показуєм сторінки
        $this->load->view('teacher/header', $header);
        $this->load->view('teacher/main', $main);
        $this->load->view('teacher/footer');
    } // end index


    // 2. сторніка - електронний журнал відповідної групи і предмету
    public function journal(){
        $header = ['navbar_text'=>'Електронний журнал', 'navbar_menu'=>'journal'];
        // завантажуємо журнал
        $journal = $this->teacher_model->load_journal();

        $this->load->view('teacher/header', $header);
        $this->load->view('teacher/journal', $journal);
        $this->load->view('teacher/footer');
    } // end journal


    // 3. сторінка - налаштування користувача
    public function settings(){
        $header = ['navbar_text'=>'Налаштування', 'navbar_menu'=>'settings'];
        //
        $this->load->view('teacher/header', $header);
        $this->load->view('teacher/settings');
        $this->load->view('teacher/footer');
    } // end settings






    // завантажуємо журнал (ajax - get)
    public function ajax_get_data(){

        // відкриваємо журнал викладча
        if ($this->input->get('action') == 'openJournal'){
            //$this->teacher_data = $this->teacher->table_journal();
            $this->teacher_data = $this->teacher->table_journal_join();

            //$this->load->view('teacher/table_journal', $this->teacher_data);
        }
        // додаємо нову ДАТУ до журналу викладача
        if ($this->input->get('action') == 'newJournalDate'){
            //$res = $this->teacher_model->add_new_data_journal();
            //echo json_encode($res);
        }
        // додаємо нову ОЦІНКУ до журнала викладача
        if ($this->input->get('action') == 'addNewMark'){
            //$res = $this->teacher_model->add_new_mark();
            //echo json_encode($res);
        }
    }








} // end Teacher
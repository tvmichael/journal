<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {

    // constructor
    public function __construct() {
        parent::__construct();
        if ( $_SESSION['role'] != 'Teacher' ) redirect(base_url());
        // підключаємо модель для роботи з базою даних
        $this->load->model('Teacher_model', 'teacher_model');
    }


    // 1. головна сторніка викладача - вибір журналу
    public function index() {
        // налаштування верхньої панелі
        $header = ['navbar_text'=>'Список груп', 'navbar_menu'=>''];
        // зчитуємо список доступних груп
        $value = $this->teacher_model->read_list_group_teacher();
        $main = ['list_gt'=> $value];

        // список доступних груп і предметів даного викладача
        $list_group = [];
        $list_subject = [];
        for($i=0; $i< count($value); $i++){
            $list_group[$i] = $value[$i]['id_group'];
            $list_subject[$i] = $value[$i]['id_subject'];
        };
        // запамятовуємо список унікальних предметів і груп які веде викладач
        $_SESSION['list_group'] = array_unique($list_group);
        $_SESSION['list_subject'] = array_unique($list_subject);

        $footer = ['js_file'=>'teacher-main.js'];

        // показуєм сторінки
        $this->load->view('teacher/header', $header);
        $this->load->view('teacher/main', $main);
        $this->load->view('teacher/footer', $footer);
    } // end index


    // 2. сторніка - електронний журнал відповідної групи і предмету
    public function journal(){
        $header = ['navbar_text'=>'Електронний журнал', 'navbar_menu'=>'journal'];
        // завантажуємо журнал
        $journal = $this->teacher_model->load_journal();
        $footer = ['js_file'=>'teacher-journal.js'];

        if ($journal['error'] == 0) {
            $this->load->view('teacher/header', $header);
            $this->load->view('teacher/journal', $journal);
            $this->load->view('teacher/footer', $footer);
        }
        else {
            $data = ['heading'=>'Помилка завантаження даних', 'message'=>'Дана сторінка відсутня'];
            $this->load->view('errors/html/error_general', $data);
        }
    } // end journal


    // 3. сторінка - налаштування користувача
    public function settings(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $header = ['navbar_text'=>'Налаштування', 'navbar_menu'=>'settings'];
        $setting = ['message'=>''];

        // перевіряємо чи відправлені дані з форми
        if ( isset($_POST['submit']) ) {
            // перевіряємо форму на правильність введених даних
            $this->form_validation->set_rules('login', '(Логін)', 'min_length[3]|max_length[16]');
            $this->form_validation->set_rules('surname', '(Прізвище)', 'required|min_length[3]|max_length[16]');
            $this->form_validation->set_rules('name', '(Імя)', 'required|min_length[2]|max_length[25]');
            $this->form_validation->set_rules('patronymic', '(по батькові)', 'min_length[2]|max_length[25]');
            $this->form_validation->set_rules('email', '(Email)', 'min_length[3]|max_length[100]|valid_emails');

            $this->form_validation->set_rules('password', '(Пароль)', 'min_length[3]|max_length[16]');
            $this->form_validation->set_rules('password1', '(Пароль-1)', 'min_length[3]|max_length[16]');
            $this->form_validation->set_rules('password2', '(Пароль-2)', 'min_length[3]|max_length[16]|matches[password1]');
            if ($this->form_validation->run() == TRUE) {
                // якщо данні введено правильно то зберігаємо користувача в БД
                $error = $this->teacher_model->updateUserInfo();
                $setting = ['message'=> $error ];
            }
        }
        $this->load->view('teacher/header', $header);
        $this->load->view('teacher/settings', $setting);
        $this->load->view('teacher/footer');
    } // end settings


    // 4. сторінка повідомлення (зі сторони викладача - і в зворотньому напрямку)
    public function message(){
        // зберігаємо повідомлення викладача
        if ($this->input->get('action') == 'sendMessage'){
            echo $this->teacher_model->save_teacher_message();
            return;
        }
        // попередні повідомлення
        $message = ['message'=>$this->teacher_model->get_all_teacher_message()];

        // налаштування верхньої панелі
        $header = ['navbar_text'=>'Повідомлення', 'navbar_menu'=>'message'];
        //
        $footer = ['js_file'=>'teacher-message.js'];
        // показуєм сторінки
        $this->load->view('teacher/header', $header);
        $this->load->view('teacher/message', $message);
        $this->load->view('teacher/footer', $footer);
    }


    // операції з журналом (ajax - get)
    public function ajax_get_data(){
        // додаємо нову ДАТУ до журналу викладача
        if ($this->input->get('action') == 'addColumnToTable'){
            $res = $this->teacher_model->saveNewTableColumn();
            echo ' Додано: (', $res, ') записи(ів).';
        }
        // додаємо нову ОЦІНКУ до журнала викладача
        if ($this->input->get('action') == 'addNewMark'){
            $res = $this->teacher_model->add_new_mark();
            //echo json_encode($res);
            echo 'Оновлено (', $res, ') запис.';
        }
        if ($this->input->get('action') == 'settingsView'){
            $this->teacher_model->user_settings(intval($this->input->get('view')));
            echo 'Збережено!';
        }
    }

    
} // end Teacher
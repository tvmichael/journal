<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        if ( !isset($_SESSION['open']) ) redirect(base_url());
        //модель для роботи з БД
        $this->load->model('Admin_model', 'admin');
        //
        $this->load->library('kint/Kint');
    }


    // головна сторніка редагування журналу викладачем
    public function index()    {
        $header = ['navbar_header'=>'Адміністратор'];

        $this->load->view('admin/header', $header);
        $this->load->view('admin/main');
        $this->load->view('admin/footer');
    }


    // сторінка налаштування навантаження викладачів
    public function working_load(){
        // таблиця нагрузки викладача
        if ($this->input->get('action') == 'teacherWorkingLoad' ){
            $this->load->helper('admin');
            // повертаємо таблицю
            return teacher_working_table($this->admin->teacherWorkingLoad());
        }
        // додати нову нагрузку
        if ($this->input->get('action') == 'teacherWorkingWrite' ){
            $this->load->helper('admin');
            // зберігаємо дані
            $this->admin->teacherWorkingWrite();
            // повертаємо таблицю
            return teacher_working_table($this->admin->teacherWorkingLoad());
        }
        // видалити нагрузку
        if ($this->input->get('action') == 'removeTeacherLoad' ){
            $this->load->helper('admin');
            // зберігаємо дані
            $this->admin->removeTeacherLoad();
            // повертаємо таблицю
            return teacher_working_table($this->admin->teacherWorkingLoad());
        }

        $header = ['navbar_header'=>'Навантаження'];
        // загрузка списку вчителів
        $main['teacher'] = $this->admin->load_list_teacher();
        //загрузка списку груп
        $main['group'] = $this->admin->load_list_group();
        // загрузка списку предметів
        $main['subject'] = $this->admin->load_list_subject();

        $this->load->view('admin/header', $header);
        $this->load->view('admin/working_load', $main);
        $this->load->view('admin/footer');
    }


    // редагування списку викладачів
    public function list_teacher(){
        $header = ['navbar_header'=>'Список викладачів'];

        $this->load->view('admin/header', $header);
        $this->load->view('admin/list_teacher');
        $this->load->view('admin/footer');
    }


    // сторінка налаштування студентів
    public function student(){
        $header = ['navbar_header'=>'Студенти'];
        $this->load->helper('admin');
        // виводимо список студентів відповідної групи
        if($this->input->get('action') == 'readGroupIdStudent'){
            return student_select_table($this->admin->readStudentAndGroup(intval($this->input->get('groupId'))) );
        }
        // список усіх студентів
        $main['student'] = $this->admin->readStudentAndGroup(0);
        // список усіх груп
        $main['group'] = $this->admin->load_list_group();

        $this->load->view('admin/header', $header);
        $this->load->view('admin/students', $main);
        $this->load->view('admin/footer');
    }


    // редагуємо студента
    public function edit_student(){
        echo $this->input->get('editStudentId');
    }

    // додаємо список нових студентів
    public function add_new_student(){
        //
        if($this->input->get('action') == 'saveStudentGroup'){
            $this->admin->insert_new_students($this->input->get('student'));
            //d($this->input->get('student'));
            return;
        }
        //
        $header = ['navbar_header'=>'Студенти'];
        $data['group'] = $this->admin->load_list_group();

        $this->load->view('admin/header', $header);
        $this->load->view('admin/add_new_student', $data);
        $this->load->view('admin/footer');
    }


    // загальні налаштування
    public function group(){
        $header = ['navbar_header'=>'Групи'];

        $this->load->view('admin/header', $header);
        $this->load->view('admin/group');
        $this->load->view('admin/footer');
    }


    // загальні налаштування
    public function setting(){
        echo 'setting';
    }























    /** додаткові функції //////////////////////////////////////////// **/
    //
    public function sql(){
        $this->teacher_data = $this->teacher->table_journal_join();
        print_r($this->teacher_data);
        print('OK--');
    }

    //
    public function add_teacher(){
        if(isset($_POST['submit'])) {
            // завантажуємо бібліотеку PHPExcel для роботи з Excel файлами
            $this->load->library('PHPExcel/PHPExcel');
            // завантажуєм додаткові функції для роботи з загруженими файлами
            $this->load->helper('load_excel_file');
            $this->teacher->insert_new_teachers(loadTeacherFile());
        }
        else {

            // Якщо включена опція (XSS Filtering) то дані з форми будуть завантажуватися тільки при наявності підтвердження змінної - 'csrf'
            $teacher_data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $this->load->view('admin/loadfile',$teacher_data);
        }

    }

    public function add_group(){
        if(isset($_POST['submit'])) {
            // завантажуємо бібліотеку PHPExcel для роботи з Excel файлами
            $this->load->library('PHPExcel/PHPExcel');
            // завантажуєм додаткові функції для роботи з загруженими файлами
            $this->load->helper('load_excel_file');
            $this->admin->insert_new_groups(loadGroupFile());
            //d(loadGroupFile());
        }
        else {

            // Якщо включена опція (XSS Filtering) то дані з форми будуть завантажуватися тільки при наявності підтвердження змінної - 'csrf'
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $data['actions'] = 'admin/add_group';
            $this->load->view('admin/loadfile',$data);
        }


    }

    //
    public function add_student(){
        if(isset($_POST['submit'])) {
            // завантажуємо бібліотеку PHPExcel для роботи з Excel файлами
            $this->load->library('PHPExcel/PHPExcel');
            // завантажуєм додаткові функції для роботи з загруженими файлами
            $this->load->helper('load_excel_file');
            $this->admin->insert_new_students(loadStudentFile());
            //d(loadStudentFile());
        }
        else {

            // Якщо включена опція (XSS Filtering) то дані з форми будуть завантажуватися тільки при наявності підтвердження змінної - 'csrf'
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $data['actions'] = 'admin/add_student';
            $this->load->view('admin/loadfile',$data);
        }
    }

    //
    public function add_subject(){
        if(isset($_POST['submit'])) {
            // завантажуємо бібліотеку PHPExcel для роботи з Excel файлами
            $this->load->library('PHPExcel/PHPExcel');
            // завантажуєм додаткові функції для роботи з загруженими файлами
            $this->load->helper('load_excel_file');
            $this->admin->insert_new_subjects(loadSubjectFile());
            //d(loadSubjectFile());
        }
        else {

            // Якщо включена опція (XSS Filtering) то дані з форми будуть завантажуватися тільки при наявності підтвердження змінної - 'csrf'
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $data['actions'] = 'admin/add_subject';
            $this->load->view('admin/loadfile',$data);
        }
    }



    // створює відповідні талиці бази даних
    public function create_database(){
        //$this->load->model('CreateDatabase_model', 'CreateBase');
        //$this->CreateBase->create_database_table();
    }



}
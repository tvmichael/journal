<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        if ( ($_SESSION['role'] != 'Admin')
            OR ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) ) redirect(base_url());

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
    public function working_load()
    {
        // таблиця нагрузки викладача
        if ($this->input->get('action') == 'teacherWorkingLoad') {
            $this->load->helper('admin');
            // повертаємо таблицю
            $ob = ['error' => 0, 'text' => teacher_working_table($this->admin->teacherWorkingLoad())];
            echo json_encode($ob, JSON_UNESCAPED_UNICODE);
            return;
        }
        // додати нову нагрузку
        if ($this->input->get('action') == 'teacherWorkingWrite') {
            $this->load->helper('admin');
            // зберігаємо дані
            $error = $this->admin->teacherWorkingWrite();
            // повертаємо таблицю
            $text = '';
            if ($error == 0) $text = teacher_working_table($this->admin->teacherWorkingLoad());
            $ob = ['error' => $error, 'text' => $text];
            echo json_encode($ob, JSON_UNESCAPED_UNICODE);
            return;
        }
        // видалити нагрузку
        if ($this->input->get('action') == 'removeTeacherLoad') {
            $this->load->helper('admin');
            // видаляємо дані
            $error = $this->admin->removeTeacherLoad();
            // повертаємо таблицю
            $text = '';
            if ($error == 0) $text = teacher_working_table($this->admin->teacherWorkingLoad());
            $ob = ['error'=>$error, 'text' => $text];
            echo json_encode($ob, JSON_UNESCAPED_UNICODE);
            return;
        }

        $header = ['navbar_header' => 'Навантаження'];
        // загрузка списку вчителів
        $main['teacher'] = $this->admin->load_list_teacher_count();
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
        $teacher['list'] = $this->admin->load_list_teacher();


        $this->load->view('admin/header', $header);
        $this->load->view('admin/list_teacher', $teacher);
        $this->load->view('admin/footer');
    }


    // додати нового викладача
    public function add_new_teacher(){
        $header = ['navbar_header'=>'Додати викладача'];
        $this->load->helper('form');
        $this->load->library('form_validation');
        $main = ['message'=>''];

        // перевіряємо чи відправлені дані з форми
        if ( isset($_POST['submit']) ) {
            // перевіряємо форму на правильність введених даних
            $this->form_validation->set_rules('login', '(Логін)', 'min_length[3]|max_length[16]');
            $this->form_validation->set_rules('surname', '(Прізвище)', 'required|min_length[3]|max_length[16]');
            $this->form_validation->set_rules('password1', '(Пароль-1)', 'min_length[3]|max_length[16]');
            $this->form_validation->set_rules('password2', '(Пароль-2)', 'min_length[3]|max_length[16]|matches[password1]');
            if ($this->form_validation->run() == TRUE) {
                // якщо данні введено правильно то зберігаємо користувача в БД
                $error = $this->admin->add_new_teacher();
                $main = ['message'=> $error];
            }
        }
        $this->load->view('admin/header', $header);
        $this->load->view('admin/add_new_teacher', $main);
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


    // редагуємо інформацію по студентові
    public function student_edit(){
        $header = ['navbar_header'=>'Студенти'];

        // додаємо студента до нової групи (і заносимо дані по журналу якщо в цій групі студенти вже мають оцінки)
        if($this->input->get('action') == 'editStudentAddGroup'){
            $res = $this->admin->edit_student_add_group();
            echo json_encode($res);
            return;
        }
        // видаляємо належність студента до вказаної групи
        if($this->input->get('action') == 'deleteStudentGroup'){
            $res = $this->admin->edit_student_delete_group();
            echo $res;
            return;
        }
        // видаляємо студента
        if($this->input->get('action') == 'deleteStudent'){
            $res = $this->admin->edit_student_delete();
            echo $res;
            return;
        }
        // зберігаємо зміни (прізвища, імя) для студента
        if($this->input->get('action') == 'saveStudent'){
            echo $this->admin->edit_student_save();
            return;
        }
        // змінити пароль
        if($this->input->get('action') == 'saveNewPass'){
            echo $this->admin->edit_student_password();
            return;
        }

        // завантажуємо дані по студенту з БД
        $main['student'] = $this->admin->load_student();
        $main['group'] = $this->admin->load_list_group();

        $this->load->view('admin/header', $header);
        $this->load->view('admin/student_edit', $main);
        $this->load->view('admin/footer');
    }


    // додаємо список нових студентів
    public function add_new_student(){
        $header = ['navbar_header'=>'Студенти'];

        // передаємо список студентів
        if($this->input->get('action') == 'saveStudentGroup'){
            $this->admin->insert_new_students($this->input->get('student'));
            //d($this->input->get('student'));
            return;
        }

        // передаємо 'excel' файл
        if($this->input->post('submitExcel')){
            $this->load->library('PHPExcel/PHPExcel');
            $this->load->helper('load_excel_file');
            $data['students'] = $this->admin->insert_new_students_excel(loadStudentFile());
            //$data['students'] = loadStudentFile();

            $this->load->view('admin/header', $header);
            $this->load->view('admin/student_excel_save', $data);
            $this->load->view('admin/footer');
            return;
        }

        // Cross-site request forgery
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['csrf'] = $csrf;
        // список груп
        $data['group'] = $this->admin->load_list_group();

        $this->load->view('admin/header', $header);
        $this->load->view('admin/student_add_new', $data);
        $this->load->view('admin/footer');
    }

    // дотаткові налаштування по студенту - генерація паролей
    public function student_setting(){
        $header = ['navbar_header'=>'Студенти'];
        $data = '';

        // згенерувати облікові записи студентів - (паролі і логіни)
        if($this->input->get('action') == 'listStudentRegistration'){
            $mas = $this->admin->list_student_registration();
            $nm = array();
            $i = 0;
            // генеруємо випадковий пароль
            function random_str($length) {
                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $pass = array();
                $alphaLength = strlen($alphabet) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $n = rand(0, $alphaLength);
                    $pass[] = $alphabet[$n];
                }
                return implode($pass);
            };

            foreach ($mas as $m){
                $nm[$i] = array();
                $nm[$i]['login'] = 'student'.$m['id'];
                $nm[$i]['password'] = random_str(5);
                $nm[$i]['name'] = $m['name'];
                $nm[$i]['surname'] = $m['surname'];
                $nm[$i]['patronymic'] = $m['patronymic'];
                $nm[$i]['groupe'] = $m['groupe'];
                $nm[$i]['course'] = $m['course'];
                $nm[$i]['settings'] = json_encode([
                    'course'=>$m['course'],
                    'groupe'=>$m['groupe'],
                    'id_group'=>$m['group_id'],
                    'id_student'=>$m['id']
                ],JSON_UNESCAPED_UNICODE);
                $i++;
            }
            //
            if ($this->admin->write_list_student_registration($nm)){
                 echo json_encode($nm);
            }
            else echo 'error';

            return;
        }
        /**/
        $this->load->view('admin/header', $header);
        $this->load->view('admin/student_setting', $data);
        $this->load->view('admin/footer');
    }


    //
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




    /** БД --------------------------- **/
    // створює відповідні талиці бази даних
    public function create_database(){
        //$this->load->model('CreateDatabase_model', 'CreateBase');
        //$this->CreateBase->create_database_table();
    }

} // END Class
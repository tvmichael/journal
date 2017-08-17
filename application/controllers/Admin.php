<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 16.08.2017
 * Time: 13:42
 */

class Admin extends CI_Controller
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        //if ( !isset($_SESSION['open']) ) redirect(base_url());
        //
        $this->load->model('Admin_model', 'admin');
        //
        $this->load->library('kint/Kint');
    }

    // головна сторніка редагування журналу викладачем
    public function index()
    {
        ///$header = ['navbar_text'=>'Електронний журнал', 'navbar_menu'=>'journal'];
        // зчитуємо список доступних груп
        //$header['navbar_list'] = $this->teacher->read_list_gs();
        //$this->load->view('teacher/header', $header);
        //$this->load->view('teacher/teacher');
        //$this->load->view('teacher/footer');

    }


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





}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    // constructor
    public function __construct()
    {
        parent::__construct();
        // завантажуємо хелпер для виведення форми
        $this->load->helper('form');
        // завантажуємо бібліотеку для перевірки правильності введених даних на формі "входу"
        $this->load->library('form_validation');
    }

    // Сторінка авторизації
    public function index()  // inaccessible()
    {
        if ( isset($_POST['submit']) ) {
            // перевіряємо форму на правильність введених даних
            $this->form_validation->set_rules('login', '(Логін)', 'required|min_length[3]|max_length[16]');
            $this->form_validation->set_rules('password', '(Пароль)', 'required|min_length[3]|max_length[16]');
            $this->form_validation->set_rules('hidden-field', 'Hidden-Field', 'required|in_list[journal-login]');

            if ($this->form_validation->run() == TRUE) {
                // якщо данні введено правильно то перевіряємо користувача в БД
                $this->load->model('login_model');
                $result = $this->login_model->validation($this->input->post('login'), $this->input->post('password'));
                // якщо логін і пароль знайдено то завантажуєм відповідну сторінку користувача
                if ($result == TRUE) {
                    redirect('/' . strtolower($_SESSION['role']));
                }
            }
        }
        // якщо користувач не авторизований то віддкриваємо форму для "входу"
        $this->load->view('login/login');
    }

    // якщо необхідно закрити доступ на деякий час (пейменовуємо функції:  index <> inaccessible)
    // також міняємо посилання у формі в файлі ../views/login/login.php з login на login/inaccessible
    public function inaccessible() // index()
    {
        $this->load->view('login/inaccessible');
    }

    // вихід
    public function logout(){
        $this->load->model('login_model');
        $this->login_model->logout();
    }

} // end Login class.
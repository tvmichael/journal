<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model
{
    // Список груп в яких читаються відповідні придмети
    public function read_list_group_teacher(){
        //All filed:  id_teacher, id_group, id_subject, id, shortname, fullname, course, groupe, subgroup
        $this->db->select('id_teacher, id_group, id_subject, shortname, fullname, course, groupe, subgroup');
        $this->db->from('list_group_teachers');
        $this->db->join('subjects', 'list_group_teachers.id_subject = subjects.id');
        $this->db->join('groups', 'list_group_teachers.id_group = groups.id');
        $this->db->where('list_group_teachers.id_teacher',$_SESSION['id'] );
        $this->db->order_by('course');
        $this->db->order_by('groupe');
        $query = $this->db->get();
        return $query->result_array();
    } // end read_list_gs


    // завантажуємо журнал викладача по предмету і групі з бази даних
    public function load_journal(){
        $data = [];
        $data['error'] = 1;
        $data['id_teacher'] = intval($this->input->get('teacher'));
        $data['id_group'] = intval($this->input->get('group'));
        $data['id_subject'] = intval($this->input->get('subject'));
        // перевіряємо чи отримані значення є правильними (чи даний вчитель читає в даних групах і має відповідні предмети)
        if ($data['id_teacher'] != $_SESSION['id'] OR
            !in_array($data['id_group'], $_SESSION['list_group']) OR
            !in_array($data['id_subject'], $_SESSION['list_subject']))
        {
            $data['error'] = 2;
            return $data;
        }
        else{
            // 1. отримати список студентів відповідної групи і відсортувати їх за прізвищем
            // All fields: id_student, id_group, id, name, surname, patronymic
            /*
            $this->db->select('id_student, id_group, name, surname, patronymic');
            $this->db->from('list_group_students');
            $this->db->where('list_group_students.id_group', $data['id_group']);
            $this->db->join('students', 'list_group_students.id_student = students.id');
            $this->db->order_by('surname');
            $query = $this->db->get();
            */
            $query = $this->db->query("SELECT id_student, id_group, name, surname FROM list_group_students JOIN students ON list_group_students.id_student = students.id WHERE list_group_students.id_group =". $data['id_group']." ORDER BY surname COLLATE utf8_unicode_ci");
            $data['students'] = $query->result_array(); //список студентів

            // 2. отримати журнал викладача, вибираємо при умові = викладач-група-предмет, знахдимо усі дати і сортуємо по даті
            $array = array('id_teacher =' => $data['id_teacher'],
                'id_group =' => $data['id_group'],
                'id_subject =' => $data['id_subject'] );
            $this->db->select('*');
            $this->db->order_by('date');
            $query = $this->db->get_where('journals', $array);
            $data['journal'] = $query->result_array();  // журнал з оцінками

            // 3. назва (курсу групи підгрупи), для відображення в заголовку зверху над таблицею
            $this->db->select('course, groupe, subgroup');
            $this->db->from('groups');
            $query = $this->db->where('id', $data['id_group']);
            $query = $this->db->get();
            $data['groupe'] = $query->row_array(); // повертає один запис

            // 4. назва предмету для відображення в заголовку зверху над таблицею
            $this->db->select('shortname, fullname');
            $this->db->from('subjects');
            $query = $this->db->where('id', $data['id_subject']);
            $query = $this->db->get();
            $data['subject'] = $query->row_array(); // повертає один запис

            // 5. список типів занять
            $this->db->select('*');
            $this->db->from('lesson_types');
            $query = $this->db->get();
            $data['lesson_type'] = $query->result_array();

            $data['error'] = 0;
            // повертаємо масив
            return $data;
        }
    }

    // додати новий стовпець до таблиці (для конктретного викладач-предмет-група)
    public function saveNewTableColumn(){
        $data = [];
        $data['id_teacher'] = intval($this->input->get('teacher'));
        $data['id_subject'] = intval($this->input->get('subject'));
        $data['id_group'] = intval($this->input->get('group'));
        $data['id_student'] = -1;
        $data['id_lesson_type'] = intval($this->input->get('type'));
        $data['lesson_number'] = intval($this->input->get('number'));
        $data['mark'] = '';
        $data['remark'] = '';
        $data['date'] = date("Y-m-d", strtotime($this->input->get('date')));

        // список студентів відповідної групи і відсортувати їх за прізвищем
        // All fields: id_student, id_group, id, name, surname, patronymic
        /*
        $this->db->select('id_student');
        $this->db->from('list_group_students');
        $this->db->where('list_group_students.id_group', $data['id_group']);
        $this->db->join('students', 'list_group_students.id_student = students.id');
        $this->db->order_by('surname');
        $query = $this->db->get();
        $students = $query->result_array();
        */
        // SELECT DISTINCT id_student FROM list_group_students WHERE id_group=...;
        //$this->db->distinct('id_student');
        $this->db->select('id_student');
        $this->db->from('list_group_students');
        $this->db->where('list_group_students.id_group', $data['id_group']);
        $query = $this->db->get();
        $students = $query->result_array();

        // додати записи в БД по кожному студенту
        foreach ($students as $v){
            $data['id_student'] = $v['id_student'];
            $this->db->insert('journals', $data);
        }
        // повертає кількість створених записів
        return $query->num_rows();
    }

    // додаємо оцінку для конкретного студента
    public function add_new_mark(){
        $data = [];
        $data['id_teacher'] = intval($this->input->get('teacher'));
        $data['id_subject'] = intval($this->input->get('subject'));
        $data['id_group'] = intval($this->input->get('group'));
        $data['id_student'] = intval($this->input->get('student'));
        $data['id_lesson_type'] = intval($this->input->get('type'));
        $data['lesson_number'] = intval($this->input->get('number'));
        $data['date'] = date("Y-m-d", strtotime($this->input->get('date')));

        // знаходимо попередню оцінку студента
        $this->db->select('mark, remark');
        $query = $this->db->get_where('journals', $data);
        // якщо оцінка існує то змінюємо її
        if($query->num_rows() == 1 ) {
            $row = $query->row_array();
            //перевіряємо чи правильна оцінка
            $array = Array('1', '2', '3',  '4', '5', '6', '7', '8', '9', '10', '11', '12', 'н', '');
            if( in_array($this->input->get('mark'), $array) ){
                $mark = $this->input->get('mark');
            }
            else {
                $mark = $row['mark'];
            }

            //якщо оцінка стерта
            if($mark == '' and $row['remark'] != '')
                $remark = 'X|'.date('Y-m-d').' '.$row['remark'];
            else
                $remark = $mark.'|'.date('Y-m-d').' '.$row['remark'];

            $this->db->where($data);
            $this->db->update('journals', Array('mark'=>$mark, 'remark'=>$remark));
        }
        //
        return $query->num_rows();
    }

    // оновлюємо інформацію по користувачу
    public function updateUserInfo(){
        // оновлюємо масив сесії для відображення актуальних даних
        function rewrite_session($s, $n, $p, $e){
            $_SESSION['surname'] = $s;
            $_SESSION['name'] = $n;
            $_SESSION['patronymic'] = $p;
            $_SESSION['email'] = $e;
        }
        $data = [];
        $data['surname'] = $this->input->post('surname');
        $data['name'] = $this->input->post('name');
        $data['patronymic'] = $this->input->post('patronymic');
        $data['email'] = $this->input->post('email');
        $password  = sha1($this->input->post('password'));
        $password1 = sha1($this->input->post('password1'));
        $password2 = sha1($this->input->post('password2'));

        if($_SESSION['id'] == $this->input->post('id')) {
            // якщо пароль не введено то змінюємо тільки пасивні поля
            if ($this->input->post('password') == '') {
                $this->db->where('id', $_SESSION['id']);
                $this->db->update('users', $data);

                rewrite_session($data['surname'], $data['name'], $data['patronymic'], $data['email']);
                $s = 'Інформація оновлена.';
                return $s;
            } else {
                $query = $this->db->get_where('users', array('id' => $_SESSION['id']));
                $row = $query->row_array();
                if (($row['password'] == $password) and
                    ($password1 == $password2) and
                    ($_SESSION['id'] == $this->input->post('userId'))) {
                    $data['password'] = sha1($this->input->post('password1'));
                    $this->db->where('id', $_SESSION['id']);
                    $this->db->update('users', $data);

                    rewrite_session($data['surname'], $data['name'], $data['patronymic'], $data['email']);
                    $s = 'Інформація оновлена. Пароль змінено!';
                    return $s;
                }
            }
        }
        $s = 'Помилка. Інформація не збережена.';
        return $s;
    }

    //зберігаємо повідомлення від викладача
    public function save_teacher_message(){
        $mas = [];
        $mas['id_user'] = $_SESSION['id'];
        $mas['date'] = $this->input->get('date');
        $mas['message'] = $this->input->get('message');
        $mas['direction'] = 1; // 1 - від користувача
        $this->db->insert('messages', $mas);
        $r = $this->db->affected_rows();
        return $r;
    }

    // отримати усі повідомлення викладача
    public function get_all_teacher_message(){
        $this->db->select('*');
        $this->db->where('id_user', $_SESSION['id']);
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('messages');
        return $query->result_array();
    }

    // зберігаємо налаштування користувача
    public function user_settings($settings){
        // замінити
        $settings = "{'view':'".$settings."'}";
        $_SESSION['settings'] = $settings;
        $this->db->where('id', $_SESSION['id']);
        $this->db->update('users', ['settings'=>$settings]);
    }


} // end Teacher_model
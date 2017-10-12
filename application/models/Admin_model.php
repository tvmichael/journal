<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    /** для роботи з викладачами --------------------------------------------------------------- */
    // список усіх викладачів
    public function load_list_teacher(){
        $q = "SELECT *, ( SELECT COUNT(list_group_teachers.id_teacher) FROM list_group_teachers WHERE list_group_teachers.id_teacher = users.id ) AS count FROM users WHERE users.role = 'Teacher' ORDER BY users.surname;";
        $query = $this->db->query($q);
        /*
        $this->db->order_by('surname', 'ASC');
        $query = $this->db->get_where('users', array('role'=>'Teacher'));
        /**/
        return  $query->result_array();
    }

    // показуємо робочу нагрузку викладача
    public function teacherWorkingLoad(){
        $this->db->select('*');
        $this->db->from('list_group_teachers');
        $this->db->where('id_teacher', intval($this->input->get('teacherId')));
        $this->db->join('subjects', 'subjects.id = list_group_teachers.id_subject');
        $this->db->join('groups', 'groups.id = list_group_teachers.id_group');
        $query = $this->db->get();

        return $query->result_array();
    }

    // заносимо нову нагрузку для вчителя
    public function teacherWorkingWrite(){
        $data['id_teacher'] = intval($this->input->get('teacherId'));
        $data['id_group'] = intval($this->input->get('groupId'));
        $data['id_subject'] = intval($this->input->get('subjectId'));

        $this->db->select('*');
        $this->db->from('list_group_teachers');
        $this->db->where($data);
        $query = $this->db->get();

        if ($query->num_rows() == 0){
            $this->db->insert('list_group_teachers', $data);
            return TRUE;
        }
        return FALSE;
    }

    // видалити нагрузку викладача
    public function removeTeacherLoad(){
        $data['id_teacher'] = intval($this->input->get('teacherId'));
        $data['id_group'] = intval($this->input->get('groupId'));
        $data['id_subject'] = intval($this->input->get('subjectId'));

        $this->db->delete('list_group_teachers', $data);
    }


    public function add_new_teacher(){
        $error = '';
        $data = [];
        $data['login'] = $this->input->post('login');
        $query = $this->db->get_where('users', $data);
        if($query->num_rows() == 0){
            $data['surname'] = $this->input->post('surname');
            $data['password'] = sha1($this->input->post('password1'));
            $data['role'] = 'Teacher';
            $data['settings'] = "{'view':'1'}";
            $this->db->insert('users', $data);
            $error = 'Викладача додано! ['.$data['surname'].']';
        }
        else $error = 'Такий логін ['.$data['login'].'] вже існує. Введіть новий';

        return $error;
    }


    /** дял роботи з предметами ---------------------------------------------------------------- */
    // список усіх предметів
    public function load_list_subject(){
        $this->db->order_by('fullname', 'ASC');
        $query = $this->db->get('subjects');
        return  $query->result_array();
    }



    /** дял роботи зі студентами --------------------------------------------------------------- */
    // список усіх студентів
    public function load_list_student(){
        $query = $this->db->get('students');
        return  $query->result_array();
    }

    // список студентів коннкретної групи
    public function readStudentAndGroup($id_group){
        /*
        SELECT *
        FROM students
        INNER JOIN list_group_students
        ON students.id=list_group_students.id_student
        INNER JOIN groups
        ON groups.id = list_group_students.id_group
        ORDER BY students.id
        */
        $this->db->select('id_student, surname, name, patronymic, id_group, course, groupe, subgroup');
        $this->db->from('students');
        $this->db->join('list_group_students', 'students.id = list_group_students.id_student');
        $this->db->join('groups', 'groups.id = list_group_students.id_group');
        if ($id_group != 0)
            $this->db->where('groups.id', $id_group);
        $this->db->order_by('students.id', 'ASC');
        $query = $this->db->get();

        return  $query->result_array();
    }

    // додаємо нових студентів до бази
    public function insert_new_students($data){
        foreach ($data as $value) {
            // заносибо студента в БД
            $sql = ['name'=>$value['name'], 'surname'=>$value['surname'], 'patronymic'=>$value['patronymic']];
            $this->db->insert('students', $sql);

            // ID номер студента
            $id = $this->db->insert_id();
            // заносимо групи до яких належить студентн
            foreach ($value['group'] as $g){
                $sql = ['id_student' =>$id, 'id_group'=>$g];
                $this->db->insert('list_group_students', $sql);
            }
        }
        // тимчасово, просто виводимо масив (треба зробити більш якісну перевірку)
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    // завантажуємо інформацію по студентові + ( групи - підгрупи в яких він є )
    public function load_student(){
        $id = intval($this->input->get('editStudentId'));
        /*  SELECT surname, name, patronymic, id_student, id_group, course, groupe, subgroup FROM students
            INNER JOIN list_group_students
            ON list_group_students.id_student = students.id
            INNER JOIN groups
            ON groups.id = list_group_students.id_group
            WHERE students.id = '....';
        */
        $this->db->select('surname, name, patronymic, id_student, id_group, course, groupe, subgroup');
        $this->db->join('list_group_students', 'list_group_students.id_student = students.id');
        $this->db->join('groups', 'groups.id = list_group_students.id_group');
        $this->db->from('students');
        $this->db->where('students.id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    // додаємо нову групу(підгрупу) до якої належить студент (або переносимо студента в нову групу)
    public function edit_student_add_group(){
        $time_start = microtime(true);

        $id_student = intval($this->input->get('id_student'));
        $id_group = intval($this->input->get('id_group'));
        $res = [];

        $this->db->select('*');
        $this->db->from('list_group_students');
        $this->db->where('id_student', $id_student);
        $this->db->where('id_group', $id_group);
        $query = $this->db->get();
        // якщо студент ЩЕ НЕ належить до даної групи то робимо звязок
        if($query->num_rows() == 0 ) {
            // якщо студент переноситься в існуючу групу то
            // перевіряємо чи існують проведені заняття в цій групі і додаємо аналогчні до студента

            /*
            #  >> 97 номер групи маємо на вході
            SELECT DISTINCT id_teacher FROM journals WHERE id_group = 97;
            # --> список вчителів
            SELECT DISTINCT id_subject FROM journals WHERE id_group = 97 AND id_teacher = 68;
            # --> список предметів для -> конкретного вчителя
            SELECT DISTINCT id_lesson_type FROM journals WHERE id_group = 97 AND id_teacher = 68 AND id_subject=51;
            # --> список типів уроків для -> конкретного вчителя по -> конкретному предмету
            SELECT DISTINCT lesson_number FROM journals WHERE id_group = 97 AND id_teacher = 68 AND id_subject=51 AND id_lesson_type=1;
            #
            SELECT DISTINCT date FROM journals WHERE id_group = 97 AND id_teacher = 68 AND id_subject=51 AND id_lesson_type=1 AND lesson_number=1;
            #
            SELECT * FROM journals WHERE id_group = 97 AND id_teacher = 68 AND id_subject=51 AND id_lesson_type=1 AND lesson_number=1 AND date='2017-09-11' LIMIT 1;
            # ==> заносимо інформацію для цього студента в новій групі
            */

            // - група
            $sql ="SELECT DISTINCT id_teacher FROM journals WHERE id_group=$id_group";
            $query = $this->db->query($sql);
            $list_teacher = $query->result_array();

            // - група - вчитель
            foreach ($list_teacher as $teacher){
                $sql ="SELECT DISTINCT id_subject FROM journals WHERE id_group=".$id_group." AND id_teacher=".$teacher['id_teacher'];
                $query = $this->db->query($sql);
                $list_subject = $query->result_array();

                // - група - вчитель - предмети
                foreach ($list_subject as $subject){
                    $sql ="SELECT DISTINCT id_lesson_type FROM journals WHERE id_group=".$id_group." AND id_teacher=".$teacher['id_teacher']." AND id_subject=".$subject['id_subject'];
                    $query = $this->db->query($sql);
                    $list_type = $query->result_array();

                    // - група - вчитель - предмети - типи уроків
                    foreach ($list_type as $type){
                        $sql ="SELECT DISTINCT lesson_number FROM journals WHERE id_group=".$id_group." AND id_teacher=".$teacher['id_teacher']." AND id_subject=".$subject['id_subject']." AND id_lesson_type=".$type['id_lesson_type'];
                        $query = $this->db->query($sql);
                        $list_number = $query->result_array();

                        // - група - вчитель - предмети - типи уроків - номер уроку
                        foreach ($list_number as $number){
                            $sql ="SELECT DISTINCT date FROM journals WHERE id_group=".$id_group." AND id_teacher=".$teacher['id_teacher']." AND id_subject=".$subject['id_subject']." AND id_lesson_type=".$type['id_lesson_type']." AND lesson_number=".$number['lesson_number'];
                            $query = $this->db->query($sql);
                            $list_date = $query->result_array();

                            //d($list_date);

                            //  - група - вчитель - предмети - типи уроків - номер уроку - дата
                            foreach ($list_date as $date){
                                $sql ="SELECT * FROM journals WHERE id_group=".$id_group." AND id_teacher=".$teacher['id_teacher']." AND id_subject=".$subject['id_subject']." AND id_lesson_type=".$type['id_lesson_type']." AND lesson_number=".$number['lesson_number']." AND date='".$date['date']."' LIMIT 1";
                                $query = $this->db->query($sql);
                                $list = $query->result_array();

                                // ЗАНОСИМО нові клітинки для студента в данії  групі - вчителя - предмету - дата + (номер пари і тип пари)
                                //id_group id_teacher id_subject id_lesson_type lesson_number date;
                                $this->db->insert('journals', [ 'id_teacher'=>$teacher['id_teacher'],
                                                                'id_subject'=>$subject['id_subject'],
                                                                'id_group'=>$id_group,
                                                                'id_student'=>$id_student,
                                                                'id_lesson_type'=>$type['id_lesson_type'],
                                                                'lesson_number'=>$number['lesson_number'],
                                                                'mark'=>'',
                                                                'remark'=>'',
                                                                'date'=>$date['date'] ]);
                                //d($list);
                            }
                        }
                    }
                }
            }
            // також додаємо студунта до списку груп
            $this->db->insert('list_group_students', ['id_student'=>$id_student, 'id_group'=>$id_group]);
            $res[0] = '0';
        } else $res[0] =  '1';

        $time_end = microtime(true) - $time_start;
        $res[1] = 'Time: '.round($time_end,4).'c.';

        // ...
        return $res;
    }

    // видаляємо записи належності студента до групи
    public function edit_student_delete_group(){
        $id_student = intval($this->input->get('id_student'));
        $id_group = intval($this->input->get('id_group'));

        // видаляємо записи студента з list_group_students
        $this->db->where('id_student', $id_student);
        $this->db->where('id_group', $id_group);
        $this->db->delete('list_group_students');

        //видаляємо усі дані студента з ЖУРНАЛУ групи в якій він був
        $this->db->where('id_student', $id_student);
        $this->db->where('id_group', $id_group);
        $this->db->delete('journals');

        // ...
        return '0';
    }

    // додаємо нових студентів до бази з ексель файла
    public function insert_new_students_excel($data){
        foreach ($data as &$value) {
            $sql = ['name'=>$value['name'], 'surname'=>$value['surname'], 'patronymic'=>$value['patronymic']];

            // перевіряємо чи є студент в БД
            $this->db->select('id');
            $query = $this->db->get_where('students', $sql);
            // якщо студента немає то додаємо
            if ($query->num_rows() == 0 ) {
                $this->db->insert('students', $sql);
                // відмічаємо що студента додано до БД   // $data[ $value]['insert'] = 1; https://stackoverflow.com/questions/15472033/how-to-update-specific-keys-value-in-an-associative-array-in-php?answertab=active#tab-top
                $value['insert'] = 1;

                $id = $this->db->insert_id();
                if ($value['b'] != 0) {
                    $sql = ['id_student' => $id, 'id_group' => $value['b']];
                    $this->db->insert('list_group_students', $sql);
                }
                if ($value['c'] != 0) {
                    $sql = ['id_student' => $id, 'id_group' => $value['c']];
                    $this->db->insert('list_group_students', $sql);
                }
                if ($value['d'] != 0) {
                    $sql = ['id_student' => $id, 'id_group' => $value['d']];
                    $this->db->insert('list_group_students', $sql);
                }
                if ($value['e'] != 0) {
                    $sql = ['id_student' => $id, 'id_group' => $value['e']];
                    $this->db->insert('list_group_students', $sql);
                }
            }
        }
        return $data;
    }


    // отримати список облікових записів студентів
    public function list_student_registration(){
        $sql ="
            SELECT students.id, students.name, students.surname, students.patronymic, groups.course, groups.groupe, groups.id as group_id
            FROM students
              JOIN list_group_students ON list_group_students.id_student=students.id
              JOIN groups ON groups.id = list_group_students.id_group
            WHERE groups.subgroup = 'Група'
            ORDER BY groups.course, groups.groupe;
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /** дял роботи з групами ------------------------------------------------------------------- */
    // список усіх груп
    public function load_list_group(){
        $this->db->order_by('course');
        $this->db->order_by('groupe');
        $this->db->order_by('subgroup', 'DESC');
        $query = $this->db->get('groups');
        return  $query->result_array();
    }























    /* =============================================================================================== */

    // додаємо нових вчителів до бази з ексель файла
    public function insert_new_teachers($data){
        foreach ($data as $value) {
            d($value);
            //$this->db->insert('users', $value);
        }
    }
    // додаємо нові групи до бази з ексель файла
    public function insert_new_groups($data){
        foreach ($data as $value) {
            d($value);
            //$this->db->insert('groups', $value);
        }
    }


    // додаємо нових предмет до бази з ексель файла
    public function insert_new_subjects($data){
        foreach ($data as $value) {
            d($value);
            //$this->db->insert('subjects', $value);
        }
    }

    //
    public function table_student_dependence(){
        $query = $this->db->get('students');
        $student = $query->result_array();

        $data = [];
        foreach ($student as $s){
            //$data[$s['id']] =

            $this->db->select('list_group_students');
            $this->db->join('groups', 'groups.id = list_group_students.id_group');
            $this->db->where('list_group_students.id_student', $s['id']);
            $query = $this->db->get();
            $list_g = $query->result_array();
        }

    }


} // end class
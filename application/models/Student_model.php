<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model  extends CI_Model
{

    // журнал студента
    public function load_student_journal($id){
        //$id = $_SESSION['id'];
        //
        //$id = 141;

        $q = "
        SELECT id_teacher, id_subject, id_group, id_lesson_type, lesson_number, mark, remark, date, fullname, name,surname, lesson_type 
        FROM journals
          JOIN subjects ON subjects.id = id_subject
          JOIN lesson_types ON lesson_types.id = id_lesson_type
          JOIN users ON users.id = id_teacher
        WHERE id_student=$id;
        ";
        $query = $this->db->query($q);

        return  $query->result_array();
    }

    public function get_group_statistic($id_student){
        $data = array();

        $this->db->select('*');
        $this->db->from('list_group_students');
        $this->db->where('id_student', $id_student);
        $query = $this->db->get();
        //$data['students'] = $query->result_array();

        foreach ($query->result_array() as $value){
            $id = $value['id_group'];

            $this->db->select('id, name, surname');
            $this->db->from('students');
            $this->db->join('list_group_students', 'list_group_students.id_student = students.id');
            $this->db->where('list_group_students.id_group', $id);
            $query = $this->db->get();
            $students = $query->result_array();

            $this->db->select('*');
            $this->db->from('journals');
            $this->db->where('id_group', $id);
            $query = $this->db->get();
            $journals = $query->result_array();

            $data['data_journal'][] = array($id, $students, $journals);

        }
        /*
        $this->db->select('id, name, surname');
        $this->db->from('students');
        $this->db->join('list_group_students', 'list_group_students.id_student = students.id');
        $this->db->where('list_group_students.id_group', $id);
        $query = $this->db->get();
        $data['students'] = $query->result_array();

        $this->db->select('*');
        $this->db->from('journals');
        $this->db->where('id_group', $id);
        $query = $this->db->get();
        $data['journals'] = $query->result_array();
        /**/
        return $data;
    }




}
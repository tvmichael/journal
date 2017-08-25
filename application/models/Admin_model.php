<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    /** для роботи з викладачами --------------------------------------------------------------- */
    // список усіх викладачів
    public function load_list_teacher(){
        $this->db->order_by('surname', 'ASC');
        $query = $this->db->get_where('users', array('role'=>'Teacher'));
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



    /** дял роботи з предметами ---------------------------------------------------------------- */
    // список усіх предметів
    public function load_list_subject(){
        $this->db->order_by('fullname', 'ASC');
        $query = $this->db->get('subjects');
        return  $query->result_array();
    }



    /** дял роботи з студентами ---------------------------------------------------------------- */
    // список усіх студентів
    public function load_list_student(){
        $query = $this->db->get('students');
        return  $query->result_array();
    }

    // список студентів коннкретної групи
    public function readGroupIdStudent(){
        $data['id_group'] = intval($this->input->get('groupId'));
        $this->db->select('*');
        $this->db->from('list_group_students');
        $this->db->where($data);
        $this->db->join('students', 'students.id = list_group_students.id_student');
        $query = $this->db->get();

        return  $query->result_array();
    }



    /** дял роботи з групами ------------------------------------------------------------------- */
    // список усіх груп
    public function load_list_group(){
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
    // додаємо нових студентів до бази з ексель файла
    public function insert_new_students($data){
        foreach ($data as $value) {
            $sql = ['name'=>$value['name'], 'surname'=>$value['surname'], 'patronymic'=>$value['patronymic']];
            $this->db->insert('students', $sql);

            $id = $this->db->insert_id();
            if ($value['b'] != 0) {
                $sql = ['id_student' =>$id, 'id_group'=>$value['b']];
                $this->db->insert('list_group_students', $sql);
            }
            if ($value['c'] != 0) {
                $sql = ['id_student' =>$id, 'id_group'=>$value['c']];
                $this->db->insert('list_group_students', $sql);
            }
            if ($value['d'] != 0) {
                $sql = ['id_student' =>$id, 'id_group'=>$value['d']];
                $this->db->insert('list_group_students', $sql);
            }
            if ($value['e'] != 0) {
                $sql = ['id_student' =>$id, 'id_group'=>$value['e']];
                $this->db->insert('list_group_students', $sql);
            }
        }
        d($data);
    }
    // додаємо нових предмет до бази з ексель файла
    public function insert_new_subjects($data){
        foreach ($data as $value) {
            d($value);
            //$this->db->insert('subjects', $value);
        }
    }


} // end class
<?php

class Admin_model extends CI_Model
{


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
            d($value);
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
    } // end insert_new_students


    // додаємо нових студентів до бази з ексель файла
    public function insert_new_subjects($data){
        foreach ($data as $value) {
            d($value);
            //$this->db->insert('subjects', $value);
        }
    } // end insert_new_subjects




}
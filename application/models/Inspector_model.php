<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector_model extends CI_Model
{

    // Загальна статистика (Головнасторінка)
    public function base_teacher_statistics(){
        $data = [];
        // Кількість викладачів
        $sql = "SELECT id, name, surname, patronymic,
              (
                  SELECT count(DISTINCT id_subject) FROM list_group_teachers
                  WHERE id_teacher = id
              ) AS count_subject,
              (
                  SELECT count(DISTINCT id_group) FROM list_group_teachers
                  WHERE id_teacher = id
              ) AS count_group,
              (
                  SELECT count(id_user) FROM logs
                  WHERE id_user = id
              ) AS count_visit
              FROM users WHERE role = 'Teacher'
              ORDER BY surname COLLATE utf8_unicode_ci;";
        $query = $this->db->query($sql);
        $data['list_teacher'] = $query->result_array();




        // Кількість студентів
        $this->db->from('students');
        $data['count_students'] = $this->db->count_all_results();



        return  $data;
    }


}
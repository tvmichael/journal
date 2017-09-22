<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector_model extends CI_Model
{

    // Загальна статистика (Головнасторінка)
    public function base_statistics(){
        $data = [];
        // Кількість викладачів
        $this->db->select('id, name, surname, patronymic');
        $this->db->from('users');
        $this->db->where('role', 'Teacher');
        //$data['count_teacher'] = $this->db->;

        // Кількість студентів
        $this->db->from('students');
        $data['count_students'] = $this->db->count_all_results();



        return  $data;
    }


}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector_model extends CI_Model
{

    // Загальна статистика (Головнасторінка)
    public function base_statistics(){
        // вчителів

        $q = "SELECT *, ( SELECT COUNT(list_group_teachers.id_teacher) FROM list_group_teachers WHERE list_group_teachers.id_teacher = users.id ) AS count FROM users WHERE users.role = 'Teacher' ORDER BY users.surname;";
        $query = $this->db->query($q);
        /*
        $this->db->order_by('surname', 'ASC');
        $query = $this->db->get_where('users', array('role'=>'Teacher'));
        /**/
        return  $query->result_array();
    }


}
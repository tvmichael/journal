<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model  extends CI_Model
{

    // журнал студента
    public function load_student_journal(){
        $id = $_SESSION['id'];
        //
        $id = 141;

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






}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inspector_model extends CI_Model
{

    // Загальна статистика по викладачах
    public function teacher_statistics_all(){
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

        return  $data;
    }

    // Статистика по викладачу
    public function teacher_statistics(){
        $id = intval($this->input->get('id'));
        $data = array();

        // Викладач - прізвище, імя ... конкретного викладача
        $this->db->select('name, surname, patronymic');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $data['teacher'] = $query->row_array();

        // список груп і предметів в яких читає пари викладач
        //All filed:  id_teacher, id_group, id_subject, id, fullname, course, groupe, subgroup
        /*
        $this->db->select('id_teacher, id_group, id_subject, fullname, course, groupe, subgroup');
        $this->db->from('list_group_teachers');
        $this->db->join('subjects', 'list_group_teachers.id_subject = subjects.id');
        $this->db->join('groups', 'list_group_teachers.id_group = groups.id');
        $this->db->where('list_group_teachers.id_teacher', $id);
        $this->db->order_by('course');
        $this->db->order_by('groupe');
        $query = $this->db->get();
        /**/
        $query = $this->db->query("
                SELECT id_teacher, id_group, id_subject, fullname, course, groupe, subgroup,
                  ( 
                    SELECT count(DISTINCT journals.date)
                    FROM journals
                    WHERE journals.id_teacher = $id AND journals.id_group = list_group_teachers.id_group AND journals.id_subject = list_group_teachers.id_subject
                  ) 
                  AS date_count
                FROM list_group_teachers
                  JOIN subjects ON subjects.id = list_group_teachers.id_subject
                  JOIN groups ON groups.id = list_group_teachers.id_group
                WHERE id_teacher = $id
                ORDER BY groups.course, groups.groupe;
                ");
        $data['teacher_list'] = $query->result_array();

        return $data;
    }

    // журнал викладача
    public function teacher_statistics_journal(){
        $data = array();
        $data['id_teacher'] = intval($this->input->get('idTeacher'));
        $data['id_group'] = intval($this->input->get('idGroup'));
        $data['id_subject'] = intval($this->input->get('idSubject'));
        $data['name_t'] = $this->input->get('nameT');
        $data['name_gs'] = $this->input->get('nameGS');

        // 1. отримати список студентів відповідної групи і відсортувати їх за прізвищем
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

        /*
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
        /**/

        // повертаємо масив
        return $data;
    }


    // Загальна статистика (Студенти)
    public function base_students_statistics(){
        $data = [];
        // Кількість студентів
        $this->db->from('students');
        $data['count_students'] = $this->db->count_all_results();

        return  $data;
    }




} // END CLASS
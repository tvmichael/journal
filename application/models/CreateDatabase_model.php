<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CreateDatabase_model extends CI_Model
{

    // створюємо відповідні таблиці в базі даних - sql
    public function create_database_table()
    {
        echo "<b>Start create table SQL</b><br><br>";

        /** DiNAMiK TABLE =========================================== */
        // JOURNAL
        $sql = "CREATE TABLE journals
              (
              id_teacher int,
              id_subject int,
              id_group int,              
              id_student int,
              id_lesson_type tinyint,
              lesson_number tinyint,              
              mark char(2),
              remark char(255),
              date date
              ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: journal <br>";

        // LOG USERS
        $sql = "CREATE TABLE logs
            (
            id_user int,
            datetime datetime
            ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: log <br>";


        /** STATIC TABLE ============================================= */
        // USERS
        $sql = "CREATE TABLE users
              (
              id int NOT NULL AUTO_INCREMENT,
              login char(16),
              password char(100),        
              name char(25),
              surname char(25),
              patronymic char(25),       
              email char(100),
              remember_token char(100),
              role char(10),
              PRIMARY KEY (id),
              UNIQUE (login)
              ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: users <br>";

        // STUDENT
        $sql = "CREATE TABLE students
              (
              id int NOT NULL AUTO_INCREMENT,              
              surname char(25),
              name char(25),              
              patronymic char(25),
              PRIMARY KEY (id)
              ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: student <br>";

        // GROUPS
        $sql = "CREATE TABLE groups
              (
              id int NOT NULL AUTO_INCREMENT,
              course char(10),
              groupe char(25),
              subgroup char(25),                            
              PRIMARY KEY (id)
              ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: groups <br>";

        // SUBJECT
        $sql = "CREATE TABLE subjects
              (
              id int NOT NULL AUTO_INCREMENT,
              shortname char(20),
              fullname char(100),
              PRIMARY KEY (id)
              ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: subject <br>";


        /** LIST ==================================================== */
        // LIST TEACHER - SUBJECT<>GROUPS
        $sql = "CREATE TABLE list_group_teachers
              (
              id_teacher int,
              id_group int,
              id_subject int
              ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: list_group_teachers <br>";

        // LIST STUDENTS
        $sql = "CREATE TABLE list_group_students
              (
              id_students int,
              id_group int              
              ) CHARACTER SET utf8 COLLATE utf8_general_ci";
        //$query = $this->db->query($sql); echo "CREATE TABLE: list_group_students <br>";

        echo "<br>Base SQL create!<br>";
    }
}
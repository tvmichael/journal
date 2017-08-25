<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// https://www.youtube.com/watch?v=eprwBD9RT-Q  // Include PHPExcel
// ------------------------------------------------------------------------------------------------
if ( ! function_exists('loadTeacherFile'))
{
   function loadTeacherFile(){
      $load_data = array();
      //set download directory
      $uploaddir = getcwd().'\resources\download\\';
      // очищаємо деректорію де знаходяться файли загрузки
      $files = glob($uploaddir.'*'); // get all file names
      foreach($files as $file){ // iterate files
         if(is_file($file)) // if file exists
             unlink($file); // delete file
      };
      // переміщаємо завантажений файл до деректрії загрузок
      $uploadfile = $uploaddir.basename($_FILES['excelfile']['name']);
      if (move_uploaded_file($_FILES['excelfile']['tmp_name'], $uploadfile))
      {
        $tmpfname = $uploaddir.$_FILES['excelfile']['name'];
        // зчитуємо дані з Excel файла
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname); // завантажуємо файл
        $worksheet = $excelObj->getSheet(0); // відкрити першу закладку 'excel' файла
        //$worksheet = $excelObj->getActiveSheet(); //
        $lastRow = $worksheet->getHighestRow(); // кількість рядків в таблиці

        $data = array();
        //починаємо з другого рятка таблиці, перший має бути назви полів
        for ($row = 2; $row <= $lastRow; $row++)
        {
            $data[$row] = array();
            $data[$row]['login'] = strtolower($worksheet->getCell('A'.$row)->getValue());
            $data[$row]['password'] = sha1($worksheet->getCell('B'.$row)->getValue());
            $data[$row]['name'] = $worksheet->getCell('C'.$row)->getValue();
            $data[$row]['surname'] = $worksheet->getCell('D'.$row)->getValue();
            $data[$row]['patronymic'] = $worksheet->getCell('E'.$row)->getValue();
            $data[$row]['email'] = $worksheet->getCell('F'.$row)->getValue();
            $data[$row]['remember_token'] = '';
            $data[$row]['role'] = 'Teacher';
        } // end for ---
      }
      return $data;
    } // end loadTeacherFile ---
} // end if



// ------------------------------------------------------------------------------------------------
if ( ! function_exists('loadGroupFile'))
{
    function loadGroupFile(){
        $load_data = array();
        //set download directory
        $uploaddir = getcwd().'\resources\download\\';
        // очищаємо деректорію де знаходяться файли загрузки
        $files = glob($uploaddir.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) // if file exists
                unlink($file); // delete file
        };
        // переміщаємо завантажений файл до деректрії загрузок
        $uploadfile = $uploaddir.basename($_FILES['excelfile']['name']);
        if (move_uploaded_file($_FILES['excelfile']['tmp_name'], $uploadfile))
        {
            $tmpfname = $uploaddir.$_FILES['excelfile']['name'];
            // зчитуємо дані з Excel файла
            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
            $excelObj = $excelReader->load($tmpfname); // завантажуємо файл
            $worksheet = $excelObj->getSheet(0); // відкрити першу закладку 'excel' файла
            //$worksheet = $excelObj->getActiveSheet(); //
            $lastRow = $worksheet->getHighestRow(); // кількість рядків в таблиці

            $data = array();
            //починаємо з другого рятка таблиці, перший має бути назви полів
            for ($row = 2; $row <= $lastRow; $row++)
            {
                $data[$row] = array();
                $data[$row]['course'] = $worksheet->getCell('A'.$row)->getValue();
                $data[$row]['groupe'] = $worksheet->getCell('B'.$row)->getValue();
                $data[$row]['subgroup'] = $worksheet->getCell('C'.$row)->getValue();
                $data[$row]['longname'] = $worksheet->getCell('D'.$row)->getValue();
            } // end for ---
        }
        return $data;
    } // end loadTeacherFile ---
} // end if


// ------------------------------------------------------------------------------------------------
if ( ! function_exists('loadStudentFile'))
{
    function loadStudentFile(){
        $load_data = array();
        //set download directory
        $uploaddir = getcwd().'\resources\download\\';
        /*
        // очищаємо деректорію де знаходяться файли загрузки
        $files = glob($uploaddir.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) // if file exists
                unlink($file); // delete file
        };
        /**/
        // переміщаємо завантажений файл до деректрії загрузок
        $uploadfile = $uploaddir.basename($_FILES['excelfile']['name']);
        if (move_uploaded_file($_FILES['excelfile']['tmp_name'], $uploadfile))
        {
            $tmpfname = $uploaddir.$_FILES['excelfile']['name'];
            // зчитуємо дані з Excel файла
            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
            $excelObj = $excelReader->load($tmpfname); // завантажуємо файл
            $worksheet = $excelObj->getSheet(0); // відкрити першу закладку 'excel' файла
            //$worksheet = $excelObj->getActiveSheet(); //
            $lastRow = $worksheet->getHighestRow(); // кількість рядків в таблиці

            $data = array();
            //починаємо з другого рятка таблиці, перший має бути назви полів
            for ($row = 2; $row <= $lastRow; $row++)
            {
                $data[$row] = array();
                $div_name = explode(' ', $worksheet->getCell('A'.$row)->getValue());

                $data[$row]['name'] = $div_name[1];
                $data[$row]['surname'] = $div_name[0];
                $data[$row]['patronymic'] = $div_name[2];

                $data[$row]['b'] = $worksheet->getCell('B'.$row)->getValue();
                $data[$row]['c'] = $worksheet->getCell('C'.$row)->getValue();
                $data[$row]['d'] = $worksheet->getCell('D'.$row)->getValue();
                $data[$row]['e'] = $worksheet->getCell('E'.$row)->getValue();

            } // end for ---
        }
        return $data;
        /**/
    } // end loadTeacherFile ---
} // end if


// ------------------------------------------------------------------------------------------------
if ( ! function_exists('loadSubjectFile'))
{
    function loadSubjectFile(){
        $load_data = array();
        //set download directory
        $uploaddir = getcwd().'\resources\download\\';
        // очищаємо деректорію де знаходяться файли загрузки
        $files = glob($uploaddir.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) // if file exists
                unlink($file); // delete file
        };
        // переміщаємо завантажений файл до деректрії загрузок
        $uploadfile = $uploaddir.basename($_FILES['excelfile']['name']);
        if (move_uploaded_file($_FILES['excelfile']['tmp_name'], $uploadfile))
        {
            $tmpfname = $uploaddir.$_FILES['excelfile']['name'];
            // зчитуємо дані з Excel файла
            $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
            $excelObj = $excelReader->load($tmpfname); // завантажуємо файл
            $worksheet = $excelObj->getSheet(0); // відкрити першу закладку 'excel' файла
            //$worksheet = $excelObj->getActiveSheet(); //
            $lastRow = $worksheet->getHighestRow(); // кількість рядків в таблиці

            $data = array();
            //починаємо з другого рятка таблиці, перший має бути назви полів
            for ($row = 2; $row <= $lastRow; $row++)
            {
                $data[$row] = array();
                $data[$row]['shortname'] = $worksheet->getCell('A'.$row)->getValue();
                $data[$row]['fullname'] = $worksheet->getCell('B'.$row)->getValue();

            } // end for ---
        }
        return $data;
    } // end loadTeacherFile ---
} // end if


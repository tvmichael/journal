<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------
if ( ! function_exists('teacher_working_table'))
{
    /**
     * Teacher_working_table
     *
     * Повертає таблицю навантаження викладача по предметах і групах.
     * Якщо записів немає то повертає - пустий рядок.
     *
     * @mas 	масив записів з БД
     * @return	повертає таблицю
     *
     */
    function teacher_working_table($mas)
    {
        //id_teacher, id_group, id_subject, id, shortname, fullname, course, groupe, subgroup
        echo "<thead><tr>";
        echo "<th>№</th>";
        echo "<th>Предмет</th>";
        echo "<th>Курс</th>";
        echo "<th>Група</th>";
        echo "<th>Підгрупа</th>";
        echo "<th class='text-center'>Видалити</th>";
        echo "</tr></thead><tbody>";
        $i = 1;
        foreach ($mas as $m) {
            echo '<tr>';
            echo "<td>$i</td>";
            echo '<td>'. $m['fullname'] . '</td>';
            echo '<td>'. $m['course'] . '</td>';
            echo '<td>'. $m['groupe'] . '</td>';
            echo '<td>'. $m['subgroup'] . '</td>';

            echo "<td class='text-center'>";
            echo "<a style='color: red' href='#teacher-working-load'";
            echo "data-id-teacher='", $m['id_teacher'], "' ";
            echo "data-id-subject='", $m['id_subject'], "' ";
            echo "data-id-group='", $m['id_group'], "' ";
            echo "'>";
            echo "<span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></a></td>";
            echo '</tr>';
            $i++;
        }
        echo "</tbody>";
    }
}


// ------------------------------------------------------------------------
if ( ! function_exists('student_select_option'))
{
    /**
     * Student_select_option
     *
     * Повертає  список студентів відповідної групи, формуючи список "option" для select
     *
     * @mas 	масив записів з БД
     * @return	повертає список "option"
     *
     */
    function student_select_option($mas)
    {
        // id_student, id_group, id, surname, name, patronymic
        d($mas);
        foreach ($mas as $i) {
            echo "<option value='", $i['id'], "'>";
            echo $i['surname'], ' ';
            echo $i['name'], ' ';
            echo $i['patronymic'];
            echo '</option>>';
        }
    }
}


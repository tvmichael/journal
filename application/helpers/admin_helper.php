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
     * @return	string - повертає таблицю
     *
     */
    function teacher_working_table($mas)
    {
        //id_teacher, id_group, id_subject, id, shortname, fullname, course, groupe, subgroup
        $st_table = "<thead data-delete='"."'><tr>".
        "<th>№</th>".
        "<th>Предмет</th>".
        "<th>Курс</th>".
        "<th>Група</th>".
        "<th>Підгрупа</th>".
        "<th class='text-center'>Видалити</th>".
        "</tr></thead><tbody>";
        $i = 1;
        $st_tr = '';
        foreach ($mas as $m) {
            $st_tr = $st_tr.
            '<tr>'.
            "<td>$i</td>".
            '<td>'.$m['fullname'].'</td>'.
            '<td>'.$m['course'].'</td>'.
            '<td>'.$m['groupe'].'</td>'.
            '<td>'.$m['subgroup'].'</td>'.

            "<td class='text-center'>".
            "<a style='color: red' href='javascript:void(0);'".
            "data-id-teacher='".$m['id_teacher']."' ".
            "data-id-subject='".$m['id_subject']."' ".
            "data-id-group='".$m['id_group']."' ".
            "'>".
            "<span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></a></td>".
            '</tr>';
            $i++;
        }
        $st_table = $st_table.$st_tr."</tbody>";

        return $st_table;
    }
}


// ------------------------------------------------------------------------
if ( ! function_exists('student_select_table'))
{
    /**
     * Student_select_table
     *
     * Повертає список студентів відповідної групи,
     * формуючи список "tr-td" для tbody таблиці table
     *
     * @mas 	масив записів з БД
     * @return	повертає внутрішню чатину tbody
     *
     */
    function student_select_table($mas)
    {
        if ( count($mas) == 0 ) return;
        // масив має бути відсортований по ID студента
        // id_student, surname, name, patronymic, id_group, course, groupe, subgroup

        // додаємо групу до списку, для відповіного студента
        function l_group($mas, $str){
            if ( strpos($mas['subgroup'], '1/2') ){$ns='1/2';}
            elseif ( strpos($mas['subgroup'], '1/3') ){$ns='1/3';}
            elseif ( strpos($mas['subgroup'], '1/4') ){$ns='1/4';}
            else {$ns='&nbsp;1&nbsp;';}
            return $str." <span class='label label-default'>$ns</span>";
        }

        // додаємо новий рядок таблиці
        function l_tr($mas, $str, $n){
            echo "<tr>";
            echo '<td>', $n, '</td>';
            echo '<td>', $mas['surname'], '</td>';
            echo '<td>', $mas['name'], '</td>';
            echo '<td>', $mas['patronymic'], '</td>';
            echo '<td>', $mas['course'],' ', $mas['groupe'],' ', $str, '</td>';
            echo "<td class='text-center'>", "<input type='checkbox' value='", $mas['id_student'], "'>", '</td>';
            echo "<td class='text-center'>";
                echo "<a href='", base_url('admin/student_edit'),'?editStudentId=', $mas['id_student'], "'>";
                echo "<button class='btn btn-default btn-xs' type='button'>";
                echo "<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>";
                echo "</button></a>";
            echo '</td>';
            echo "</tr>";
        };
        $n = 1;
        $list_group = '';
        $id = $mas[0]['id_student'];
        for($i = 0; $i < count($mas); $i++){

            if ( $i != (count($mas)-1) ) {
                if ($id != $mas[$i + 1]['id_student']) {
                    // якщо новий ІД то - новий рядок
                    $list_group = l_group($mas[$i], $list_group);
                    l_tr($mas[$i], $list_group, $n);

                    $id = $mas[$i + 1]['id_student'];
                    $list_group = '';
                    $n++;
                } else {
                    // додаємо групу до списку
                    $list_group = l_group($mas[$i], $list_group);
                }
            }
            else {
                // якщо останній запис
                $list_group = l_group($mas[$i], $list_group);
                l_tr($mas[$i], $list_group, $n);
            }
        }
    }
}





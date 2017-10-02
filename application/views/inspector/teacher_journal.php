<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="inspector-teacher-journal">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div>
                    <p>
                        <b><?php echo $name_t; ?>&nbsp;&nbsp;</b>
                        <span class="text-muted"><?php echo $name_gs; ?></span>
                    </p>
                </div>
                <div class="m-container-table">
                    <table class="table table-bordered table-hover">
                        <?php
                        $time_start = microtime(true);

                        // вибираємо дати
                        $journal_date = array();
                        $i = 0;
                        // id_teacher, id_subject, id_group, id_student, date, id_lesson_type, lesson_number, mark, remark
                        foreach ($journal as $j){
                            $journal_date[$i] = array();
                            $journal_date[$i]['date'] = $j['date'];
                            $journal_date[$i]['lesson_number'] = $j['lesson_number'];
                            $journal_date[$i]['id_lesson_type'] = $j['id_lesson_type'];
                            $i++;
                        };
                        $journal_date = array_unique($journal_date, SORT_REGULAR);
                        // заново індексуємо значення масиву
                        $journal_date = array_values($journal_date);
                        // сортування масиву
                        array_multisort($journal_date, SORT_ASC);

                        $thead = "<tr><th width='3%'>№</th>".
                            "<th class='m-table-name-surname'>Прізвище Ім'я</th>".
                            "<th class='text-center m-average'>ср</th>".
                            "<th class='text-center m-miss'>н</th>";
                        foreach ($journal_date as $d){
                            $str = explode('-', $d['date']);
                            $thead = $thead.
                                "<th data-ln='".$d['lesson_number']."' data-lt='".$d['id_lesson_type']."' class='text-center'>".$str[2].
                                "<br><span class='m-table-date'>".$str[1].
                                '</span></thm>';
                        }
                        $thead = $thead.'</tr>';

                        // проходимо усіх студентів що в групі
                        $tbody = '';
                        $i = 1;
                        foreach ($students as $s){
                            echo "<tr class='text-center'>".
                                 '<td>'.$i.'</td>'.
                                //  data-student-id='".$s['id_student']."'
                                 "<td class='text-left'><a href='".base_url('inspector/student?action=openStudentJournal&id=').''.$s['id_student']."'>".$s['surname'].' '.$s['name'].'</a></td>'.
                                 "<td class='m-average'></td>".
                                 "<td class='m-miss'></td>";
                            // для кожного студента заносипо відповідну дату
                            foreach ($journal_date as $d){
                                // для кожної дати створюємо клітинку і якщо є то заносимо оцінку
                                foreach ( $journal as $key => $j){
                                    if( ($j['date'] == $d['date']) AND
                                        ($j['lesson_number'] == $d['lesson_number']) AND
                                        ($j['id_lesson_type'] == $d['id_lesson_type']) AND
                                        ($j['id_student'] == $s['id_student'])){

                                        echo "<td data-ln='".$j['lesson_number'].
                                            "' data-lt='".$j['id_lesson_type'].
                                            "' data-remark='".$j['remark'].
                                            "'>".$j['mark'].'</td>';

                                        // якщо знайшли відповідний запис то стираємо його і виходимо з циклу
                                        unset($journal[$key]);
                                        break;
                                    }
                                }
                            }
                            echo '</tr>';
                            $i++;
                        }
                        ?>
                        <thead><?php echo $thead; ?></thead>
                        <tbody><?php echo $tbody; ?></tbody>
                    </table>
                </div>


                <div>
                <?php
                //d($students);
                //d($journal);
                //d($journal_date);
                //d($_SESSION);

                $time_end = microtime(true) - $time_start;
                //echo 'Time: '.round($time_end,6).'c.';
                ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main id="main-journal" class="m-main-content" data-url="<?php echo base_url('teacher/ajax_get_data')?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <p class="m-table-headline">
                    <span class="m-table-headline-c"> <?php echo $groupe['course']; ?> </span>
                    <span class="m-table-headline-g"> <?php echo $groupe['groupe']; ?> </span>
                    <span class="m-table-headline-s"> <?php echo $groupe['subgroup']; ?> </span>
                    <span class="text-info m-table-headline-p"> <?php echo $subject['fullname']; ?> </span>
                    <span id="table-headline-message" class="label label-info m-table-headline-m"></span>
                </p>

                <!-- TABLE JOURNAL -->
                <div class="m-table-container">

                    <div id="table-student-list" class="m-table-student-list">
                        <table id="table-list" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>№<br><br><br></th>
                                <th>
                                    Прізвише Ім'я<br><br>
                                    <span class="m-table-stud-num">№</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i=1;
                            foreach ($students as $s){
                                echo "<tr><td class='text-muted'>$i</td><td data-id-student='", $s['id_student'], "'>";
                                echo $s['surname'], ' ';
                                echo $s['name'], ' ';
                                echo '</td></tr>';
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="table-student-mark" class="m-table-mark-scrolling">
                        <table id="table-mark"
                               class="table table-hover table-bordered"
                            <?php echo "data-id-teacher='$id_teacher' data-id-group='$id_group' data-id-subject='$id_subject'";?> >
                            <thead>
                                <tr>
                                <?php
                                // BASE --
                                // id, lesson_type
                                // id_student, id_group, name, surname
                                // id_teacher, id_subject, id_group, id_student, id_lesson_type, lesson_number, mark, remark, date
                                // VARIABLES --
                                // $journal, $students,  $groupe, $lesson_type

                                // виводимо окремі дати в заголовок таблиці
                                // створюємо окремий масив дат і типу заняття
                                $count_date = [];
                                $i=0;
                                foreach ($journal as $v){
                                    $count_date[$i] = [];
                                    $count_date[$i]['date'] = $v['date'];
                                    $count_date[$i]['lesson_number'] = $v['lesson_number'];
                                    $count_date[$i]['lesson_type'] = $v['id_lesson_type'];
                                    $i++;
                                }

                                // виділяємо унікальні дати з масиву дат - моя функція
                                /*
                                $count_date = [];
                                $i = 0;
                                foreach ($journal as $v){
                                    if ($i == 0){
                                        $count_date[$i] = [];
                                        $count_date[$i]['date'] = $v['date'];
                                        $count_date[$i]['lesson_type'] = $v['id_lesson_type'];
                                        $count_date[$i]['lesson_number'] = $v['lesson_number'];
                                        $i++;
                                    } else {
                                        $k = 0;
                                        foreach ($count_date as $d){
                                            if  ($d['date'] == $v['date'])
                                                if ( $d['lesson_number'] == $v['lesson_number'])
                                                    if ( $d['lesson_type'] == $v['id_lesson_type']) {
                                                $k++;
                                            }
                                        }
                                        if($k == 0){
                                            $count_date[$i] = [];
                                            $count_date[$i]['date'] = $v['date'];
                                            $count_date[$i]['lesson_type'] = $v['id_lesson_type'];
                                            $count_date[$i]['lesson_number'] = $v['lesson_number'];
                                            $i++;
                                        }

                                    }
                                }
                                /**/
                                // ... або виділяємо унікальні дати з масиву дат засобами php, мабуть так краще?
                                $count_date = array_unique($count_date, SORT_REGULAR);
                                // заново індексуємо значення масиву
                                $count_date = array_values($count_date);
                                // сортування масиву
                                array_multisort($count_date, SORT_ASC);


                                // стовбці заголовка таблиці з датами
                                for ($i = 0; $i < count($count_date); $i++){
                                    echo "<th class='text-center m-table-type-", $count_date[$i]['lesson_type'], "'";
                                    echo "data-lesson-type='", $count_date[$i]['lesson_type'],
                                         "' data-date='", $count_date[$i]['date'],
                                         "' data-lesson-number='", $count_date[$i]['lesson_number'],
                                         // типи занять в масиві змішені на 1, тому що масив впочинається з 0
                                         "' title='",$lesson_type[$count_date[$i]['lesson_type']-1]['lesson_type'], "'>";
                                    $s = explode('-', $count_date[$i]['date']);
                                    echo "<span class='m-table-h-day'>", $s[2], "</span><br>";
                                    echo "<span class='m-table-h-month'>", $s[1], "</span><br>";
                                    echo "<span class='m-table-stud-count'>", $i+1, "</span>";
                                    echo "</th>";
                                }
                                ?>

                                <td class="text-right">
                                    <button id="add-new-date" type="button" class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            // виводимо журнал до таблиці
                            foreach ($students as $s){
                                echo "<tr>";
                                foreach ($count_date  as $d){
                                    foreach ($journal as $key => $j){
                                        if( $d['date'] == $j['date'] and
                                            $d['lesson_number'] == $j['lesson_number'] and
                                            $d['lesson_type'] == $j['id_lesson_type'] and
                                            $s['id_student'] == $j['id_student'] ){
                                            echo "<td ";
                                            echo "data-id-teacher='", $j['id_teacher'], "' ";
                                            echo "data-id-subject='", $j['id_subject'], "' ";
                                            echo "data-id-group='", $j['id_group'], "' ";
                                            echo "data-id-student='", $j['id_student'], "' ";
                                            echo "data-id-lesson-type='", $j['id_lesson_type'], "' ";
                                            echo "data-lesson-number='", $j['lesson_number'], "' ";
                                            echo "data-mark='", $j['mark'], "' ";
                                            echo "data-date='", $j['date'], "' ";

                                            // якщо була виправлена "н" або "2"
                                            if (strpos($j['remark'], 'н')) echo "data-remark='1' ";
                                            elseif ( strpos($j['remark'], '2|') )
                                                { if ($j['mark'] != '12') echo "data-remark='2' "; }
                                            else echo "data-remark='0' ";

                                            echo ">",$j['mark'], "</td>";

                                            // якщо знайшли відповідний запис то стираємо його і виходимо з циклу
                                            unset($journal[$key]);
                                            break;
                                        }
                                    }
                                }
                                echo "<td class='text-muted text-right'>.</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div> <!-- END TABLE MARK -->

                </div>
                <!-- END TABLE JOURNAL -->


                <!-- ADD NEW DATE -->
                <div id="box-add-new-date" class="m-box-add-new-date">
                    <div class="m-add-new-date-header">
                        <p>Додати пару</p>
                    </div>
                    <div>
                        <div class="m-lesson-input-box">
                        <select id="add-new-lesson-input" class="m-add-new-lesson-input" name="add-new-lesson-input">
                            <?php
                            foreach ($lesson_type as $v){
                                echo "<option value='", $v['id'], "'>", $v['lesson_type'], "</option>";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="text-center">
                            <input id="add-new-date-input" class="m-add-new-date-input" type="date" name="new-d"><br>
                        </div>
                        <div class="text-center">
                            <button id="add-new-date-attendion" class="btn btn-primary add-new-date-ok-cancel" type="button" data-toggle="modal" data-target="#attendion-new-date">Додати</button>
                            <button id="add-new-date-cancel" class="btn btn-danger add-new-date-ok-cancel" type="button">Відміна</button>
                        </div>
                    </div>
                </div>

                <!-- CHANGE DATE -->
                <div class="modal fade" id="change-date" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button id="change-date-cancel-attention" type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title text-danger">Увага!</h3>
                            </div>
                            <div class="modal-body">
                                <h4>Ви хочите змінити наявну дату.</h4>
                                <h4 id="change-date-display" class="text-primary"></h4>
                            </div>
                            <div class="modal-footer">
                                <button id="change-date-ok" type="button" class="btn btn-success" data-dismiss="modal">Змінити дату</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Вийти</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- (ATTENTION MESSAGE) -->
                <div class="modal fade" id="attendion-new-date" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button id="add-new-date-cancel-attention" type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title text-danger">Увага!</h3>
                            </div>
                            <div class="modal-body">
                                <h4>Ви не зможете змінити введену дату.</h4>
                                <h4 id="add-new-lesson-display" class="text-primary">Заняття</h4>
                                <h4 id="add-new-date-display" class="text-primary">01-01-2017</h4>
                            </div>
                            <div class="modal-footer">
                                <button id="add-new-date-ok" type="button" class="btn btn-success" data-dismiss="modal">Продовжити, дата вірна</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Змінити дату</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</main>
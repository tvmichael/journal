<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="inspector-teacher">
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Жрнали викладача: <b><?php $name_t = trim($teacher['surname'].' '.$teacher['name'].' '.$teacher['patronymic']); echo $name_t; ?></b></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="usr">Пошук:</label>
                            <input class="form-control" type="text" id="input-search" placeholder="Курс, група, підгрупа">
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Курс</th>
                                <th>Група</th>
                                <th>Підгрупа</th>
                                <th>Предмет</th>
                                <th>Проведено занять</th>
                                <th>Журнал</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                                foreach ($teacher_list as $tl) {
                                    $name_gs = $tl['course'] . ' ' . $tl['groupe'] . ' ' . $tl['subgroup'] . ' ' . $tl['fullname'];
                                    echo "<tr data-search='" . $name_gs . "'>";
                                    echo '<td>' . $i . '</td>';
                                    echo '<td>' . $tl['course'] . '</td>';
                                    echo '<td>' . $tl['groupe'] . '</td>';
                                    echo '<td>' . $tl['subgroup'] . '</td>';
                                    echo '<td>' . $tl['fullname'] . '</td>';

                                    if ($tl['date_count'] == 0) echo '<td>' . '' . '</td>';
                                    else {
                                        $n = 2;
                                        if ( $tl['date_count'] >= 50 ) $n = 1;
                                        echo "<td><div class='m-count-date-n' style='width:" . ($n * $tl['date_count']) . "%;'>" . $tl['date_count'] . "</div></td>";
                                    }

                                    echo "<td><a href='".base_url('inspector/teacher?action=openTeacherJournal&idTeacher=').$tl['id_teacher'].
                                        '&idSubject='.$tl['id_subject'].
                                        '&idGroup='.$tl['id_group'].
                                        '&nameT='.$name_t.
                                        '&nameGS='.$name_gs.
                                        "'>".'Відкрити журнал'.'</a></td>';
                                    echo '</tr>';
                                    $i++;
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>


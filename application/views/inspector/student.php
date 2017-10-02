<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="inspector-main-students">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div><div>Загальна кількість студентів: <b><?php echo count($students); ?></b></div></div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="usr">Пошук:</label>
                            <input class="form-control" type="text" id="input-search-student" placeholder="Прізвище Імя по батькові, курс, група ...">
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">№</th>
                                    <th>Прізвище Імя</th>
                                    <th>Курс</th>
                                    <th>Група</th>
                                    <th>Середній бал</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($students as $s){
                                echo "<tr data-search='".$s['surname'].' '.$s['name'].' '.$s['patronymic'].' '.$s['course'].' '.$s['groupe'].' '.round($s['avg_b'],1)."'>";
                                echo "<td>$i</td>";
                                echo "<td><a href='".base_url('inspector/student?action=openStudentJournal&id=').$s['id_student']."'>".$s['surname'].' '.$s['name'].' '.$s['patronymic']."</a></td>";
                                echo "<td>".$s['course']."</td>";
                                echo "<td>".$s['groupe']."</td>";
                                echo "<td><div class='m-average-student-bal' style='width:".round(100*$s['avg_b']/12)."%;'>".round($s['avg_b'],1)."</div></td>";
                                echo "</tr>";
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

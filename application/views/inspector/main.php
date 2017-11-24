<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="inspector-main">
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Загальна кількість викладачів: <b><?php echo count($list_teacher); ?></b></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="usr">Пошук:</label>
                            <input class="form-control" type="text" id="input-search-teacher" placeholder="Прізвище Імя по батькові ...">
                        </div>
                        <?php
                            $max = 1;
                            foreach ($list_teacher as $i){
                                if($i['count_visit'] > $max) $max = $i['count_visit'];
                            }
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Прізвище Імя по батькові</th>
                                <th title="Лекції, практичні, лабораторні">
                                    <span class="m-sort-table">Предметів</span>
                                </th>
                                <th>
                                    <span class="m-sort-table">Груп (підгруп)</span>
                                </th>
                                <th>
                                    <span class="m-sort-table">Відвідування електронного журналу</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($list_teacher as $lt){
                                echo "<tr data-id='".$lt['id']."'>";
                                echo "<td>".$i."</td>";
                                echo "<td><a class='m-list-teacher-a' href='".base_url('inspector/teacher?action=openTeacher&id=').$lt['id']."'><div>".$lt['surname'].' '.$lt['name'].' '.$lt['patronymic']."</div></a></td>";

                                if($lt['count_subject'] == 0) echo "<td><div></div></td>";
                                    else echo "<td><div class='m-count-subject' style='width:".(5*$lt['count_subject'])."%;'>".$lt['count_subject']."</div></td>";

                                if($lt['count_group'] == 0) echo "<td><div></div></td>";
                                    else echo "<td><div class='m-count-group' style='width:".(2*+$lt['count_group'])."%;'>".$lt['count_group']."</div></td>";

                                echo "<td><div class='m-count-visits' style='width: ".round(($lt['count_visit'])*100/$max, 0, PHP_ROUND_HALF_DOWN)."%;'>".$lt['count_visit']."</div></td>";

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

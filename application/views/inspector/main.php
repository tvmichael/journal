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
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="text-primary">
                                <td>№</td>
                                <td>Прізвище Імя по батькові</td>
                                <td title="Лекції, практичні, лабораторні">Предметів</td>
                                <td>Груп (підгруп)</td>
                                <td>Відвідування електронного журналу</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($list_teacher as $lt){
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td><a class='m-list-teacher-a' href='".base_url('inspector/teacher?action=openTeacher&id=').$lt['id']."'><div>".$lt['surname'].' '.$lt['name'].' '.$lt['patronymic']."</div></a></td>";

                                if($lt['count_subject'] == 0) echo "<td></td>";
                                    else echo "<td><div class='m-count-subject' style='width:".(5*$lt['count_subject'])."%;'>".$lt['count_subject']."</div></td>";

                                if($lt['count_group'] == 0) echo "<td></td>";
                                    else echo "<td><div class='m-count-group' style='width:".(2*+$lt['count_group'])."%;'>".$lt['count_group']."</div></td>";

                                if($lt['count_visit'] == 0) echo "<td></td>";
                                elseif ($lt['count_visit'] < 50)
                                    echo "<td><div class='m-count-visits' style='width: ".(2*$lt['count_visit'])."%;'>".$lt['count_visit']."</div></td>";
                                elseif ($lt['count_visit'] >= 50)
                                    echo "<td><div class='m-count-visits' style=' width: ".$lt['count_visit']."%;'>".$lt['count_visit']."</div></td>";

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

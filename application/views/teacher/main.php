<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main id="main-journal" class="m-main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <div class="m-display-type">
                        <a href="<?php echo base_url('teacher'); ?>?display_type=1"><span class="glyphicon glyphicon-th-large"></span></a>
                        <a href="<?php echo base_url('teacher'); ?>?display_type=2"><span class="glyphicon glyphicon-th-list"></span></a>
                    </div>
                </div>
            </div>


            <?php



            /** ....... Потрібно реалізувати на стороні користувача .............................. **/



            // id_teacher, id_group, id_subject,
            // id, shortname, fullname,
            // course, groupe, subgroup

            // сортування масииву по відповідному полю

            function myCmp($a, $b) {
                if ($a['course'] === $b['course']) return 0;
                return $a['course'] > $b['course'] ? 1 : -1;
            }
            uasort($list_gt, 'myCmp');
            /**/
            //array_multisort($list_gt, SORT_ASC);
            //d($list_gt);


            // якщо немає налаштувань вигляду клітинок груп то робимо = 2
            if(!(isset($display_type))) $display_type = 2;

            if ($display_type == 1) {
                foreach ($list_gt as $row) {
                    ?>
                    <div class="col-sm-6 col-lg-4">
                        <a href="<?php echo base_url('teacher/journal'); ?>?teacher=<?php echo $row['id_teacher']; ?>&group=<?php echo $row['id_group']; ?>&subject=<?php echo $row['id_subject']; ?>"
                           style="text-decoration: none;">
                            <div id="list-group-teacher">
                                <h5 class="m-course-name<?php
                                echo " list-group-teacher-";
                                if (strpos($row['subgroup'], '1/2')) {
                                    echo '1-2';
                                } elseif (strpos($row['subgroup'], '1/3')) {
                                    echo '1-3';
                                } elseif (strpos($row['subgroup'], '1/4')) {
                                    echo '1-4';
                                } else echo '1';
                                ?>"><?php echo $row['course']; ?></h5>
                                <h3 class="m-group-name"><?php echo $row['groupe']; ?></h3>
                                <p class="m-subgroup-name"><?php echo $row['subgroup']; ?></p>
                                <p class="m-fullname-name"><?php echo $row['fullname']; ?></p>
                            </div>
                        </a>
                    </div>
                <?php
                };
            };
            ?>


            <?php if($display_type == 2){ ?>
            <div class="col-md-12">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Курс</th>
                    <th>Група</th>
                    <th>Підгрупа</th>
                    <th>Предмет</th>
                    <th>Журнал</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    foreach ($list_gt as $row){
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$row['course']."</td>";
                        echo "<td>".$row['groupe']."</td>";
                        echo "<td>".$row['subgroup']."</td>";
                        echo "<td>".$row['fullname']."</td>";
                        echo "<td>"."<a href='".base_url('teacher/journal')."?teacher=".$row['id_teacher']."&group=".$row['id_group']."&subject=".$row['id_subject']."'>Відкрити сторінку журналу</a>"."</td>";
                        echo "</tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <?php }; ?>

        </div>
    </div>
</main>
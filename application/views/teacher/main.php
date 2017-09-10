<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main id="main-journal" class="m-main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                        <div class="text-center">
                            <button class="btn btn-default"><span class="glyphicon glyphicon-th-large"></span></button>
                            <button class="btn btn-default"><span class="glyphicon glyphicon-th"></span></button>
                            <button class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span></button>
                        </div>
                </div>
            </div>
            <?php
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

            foreach ($list_gt as $row){?>
            <div class="col-sm-6 col-lg-4">
                <a href="<?php echo base_url('teacher/journal');?>?teacher=<?php echo $row['id_teacher'];?>&group=<?php echo $row['id_group'];?>&subject=<?php echo $row['id_subject'];?>"
                   style="text-decoration: none;">
                <div id="list-group-teacher">
                    <h5 class="m-course-name<?php
                        echo " list-group-teacher-";
                        if ( strpos($row['subgroup'],'1/2') ){ echo '1-2';}
                        elseif ( strpos($row['subgroup'],'1/3') ){ echo '1-3';}
                        elseif ( strpos($row['subgroup'],'1/4') ){ echo '1-4';}
                        else echo '1';
                    ?>"><?php echo $row['course'];?></h5>
                    <h3 class="m-group-name"><?php echo $row['groupe'];?></h3>
                    <p class="m-subgroup-name"><?php echo $row['subgroup']; ?></p>
                    <p class="m-fullname-name"><?php echo $row['fullname'];?></p>
                </div>
                </a>
            </div>
            <?php };?>
        </div>
    </div>
</main>
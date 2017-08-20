<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main id="main-journal" class="m-main-content">
    <div class="container-fluid">
        <div class="row">
            <?php
            // id_teacher, id_group, id_subject,
            // id, shortname, fullname,
            // course, groupe, subgroup
            foreach ($list_gt as $row){?>
            <div class="col-sm-6 col-lg-4">
                <a href="<?php echo base_url('teacher/journal');?>?teacher=<?php echo $row['id_teacher'];?>&group=<?php echo $row['id_group'];?>&subject=<?php echo $row['id_subject'];?>"
                   style="text-decoration: none;">
                <div id="list-group-teacher">
                    <h5 class="m-course-name"><?php echo $row['course'];?></h5>
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


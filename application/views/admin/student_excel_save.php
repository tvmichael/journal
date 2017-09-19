<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/add_new_student');?>"
      data-admin="student-excel-save">

    <div class="row">
        <!-- SAVE STUDENTS -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Студенти занесені до БД</div>
                <div class="panel-body">
                <?php
                    d($students);
                ?>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/student_setting');?>"
      data-admin="student-setting">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Облікові дані студентів</div>
                <div class="panel-body">
                    <button id="list-student-registration">
                        Згенерувати список облікових даних студентів по групах
                    </button>
                    <br>
                    <div id="data-list-student-registration"></div>
                </div>
            </div>
        </div>
    </div>
</main>



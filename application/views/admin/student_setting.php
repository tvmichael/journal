<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/student_setting');?>"
      data-admin="student-setting">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Облікові дані для студентів (логін, пароль)</div>
                <div class="panel-body">
                    <button id="list-student-registration">
                        Згенерувати список облікових даних студентів по групах
                    </button>
                    <br>
                    <div id="data-list-student-registration"></div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Перевести студентів на новий начальний рік</div>
                <div class="panel-body">
                    <button id="list-student-registration">
                        Перевести
                    </button>
                    <br>
                    <div id="go-student-to-new-year"></div>
                </div>
            </div>
        </div>
    </div>
</main>



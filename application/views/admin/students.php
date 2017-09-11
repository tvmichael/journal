<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/student');?>"
      data-admin="student">

    <div class="row">

        <!-- STUDENTS LIST -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Групи студентів</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <label for="sel-s-group-list">Список груп (підгруп):<?php echo count($group);?></label>
                        <select size="25" class="form-control t-sel-list-font"
                                id="sel-s-group-list">
                                <option value="0">Усі студенти</option>
                            <?php
                            foreach ($group as $i){
                                echo "<option value='".$i['id']."'>";
                                if ( count(explode(' ', $i['subgroup']))>1 ) echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo $i['course'].' ';
                                echo $i['groupe'].' ';
                                echo $i['subgroup'];
                                echo "</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="sel-s-student-list">
                            Список студентів:
                            <span id="sel-s-count-student"></span>
                        </label>
                        <table id="sel-s-student-list" class="table table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Прізвиеще</th>
                                    <th>Ім'я</th>
                                    <th>по батькові</th>
                                    <th>Група</th>
                                    <th></th>
                                    <th class="text-center"><span class="glyphicon glyphicon-pencil"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php student_select_table($student); ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>



    </div>
</main>

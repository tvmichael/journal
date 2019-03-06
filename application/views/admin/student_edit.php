<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/********************
 $student
 $group
********************/
?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/student_edit');?>"
      data-admin="student_edit">
    <div class="row">
        <!-- STUDENTS LIST -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <div class="col-md-4">
                            <label>Прізвище</label>
                            <input type="text" class="form-control" id="student-surname" value="<?php echo $student[0]['surname'];?>">
                        </div>
                        <div class="col-md-4">
                            <label>Імя</label>
                            <input type="text" class="form-control" id="student-name" value="<?php echo $student[0]['name'];?>">
                        </div>
                        <div class="col-md-4">
                            <label>по батькові</label>
                            <input type="text" class="form-control" id="student-patronymic" value="<?php echo $student[0]['patronymic'];?>">
                        </div>
                        <div class="col-md-12 text-right" style="margin: 10px 0px;">
                            <button id="save-student" data-id-student="<?php echo $student[0]['id_student'];?>" class="btn btn-success">
                                <span class="glyphicon glyphicon-save"></span>
                                Зберегти внесені зміни
                            </button>
                            <button id="delete-student" data-id-student="<?php echo $student[0]['id_student'];?>" type="button" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span>
                                Видалити студента з "Бази Даних"
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input type="text" class="form-control" id="new-pass-x" value="" placeholder="Новий пароль">
                    </div>
                    <div class="col-md-4">
                        <button id="new-pass-save" data-id-student="<?php echo $student[0]['id_student'];?>" type="button" class="btn btn-success">
                            <span class="glyphicon glyphicon-save"></span>
                            Зберегти новий пароль
                        </button>
                    </div>
                    <script>
                        // зміна пароля
                        document.addEventListener("DOMContentLoaded", function () {
                            $('#new-pass-save').click(function () {
                                $.get("<?php echo base_url('admin/student_edit');?>", {
                                    'action':'saveNewPass',
                                    'id_student':$(this).attr('data-id-student'),
                                    'new-pass':$('#new-pass-x').val(),
                                    'surname':'<?php echo $student[0]['surname'];?>',
                                    'name':'<?php echo $student[0]['name'];?>',
                                    'patronymic':'<?php echo $student[0]['patronymic'];?>'
                                }).done(function (error) {
                                    console.log(error);
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <label>Список груп (підгруп) в які входить студент</label>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Група (Підгрупа)</th>
                                <th>Видалити</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            //surname, name, patronymic, id_student, id_group, course, groupe, subgroup
                            foreach ($student as $s){?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $s['course'].' '.$s['groupe'].' '.$s['subgroup']; ?></td>
                                    <td>
                                        <button data-delete-group="1" data-id-student="<?php echo $s['id_student'];?>" data-id-group="<?php echo $s['id_group'];?>" class="btn btn-default">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </td>
                                </tr>
                                <?php $i++; };?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <label>Виберіть групу</label>
                        <select id="group-selected" class="form-control t-sel-list-font">
                            <option value="-1"></option>
                            <?php
                            foreach ($group as $g){
                                echo "<option value='".$g['id']."'>";
                                if ( count(explode(' ', $g['subgroup']))>1 ) echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo $g['course'].' ';
                                echo $g['groupe'].' ';
                                echo $g['subgroup'];
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <button id="add-new-group" data-id-student="<?php echo $student[0]['id_student'];?>" class="btn btn-success">
                                <span class="glyphicon glyphicon-open"></span>
                                <br>Додати підгрупу
                            </button>
                        </div>
                        <div class="col-md-6">
                            <small>Інформація зберігається автоматично</small>
                            <h4 id="respond"></h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
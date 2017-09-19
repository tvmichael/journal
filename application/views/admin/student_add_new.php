<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/add_new_student');?>"
      data-admin="add-new-student">

    <div class="row">
        <!-- ADD STUDENTS -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Додати нових студентів</div>
                <div class="panel-body">

                    <div id="textarea-container">
                        <p><b>Скопіюйте список студентів в текстове поле</b> (Прізвище, Імя по бітькові)</p>
                        <p class="text-danger">Не більше 5-ти студентів</p>
                        <p>
                            Наприклад так:<br>
                            <span class="text-info">&nbsp;&nbsp;Іванов Іван Іванович</span><br>
                            <span class="text-info">&nbsp;&nbsp;Петров Петро Петрович</span>
                        </p>
                        <textarea id="s-textarea" class="s-textarea"></textarea>
                        <div class="text-right">
                            <button id="textarea-button" type="button" class="btn btn-success">Додати студентів</button>
                        </div>
                        <div>
                            <hr>
                            <form action="<?php echo base_url('admin/add_new_student')?>" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                                <label for="fileExcel">Виберіть <code>excel</code> файл для завантаження</label>
                                <input type="file" name="excelfile" value="excelfile" id="excelfile">
                                <br>
                                <input type="submit" name="submitExcel" class="btn btn-success" value="Завантажити">
                            </form>
                        </div>
                    </div>

                    <div id="student-div" class="s-student-div">
                        <table class="table table-bordered table-hover table-condensed" id="edit-student-table">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Прізвище</th>
                                <th>Імя</th>
                                <th>по батькові</th>
                                <th><span class="glyphicon glyphicon-ok"></span></th>
                                <th style="width: 15%;">Групи</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="col-sm-4">
                            <h5>Виберіть групу і додайте до виділених студентів:</h5>
                        </div>
                        <div class="col-sm-5">
                            <select id="group-selected" class="form-control t-sel-list-font">
                                <option value="-1"></option>
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
                        <div class="col-sm-3">
                            <button id="button-add-group" type="button" class="btn btn-success">Додати групу</button>
                        </div>
                        <div class="col-sm-12"><hr></div>
                        <div class="col-sm-12 text-center">
                            <button id="save-student-group" type="button" class="btn btn-primary">Зберегти список студентів </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

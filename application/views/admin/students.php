<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/student');?>"
      data-admin="student">

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Список студентів</div>
                <div class="panel-body">
                    <button id="open-load-excel-file"type="button" class="btn btn-default"
                            data-toggle="modal" data-target="#modal-load-excel-file">
                        Завантажити файл (формат excel)
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-load-excel-file" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Завантажити список студентів (формат excel)</h4>
                                </div>
                                <div class="modal-body">
                                    <!-- -->
                                    <form action="<?php echo base_url('admin/student');?>" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="50000">
                                        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
                                        <div class="s-open-excel-file">
                                            <input type="file" name="excelfile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" id="filestyle-0" tabindex="-1" >
                                        </div>
                                        <div class="s-open-excel-but">
                                            <button class="btn btn-default" type="submit" name="submit" value='excel'>Завантажити файл</button>
                                        </div>
                                    </form>
                                    <!-- -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Відміна</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
                </div>
                <div class="panel-footer"><?php echo $result_load_excel; ?></div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Загальна статистика</div>
                <div class="panel-body">
                    <p>Загальна кількість студентів: <b><?php echo count($student);?></b></p>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Пререгляд груп студентів</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <label for="sel-s-group-list">Список груп (підгруп):<?php echo count($group);?></label>
                        <select size="20" multiple class="form-control t-sel-list-font"
                                id="sel-s-group-list">
                            <?php
                            foreach ($group as $i){
                                echo "<option value='", $i['id'], "''>";
                                echo $i['course'], ' ';
                                echo $i['groupe'], ' ';
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
                        <select size="20" multiple class="form-control t-sel-list-font"
                                id="sel-s-student-list">
                            <?php
                            foreach ($student as $i){
                                echo "<option value='", $i['id'], "''>";
                                echo $i['surname'], ' ';
                                echo $i['name'], ' ';
                                echo $i['patronymic'];
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>



    </div>
</main>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="t-main"
      class="container-fluid"
      data-url="<?php echo base_url('admin/teacher');?>"
      data-admin="teacher">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Загальний список</div>
                <div class="panel-body">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel-teacher-list">Список викладачів:</label>
                            <select size="10" multiple class="form-control t-sel-list-font"
                                    id="sel-teacher-list">
                                <?php
                                    foreach ($teacher as $t){
                                        echo "<option value='", $t['id'], "''>";
                                        echo $t['surname'], ' ';
                                        echo $t['name'], ' ';
                                        echo $t['patronymic'];
                                        echo "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel-subject-list">Список предметів:</label>
                            <select size="10" multiple class="form-control t-sel-list-font"
                                    id="sel-subject-list">
                                <?php
                                foreach ($subject as $s){
                                    echo "<option value='", $s['id'], "''>";
                                    echo $s['fullname'];
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sel-group-list">Список груп:</label>
                            <select size="10" multiple class="form-control t-sel-list-font"
                                    id="sel-group-list">
                                <?php
                                foreach ($group as $g){
                                    echo "<option value='", $g['id'], "''>";
                                    echo $g['course'], ' ';
                                    echo $g['groupe'], ' ';
                                    echo $g['subgroup'];
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-8">
                            <span id="teacher-current-choice" class="label label-default">...</span>
                            &nbsp;
                            <span id="subject-current-choice" class="label label-default">...</span>
                            &nbsp;
                            <span id="group-current-choice" class="label label-default">...</span>
                            &nbsp;
                            <span id="save-choice" class="label label-success t-save-chioce">
                                <span class="glyphicon glyphicon-save" aria-hidden="true">  зберігаємо ... </span>
                            </span>
                        </div>
                        <div class="col-md-4 text-right">
                            <button id="button-add" type="button" class="btn btn-success">
                                Додати до списку викладача
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div id="header-teacher">Невідомий викладач</div>
                </div>
                <div class="panel-body">
                    <div>
                        <table id="teacher-working-load" class="table table-bordered table-hover">

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
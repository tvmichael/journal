<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main id="teacher-main"
      class="container-fluid"
      data-url="<?php echo base_url('teacher/working_load');?>"
      data-teacher="working-load">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Сторінка редагування навантаження викладача</div>
                <div class="panel-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sel-subject-list">Виберіть предмет:</label>
                            <select size="10" multiple class="form-control t-sel-list-font"
                                    id="sel-subject-list">
                                <?php
                                $i = 1;
                                foreach ($subject as $s){
                                    echo "<option value='", $s['id'], "''>";
                                    echo $i;
                                    if ( $i < 10 ) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        else if ( $i < 100 ) echo '&nbsp;&nbsp;&nbsp;'; else echo '&nbsp;&nbsp;';
                                    echo $s['fullname'];
                                    echo "</option>";
                                    $i++;
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sel-group-list">Виберіть групу:</label>
                            <select size="10" multiple class="form-control t-sel-list-font"
                                    id="sel-group-list">
                                <?php
                                foreach ($group as $g){
                                    echo "<option value='", $g['id'], "''>";
                                    if ( count(explode(' ', $g['subgroup']))>1 ) echo '&nbsp;&nbsp;&nbsp;&nbsp;';
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
                            <span id="teacher-current-choice" data-teacher-id="<?php echo $_SESSION['id'];?>" class="label label-default">
                                <?php echo $_SESSION['name'], ' ', $_SESSION['surname'] ?>
                            </span>
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
                                Додати до навантаження
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div id="header-teacher">Список активних груп</div>
                </div>
                <div class="panel-body">
                    <div>
                        <table id="teacher-working-load" class="table table-bordered table-hover">

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <pre>
                <?php
                //print_r($_SESSION);
                ?>
            </pre>
        </div>

    </div>
</main>
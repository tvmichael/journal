<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<main class="container-fluid"
      id="t-main-list"
      data-url="<?php echo base_url('admin/working_load');?>"
      data-admin="working-load">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Список викладачів:</div>
                <div class="panel-body">

                    <div class="col-md-12">
                        <div class="form-group">

                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Прізвище</th>
                                    <th>Імя</th>
                                    <th>по батькові</th>
                                    <th>Налаштування</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($list as $i => $l){
                                    echo '<tr>';
                                    echo '<td>'.($i+1).'</td>';
                                    echo '<td>'.$l['surname'].'</td>';
                                    echo '<td>'.$l['name'].'</td>';
                                    echo '<td>'.$l['patronymic'].'</td>';
                                    echo '<td><a href="" data-id="'.$l['id'].'">'
                                        .'Редагувати'.'</a></td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

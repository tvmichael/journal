<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main class="m-main-content">
    <div class="container-fluid">
        <div class="row">

            <?php echo form_open('admin/add_new_teacher');?>
            <div class="col-sm-6">
                <label for="login" class="m-settings-label">Логін (латинськими буквами)</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_input('login', '', "id='login' class='form-control' name='login' placeholder='Логін' required ");
                    echo form_error('login', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

                <label for="surname" class="m-settings-label">Прізвище Імя</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_input('surname', '', "id='surname' class='form-control' name='surname'  placeholder='Прізвище' required");
                    echo form_error('surname', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

            </div>

            <div class="col-sm-6">
                <label for="password1" class="m-settings-label">Тимчасовий пароль</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_password('password1', '', "id='password1' class='form-control' name='password1'  placeholder='пароль'");
                    echo form_error('password1', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>
                <label for="password2" class="m-settings-label">Підтвердження</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_password('password2', '', "id='password2' class='form-control' name='password2'  placeholder='пароль - підтвердження'");
                    echo form_error('password2', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

                <br>
                <hr>
                <div class="input-group text-center m-settings-bot" style="width: 100%">
                    <?php
                    echo form_submit('submit', 'Зберегти інформацію',"class='btn btn-success'");
                    ?>
                </div>

            </div>

            <?php
            echo form_hidden('userId', 'add-teacher');
            echo form_close();
            ?>

            <div class="text-center">
                <h4><?php print_r($message); ?></h4>
            </div>
        </div>
    </div>
</main>

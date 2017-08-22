<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main class="m-main-content">
    <div class="container-fluid">
        <div class="row">

            <?php echo form_open('teacher/settings');?>
            <div class="col-sm-6">
                <label for="login" class="m-settings-label">Логін</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_input('login', $_SESSION['login'], "id='login' class='form-control' name='login'  placeholder='Логін' disabled required title='Ви не можете змінити логін. Зверніться до адміністратора.'");
                    echo form_error('login', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

                <label for="surname" class="m-settings-label">Прізвище*</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_input('surname', $_SESSION['surname'], "id='surname' class='form-control' name='surname'  placeholder='Прізвище' required");
                    echo form_error('surname', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

                <label for="name" class="m-settings-label">Ім'я*</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_input('name', $_SESSION['name'], "id='name' class='form-control' name='name'  placeholder='Імя' required");
                    echo form_error('name', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

                <label for="patronymic" class="m-settings-label">по батькові</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_input('patronymic', $_SESSION['patronymic'], "id='patronymic' class='form-control' name='patronymic'  placeholder='по батькові' ");
                    echo form_error('patronymic', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

                <label for="email" class="m-settings-label">Адреса електронної пошти</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_input('email', $_SESSION['email'], "id='email' class='form-control' name='email'  placeholder='Email'");
                    echo form_error('email', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>

                <br>
                <p>* - поля обовязкові для заповнення</p>
            </div>

            <div class="col-sm-6">
                <label for="password" class="m-settings-label">Змінити пароль</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_password('password', '', "id='password' class='form-control' name='password'  placeholder='Старий пароль'");
                    echo form_error('password', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>
                <label for="password1" class="m-settings-label">Новий пароль</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_password('password1', '', "id='password1' class='form-control' name='password1'  placeholder='Новий пароль'");
                    echo form_error('password1', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>
                <label for="password2" class="m-settings-label">Підтвердження</label>
                <div class="input-group" style="width: 100%">
                    <?php
                    echo form_password('password2', '', "id='password2' class='form-control' name='password2'  placeholder='Новий пароль - підтвердження'");
                    echo form_error('password2', '<div class="alert alert-danger alert-top">', '</div>');
                    ?>
                </div>
                <h5>Якщо не бажаєте змінювати пароль - залишіть поля пустими</h5>

                <br>
                <hr>
                <div class="input-group text-center m-settings-bot" style="width: 100%">
                    <?php
                    echo form_submit('submit', 'Зберегти інформацію',"class='btn btn-success'");
                    ?>
                </div>

            </div>

            <?php
                echo form_hidden('userId', $_SESSION['id']);
                echo form_close();
            ?>

            <div class="text-center">
                <h4><?php echo $message;?></h4>
            </div>
        </div>
    </div>
</main>
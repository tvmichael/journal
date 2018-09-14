<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизація</title>
    <link rel="shortcut icon" href="<?php echo base_url();?>resources/images/login.png" type="image/x-icon">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Login -->
    <link href="<?php echo base_url();?>resources/css/login.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="center">
        <h2>Авторизація</h2>

        <?php echo form_open('login/inaccessible', "name='form-login'"); ?>

        <div class="form-group">
        <?php
            echo form_input('login', '', "class='form-control' name='username'  placeholder='Логін' required autofocus ");
            echo form_error('login', '<div class="alert alert-danger alert-top">', '</div>');
        ?>
        </div>

        <div class="form-group">
        <?php
            echo form_password('password', '', "class='form-control' name='password'  placeholder='Пароль' required ");
            echo form_error('password', '<div class="alert alert-danger alert-top">', '</div>');
        ?>
        </div>

        <div>
        <?php echo form_hidden('hidden-field', 'journal-login'); ?>
        </div>

        <div>
        <?php echo form_submit('submit', 'Вхід', "class='btn btn-primary'"); ?>
        </div>

        <?php echo form_close(); ?>

        <div class="timetable-link">
            <a href="https://sites.google.com/site/medichne/"><h5>Розклад занять</h5></a>
        </div>

        <!--
        <?php
        // old
        // be845e98d086486272955c517959f9e922d0a563
        //new
        // 8222c902ae0723e8bb352bb17ed76809e4688165
        // echo sha1('Katia');

        // 789481345e5af4cfa4e07455defdb2f53a3ea6d2
        // b4514f8853ae06008dbf408584970518c52d98fc
        ?>
        -->

    </div>
</div>
</body>
</html>
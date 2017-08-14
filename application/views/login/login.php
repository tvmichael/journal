<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Authorisation</title>
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

        <?php echo form_open('login', "name='form-login'"); ?>

        <div class="form-group">
        <?php
            echo form_input('login', 'mik', "class='form-control' name='username'  placeholder='Логін' required autofocus ");
            echo form_error('login', '<div class="alert alert-danger alert-top">', '</div>');
        ?>
        </div>

        <div class="form-group">
        <?php
            echo form_password('password', 'mik', "class='form-control' name='password'  placeholder='Пароль' required ");
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

    </div>
</div>
</body>
</html>
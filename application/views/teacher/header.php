<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Журнал</title>
    <link rel="shortcut icon" href="<?php echo base_url();?>resources/images/teacher.png" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Teacher -->
    <link href="<?php echo base_url();?>resources/css/teacher.css" rel="stylesheet">
</head>
<body>

<!-- HEADER ------------------------------------------------------------------------- -->
<header>
    <nav class="navbar navbar-default navbar-top">
        <div class="container-fluid">

            <div class="navbar-header">
                <span class="navbar-brand"><?php echo $navbar_text; ?></span>

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-journal" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbar-journal">
                <ul class="nav navbar-nav">
                    <?php if (($navbar_menu != 'add_group') && ($navbar_menu != 'journal') ) { ?>
                    <li>
                        <a href="<?php echo base_url('teacher/working_load');?>"><span class="glyphicon glyphicon-list-alt"></span> Редагувати групи</a>
                    </li>
                    <?php }; ?>
                    <?php if (($navbar_menu == 'journal') || ($navbar_menu == 'settings') || ($navbar_menu == 'message') || ($navbar_menu == 'add_group') ) { ?>
                    <li>
                        <a href="<?php echo base_url('teacher');?>"><b>Cписок груп</b></a>
                    </li>
                    <?php }; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo base_url('teacher/message');?>"><span class="glyphicon glyphicon-envelope"></span> Повідомлення</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('teacher/settings')?>">
                            <span class="glyphicon glyphicon-user"></span>
                            <?php echo $_SESSION['name'], ' ', $_SESSION['surname'] ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('login/logout')?>">
                            <span class="glyphicon glyphicon-log-out"></span>
                            Вихід
                        </a>
                    </li>
                </ul>
            </div><!-- navbar-collapse -->

        </div>
    </nav>
</header>

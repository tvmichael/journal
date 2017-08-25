<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Адміністратор</title>
    <link rel="shortcut icon" href="<?php echo base_url();?>resources/images/admin.png" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Teacher -->
    <link href="<?php echo base_url();?>resources/css/admin.css" rel="stylesheet">
</head>
<body>
<header class="m-header-bg-c">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="navbar-brand" ><?php echo $navbar_header; ?></span>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-admin" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar-admin" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url('admin');?>">Головна</a></li>
                <li><a href="<?php echo base_url('admin/teacher');?>">Викладачі</a></li>
                <li><a href="<?php echo base_url('admin/student');?>">Студенти</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                       role="button" aria-haspopup="true" aria-expanded="false">
                       Dropdown
                       <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?php echo base_url('admin/setting')?>">
                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                        &nbsp;
                        <?php echo $_SESSION['surname'], ' ', $_SESSION['name']; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('login/logout')?>">
                        <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                        &nbsp;
                        Вихід
                    </a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</header>
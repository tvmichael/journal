<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>load</title>
</head>
<body>
<div class="container">
    <div class="center">
        <h1>File</h1>
        <!-- -->
        <form action="<?php echo base_url($actions);?>" enctype="multipart/form-data" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="500000">
            <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
            <input type="file" name="excelfile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" id="filestyle-0" tabindex="-1" >
            <button type="submit" name="submit" value='excel'>Завантажити файл</button>
        </form>
        <!-- -->
    </div>
</div>
</body>
</html>

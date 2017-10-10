<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main id="main-student">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div id="student-data"></div>
            </div>
        </div>
    </div>
</main>
<!-- STUDENT OBJECT ----------------------------------------------------------------- -->
<script>
    <?php
    $student = array();
    $student['id'] = $_SESSION['id'];
    $student['name'] = $_SESSION['name'];
    $student['surname'] = $_SESSION['surname'];
    $student['patronymic'] = $_SESSION['patronymic'];
    echo 'var student = '.json_encode($student, JSON_UNESCAPED_UNICODE).';';
    echo 'var journal = '.json_encode($journal, JSON_UNESCAPED_UNICODE).';';
    ?>
</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="main-student-rating">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="<?php echo base_url('student'); ?>">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            повернутись назад
                        </a>                        &nbsp;&nbsp;&nbsp;
                        <b><?php echo $group_name; ?></b>
                    </div>
                    <div class="panel-body">
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <?php
                        foreach ($data_journal as $v)
                        {
                            echo "<div id='group-content_".$v[0]."'></div><hr>";
                        }
                        ?>
                        <script>
                            var data_journal = <?php echo json_encode($data_journal, JSON_UNESCAPED_UNICODE); ?>;
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

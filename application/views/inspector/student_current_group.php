<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="inspector-current-group">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="<?php echo base_url('inspector/student?action=openStudentGroup'); ?>">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            Список груп
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <b><?php echo $group_name; ?></b>
                    </div>
                    <div class="panel-body">

                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                        <div id="group-content"></div>

                        <script>
                            var studentsList = <?php echo json_encode($students, JSON_UNESCAPED_UNICODE); ?>;
                            var journalsList = <?php echo json_encode($journals, JSON_UNESCAPED_UNICODE); ?>;
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</main>
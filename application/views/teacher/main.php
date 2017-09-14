<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main id="main-journal"
      class="m-main-content"
      data-ajax="<?php echo base_url('/teacher/ajax_get_data')?>"
      data-url="<?php echo base_url('/teacher/journal')?>">
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <div class="col-sm-8 col-xs-8">
                    <div class="m-display-type text-left">
                        <button data-sort='course' data-direction='0' class="btn btn-default" title="Сортувати по - курсу">
                            <span  class="glyphicon glyphicon-menu-hamburger"></span>
                        </button>
                        <button data-sort='groupe' data-direction='0' class="btn btn-default" title="Сортувати по - групі">
                            <span class="glyphicon glyphicon-modal-window"></span>
                        </button>
                        <button data-sort='subgroup' data-direction='0' class="btn btn-default" title="Сортувати по - підгрупі">
                            <span class="glyphicon glyphicon-list-alt"></span>
                        </button>
                        <button data-sort='fullname' data-direction='0' class="btn btn-default" title="Сортувати по - предмету">
                            <span class="glyphicon glyphicon-book"></span>
                        </button>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-4">
                    <div class="m-display-type text-right">
                        <button class="btn btn-default">
                            <span class="glyphicon glyphicon-th-large"></span>
                        </button>
                        <button class="btn btn-default">
                            <span class="glyphicon glyphicon-th-list"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="list-gt" class="col-sm-12 col-xs-12">
            </div>

            <script type="text/javascript">
                <?php echo 'var listGT = '.json_encode($list_gt, JSON_UNESCAPED_UNICODE).';'; ?>
                <?php
                    if ($_SESSION['settings'] != '')
                        echo 'var settings = '.$_SESSION['settings'].';';
                    else
                        echo 'var settings = {};';
                ?>
            </script>
        </div>
    </div>
</main>

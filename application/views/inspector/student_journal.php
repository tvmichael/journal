<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="inspector-main-student-journals">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo $student_name; ?>
                    </div>
                    <div class="panel-body">
                        <?php
                            $subject_count = 0;
                            foreach ($journal as $j){


                            echo "<h4><span class='label label-primary'>".
                                $j[0]['fullname'].
                                "</span> <span class='label label-default'>".
                                $j[0]['surname'].' '.$j[0]['name'].
                                '</span></h4>';
                            $th = '';
                            $td = '';
                            $sb = 0;
                            $k = 0;
                            foreach ($j as $val){
                                $d = explode('-', $val['date']);
                                $th = $th."<th class='text-center'>".$d[2].'<br><span style="color: gray; border-top: 1px solid gray;">'.$d[1].'</span></th>';
                                $td = $td."<td class='text-center'>".$val['mark'].'</td>';
                                if (intval($val['mark']) > 0 ){
                                    $sb = $sb +  intval($val['mark']);
                                    $k++;
                                }
                            };
                            if ($k != 0) { $sb = round($sb / $k, 1);}
                                else $sb = '';

                            $th = '<th style="width: 5%;">Дата</th><th style="width: 5%;">с.б.</th>'.$th;
                            $td = "<td>Оцінка</td><td class='danger'>".$sb.'</td>'.$td;
                        ?>
                        <div style='overflow-x:auto'>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="success">
                                    <?php echo $th; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php echo $td; ?>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <br>
                        <?php }; ?>

                        <?php

                        //d($subjects);
                        //d($journal);
                        $time_end = microtime(true) - $time;
                        //echo '<br>Time: '.round($time_end,6).'c.';
                        ?>
                    </div>
                </div>



            </div>
        </div>
    </div>
</main>

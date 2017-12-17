<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main data-name="inspector-main-groups">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo $group_name; ?>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="usr">Пошук:</label>
                            <input class="form-control" type="text" id="input-search-group" placeholder="Курс, група, підгрупа ...">
                        </div>

                        <pre>
                            <?php //print_r($group_table); ?>
                        </pre>

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 3%;">№</th>
                                <th>Курс</th>
                                <th>Група</th>
                                <th>Підгрупа</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach ($group_table as $s){
                                $href = base_url('inspector/student?action=openGroup&id=').$s['id'].
                                    "&groupName=".$s['course'].' '.$s['groupe'].' '.$s['subgroup'];
                                echo "<tr data-search='".$s['course'].' '.$s['groupe'].' '.$s['subgroup']."'>";
                                echo "<td>$i</td>";
                                echo "<td>".$s['course']."</td>";
                                echo "<td>".$s['groupe']."</td>";
                                echo "<td><a href='".$href."'>".$s['subgroup']."</a></td>";
                                echo "</tr>";
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
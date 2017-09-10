<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAIN --------------------------------------------------------------------------- -->
<main id="main-journal" class="m-main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-warning" role="alert">
                    <span class="text-danger">Якщо ви помітили неточність,</span>
                    або знайшли якусь помилку то залишіть повідомлення на цій сторніці.
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Повідомлення</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <textarea id="textarea-message" class="m-textarea-message"></textarea>
                            <p class="text-warning">Не більше 250 символів</p>
                            <div class="text-right">
                                <button id="send-message" <?php
                                echo "data-user-id='".$_SESSION['id']."'";
                                echo "data-url='".base_url('teacher/message')."'";
                                ?>" class="btn btn-default">
                                    Надіслати
                                </button>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h5>Ваші повідомлення</h5>
                            <hr>
                            <div id="list-message" class="m-list-message">
                                <?php
                                foreach ($message as $m){
                                    if($m['direction']==1)$c = 'bg-warning'; // вчитель
                                    if($m['direction']==2)$c = 'bg-success'; // адміністратор

                                    echo "<div class='$c m-message-text'>";
                                    echo 'Дата: <b>'.$m['date'].'</b><br>';
                                    echo $m['message'];
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

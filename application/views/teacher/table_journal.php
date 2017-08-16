<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if( $error > 0 ){
    echo "<p class='text-danger'>&nbsp; $error. Виберіть групу і предмет!</p>";
    exit();
}


/*
// створюємо масив окремих дат
$arr_date = array();
foreach ($journal as $key => $value) { $arr_date[$key] = $value->date; }
$arr_date = array_unique($arr_date);

/*
//--------------------------
// формуємо заголовок таблиці
$h_th = "<th>Прізвище, І'мя, по батькові</th>";
foreach ($arr_date as $v_date) {
    // заносимо в заголовок усі внесені дати по = викладачу-предмету-групі
    $h_th = $h_th."<th data-date='".$v_date."'>".date("d.m", strtotime($v_date))."</th>";
}

//----------------------
// формуємо тіло таблиці
$b_td ='';
foreach ($students as $ks => $vs) {
    $b_td = $b_td."<tr data-student-id='".$vs->id."'>";
    // вивоимо прізвище-імя-студента (перший стовбчик)
    $b_td = $b_td."<td>".$vs->surname.' '.$vs->name.' '.$vs->patronymic."</td>";
    // створюємо клітинки та виводимо оцінки для даного студента
    foreach ($arr_date as $v_date) {
        $s_mark = '';
        foreach ($journal as $kj => $vj) {
            if ( ($v_date == $vj->date) AND ($vs->id == $vj->id_student) ){
                $s_mark = $vj->mark;
            }
        }
        $b_td = $b_td."<td data-td-date='$v_date'>$s_mark</td>";
    } // end
    $b_td = $b_td."</tr>";
}
/**/
?>

<!-- JOURNAL TABLE -->
<thead <?php //echo "data-teacher-id='$id_teacher' data-group-id='$id_group' data-subject-id='$id_subject'";?> >
<tr>
    <td>
    <?php
    //echo $h_th;
    print_r($students);
    //print_r($journal);

    ?>
    </td>
</tr>
</thead>
<tbody>
    <?php //echo $b_td; ?>
</tbody>
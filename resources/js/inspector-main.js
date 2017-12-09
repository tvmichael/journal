function l(s) { console.log(s)} l('Inspector start!');

// сторніка
var namePage = document.getElementsByTagName('main')[0].getAttribute("data-name");


// якщо головна сторніка - список викладачів
if(namePage == 'inspector-main') {
    // Пошук викладача за прізвищем
    $('#input-search-teacher').keyup(function () {
        var filter, table, tbody, tr, td, i;
        filter = $(this).val();
        table = document.getElementsByTagName('table')[0];
        tbody = table.getElementsByTagName('tbody')[0];
        tr = tbody.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toLowerCase().indexOf(filter.toLowerCase()) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });

    // сортування таблиці 1) https://www.w3schools.com/howto/howto_js_sort_table.asp   2) https://codereview.stackexchange.com/questions/37632/sorting-an-html-table-with-javascript
    $('.m-sort-table').click(function (e) {
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementsByTagName('TABLE')[0];
            switching = true;
            //Set the sorting direction to ascending:
            dir = "desc";
            /*Make a loop that will continue until no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.getElementsByTagName("TR");
                /*Loop through all table rows (except the first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare, one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];

                    if( x.getElementsByTagName('div')[0].innerHTML != '' )
                        x = parseInt(x.getElementsByTagName('div')[0].innerHTML);
                    else x = 0;
                    if( y.getElementsByTagName('div')[0].innerHTML != '' )
                        y = parseInt(y.getElementsByTagName('div')[0].innerHTML);
                    else y = 0;

                    /*check if the two rows should switch place, based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if ( x > y ) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if ( x < y ) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount ++;
                } else {
                    /*If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        } // end function
        sortTable(e.target.parentNode.cellIndex);
    })
}


// якщо сторінка викладача - з переліком предметів і груп
if(namePage == 'inspector-teacher') {
    // Пошук
    $('#input-search').keyup(function () {
        var filter, table, tbody, tr, td, i;
        filter = $(this).val();
        table = document.getElementsByTagName('table')[0];
        tbody = table.getElementsByTagName('tbody')[0];
        tr = tbody.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getAttribute('data-search');
            if (td.toLowerCase().indexOf(filter.toLowerCase()) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    });
}


// якщо сторінка журналу для конкретного викладача
if(namePage == 'inspector-teacher-journal') {

    // показати усі оцінки
    $('table tbody tr').each(function () {
        var td = this.getElementsByTagName('td'),
            n = td.length,
            i, j,
            nb = 0, // пропусків (н)
            k = 0,  //
            sb = 0, // середній бал
            litsmark,
            markArr,
            lArr;

        for (i = 4; i < n; i++ ){
            if (td[i].innerText == 'н') nb++;
            else {
                if (td[i].innerText != ''){
                    sb = sb + parseInt(td[i].innerText);
                    k++;
                }
            }
            litsmark = td[i].getAttribute('data-remark');

            markArr = '';
            lArr = litsmark.split(" ");
            for(j = 1; j < lArr.length; j++){
                lArr[j] = lArr[j].split("|");
                markArr = markArr + lArr[j][0]+'<br>';
            }
            // l(markArr);

            litsmark = litsmark.replace(/ /g, '<br>');
            litsmark = litsmark.replace(/\|/g, ' → ');
            var titleStr = "<div class='m-remark-tooltip'>"+litsmark+"</div>";
            td[i].innerHTML = '<div data-toggle="tooltip" data-placement="left" title="' + titleStr + '">' +
                td[i].innerText +
                '<div class="m-remark">' + markArr + '</div></div>';

        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip({'html':true});
        });

        if (k != 0 )
            td[2].innerHTML = (sb/k).toFixed(1);
        if (nb != 0)
            td[3].innerHTML = nb;
    });
    l('inspector-teacher-journal');
}



// якщо сторінка студентів
if(namePage == 'inspector-main-students') {
    // Пошук студента за прізвищем
    $('#input-search-student').keyup(function () {
        var filter, table, tbody, tr, td, i;
        filter = $(this).val();
        table = document.getElementsByTagName('table')[0];
        tbody = table.getElementsByTagName('tbody')[0];
        tr = tbody.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getAttribute('data-search');
            if (td.toLowerCase().indexOf(filter.toLowerCase()) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    });
}

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
}


// якщо сторінка викладача - з переліком предметів і груп
if(namePage == 'inspector-teacher') {
    // Пошук викладача за прізвищем
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

    $('table tbody tr').each(function () {

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

function l(s) { console.log(s)} l('Inspector start!');

//
var namePage = document.getElementsByTagName('main')[0].getAttribute("data-name");

//
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

//
if(namePage == 'inspector-teacher-journal') {

    $('table tbody tr').each(function () {
        
    });
    
    l('inspector-teacher-journal');
}
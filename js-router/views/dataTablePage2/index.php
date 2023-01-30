<!-- <!DOCTYPE html> -->
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
		<!-- CSS only -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">		
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <!-- datatable export button -->
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="http://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script> 



		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <title>
  </title>
</head>
<table id="tableObj" class="display" style="width:100%">
    <thead>
        <tr>
            <th>姓名</th>
            <th>職位</th>
            <th>薪資</th>
            <th>開始工作日</th>
            <th>辦公室</th>
            <th>分機</th>
        </tr>
    </thead>
</table>

<button onclick = 'search()'>CLICK</button>
<script>
    window.search = function() {
        console.log(2123);
        dataTable.column(0).search('^approval$', true, false).draw();
    }
    var dataTable;
    $(document).ready( function () {
        var data = [
                    {
                        "name":       "Disapproval",
                        "position":   "Director",
                        "salary":     "$5,300",
                        "start_date": "2011/07/25",
                        "office":     "Edinburgh",
                        "extn":       "8422"
                    },
                    {
                        "name":       "approval",
                        "position":   "Director",
                        "salary":     "$5,300",
                        "start_date": "2011/07/25",
                        "office":     "Edinburgh",
                        "extn":       "8422"
                    },
                    {
                        "name":       "Tiger Nixon",
                        "position":   "System Architect",
                        "salary":     "$3,120",
                        "start_date": "2011/04/25",
                        "office":     "Edinburgh",
                        "extn":       "5421"
                    },
                    {
                        "name":       "Tiger",
                        "position":   "Director",
                        "salary":     "$5,300",
                        "start_date": "2011/07/25",
                        "office":     "Edinburgh",
                        "extn":       "8422"
                    },
                    {
                        "name":       "Garrett Winters",
                        "position":   "Director",
                        "salary":     "$5,300",
                        "start_date": "2011/07/25",
                        "office":     "Edinburgh",
                        "extn":       "8422"
                    }
                ]

        dataTable = $('#tableObj').DataTable({
            "data": data,
            // "columns": [
            // { data: 'name',title: "姓名" },
            // { data: 'position',title: "職位" },
            // { data: 'salary',title: "薪資" },
            // { data: 'start_date',title: "開始工作日" },
            // { data: 'office',title: "辦公室" },
            // { data: 'extn',title: "分機" },
            // ]
            "columns": [
            { data: 'name' },
            { data: 'position' },
            { data: 'salary' },
            { data: 'start_date' },
            { data: 'office'},
            { data: 'extn'},
            ]
        })

    });
</script>
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
<body>
<div id='app'></div>
<!-- template TESTing -->

<br>
<br>
<div class="container first">
			<br />
			<h1 align="center" class="text-primary"><b>jQuery DataTable Jump to a Specific Page with PHP Ajax</b></h1>
			<br />
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-9">Customer Data</div>
						<div class="col-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Page</span>
								</div>
								<select name="pagelist" id="pagelist" class="form-control"></select>
								<div class="input-group-append">
									<span class="input-group-text">of&nbsp;<span id="totalpages"></span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">

						<table id="customer_table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>CourseID</th>

									<th>Title</th>
									<th>Credits</th>
									<th>DepartmentID</th>
									<th>CreatedON</th>
                  <th></th>
                  <th></th>

								</tr>
							</thead>
						</table>
						
					</div>
				</div>
			</div>
		</div>
    <br>
    <br>


    <!-- <button onClick = 'btn()'>123</button> -->
  </body>
<script type = 'module'>
  var dataTable ;
  function load_data(start, length)
  {
		  dataTable = $('#customer_table').DataTable({
        processing : true,
        serverSide : true,
        order : [],
        retrieve: true,
        destroy: true,
        ajax : {
          url:"http://localhost:8888/MAMP/projects/jsrouter-phpapi-datatable/router.php/mysql/datatable",
          method:"POST",
          data:{start:start, length:length},
          // // 除錯用，若為了datatable正常顯示，需註解起來
          // success: function (response) {
          //   //這邊放 
          //   console.log(response);
          // },
          // error:function(err){
          //   console.log(err.responseText);
          // },
        },
        // IF type from data which API(from php) send is Object，必須加上這個
        columns: [ //列的標題一般是從DOM中讀取（你還可以使用這個屬性為表格創建列標題)
          { data: 'CourseID' },
          { data: 'Title'},
          { data: 'Credits' },
          { data: 'DepartmentID' },
          { data: 'CreatedON' },
          { 
            data: 'CourseID',
            render: function ( data, type, row ) {
              return '<!-- Button trigger modal --><button onClick = "triggerModal('+data+')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button>';
            }
          }
        ],
        columnDefs: [{ // 事後增加按鈕或值
                //   指定第四列，从0开始，0表示第一列，1表示第二列……
                "targets": 6,
                "render": function(data, type, row, meta) {
                    return '<input type="checkbox" name="checklist" />'
                }
            }],
        dom: 'lBfrtip',
        buttons: [
          {
            extend:'excelHtml5',
            autoFileter: true,
            sheetName: 'Export data',
            exportOptions: {
              columns: [0, 1, 2, 3, 4],
            }
          }
        ],
        drawCallback : function(settings){
          var page_info = dataTable.page.info();

          $('#totalpages').text(page_info.pages);

          var html = '';

          var start = 0;

          var length = page_info.length;

          console.log( page_info);
          for(var count = 1; count <= page_info.pages; count++)
          {
          	var page_number = count - 1;

          	html += '<option value="'+page_number+'" data-start="'+start+'" data-length="'+length+'">'+count+'</option>';

          	start = start + page_info.length;
          }

          $('#pagelist').html(html);

          $('#pagelist').val(page_info.page);
        },
       
        
      });
      
	}
  
  // window.btn = function()  {
  //   console.log(123);
  //   dataTable.column(2).search('2' ,true, false, false).draw(false);
  // }

	load_data();

  $('#pagelist').change(function(){

    var start = $('#pagelist').find(':selected').data('start');

    var length = $('#pagelist').find(':selected').data('length');

    load_data(start, length);

    var page_number = parseInt($('#pagelist').val());

    var test_table = $('#customer_table').dataTable();

    test_table.fnPageChange(page_number);

  });


  // click function需用window.[func] 定義
  window.triggerModal = function (courseId) {
    console.log(courseId);
  }

  
</script>
</html>








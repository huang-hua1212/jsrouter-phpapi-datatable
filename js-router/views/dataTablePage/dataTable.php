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
    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
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
    <div class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Modal body text goes here.</p>
            <label>CourseID: </label>
            <text class = 'courseid_text'></text>
            <br>
            <label>Credits</label>
            <input type = 'text' class = 'credits-edit' name = 'credits-name' value='123'>
          </div>
          <div class="modal-footer">
            <button type="button" class="save btn btn-primary" onclick = 'save()'>Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </body>









<script type = 'module'>
  var dataTable ;
  var globalData;
  function load_data(start, length)
  {
    console.log(start);
    console.log(length);

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
          dataSrc: function(json) {
            console.log(json);
            globalData = json.data;
            return json.data;
          },
          // // ?????????????????????datatable??????????????????????????????
          // success: function (response) {
          //   //????????? 
          //   console.log(response);
          // },
          // error:function(err){
          //   console.log(err.responseText);
          // },
        },
        // IF type from data which API(from php) send is Object?????????????????????
        columns: [ //????????????????????????DOM??????????????????????????????????????????????????????????????????)
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
        columnDefs: [{ // ????????????????????????
                //   ?????????????????????0?????????0??????????????????1?????????????????????
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
        
        rowCallback: function( row, data ) {
          // console.log(data);
        },
        drawCallback : function(settings){
          console.log(settings);
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


  // click function??????window.[func] ??????
  window.triggerModal = function (courseId) {
    $('.courseid_text').html(courseId);
    const currentObj = globalData.filter(it => 
      it.CourseID == courseId);
    $('input[name="credits-name"]').val(currentObj[0].Credits) ;
    $('.modal').modal('toggle');
  }

  window.save = function(e) {
    var formData = new FormData();
    formData.append('courseId', $('.courseid_text').html());
    formData.append('credits', $('input[name="credits-name"]').val());

    $.ajax({
        url: 'http://localhost:8888/MAMP/projects/jsrouter-phpapi-datatable/router.php/datatable_delete',           
        async: true,
        method: 'POST', 
        data: formData,
        cache: false,
        processData: false, // needed
        contentType: false, // needed
        success: function (data) {
          console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
        //   console.log(jqXHR);
          console.log(jqXHR.responseText);
            /*??????jqXHR???????????????*/
            // alert(jqXHR.responseText);
            // alert(jqXHR.status);
            // alert(jqXHR.readyState);
            // alert(jqXHR.statusText);
            // /*?????????????????????????????????*/
            // alert(textStatus);
            // alert(errorThrown);
        }
    });




    $('.modal').modal('hide');

    // page-reload-after-edit-keep-page-position
    dataTable.ajax.reload(null, false);
    //  change page: success
    // dataTable.ajax.reload();
    // dataTable.page( 2 ).draw( 'page' ); // ?????????








  }
</script>
</html>








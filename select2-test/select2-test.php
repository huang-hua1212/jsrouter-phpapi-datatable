<?php print_r($_POST);?>
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
  <title>
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
</head>
<body>
<div id='app'>

<select id="cluster" class="select2" multiple style = 'width: 300px'>
 
</select>
<div>
  <input type='radio' name='check' value='A'><label>AA</label>
  <input type='radio' name='check' value='B'><label>BB</label>
</div>
</div>


<select id="select_id" style="width: 200px">
<option value"1">Text 1</option>
<option value"2">Text 2</option>
<option value"3">Text 3</option>
</select>

<button id="referecedField">Change text of the selected option</button>
</body>
<script type = 'module'>


var n = 0;
$('#cluster').on('change', function(e, state) {
  console.log($(this).val());
  if(e.originalEvent === undefined) {
    // console.log(n);
      //  n++;
        console.log('trigger from code');
      
        // $("#cluster").find("option:selected").text('New_Text').trigger('change');
        // $("#cluster").find("option:selected").val('New_Text').trigger('change');
        // $("#cluster").find("option:selected").html('New_Text').trigger('change');
        $("#cluster").find("option:selected").text('New_Text');
        $("#cluster").find("option:selected").val('New_Text');
        $("#cluster").find("option:selected").html('New_Text');
        return ;
      }  
  // if(typeof state!=='undefined' && state) {
  //       console.log('trigger from code');
  //       $("#cluster").find("option:selected").text('New_Text').trigger('change');
  //       return ;
  //     }  
  // $("#cluster").find("option:selected").text('New_Text').trigger('change');
  // console.log('trigger from ui');
  
});
$('input[name="check"]').on('change', function(e) {
  var value = $('input[name="check"]:checked').val();
  var formData = new FormData();
  formData.append('checked', value);
  $.ajax({
    url: './option.php',
    method:'POST',
    contentType: false,
    processData: false,
    data: formData,
    success: function(result) {
      result = JSON.parse(result);
      var keys = Object.keys(result);
      // $('#cluster').val(null).trigger('change');
      $('#cluster').empty().trigger('change');

      for (let k of keys) {
        let k_= k;
        let v_ = result['k'];
        var option = new Option(k_, v_, false, false);
        $("#cluster").append(option).trigger('change');
      }
      $("#cluster").select2();





      // 2023/1/11
      // $("#cluster").select2().select2('destroy');
      // $('#cluster option[value="2"]').val('10').trigger('change');
      // $('#cluster option[value="2"]').val('10');
      // $('#cluster option[value="2"]').text('10');
      // $("#select_id").find("option[value='2']").text('New_Text');
      // var select = $("#cluster").select2();
      // select.select2('destroy');          
      //   $("#cluster").find("option:selected").text('New_Text');
      //   console.log($("#cluster").find("option:selected"));
      //   select.select2();

      // $('#cluster').trigger('change');
      // $("#cluster").select2().trigger('change');
      // $("#cluster").select2().select2();
      

    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
          /*弹出jqXHR对象的信息*/
          // alert(jqXHR.responseText);
          // alert(jqXHR.status);
          // alert(jqXHR.readyState);
          // alert(jqXHR.statusText);
          // /*弹出其他两个参数的信息*/
          // alert(textStatus);
          // alert(errorThrown);
      }

  })
});


    $("#cluster").select2();









    // 2023/1/11
    var select = $("#select_id").select2();
$('#select_id').select2();
 
$('#referecedField').on('click', function() {
      
      select.select2('destroy');          

        $("#select_id").find("option:selected").text('New_Text');
        select.select2();
 });
</script>
<?php
$dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
$connect = new PDO($dbconnect, 'root', 'root');
$query = "SELECT * FROM customer_table ";


$query1 = '';

$result = $connect->query($query);

$data = array();

foreach($result as $row)
{
    print_r($row);

	$sub_array = array();

	$sub_array[] = $row['customer_id'];

	$sub_array[] = $row['customer_first_name'];

	$sub_array[] = $row['customer_last_name'];

	$sub_array[] = $row['customer_email'];

	$sub_array[] = $row['customer_gender'];

	$data[] = $sub_array;
}

function count_all_data($connect)
{
	$query = "SELECT * FROM customer_table";

	$statement = $connect->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

$output = array(
	"data"		=>	$data
);



?>
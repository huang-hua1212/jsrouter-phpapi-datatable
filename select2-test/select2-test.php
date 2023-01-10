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
</body>
<script type = 'module'>

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
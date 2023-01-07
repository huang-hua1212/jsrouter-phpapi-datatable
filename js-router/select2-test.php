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
  <!-- <option value="1">jiesi-1</option>
  <option value="5">jiesi-8</option> -->
  <?php
 $user = 'root';
 $password = 'root';
 $db = 'test_db';
 $host = 'localhost';
 $port = 8889;
 $serverName ='localhost:8889';
 
 $link = mysqli_init();
 $success = mysqli_real_connect(
    $link,
    $host,
    $user,
    $password,
    $db,
    $port
 );
 $sql = 'select * from `test_db`.enrollment';
 $query = mysqli_query($link, $sql);
 $result = $query->fetch_all(MYSQLI_ASSOC);
 foreach($result as $key=> $value) {
    ?>
     <option value="<?= $value['EnrollmentID'] ?>"><?= $value['EnrollmentID']?></option>
     <?php
 }
?>
</select>

</div>
</body>
<script type = 'module'>


    $("#cluster").select2();
    </script>
<?php
// function getData() {
// //     $user = 'root';
// // $password = 'root';
// // $db = 'test_db';
// // $host = 'localhost';
// // $port = 8889;
// // $serverName ='localhost:8889';

// // $link = mysqli_init();
// // $success = mysqli_real_connect(
// //    $link,
// //    $host,
// //    $user,
// //    $password,
// //    $db,
// //    $port
// // );
// // $sql = 'select * from `test_db`.enrollment';
// // $query = mysqli_query($link, $sql);
// // $result = $query->fetch_all(MYSQLI_ASSOC);
// // foreach($result as $key=> $value) {
// //     $html.= "<option value='".$value['EnrollmentID']."' >".$value['EnrollmentID']."</option>";
// // }
// // return $html;
// }


// $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
// $dbgo = new PDO($dbconnect, 'root', 'root');
// // $sql = 'select * from Enrollment';
// $sql = 'SELECT * FROM customer_table ';

// $statement = $dbconnect->prepare($sql);
// $statement->execute();
// $number_filter_row = $statement->rowCount();

// $result = $connect->query($query . $query1);

// $data = array();

// // foreach($result as $row)
// // {
// // 	$sub_array = array();

// // 	$sub_array[] = $row['customer_id'];

// // 	$sub_array[] = $row['customer_first_name'];

// // 	$sub_array[] = $row['customer_last_name'];

// // 	$sub_array[] = $row['customer_email'];

// // 	$sub_array[] = $row['customer_gender'];

// // 	$data[] = $sub_array;
// // }
// // function count_all_data($connect)
// // {
// // 	$query = "SELECT * FROM customer_table";

// // 	$statement = $connect->prepare($query);

// // 	$statement->execute();

// // 	return $statement->rowCount();
// // }

// // $output = array(
// // 	"draw"		=>	intval($_POST["draw"]),
// // 	"recordsTotal"	=>	count_all_data($connect),
// // 	"recordsFiltered"	=>	$number_filter_row,
// // 	"data"		=>	$data
// // );



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
<?php

// Use this namespace
use Steampixel\Route;

// Include router class
include 'src/Steampixel/Route.php';

// Define a global basepath
// define('BASEPATH','/');
// define('BASEPATH','/MAMP/projects/simplePHPRouter/router.php/');
define('BASEPATH','/MAMP/projects/jsrouter-phpapi-datatable/router.php/');



// If your script lives in a subfolder you can use the following example
// Do not forget to edit the basepath in .htaccess if you are on apache
// define('BASEPATH','/api/v1');

// Lets define some slugs for automatic route and navigation generation
// See examples below
$slugs = ['article-1' => 'Article 1', 'article-2' => 'Article 2', 'article-3' => 'Article 3', 'article-4' => 'Article 4', 'article-5' => 'Article 5'];

// This function just renders a simple navigation
function navi() {
  global $slugs;
  $navi = '
  Navigation:
  <ul>
      <li><a href="'.BASEPATH.'">home</a></li>
      <li><a href="'.BASEPATH.'index.php">index.php</a></li>
      <li><a href="'.BASEPATH.'user/3/edit">edit user 3</a></li>
      <li><a href="'.BASEPATH.'foo/5/bar">foo 5 bar</a></li>
      <li><a href="'.BASEPATH.'foo/bar/foo/bar">long route example</a></li>
      <li><a href="'.BASEPATH.'contact-form">contact form</a></li>
      <li><a href="'.BASEPATH.'get-post-sample">get+post example</a></li>
      <li><a href="'.BASEPATH.'test.html">test.html</a></li>
      <li><a href="'.BASEPATH.'blog/how-to-use-include-example">How to push data to included files</a></li>
      <li><a href="'.BASEPATH.'phpinfo">PHP Info</a></li>
      <li><a href="'.BASEPATH.'äöü">Non english route: german</a></li>
      <li><a href="'.BASEPATH.'الرقص-العربي">Non english route: arabic</a></li>
      <li><a href="'.BASEPATH.'global/test123">Inject variables to local scope</a></li>
      <li><a href="'.BASEPATH.'return">Return instead of echo test</a></li>
      <li><a href="'.BASEPATH.'arrow/test123">Arrow function test (please enable this route first)</a></li>
      <li><a href="'.BASEPATH.'aTrailingSlashDoesNotMatter">aTrailingSlashDoesNotMatter</a></li>
      <li><a href="'.BASEPATH.'aTrailingSlashDoesNotMatter/">aTrailingSlashDoesNotMatter/</a></li>
      <li><a href="'.BASEPATH.'theCaseDoesNotMatter">theCaseDoesNotMatter</a></li>
      <li><a href="'.BASEPATH.'thecasedoesnotmatter">thecasedoesnotmatter</a></li>
      <li><a href="'.BASEPATH.'this-route-is-not-defined">404 Test</a></li>
      <li><a href="'.BASEPATH.'this-route-is-defined">405 Test</a></li>
      <li><a href="'.BASEPATH.'known-routes">known routes</a></li>';

      // Auto generate some entrys
      foreach($slugs as $slug => $entry) {
        $navi.= '<li><a href="'.BASEPATH.'my-blog-articles/'.$slug.'">'.$entry.' (auto generated)</a></li>';
      }

  $navi.= '</ul>';
  echo $navi;
}

// Add base route (startpage)
Route::add('/', function() {
  navi();
  echo 'Welcome :-)';
});

// Another base route example
Route::add('/index.php', function() {
  navi();
  echo 'You are not really on index.php ;-)';
});

// Simple test route that simulates static html file
Route::add('/test.html', function() {
  navi();
  echo 'Hello from test.html';
});

// This example shows how to include files and how to push data to them
// Hint: If you want to use this router for building websites with different nice looking HTML pages please visit https://github.com/steampixel/simplePHPPages
// There you will find a complete website example that bases on this router including themes, pages, layouts and content blocks.
Route::add('/blog/([a-z-0-9-]*)', function($slug) {
  navi();
  include('include-example.php');
});

// This route is for debugging only
// It simply prints out some php infos
// Do not use this route on production systems!
Route::add('/phpinfo', function() {
  navi();
  phpinfo();
});

// Get route example
Route::add('/contact-form', function() {
  navi();
  echo '<form method="post"><input type="text" name="test"><input type="submit" value="send"></form>';
}, 'get');

// Post route example
Route::add('/contact-form', function() {
  // navi();
  echo 'Hey! The form has been sent:<br>';
  print_r($_POST);

}, 'post');

// Get and Post route example
Route::add('/get-post-sample', function() {
  navi();
	echo 'You can GET this page and also POST this form back to it';
	echo '<form method="post"><input type="text" name="input"><input type="submit" value="send"></form>';
	if (isset($_POST['input'])) {
		echo 'I also received a POST with this data:<br>';
		print_r($_POST);
	}
}, ['get','post']);

// Route with regexp parameter
// Be aware that (.*) will match / (slash) too. For example: /user/foo/bar/edit
// Also users could inject SQL statements or other untrusted data if you use (.*)
// You should better use a saver expression like /user/([0-9]*)/edit or /user/([A-Za-z]*)/edit
Route::add('/user/(.*)/edit', function($id) {
  navi();
  echo 'Edit user with id '.$id.'<br>';
});

// Accept only numbers as parameter. Other characters will result in a 404 error
Route::add('/foo/([0-9]*)/bar', function($var1) {
  navi();
  echo $var1.' is a great number!';
});

// Crazy route with parameters
Route::add('/(.*)/(.*)/(.*)/(.*)', function($var1,$var2,$var3,$var4) {
  navi();
  echo 'This is the first match: '.$var1.' / '.$var2.' / '.$var3.' / '.$var4.'<br>';
});

// Long route example
// By default this route gets never triggered because the route before matches too
Route::add('/foo/bar/foo/bar', function() {
  echo 'This is the second match (This route should only work in multi match mode) <br>';
});

// Route with non english letters: german example
Route::add('/äöü', function() {
  navi();
  echo 'German example. Non english letters should work too <br>';
});

// Route with non english letters: arabic example
Route::add('/الرقص-العربي', function() {
  navi();
  echo 'Arabic example. Non english letters should work too <br>';
});

// Auto generate dynamic routes from a database or from another source
// For this example we will just use a predefined array
foreach($slugs as $slug => $entry) {
  Route::add('/my-blog-articles/'.$slug, function() use($entry) {
    navi();
      echo 'You are here: '.$entry;
  });
}

// Use variables from global scope
// You can use for example use() to inject variables to local scope
// You can use global to register the variable in local scope
$foo = 'foo';
$bar = 'bar';
Route::add('/global/([a-z-0-9-]*)', function($param) use($foo) {
  global $bar;
  navi();
  echo 'The param is '.$param.'<br/>';
  echo 'Foo is '.$foo.'<br/>';
  echo 'Bar is '.$bar.'<br/>';
});

// Return example
// Returned data gets printed
Route::add('/return', function() {
  navi();
  return 'This text gets returned by the add method';
});

// Arrow function example
// Note: You can use this example only if you are on PHP 7.4 or higher
// $bar = 'bar';
// Route::add('/arrow/([a-z-0-9-]*)', fn($foo) => navi().'This is a working arrow function example. <br/> Parameter: '.$foo. ' <br/> Variable from global scope: '.$bar );

// Trailing slash example
Route::add('/aTrailingSlashDoesNotMatter', function() {
  navi();
  echo 'a trailing slash does not matter<br>';
});

// Case example
Route::add('/theCaseDoesNotMatter',function() {
  navi();
  echo 'the case does not matter<br>';
});

// 405 test
Route::add('/this-route-is-defined', function() {
  navi();
  echo 'You need to patch this route to see this content';
}, 'patch');

// Add a 404 not found route
Route::pathNotFound(function($path) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 404 Not Found');
  navi();
  echo 'Error 404 :-(<br>';
  echo 'The requested path "'.$path.'" was not found!';
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method) {
  // Do not forget to send a status header back to the client
  // The router will not send any headers by default
  // So you will have the full flexibility to handle this case
  header('HTTP/1.0 405 Method Not Allowed');
  navi();
  echo 'Error 405 :-(<br>';
  echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
});

// Return all known routes
Route::add('/known-routes', function() {
  navi();
  $routes = Route::getAll();
  echo '<ul>';
  foreach($routes as $route) {
    echo '<li>'.$route['expression'].' ('.$route['method'].')</li>';
  }
  echo '</ul>';
});


// datatable
Route::add('/mysql/datatable', function() {
  try{
 //// PDO WITH MYSQL version1
 // $dbconnect = "mysql:host=localhost;dbname=test_db;port=8889";
 // $connect = new PDO($dbconnect, 'root', 'root');
 // $query = 'SELECT * from course';
 // $result = $connect->query($query);
 // // print_r($result); //此時不會顯示出值
 // $data = array();
 // foreach($result as $row)
 // {
 //     print_r($row); //此時才會顯示出值
 //   $sub_array = array();
 //   // $sub_array[] = $row['customer_id'];
 //   // $sub_array[] = $row['customer_first_name'];
 //   // $sub_array[] = $row['customer_last_name'];
 //   // $sub_array[] = $row['customer_email'];
 //   // $sub_array[] = $row['customer_gender'];
 //   $data[] = $sub_array;
 // }
 

 // mysqli version1
 $user = 'root';
 $password = 'root';
 $db = 'test_db';
 $host = 'localhost';
 $port = 8889;
 $link = mysqli_init();
 $success = mysqli_real_connect(
    $link,
    $host,
    $user,
    $password,
    $db,
    $port
 );
 $query = "SELECT * from course";
 $allCount = countAllTableDataRows($link, $query);
 if($_POST['length'] != -1)
 {
   $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
 }
   $res = mysqli_query( $link , $query);
   // if (!mysqli_query($link, $sql)) {
   //   die('Error: ' . mysqli_error($link));
   // }
   $rows = mysqli_fetch_all($res,MYSQLI_ASSOC);
   $n = 0;
   foreach($rows as &$row) {
     $row['id'] = $n;
     $n++;
   }

//     $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
// $conn =  new mysqli('localhost', 'root', 'root','test_tmp_tbl', '8889');
// $query = "SELECT * FROM customer_table ";
// $rs = $conn->query($query);
// $rows = $rs-> fetch_array();
// // fetch_assoc() //適合一個一個取
// // $rows = array();
// // while($row = $rs-> fetch_assoc()){
// //   $rows[] = $row;
// // }
  


   $res = array(
     "draw"		=>	intval($_POST["draw"]),
     "recordsTotal"	=>	$allCount,
     "recordsFiltered"	=>	$allCount, // 每次表現幾行
     'data'=> $rows,
   );


   // echo json_encode($rows);
   echo json_encode($res);

 }
 catch (Exception $e) {
   print($e);
 }
 



 // $connection = mysqli_connet($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_NAME, $DB_PORT);
 // $query = 'SELECT * from course';
 // // $result = mysqli_query($connection, $query);
 // // $data = mysqli_fetch_array($result);
 // // var_dump($data);
 // $result = $mysqli -> query($sql);
 // $result -> fetch_all(MYSQLI_ASSOC);
 // print_r($result);

}, ['get','post']);





Route::add('/mysql/data1', function() {
  //// PDO WITH MYSQL version1
  // $dbconnect = "mysql:host=localhost;dbname=test_db;port=8889";
  // $connect = new PDO($dbconnect, 'root', 'root');
  // $query = 'SELECT * from course';
  // $result = $connect->query($query);
  // // print_r($result); //此時不會顯示出值
  // $data = array();
  // foreach($result as $row)
  // {
  //     print_r($row); //此時才會顯示出值
  //   $sub_array = array();
  //   // $sub_array[] = $row['customer_id'];
  //   // $sub_array[] = $row['customer_first_name'];
  //   // $sub_array[] = $row['customer_last_name'];
  //   // $sub_array[] = $row['customer_email'];
  //   // $sub_array[] = $row['customer_gender'];
  //   $data[] = $sub_array;
  // }
  



  // mysqli_real_connect version1 fetch_all(MYSQL_ASSOC)+DATA_TABLE
  // $user = 'root';
  // $password = 'root';
  // $db = 'test_db';
  // $host = 'localhost';
  // $port = 8889;
  // $link = mysqli_init();
  // $success = mysqli_real_connect(
  //    $link,
  //    $host,
  //    $user,
  //    $password,
  //    $db,
  //    $port
  // );
  // $query = "SELECT * from course";
  // $allCount = countAllTableDataRows($link, $query);
  // // print($_POST['length']);
  // if($_POST['length'] != -1)
  // {
  //   $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
  // }
  // try{
  //   $res = mysqli_query( $link , $query);
  //   // if (!mysqli_query($link, $sql)) {
  //   //   die('Error: ' . mysqli_error($link));
  //   // }
  //   $rows = mysqli_fetch_all($res,MYSQLI_ASSOC);
  //   $n = 0;
  //   foreach($rows as &$row) {
  //     $row['id'] = $n;
  //     $n++;
  //   }
  //   $res = array(
  //     "draw"		=>	intval($_POST["draw"]),
  //     "recordsTotal"	=>	$allCount,
  //     "recordsFiltered"	=>	$allCount, // 每次表現幾行
  //     'data'=> $rows,
  //   );
  //   // echo json_encode($rows);
  //   echo json_encode($res);
  // }catch (Exception $e) {
  //   print($e);
  // }
  


  // mysqli_real_connect version2 fetch_all($res, MYSQLI_ASSOC)
  // $user = 'root';
  // $password = 'root';
  // $db = 'test_db';
  // $host = 'localhost';
  // $port = 8889;
  // $link = mysqli_init();
  // $success = mysqli_real_connect(
  //    $link,
  //    $host,
  //    $user,
  //    $password,
  //    $db,
  //    $port
  // );
  // $query = "SELECT * from course";
  // try{
  //   $res = mysqli_query( $link , $query);
  //   // if (!mysqli_query($link, $sql)) {
  //   //   die('Error: ' . mysqli_error($link));
  //   // }
  //   // $rows = array();
  //   $rows = mysqli_fetch_all($res,MYSQLI_ASSOC);
  //   echo json_encode($rows);
  // }catch (Exception $e) {
  //   print($e);
  // }



  // mysqli_real_connect version3 fetch_assoc($res)
  // $user = 'root';
  // $password = 'root';
  // $db = 'test_db';
  // $host = 'localhost';
  // $port = 8889;
  // $link = mysqli_init();
  // $success = mysqli_real_connect(
  //    $link,
  //    $host,
  //    $user,
  //    $password,
  //    $db,
  //    $port
  // );
  // $query = "SELECT * from course";
  // try{
  //   $res = mysqli_query( $link , $query);
  //   // if (!mysqli_query($link, $sql)) {
  //   //   die('Error: ' . mysqli_error($link));
  //   // }
  //   $rows = array();
  //   while($row = mysqli_fetch_assoc($res)) {
  //     // print_r($row);
  //     $rows[] = $row;
  //   }
  //   echo json_encode($rows);
  // }catch (Exception $e) {
  //   print($e);
  // }




  // new mysqli version4 $rs->fetch_all(MYSWL_ALL)
  // $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
  // $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
  // $query = "SELECT * FROM course ";
  // $rs = $conn->query($query);
  // $rows = $rs-> fetch_all(MYSQLI_ASSOC);
  // // fetch_assoc() //適合一個一個取
  // // $rows = array();
  // // while($row = $rs-> fetch_assoc()){
  // //   $rows[] = $row;
  // // }  
  // echo json_encode($rows);  



   // new mysqli version5 $rs->fetch_assoc()
   $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
   $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
   $query = "SELECT * FROM course ";
   $rs = $conn->query($query);
   //fetch_assoc() //適合一個一個取
   $rows = array();
   while($row = $rs-> fetch_assoc()){
     $rows[] = $row;
   }  
   echo json_encode($rows);  

 
}, ['get','post']);



Route::add('/mysql/ajax-formdata-test', function() {
  // echo json_encode(array());
  echo json_encode($_POST);
}, ['get','post']);


Route::add('/upload-single-image', function() {
   // echo json_encode($_FILES); 
  // echo json_encode($_FILES['fileInfo']); //  file info
  SaveBase64ToJpeg($_POST['base64'], './media/images/sample.png');
  echo json_encode($_POST['base64']); // BASE64
}, ['get','post']);


Route::add('/export-single-excel-version1', function() {
  $exportExcelData = ['article-1' => ['Article 1'], 'article-2' => ['Article 2'], 'article-3' => ['Article 3'], 
  'article-4' => ['Article 4'], 'article-5' => ['Article 5']];
  makeExportedExcelV1('test.xlsx', ['a'],  $exportExcelData);
}, ['get','post']);



Route::add('/export-single-excel-version2', function() {
  $exportExcelData = ['article-1' => ['Article 1'], 'article-2' => ['Article 2'], 'article-3' => ['Article 3'], 
  'article-4' => ['Article 4'], 'article-5' => ['Article 5']];
  makeExportedExcelV2($exportExcelData);
}, ['get','post']);



Route::add('/export-single-excel-version3', function() {
  $exportExcelData = ['article-1' => ['Article 1'], 'article-2' => ['Article 2'], 'article-3' => ['Article 3'], 
  'article-4' => ['Article 4'], 'article-5' => ['Article 5']];
  makeExportedExcelV3($exportExcelData);
}, ['get','post']);



Route::add('/export-excel-from-mysql', function() {
  
  makeExportExcelFromMysql();
}, ['get','post']);







Route::add('/upload-single-excel', function() {
  SaveBase64ToJpeg($_POST['base64'], './media/excel/csv/sample.csv');
  echo json_encode($_POST['base64']); // BASE64

}, ['get','post']);



Route::add('/read-single-excel', function() {
  // csvToArray("./media/excel/csv/sample.csv");
  echo json_encode(csvToArray("./media/excel/csv/sample.csv"));
}, ['get','post']);



Route::add('/read-single-docx', function() {
  // echo json_encode(csvToArray("./media/excel/csv/sample.csv"));
  $fileName = "./media/word/test.docx";
  echo readDocx($fileName);
}, ['get','post']);


Route::add('/export-single-csv', function() {
  makeCsv();
}, ['get','post']);


Route::add('/test__', function() {
  $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
   $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
   $query = "call course_procedure(); ";
   $rs = $conn->query($query);
   //fetch_assoc() //適合一個一個取
   $rows = array();
   while($row = $rs-> fetch_assoc()){
    print_r($row);
    //  $rows[] = $row;
   }  
}, ['get','post']);


Route::add('/call_insert_update_procedure', function() {
  // call course_insert_update_procedure(parameter1, parameter2......)
  /**
   *
    DROP PROCEDURE IF EXISTS `course_insert_update_procedure`;
    DELIMITER //
    CREATE PROCEDURE course_insert_update_procedure(var1 varchar(50),	var2 INT(10), var3 INT(10), var4 INT(10))
    BEGIN
    IF not EXISTS (SELECT * FROM course WHERE title = var1) then
      INSERT INTO course (CourseID, title, credits, DepartmentID, CreatedON) 
        SELECT 900, x.title, x.credits, x.DepartmentID, x.createdon
        FROM (SELECT var1 as title, var2 as credits, var3 as DepartmentID,  var4 as createdon
            ) as x;
    ELSE
        UPDATE `course`
        SET  CourseID = 900,title= var1, credits= var2, DepartmentID = var3, CreatedON = var4 
        WHERe title = var1;
    end if;
    END
   */
  $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
  $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
  $insertArray = [];
  array_push($insertArray, array('title'=> '888888', 'credits'=>'0', 'DepartmentID'=>'0', 'CreatedON'=>'0') );
  array_push($insertArray, array('title'=> '555555', 'credits'=>'100', 'DepartmentID'=>'100', 'CreatedON'=>'100') );
  foreach($insertArray as $arr) {
    $query = "call course_insert_update_procedure('".$arr['title']."', 
    '".$arr['credits']."', '".$arr['DepartmentID']."', '".$arr['CreatedON']."'); ";
    $rs = $conn->query($query);
  }
}, ['get','post']);




Route::add('/datatable_delete', function() {
  $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
  $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
  $sql = 'update course set credits = "'.$_POST['credits'].'" where courseid="'.$_POST['courseId'].'"';
  $rs = $conn->query($sql);
}, ['get','post']);




Route::add('/call_course_procedure_1', function() {
  // course_procedure_1()
  /**
      DROP PROCEDURE IF EXISTS `course_procedure_1`;
      DELIMITER //
      CREATE PROCEDURE `course_procedure_1`()
      BEGIN

      ALTER TABLE course_1 ENGINE = InnoDB;
      ALTER TABLE course ENGINE = InnoDB;


      start TRANSACTION;
      insert into course_1(CourseID, Title, Credits, DepartmentID, CreatedON)
      values(900, 'cccc', 0, 0, 0);
      insert into course(CourseID, Title, Credits, DepartmentID, CreatedON)
      values(900, 'cccc', 'cccc', 0, 0);


      commit;
      ALTER TABLE course_1 ENGINE = MyISAM;
      ALTER TABLE course ENGINE = MyISAM;

      END//
      DELIMITER ;
   */
  $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
  $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
  $sql = 'call course_procedure_1();';
  $rs = $conn->query($sql);
  if($rs == false) {
    print('失敗!!');
    $sqlc = 'ALTER TABLE course_1 ENGINE = MyISAM';
    $rs = $conn->query($sqlc);
    if($rs) {
      print('成功!!');
    }
    $sqlc = 'ALTER TABLE course ENGINE = MyISAM';
    $rs = $conn->query($sqlc);
    if($rs) {
      print('成功!!');
    }
  } else {
    print('成功!!!');
  }
}, ['get','post']);





function countAllTableDataRows($link, $query) {
  $res = mysqli_query( $link , $query);
  $rows = mysqli_fetch_all($res,MYSQLI_ASSOC);
  $count = count($rows); 
  return $count;

}

function SaveBase64ToJpeg($base64_string, $output_file) {
  // open the output file for writing
  $ifp = fopen( $output_file, 'wb' ); 

  // split the string on commas
  // $data[ 0 ] == "data:image/png;base64"
  // $data[ 1 ] == <actual base64 string>
  $data = explode( ',', $base64_string );

  // we could add validation here with ensuring count( $data ) > 1
  fwrite( $ifp, base64_decode( $data[ 1 ] ) );

  // clean up the file resource
  fclose( $ifp ); 
  return $output_file; 
}


function makeExportedExcelV1($excelFileName, $title, $data) {
    $str = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
    xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    </head>
    <body>';
    $str .='<table border=1 align=center cellpadding=0 cellspacing=0>';
    // 拼接標題行
    $str .= '<tr style="height:25px;font-size:13px;font-weight: bold;">';
    foreach ($title as $key => $val) {
        $str .= '<td>'.$val.'</td>';
    }
    $str .= '</tr>';
    // 拼接資料
    foreach ($data as $key => $val) {
        $str .= '<tr style="text-align: left;height:25px;font-size:13px;">';
        foreach ($val as $v) {
            if (is_numeric($v) && $v > 100000000) {
                $str .= "<td style='vnd.ms-excel.numberformat:@'>".$v."</td>";
            } elseif (is_numeric($v) && preg_match('/^[0-9]+(\.[0-9]{2})+$/', $v)) {
                // 是兩位小數的保留2位顯示
                $str .= "<td style='vnd.ms-excel.numberformat:0.00'>".$v."</td>";
            } elseif (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (0[0-9]|1[0-9]|2[0-4]):(0[0-9]|[1-5][0-9]):(0[0-9]|[1-5][0-9])$/', $v)) {
                // 是日期
                $str .= "<td style='vnd.ms-excel.numberformat:yyyy-mm-dd\ hh\:mm\:ss'>".$v."</td>";
            } else {
                $str .= "<td>".$v."</td>";
            }
        }
        $str .= "</tr>\n";
    }
    $str .= "</table></body></html>";
    // 實現檔案下載
    header("Content-Type: application/vnd.ms-excel; name='excel'");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $excelFileName);
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $str;

}

function makeExportedExcelV2($data) {
  $output .= '
   <table class="table" border="1">  
                    <tr>  
                         <th>A</th>  
                    </tr>
  ';
  foreach($data as $value){
    foreach($value as $val){
      $output .= '
        <tr>  
              <td>'. $val.'</td>  
        </tr>
      ';
    }
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;

}


function makeExportExcelFromMysql() {
   // new mysqli version5 $rs->fetch_assoc()
   $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
   $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
   $query = "SELECT * FROM course ";
   $rs = $conn->query($query);
   //fetch_assoc() //適合一個一個取
   $rows = array();
   while($row = $rs-> fetch_assoc()){
     $rows[] = $row;
   }  


  $output .= '
   <table class="table" border="1">  
                    <tr>  
                         <th>A</th>  
                    </tr>
  ';
  foreach( $rows as $key=>$val)
  {
   $output .= '<tr> ';
   foreach($val as $v){
    $output .= ' <td>'. $v.'</td> ';
   }
   $output .= '</tr> '; 
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;

}


function makeCsv() {
  header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=DevelopersData.csv');
	

  // new mysqli version5 $rs->fetch_assoc()
  $dbconnect = "mysql:host=localhost;dbname=test_tmp_tbl;port=8889";
  $conn =  new mysqli('localhost', 'root', 'root','test_db', '8889');
  $query = "SELECT * FROM course ";
  $rs = $conn->query($query);
  $output = fopen("php://output", "w");
  // $output = fopen("./media/excel/csv/output.csv", "w");
  fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

	fputcsv($output, array('Id','Name','Skills','Address', 'Designation'));
  //fetch_assoc() //適合一個一個取
  $rows = array();
  while($row = $rs-> fetch_assoc()){
    $rows[] = $row;
    fputcsv($output, $row);
  }  

	fclose($output);
}



function csvToArray($importPath) {
  $handle=fopen($importPath,"r");
  $data = array();
  while($row = fgetcsv($handle,10000,",")) {
    $data[] = $row;
    // print_r($row);
  }
  return $data;
}


function readDocx($filename){

    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return false;

    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) return false;

    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }
    zip_close($zip);      
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return $striped_content;
}







// Run the Router with the given Basepath
Route::run(BASEPATH);

// Enable case sensitive mode, trailing slashes and multi match mode by setting the params to true
// Route::run(BASEPATH, true, true, true);

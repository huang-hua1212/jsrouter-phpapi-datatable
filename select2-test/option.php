<?php
      $data = array();

  if($_POST['checked']=='A') {
    // return $_POST['checked'];
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
           $data[$value['EnrollmentID']] = $value['EnrollmentID'] ;
      }
  }else if($_POST['checked']=='B') {
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
    $N = 'A';
    foreach($result as $key=> $value) {
        $data[$N ] =  $N; 
      $N++;
    }

  }
  echo json_encode($data);
?>
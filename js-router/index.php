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
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <title>
  </title>
</head>
<body>
<div id='app'></div>
<!-- template TESTing -->
<template-test></template-test>

</body>
<script type = 'module'>
  // import RoutingRouter from '../lib/router/history-routing.js';
  import RoutingRouter from './lib/router/history-routing.js';
  
  window.customElements.define('template-test', RoutingRouter);

 
  // $.ajax({
  //       url: 'http://localhost:8888/MAMP/projects/simplePHPRouter/router.php/mysql/data1',            
  //       success: function (data) {
  //         // console.log(typeof data);

  //         console.log(data);
  //         // console.log(JSON.parse(data)[0]);
  //         // alert(data);
  //       },
  //       error: function (jqXHR, textStatus, errorThrown) {
  //         console.log(jqXHR);
  //           /*??????jqXHR???????????????*/
  //           // alert(jqXHR.responseText);
  //           // alert(jqXHR.status);
  //           // alert(jqXHR.readyState);
  //           // alert(jqXHR.statusText);
  //           // /*?????????????????????????????????*/
  //           // alert(textStatus);
  //           // alert(errorThrown);
  //       }
  //   });

  



  
</script>
</html>
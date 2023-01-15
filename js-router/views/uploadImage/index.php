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
<div class="container">
    <input type="file" id="file-uploader" data-target="file-uploader" accept="image/*"  multiple="multiple"/>
    
  </div>	

</body>
<script type = 'module'>
  $('#file-uploader').on('change', function(e) {
    if(e.target.files.length > 1) {
      alert('上傳檔案大於一件');
    } else {
      var files = e.target.files;
      var file = files[0];
      var fileReader = new FileReader();
      fileReader.addEventListener("load", function (e) {          //等fileReader.readAsDataURL讀完全部檔案後，才會進行fileReader.addEventListener之迴圈(巡迴)，並且this.result會依序更換(this.result為每個檔案)
          var sendedFile = fileReader.result;
          var data = {
            file: file,
          }
          var formData = new FormData();
          formData.append("fileInfo", file); // $_FILES
          formData.append("base64", sendedFile); // $_POST

          $.ajax({
            url: 'http://localhost:8888/MAMP/projects/jsrouter-phpapi-datatable/router.php/upload-single-image',
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
          });
      });
      fileReader.readAsDataURL(files[0]);
      
    
    }
   
  })



  
</script>
</html>
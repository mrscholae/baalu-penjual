<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <style type="text/css">
    a {
      padding-left: 5px;
      padding-right: 5px;
      margin-left: 5px;
      margin-right: 5px;
    }
    </style>
    
    <!-- Custom fonts for this template-->
    <link href="<?= base_url()?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url()?>assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?= base_url()?>assets/css/mystyle.css" rel="stylesheet">
    <script src="<?= base_url()?>assets/jquery/sweetalert2@9.js"></script>
    
  </head> 
  <body>
 
   <!-- Posts List -->
   <table border='1' width='100%' style='border-collapse: collapse;' id='postsList'>
     <thead>
      <tr>
        <th>S.no</th>
        <th>Title</th>
        <th>Content</th>
      </tr>
     </thead>
     <tbody></tbody>
   </table>
 
   <!-- Paginate -->
   <div style='margin-top: 10px;' id='pagination'></div>

   <!-- Script -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script type='text/javascript'>
   $(document).ready(function(){

     // Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       loadPagination(pageno);
     });

     loadPagination(0);

     // Load pagination
     function loadPagination(pagno){
       $.ajax({
         url: '<?=base_url()?>pengambilan/loadRecord/'+pagno,
         type: 'get',
         dataType: 'json',
         success: function(response){
            $('#pagination').html(response.pagination);
            createTable(response.result,response.row);
         }
       });
     }

     // Create table list
     function createTable(result,sno){
       sno = Number(sno);
       $('#postsList tbody').empty();
       for(index in result){
          var id = result[index].id;
          var nama_toko = result[index].nama_toko;
          var alamat = result[index].alamat;
          sno+=1;

          var tr = "<tr>";
          tr += "<td>"+ sno +"</td>";
          tr += "<td><a href='#' target='_blank' >"+ nama_toko +"</a></td>";
          tr += "<td>"+ alamat +"</td>";
          tr += "</tr>";
          $('#postsList tbody').append(tr);
 
        }
      }
    });
    </script>
  </body>
</html>
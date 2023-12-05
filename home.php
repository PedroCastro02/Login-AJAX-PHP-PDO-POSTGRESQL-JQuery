<?php
error_reporting(0);
?>
  
 <!doctype html>
 <html lang="en">
 
 <head>
   <title>Title</title>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
   <!-- Bootstrap CSS v5.2.1 -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
 
 </head>
 <style> 
  
  .container-control {
        height: 100vh;
        border: 2px solid white;
        margin-left: 14%;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container-controlMl4 {
        height: 100vh;
        border: 2px solid white;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }
 </style>
 <body>
 <?php include ('sidebar.php') ?>
  <div class="container-control">
      <img src="assets/imgs/MarmorariaTesteLogo.png" alt="">
  </div>
 </body>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
     integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
   </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
     integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
   </script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
   $(document).ready(function() {
        // Quando o checkbox com id "btn" é alterado
        $('#btn').change(function() {
            // Se o checkbox estiver marcado
            if ($(this).is(':checked')) {
                // Adiciona a classe .container-controlMl4 e remove a classe .container-control
                $('.container-control').removeClass('container-control').addClass('container-controlMl4');
            } else {
                // Adiciona a classe .container-control e remove a classe .container-controlMl4
                $('.container-controlMl4').removeClass('container-controlMl4').addClass('container-control');
            }
        });
    });
    </script>
 </html>
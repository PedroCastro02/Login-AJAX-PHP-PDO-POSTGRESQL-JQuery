<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<style>
    .container-control {
        height: 100vh;
        border: 2px solid white;
        margin-left: 14%;
    }
    .container-control2 {
        margin-top: 6.5%;
        margin-left: 3%;
        margin-right: 3%;
    }
    .box-search {
        display: flex;
        justify-content: space-around;
    }
    .filtrar {
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
    }
    .input-control {
        width: 65%;
        display: flex;
        justify-content: space-around;
    }
    .buttons {
        width: 40%;
    }
    .btn.btn-botao {
        background: #c73232; 
        color: white;
        font-weight: 400;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
    }
    
</style>
<body>
<?php include ('sidebar.php') ?>
    <div class="container-control">
        <div class="container-control2">
            <div class="box-search">
                <div class="input-control">
                    <input type="text" class="form-control w-50 filtrar" placeholder="Selecione um campo para filtrar">
                    <div class="buttons">
                        <button class="btn btn-botao">Buscar</button>
                        <button class="btn btn-botao">Limpar</button>
                    </div>
                </div>
                <div class="adicionar">
                    <button class="btn btn-botao" data-bs-toggle="modal" data-bs-target="#exampleModal">adicionar</button>
                </div>
                <!-- //? modal para adicionar funcionario  -->
                <!-- Vertically centered modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar novo funcionario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-botao">Save changes</button>
                        </div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
  </script>

</html>
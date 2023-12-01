<?php
require 'connection/connection.php';

$listaJoin = [];

$sqlJoin = $pdo->query('SELECT p.name, p.telephone, e."position", e.dt_hiring, e.balance_of_hours, e.id FROM employees e 
JOIN people p ON e.id_person = p.id');

if ($sqlJoin->rowCount() > 0) {
    $listaJoin = $sqlJoin->fetchAll(PDO::FETCH_ASSOC);
}

?>

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
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.7/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="assets/js/jQuery/jquery-3.5.1.min.js"></script>

</head>

<style>
    .container-control {
        height: 100vh;
        border: 2px solid white;
        margin-left: 14%;
        transition: all 0.3s ease;
    }
    .container-controlMl4 {
        height: 100vh;
        border: 2px solid white;
        margin-left: 1%;
        transition: all 0.3s ease;
    }
    .container-control2 {
        margin-top: 2%;
        margin-left: 3%;
        margin-right: 3%;
    }
    .container-control-table {
        margin-top: 6%;
        margin-left: 4%;
        margin-right: 4%;
    }
    .titulo {
        margin-top: 2%;
        text-align: center;
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
    .btn-secondary {
        font-weight: 400;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
    }
    
</style>
<body>
<?php include ('sidebar.php') ?>
    <div class="container-control">
        <div class="titulo"><h2>Funcionários</h2></div>
        <div class="container-control2">
            <div class="box-search">
                <div class="input-control">
                    <input type="search" class="form-control w-50 filtrar" id="filtrar" placeholder="Selecione um campo para filtrar">
                    <div class="buttons">
                        <button class="btn btn-botao">Buscar</button>
                        <button class="btn btn-botao" onclick="limparInput()">Limpar</button>
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
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-botao">Save changes</button>
                        </div>
                        </div>
                    </div>
                </div> 
                <!-- //? FIM modal -->
            </div>
        </div>
            <!-- //? Início tabela -->
            <table id="example" class="display" style="width:93%; margin-top:3%; padding: 10px; border-radius: 10px;
             box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Editar</th>
                        <th>Nome</th>
                        <th>Função</th>
                        <th>Telefone</th>
                        <th>Data Contratação</th>
                        <th>Banco de horas</th>
                        <th>Anexar documentos</th>
                        <th>Vizualizar Funcionário</th>
                        <th>Apagar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaJoin as $funcionariosJOIN): ?>
                    <tr>
                        <td><?= $funcionariosJOIN['id'];?></td>
                        <td><a href="editar.php?id=<?= $funcionariosJOIN['id'];?>"><i class="fas fa-solid fa-pen" style="color: #082b68; margin-left:30%;"></i></a></td>
                        <td><?= $funcionariosJOIN['name'];?></td>
                        <td><?= $funcionariosJOIN['position'];?></td>
                        <td><?= $funcionariosJOIN['telephone'];?></td>
                        <td><?= $funcionariosJOIN['dt_hiring'];?></td>
                        <td><?= $funcionariosJOIN['balance_of_hours'];?></td>
                        <td><a href="#"><i class="fas fa-paperclip" style="color: #2f89fc; margin-left:30%;"></i></a></td>
                        <td><a href="editar.php?id=<?= $funcionariosJOIN['id'];?>"><i class="fas fa-solid fa-eye" style="color: #000000; margin-left:30%;"></i></a></td>
                        <td><a href="excluir.php?id=<?= $funcionariosJOIN['id'];?>"><i class="fas fa-solid fa-trash" style="color: #b91818; margin-left:30%;"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
            </div>
</body>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
  </script>
  <script>
    $.fn.dataTable.ext.errMode = 'throw';
        $(document).ready(function() {
            $('#example').DataTable({
                pagingType: 'simple'
            });
        });

    function limparInput() {
        $('#filtrar').val('');
        return false;
    }
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
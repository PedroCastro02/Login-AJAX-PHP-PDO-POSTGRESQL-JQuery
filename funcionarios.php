<?php
include ('connection/connection.php');
include 'actions/FuncionariosAction.php';


$listaJoin = [];

$sqlJoin = $pdo->query("SELECT p.name, p.telephone, e.position, e.dt_hiring, e.balance_of_hours, e.id FROM employees e 
JOIN people p ON e.id_person = p.id");

if ($sqlJoin->rowCount() > 0) {
    $listaJoin = $sqlJoin->fetchAll(PDO::FETCH_ASSOC);
}
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT p.name, p.telephone, e.position, e.dt_hiring, e.balance_of_hours, e.id 
            FROM employees e 
            JOIN people p ON e.id_person = p.id
            WHERE e.id LIKE '%$data%' 
               OR p.name LIKE '%$data%' 
               OR p.telephone LIKE '%$data%' 
               OR e.position LIKE '%$data%' 
               OR e.balance_of_hours LIKE '%$data%' 
               OR e.dt_hiring LIKE '%$data%' 
            ORDER BY e.id DESC";
} else {
    
}

$ListaTurnos = [];
$sqlTurnos = $pdo->query('SELECT p.name FROM people p WHERE p.active = true');
if($sqlTurnos->rowCount() > 0){
    $ListaTurnos = $sqlTurnos->fetchAll(PDO::FETCH_ASSOC);
}
$ListaIdShift = [];
$sqlIdShifts = $pdo->query('SELECT * FROM shifts');
if($sqlIdShifts->rowCount() > 0){
    $ListaIdShift = $sqlIdShifts->fetchAll(PDO::FETCH_ASSOC);
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
    .custom-form-control {
        padding: 5px;
        border: 1px solid white;
    }

    .inputs {
        color:#000000;
        border-radius: 7px;
        padding: 5px;
        border: 1px solid #5C636A;
    }
    .red-asterisk {
        color: red;
    }
    .collapse {
         display: none;
    }
    #id {
        width: 75px;
        background-color: #DDDDDD;
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
                        <button class="btn btn-botao" onclick="searchData()">Buscar</button>
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
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar novo funcionario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                         <!-- //? conteudo  -->
                        <div class="modal-body">
                        <p>
                            <button class="btn btn-botao w-100" type="button" id="toggleButton">
                            <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i> Dados Do Funcionário <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i>
                            </button>
                        </p>
                        <!-- //? DADOS DO FUNCIONARIO collapse  -->
                            <div id="myCollapse1" class="collapse">
                                <div class="card card-body">
                                    <div class="dadosFuncionarios"> 
                                    <form action="funcionarios.php" method="POST">
                                        <div class="divDados1">
                                            <div class="Dados1Control d-flex">
                                                
                                                <div class="custom-form-control d-flex flex-column w-25">
                                                    <label for="id">Id</label>
                                                    <input class="inputs" type="number" name="id" id="id" readonly> 
                                                </div>
                                                <div class="custom-form-control d-flex flex-column  w-100">
                                                    <label for="id_person">Nome<span class="red-asterisk">*</span></label>
                                                    <select class="form-select"  class="inputs" aria-label="Default select example">
                                                        <option selected>Selecione o Nome</option>
                                                        <?php foreach ($ListaTurnos as $turnos): ?>
                                                            <option value="<?= $turnos['name']; ?>"> <?= $turnos['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column  w-100">
                                                    <label for="position">Cargo/Função<span class="red-asterisk">*</span></label>
                                                    <input  class="inputs" type="text" name="position" id="position" required>
                                                </div>
                                            </div>
                                            <div class="Dados1Control d-flex mt-2">
                                                
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="dt_hiring">Data Da Contratação<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="date" name="dt_hiring" id="dt_hiring" required>
                                                </div>
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="real_wage">Salário Real<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="number" name="real_wage" id="real_wage" required>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column w-50">
                                                    <label for="fiscal_wage">Salário fiscal<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="text" name="fiscal_wage" id="fiscal_wage" required>
                                                </div>
                                            </div>
                                            <div class="Dados1Control d-flex mt-2">
                                                    <div class="custom-form-control d-flex flex-column">
                                                        <label for="id_shift">Turnos<span class="red-asterisk">*</span></label>
                                                        <select class="form-select"  class="inputs" aria-label="Default select example">
                                                        <option selected>Selecione o Turnos</option>
                                                        <?php foreach ($ListaIdShift as $Shifts): ?>
                                                            <option value="<?= $Shifts['shift']; ?>"><?= $Shifts['shift']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    </div>
                                                </div>
                                        </div>
                                    </form>
                                    </div> 
                                </div>
                            </div>
                            <!-- //? FIM DO DADOS DO FUNCIONARIO collapse  -->
                            <!-- //? DADOS DO DEPENDENTE collapse  -->
                            <p>
                                <button class="btn btn-botao w-100" type="button" id="toggleButton2">
                                <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i> Dependentes <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i>
                                </button>
                            </p>
                            <div id="myCollapse2" class="collapse">
                                <div class="card card-body">
                                    <div class="dadosFuncionarios"> 
                                    <form action="funcionarios.php" method="POST">
                                        <div class="divDados1">
                                            <div class="Dados1Control d-flex">
                                                
                                                <div class="custom-form-control d-flex flex-column">
                                                    <label for="id">Id</label>
                                                    <input class="inputs" type="number" name="id" id="id" readonly> 
                                                </div>
                                                <div class="custom-form-control d-flex flex-column  w-100">
                                                    <label for="name">Nome<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="text" name="name" id="name" required>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column  w-100">
                                                    <label for="position">Relação<span class="red-asterisk">*</span></label>
                                                    <input  class="inputs" type="text" name="position" id="position" required>
                                                </div>
                                            </div>
                                            <div class="Dados1Control d-flex mt-2">
                                                
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="dt_birth">Data De Nascimento<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="date" name="dt_birth" id="dt_birth" required>
                                                </div>
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="name">Telefone<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="phone" name="Nome" id="name" required>
                                                </div>
                                                <div class="custom-form-control">
                                                    <button type="button" class="btn btn-botao">Remover Dependente</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                    </div> 
                                </div>
                            </div>
                            <!-- //? FIM DADOS DO DEPENDENTE collapse  -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-botao" onclick="saveFuncionarios()">Adicionar</button>
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
        $(document).ready(function(e) {
            
            $('#example').DataTable({
                pagingType: 'simple'
            });
        });
        function saveFuncionarios(){
        $.ajax ({
            type: 'POST',
            url : 'actions/FuncionariosAction.php',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'saveFuncionarios',
                id_person: id_person,
                dt_hiring: dt_hiring,
                fiscal_wage: fiscal_wage,
                real_wage: real_wage,
                position: position,
                id_shift: id_shift,
                balance_of_hours: balance_of_hours
            }),
            success: function(data) {
                console.log("success");
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr, textStatus, error);
            },
        }
    )}

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
    $(document).ready(function() {
            $('#toggleButton').on('click', function() {
                $('#myCollapse1').slideToggle();
            });
        });
    $(document).ready(function() {
        $('#toggleButton2').on('click', function() {
            $('#myCollapse2').slideToggle();
        });
    });
    
//! _______________________________________________________________
    let search = document.getElementById('filtrar');
    search.addEventListener("keydown", function(event){
        if (event.key === "Enter") {
            search.data();
        }
    });

    function searchData() {
        window.location = 'funcionarios.php?search='+search.value;
    }
//! _______________________________________________________
        

  </script>

</html>
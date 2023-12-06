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

$ListaUsers = [];
$sqlUsers = $pdo->query("SELECT u.id, u.email, u.username, pr.profile, p.name FROM users u
JOIN people p on p.id = u.id_person
JOIN profiles pr on u.id_profile = pr.id
WHERE p.active = true");
if($sqlUsers->rowCount() > 0){
    $ListaUsers = $sqlUsers->fetchAll(PDO::FETCH_ASSOC);
}
$ListaPeople = [];
$sqlPeople = $pdo->query('SELECT p.name, p.id FROM people p WHERE p.active = true');
if($sqlPeople->rowCount() > 0){
    $ListaPeople = $sqlPeople->fetchAll(PDO::FETCH_ASSOC);
}

$ListaProfile = [];
$sqlProfiles = $pdo->query('SELECT p.profile, p.id, u.id_profile FROM profiles p JOIN users u on p.id = u.id_profile');
if($sqlProfiles->rowCount() > 0){
    $ListaProfile = $sqlProfiles->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
    #successModal {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Um fundo semi-transparente para destacar o modal */
    }
    #ErrorModal {
        background: rgba(0, 0, 0, 0.5); 
    }
    #SuccessDelete {
        background: rgba(0, 0, 0, 0.5); 
    }
    .visivel {
        display: none;
    }
    .invisivel {

    }
    
   
</style>
<body>
<?php include ('sidebar.php') ?>
    <div class="container-control">
        <div class="titulo"><h2>Usuários</h2></div>
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Usuários</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                         <!-- //? conteudo  -->
                        <div class="modal-body">
                        <p>
                            <button class="btn btn-botao w-100" type="button" id="toggleButton">
                                <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i> Dados Pessoais <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i>
                            </button>
                        </p>
                        <!-- //? DADOS DOS USUARIOS collapse  -->
                            <div id="myCollapse1" class="collapse">
                                <div class="card card-body">
                                    <div class="dadosFuncionarios"> 
                                    <form method="POST">
                                        <div class="divDados1">
                                            <div class="Dados1Control d-flex">

                                                <div class="custom-form-control d-flex flex-column w-25">
                                                    <label for="id">Id</label>
                                                    <input class="inputs" type="number" name="id" id="id" readonly> 
                                                </div>
                                                <div class="custom-form-control d-flex flex-column  w-100">
                                                    <label for="id_person">Nome<span class="red-asterisk">*</span></label>
                                                    <select class="form-select"  class="inputs" aria-label="Default select example" id="id_person">
                                                        <option selected>Selecione o Nome</option>
                                                        <?php foreach ($ListaPeople as $people): ?>
                                                            <option value="<?= $people['id']; ?>"> <?= $people['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column  w-100">
                                                    <label for="username">Username<span class="red-asterisk">*</span></label>
                                                    <input  class="inputs" type="text" name="username" id="username" required>
                                                </div>
                                                <div class="custom-form-control d-flex flex-column  w-100">
                                                    <label for="id_person">Perfil<span class="red-asterisk">*</span></label>
                                                    <select class="form-select"  class="inputs" aria-label="Default select example" id="id_profile">
                                                        <option selected>Selecione o Perfil<span class="red-asterisk">*</span></option>
                                                        <?php foreach ($ListaProfile as $profile): ?>
                                                            <option value="<?= $profile['id_profile']; ?>"> <?= $profile['profile']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="Dados1Control d-flex mt-2">
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="email">Email<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="email" name="email" id="email" required>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column w-50">
                                                    <label for="password">Senha<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="password" name="password" id="password" required>
                                                </div>
                                                <div class="visibilidade" style="cursor: pointer; margin-top: 4.8%;">
                                                    <span class="material-symbols-outlined visivel">visibility</span>
                                                    <span class="material-symbols-outlined invisivel">visibility_off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div> 
                                </div>
                            </div>
                            <!-- //! FIM DO DADOS DO FUNCIONARIO collapse  -->

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-botao" onclick="saveUsuarios()">Adicionar</button>
                            </div>
                            <!-- //? MODAIS DE SUCESSO e FALHA -->
                            <div class="modal fade bd-example" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="successModal">
                                <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
                                    <div class="modal-content d-flex justify-content-center align-items-center flex-column" id="conteudo-sucesso-modal" style="height: 250px; width: 375px;">
                                    <div class="text-success text-center" style="font-size: 24px;">
                                        <i class="fas fa-check-circle fa-3x mb-4"></i>
                                        <br>
                                        Usuario Adicionado com Sucesso!
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade bd-example" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="ErrorModal">
                                <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
                                    <div class="modal-content d-flex justify-content-center align-items-center flex-column text-danger" id="conteudo-sucesso-modal" style="height: 250px; width: 375px;">
                                    <div class="text-center" style="font-size: 24px;">
                                        <i class="fas fa-times-circle fa-3x mb-4"></i>
                                        <br>
                                        Erro ao adicionar Funcionário.
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade bd-example" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="SuccessDelete">
                                <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
                                    <div class="modal-content d-flex justify-content-center align-items-center flex-column text-danger" id="conteudo-sucesso-modal" style="height: 250px; width: 375px;">
                                    <div class=" text-success text-center" style="font-size: 24px;">
                                        <i class="fas fa-check-circle fa-3x mb-4"></i>
                                        <br>
                                        Funcionário deletado com sucesso
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <!-- //! FIM MODAIS DE SUCESSO E FALHA -->

                        </div>
                </div> 
                <!-- //?! FIM modal -->
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
                        <th>Nome de Usuário</th>
                        <th>Perfil</th>
                        <th>E-mail</th>
                        <th>Apagar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ListaUsers as $usersJOIN): ?>
                        <tr>
                            <td><?= $usersJOIN['id'];?></td>
                            <td><a href="editar.php?id=<?= $usersJOIN['id'];?>"><i class="fas fa-solid fa-pen" style="color: #082b68; margin-left:30%;"></i></a></td>
                            <td><?= $usersJOIN['name'];?></td>
                            <td><?= $usersJOIN['username'];?></td>
                            <td><?= $usersJOIN['profile'];?></td>
                            <td><?= $usersJOIN['email'];?></td>
                            <td><span style="cursor: pointer;" onclick="deleteUsuario(<?= $usersJOIN['id'];?>)"><i class="fas fa-solid fa-trash" style="color: #b91818; margin-left:30%;"></i></span></td>
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

        function saveUsuarios(){
            var id_person = $('#id_person').val();
            var username = $('#username').val();
            var id_profile = $('#id_profile').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var id_company = 1;
        $.ajax ({
                type: 'POST',
                url : 'actions/UsuarioActions.php',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'saveUsuarios',
                    id_person: id_person,
                    username: username,
                    id_profile: id_profile,
                    email: email,
                    password: password,
                    id_company: id_company
                }),
                success: function(data) {
                    if(data === "Usuário cadastrado com sucesso!") {
                        $('#successModal').modal('show');
                    } else if (data === "Erro ao cadastrar usuário") {
                        $('#ErrorModal').modal('show');
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                    console.log("sucessos")
                },
                error: function(xhr, textStatus, error) {
                    console.log(xhr, textStatus, error);
                },
            }
        )}

        function deleteUsuario(id){
            var confirmDelete = window.confirm("Você tem certeza que deseja excluir este usuário?");
            if(confirmDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'actions/UsuarioActions.php',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        action: 'deleteUsuario',
                        id: id,
                    }),
                    success: function(data) {
                    //     $('#SuccessDelete').modal('show');
                    //     setTimeout(function() {
                    //     location.reload();
                    // }, 2000);
                    console.log("deletes");
                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr, textStatus, error);
                    },
                });
            }
        }
        
        
               

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
const visibility = document.querySelector('.visibilidade');
    let inputPassword = document.getElementById('password')

    visibility.addEventListener("click", function() {
        if (inputPassword.type === "password") {
            inputPassword.type = 'text';
            document.querySelector('.visivel').style.display = 'inline'; // Exibe o ícone de visibilidade
            document.querySelector('.invisivel').style.display = 'none';
        } else {
            inputPassword.type = 'password';
            document.querySelector('.visivel').style.display = 'none'; // Oculta o ícone de visibilidade
            document.querySelector('.invisivel').style.display = 'inline';
        }
    });
  </script>

</html>
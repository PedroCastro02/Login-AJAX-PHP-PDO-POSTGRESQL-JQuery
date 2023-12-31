<?php
include ('connection/connection.php');
include 'actions/FuncionariosAction.php';


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
} 

$ListaPeopleTela = [];
$sqlPeopleTela = $pdo->query('SELECT p.id, p.name, p.telephone, p.person_type, p.active FROM people p');

if ($sqlPeopleTela->rowCount() > 0) {
    $ListaPeopleTela = $sqlPeopleTela->fetchAll(PDO::FETCH_ASSOC);
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
    .btn.btn-status {
        background: #eee; 
        color: black;
        font-weight: 400;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        margin-left: 15px;
        margin-right: 15px;
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
    .ativo {
        color: #2fa83b !important; /* verde */
        font-weight: bolder !important;
        background-color: #a6eaad !important;
    }
    .inativo {
        color: red !important; /* vermelho */
        font-weight: bolder !important;
        background-color: #eac8c2 !important;
    }
    
   
</style>
<body>
<?php include ('sidebar.php') ?>
    <div class="container-control">
        <div class="titulo"><h2>Pessoas</h2></div>
        <div class="container-control2">
            <div class="box-search">
                <div class="input-control">
                    <input type="search" class="form-control w-50 filtrar" id="filtrar" placeholder="Selecione um campo para filtrar">
                    <label for="statusFilter"></label>
                        <select class="btn btn-status" id="statusFilter">
                            <option value="all" >Filtrar por status:</option>
                            <option value="ativo" >Ativo</option>
                            <option value="inativo" >Inativo</option>
                        </select>
                    <div class="buttons">
                        <button class="btn btn-botao" onclick="searchData()">Buscar</button>
                        <button class="btn btn-botao" onclick="limparInput()">Limpar</button>
                    </div>
                </div>
                <div class="adicionar">
                    <button class="btn btn-botao" data-bs-toggle="modal" data-bs-target="#exampleModal">adicionar</button>
                </div>
                <!-- //? modal para adicionar CADASTRAR PESSOAS -->
                <!-- Vertically centered modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar Pessoas</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                         <!-- //? conteudo  -->
                        <div class="modal-body">
                        <p>
                            <button class="btn btn-botao w-100" type="button" id="toggleButtonDadosPessoais">
                                <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i> Dados Pessoais <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i>
                            </button>
                        </p>
                        <!-- //? DADOS PESSOAIS collapse  -->
                            <div id="myCollapseDadosPessoais" class="collapse">
                                <div class="card card-body">
                                    <div class="dadosFuncionarios"> 
                                    <form method="POST">
                                        <div class="divDados1">
                                            <div class="Dados1Control d-flex">
                                                
                                                <div class="custom-form-control d-flex flex-column w-25">
                                                    <label for="id">Id</label>
                                                    <input class="inputs" type="number" name="id" id="id" readonly> 
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column  w-100">
                                                    <label for="name">Nome<span class="red-asterisk">*</span></label>
                                                    <input  class="inputs" type="text" name="name" id="name" required>
                                                </div>
                                                <div class="custom-form-control d-flex flex-column  w-25">
                                                    <label for="person_type">Tipo Pessoa<span class="red-asterisk">*</span></label>
                                                    <select class="form-select"  class="inputs" aria-label="Default select example" id="person_type" name="person_type">
                                                            <option value="PF"> PF </option>
                                                            <option value="PJ"> PJ </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="Dados1Control d-flex mt-2">
                                                
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="document">Documento<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="number" name="document" id="document" required>
                                                </div>
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="telephone">Telefone<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="phone" name="telephone" id="telephone" required>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column w-50">
                                                    <label for="dt_birth">Data Nascimento<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="date" name="dt_birth" id="dt_birth" required>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div> 
                                </div>
                            </div>
                            <!-- //! FIM DO DADOS PESSOAIS collapse  -->
                            <!-- //? DADOS DE ENDEREÇOS collapse  -->
                            <p>
                                <button class="btn btn-botao w-100" type="button" id="toggleButtonEnderencos">
                                <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i> Endereços <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i>
                                </button>
                            </p>
                            <div id="myCollapseEnderecos" class="collapse">
                                <div class="card card-body">
                                    <div class="dadosFuncionarios"> 
                                    <form action="funcionarios.php" method="POST">
                                        <div class="divDados1">
                                            <div class="Dados1Control d-flex">
                                                
                                                <div class="custom-form-control d-flex flex-column">
                                                    <label for="id">Id</label>
                                                    <input class="inputs" type="number" name="id" id="id" readonly> 
                                                </div>
                                                <div class="custom-form-control d-flex flex-column w-25">
                                                    <label for="zip_code">CEP<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="text" name="zip_code" id="zip_code" required>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column  w-25">
                                                    <label for="street">Rua<span class="red-asterisk">*</span></label>
                                                    <input  class="inputs" type="text" name="street" id="street" required>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column  w-25">
                                                    <label for="number">Número<span class="red-asterisk">*</span></label>
                                                    <input  class="inputs" type="text" name="number" id="number" required>
                                                </div>
                                                <div class="custom-form-control  d-flex flex-column  w-25">
                                                    <label for="district">Bairro<span class="red-asterisk">*</span></label>
                                                    <input  class="inputs" type="text" name="district" id="district" required>
                                                </div>
                                            </div>
                                            <div class="Dados1Control d-flex mt-2">
                                                
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="complement">Complemento<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="text" name="complement" id="complement" required>
                                                </div>
                                                <div class="custom-form-control d-flex flex-column w-50">
                                                    <label for="city">Cidade<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="phone" name="city" id="city" required>
                                                </div>
                                                <div class="custom-form-control d-flex flex-column  w-25">
                                                    <label for="state">Tipo Pessoa<span class="red-asterisk">*</span></label>
                                                    <select class="form-select"  class="inputs" aria-label="Default select example" id="state" name="state">
                                                            <option value="AC">AC</option>
                                                            <option value="AL">AL</option>
                                                            <option value="AP">AP</option>
                                                            <option value="AM">AM</option>
                                                            <option value="BA">BA</option>
                                                            <option value="CE">CE</option>
                                                            <option value="DF">DF</option>
                                                            <option value="ES">ES</option>
                                                            <option value="GO">GO</option>
                                                            <option value="MA">MA</option>
                                                            <option value="MT">MT</option>
                                                            <option value="MS">MS</option>
                                                            <option value="MG">MG</option>
                                                            <option value="PA">PA</option>
                                                            <option value="PB">PB</option>
                                                            <option value="PR">PR</option>
                                                            <option value="PE">PE</option>
                                                            <option value="PI">PI</option>
                                                            <option value="RJ">RJ</option>
                                                            <option value="RN">RN</option>
                                                            <option value="RS">RS</option>
                                                            <option value="RO">RO</option>
                                                            <option value="RR">RR</option>
                                                            <option value="SC">SC</option>
                                                            <option value="SP">SP</option>
                                                            <option value="SE">SE</option>
                                                            <option value="TO">TO</option>
                                                    </select>
                                                </div>
                                                <div class="custom-form-control">
                                                    <button type="button" class="btn btn-botao">Remover Endereço</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                    </div> 
                                </div>
                            </div>
                            <!-- //! FIM DADOS DE ENDEREÇOS collapse  -->
                            <!-- //? DADOS DE EMAIL collapse  -->
                            <p>
                                <button class="btn btn-botao w-100" type="button" id="toggleButtonEmails">
                                <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i> Emails <i class="fas fa-solid fa-arrow-down" style="color: #000000;"></i>
                                </button>
                            </p>
                            <div id="myCollapseEmails" class="collapse">
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
                                                    <label for="email">Email<span class="red-asterisk">*</span></label>
                                                    <input class="inputs" type="email" name="email" id="email" required>
                                                </div>  
                                                <div class="custom-form-control">
                                                    <button type="button" class="btn btn-botao">Remover Email</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div> 
                                </div>
                            </div>
                            <!-- //! FIM DADOS DE EMAIL collapse  -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-botao" onclick="savePessoas()">Adicionar</button>
                            </div>
                            <!-- //? MODAIS DE SUCESSO e FALHA -->
                            <div class="modal fade bd-example" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="successModal">
                                <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
                                    <div class="modal-content d-flex justify-content-center align-items-center flex-column" id="conteudo-sucesso-modal" style="height: 250px; width: 375px;">
                                    <div class="text-success text-center" style="font-size: 24px;">
                                        <i class="fas fa-check-circle fa-3x mb-4"></i>
                                        <br>
                                        Funcionário Adicionado com Sucesso!
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
                        <th>Telefone</th>
                        <th>Tipo Pessoa</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($ListaPeopleTela as $Peoples): ?>
                    <?php
                        $statusClass = $Peoples['active'] ? 'ativo' : 'inativo';
                    ?>
                    <tr class="active-row <?= $statusClass; ?>" data-status="<?= $statusClass; ?>">
                        <td><?= $Peoples['id']; ?></td>
                        <td><a href="editar.php?id=<?= $Peoples['id']; ?>"><i class="fas fa-solid fa-pen" style="color: #082b68; margin-left:30%;"></i></a></td>
                        <td><?= $Peoples['name']; ?></td>
                        <td><?= $Peoples['telephone']; ?></td>
                        <td><?= $Peoples['person_type']; ?></td>
                        <td><?= $Peoples['active'] ? 'Ativo' : 'Inativo'; ?></td>
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
        function savePessoas(){
            var name = $('#name').val();
            var person_type = $('#person_type').val();
            var document = $('#document').val();
            var telephone = $('#telephone').val();
            var dt_birth = $('#dt_birth').val();
            var zip_code = $('#zip_code').val();
            var street = $('#street').val();
            var number = $('#number').val();
            var district = $('#district').val();
            var complement = $('#complement').val();
            var city = $('#city').val();
            var state = $('#state').val();
            var email = $('#email').val();
            var id_company = 1;
        $.ajax ({
                type: 'POST',
                url : 'actions/PessoasAction.php',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'savePessoas',
                    name: name,
                    document: document,
                    telephone: telephone,
                    person_type: person_type,
                    dt_birth: dt_birth,
                    zip_code: zip_code,
                    street: street,
                    number: number,
                    district: district,
                    complement: complement,
                    city: city,
                    state: state,
                    email: email,
                    id_company: id_company
                }),
                success: function(data) {
                    console.log(data);
                    // if(data === "Funcionário adicionado com sucesso!!") {
                    //     $('#successModal').modal('show');
                    // } else if (data === "Erro ao adicionar funcionário") {
                    //     $('#ErrorModal').modal('show');
                    // }
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 2000);
                },
                error: function(xhr, textStatus, error) {
                    console.log(xhr, textStatus, error);
                },
            }
        )}

        function deleteFuncionario(id){
            var confirmDelete = window.confirm("Você tem certeza que deseja excluir este funcionário?");
            if(confirmDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'actions/FuncionariosAction.php',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        action: 'deleteFuncionario',
                        id: id,
                    }),
                    success: function(data) {
                        $('#SuccessDelete').modal('show');
                        setTimeout(function() {
                        location.reload();
                    }, 1000);
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
            $('#toggleButtonDadosPessoais').on('click', function() {
                $('#myCollapseDadosPessoais').slideToggle();
            });
        });
    $(document).ready(function() {
        $('#toggleButtonEnderencos').on('click', function() {
            $('#myCollapseEnderecos').slideToggle();
        });
    });
    $(document).ready(function() {
            $('#toggleButtonEmails').on('click', function() {
                $('#myCollapseEmails').slideToggle();
            });
        });

    $(document).ready(function () {
        $("#statusFilter").change(function () {
            var selectedStatus = $(this).val();

            if (selectedStatus === "all") {
                $(".active-row").show();
            } else {
                $(".active-row").hide();
                $(".active-row[data-status='" + selectedStatus + "']").show();
            }
        });
    });
    


  </script>

</html>
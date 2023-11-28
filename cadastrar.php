<?php

    include ('connection/connection.php');
    include 'actions/UsuarioDAOPgSQL.php';

    $usuarioDao = new UsuarioDAOPgSQL($pdo);

    $listaCompanies = [];
    $sql = $pdo->query('SELECT * FROM companies');
    if($sql->rowCount() > 0){
        $listaCompanies = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    $ListaProfile = [];
    $sql = $pdo->query('SELECT * FROM profiles');
    if($sql->rowCount() > 0){
        $ListaProfile = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    $ListaPerson = [];
    $sql = $pdo->query('SELECT * FROM people');
    if($sql->rowCount() > 0){
        $ListaPerson = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Document</title>
</head>
<style>
    .container-login {
        height: 100vh;
        background-color: #c7c7c7;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .central-login {
        background-color: white;
        text-align: center;
        width: 450px;
        padding: 30px 0px;
        border-radius: 20px;
    }
    .cotrol-input {
        text-align: start;
        display: flex;
        flex-direction: column;
        margin-left: 20px;
        margin-right: 20px;
        margin-top: 20px;
    }
    .options {
        margin-top: 10px;
        margin-left: 30px;
        margin-right: 30px;
        display: flex;
        justify-content: space-between;
    }
    .visivel {
        visibility: hidden;
    }
    .control-voltar {
        display: flex;
        align-items: center;
        justify-content:flex-start;
        margin-left: 20px;
        margin-bottom: -35px;
    }

</style>
<body>
    <div class="container-login">
        

        <div class="central-login">
            <div class="control-voltar">
                <a href="index.php"><span class="material-symbols-outlined">arrow_back_ios</span></a>
            </div>
            <div class="titulo">
            <h1>CADASTRO</h1>
            </div>
            <div class="alert alert-success d-none cotrol-input text-center" id="mensagem-sucesso" role="alert">
                
            </div>
            <form class="login-form" id="form1" method="POST" >
                <div class="cotrol-input">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="cotrol-input">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="cotrol-input">
                    <label for="password">Senha:</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="cotrol-input">
                    <label for="confirm-password">Confirme Sua Senha:</label>
                    <input type="password" name="confirm-password" id="confirm-password">
                </div>
                <div class="cotrol-input-select d-flex justify-content-between m-4">
                <select name="id_company" id="id_company">
                    <?php foreach ($listaCompanies as $companie): ?>
                        <option value="<?= $companie['id']; ?>"><?= $companie['fantasy_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                    <select id="id_profile" name="id_profile">
                    <?php foreach ($ListaProfile as $profiles): ?>
                        <option value="<?= $profiles['id']; ?>"><?= $profiles['profile']; ?></option>
                        <?php endforeach; ?>
                    </select> 
                    <select id="id_person" name="id_person">
                    <?php foreach ($ListaPerson as $person): ?>
                        <option value="<?= $person['id']; ?>">id Person <?= $person['id']; ?></option>
                    <?php endforeach; ?>
                    </select>

                </div>
                
                <div class="input btn mt-2">
                    <button type="button" onclick="saveRecords()" class="btn border-primary bg-info">Cadastrar</button>
                </div>
            </form>
        </div>

    </div>
</body>
<script src="assets/js/jQuery/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

    <script>

    function saveRecords(){
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirm-password').val();
        var id_profile = $('#id_profile').val();
        var id_company = $('#id_company').val();
        var id_person = $('#id_person').val();
        

        if(username == "" || email == "" || password == ""){
            alert("preecha todos os campos");
            return;
       }
       if (password !== confirmPassword) {
        alert("As senhas não coincidem.");
        return;
        }

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!email.match(emailPattern)) {
            alert("O e-mail inserido não é válido.");
            return;
        }
            
        if (password.trim().length < 3 ) {
            alert("A senha deve conter pelo menos 3 caracteres");
            return;
        }
        $.ajax ({
            type: 'POST',
            url : 'actions/UsuarioDAOPgSQL.php',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'saveRecords',
                email: email,
                password: password,
                username: username,
                id_company: id_company,
                id_profile: id_profile,
                id_person: id_person
            }),
            success: function(data) {
                console.log('SUCESSO')
                if(data === "Email ja esta em uso!") {
                    
                    $('#mensagem-sucesso').removeClass('alert alert-success');
                    $('#mensagem-sucesso').addClass('alert alert-danger');
                    $('#mensagem-sucesso').removeClass('d-none');
                    $('#mensagem-sucesso').text(data);
                } else if(data === "Username ja esta em uso!") {
                    $('#mensagem-sucesso').removeClass('alert alert-success');
                    $('#mensagem-sucesso').addClass('alert alert-danger');
                    $('#mensagem-sucesso').removeClass('d-none');
                    $('#mensagem-sucesso').text(data);
                } else if(data === "Username e Email ja estão em uso!"){
                    $('#mensagem-sucesso').removeClass('alert alert-success');
                    $('#mensagem-sucesso').addClass('alert alert-danger');
                    $('#mensagem-sucesso').removeClass('d-none');
                    $('#mensagem-sucesso').text(data);
                } else {
                    $('#mensagem-sucesso').removeClass('alert alert-danger');
                    $('#mensagem-sucesso').addClass('alert alert-success');
                    $('#mensagem-sucesso').text(data);
                    $('#mensagem-sucesso').removeClass('d-none');
                } 
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr, textStatus, error);
            },
        }
        )}
                
    </script>

</html>
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
        width: 400px;
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


</style>
<script src="assets/js/jQuery/jquery-3.5.1.min.js"></script>
<body>
    <div class="container-login">
        <div class="central-login">
            <div class="titulo">
                <h1>LOGIN</h1>
            </div>
            <div class="controle-alerta d-flex justify-content-center">
                <div class="alert alert-danger w-75 mt-4 d-none text-center" role="alert" id="mensagem-erro"></div>
            </div>
            <form class="login-form" id="form1" method="POST" action="/verificar.php">
                <div class="cotrol-input">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="cotrol-input">
                    <label for="password">Senha:</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="options">
                    <a href="cadastrar.php">Cadastrar</a>
                    <div class="visibilidade" style="cursor: pointer;">
                        <span class="material-symbols-outlined visivel">visibility</span>
                        <span class="material-symbols-outlined">visibility_off</span>
                    </div>
                </div>
                <div class="input btn mt-4">
                <input type="submit" form="form1">
            </form>
        </div>

    </div>
</body>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <script>

            const visibility = document.querySelector('.visibilidade');
            let inputPassword = document.getElementById('password')
            visibility.addEventListener("click", function(){
                if(inputPassword.type === "password"){
                    inputPassword.type = 'text';
                    this.innerHTML = '<span class="material-symbols-outlined">visibility</span>';
                }else{
                    inputPassword.type = 'password';
                    this.innerHTML = '<span class="material-symbols-outlined">visibility_off</span>';
                };
            });

            $('#form1').submit(function(e){
                e.preventDefault();

                var email = $('#email').val();
                var password = $('#password').val();

                $.ajax ({
                    url : 'http://localhost/Marmoraria/verificar.php',
                    method: 'POST',
                    data: {email: email, password: password},
                    dataType: 'json'
                }).done(function(result){
                    if(result.redirect) {
                        window.location.href = result.redirect;
                    } else {
                    $('#mensagem-erro').text("Email ou senha não encontrado");
                    $('#mensagem-erro').removeClass('d-none');
                    }
                });
            });

    </script>   


</html>
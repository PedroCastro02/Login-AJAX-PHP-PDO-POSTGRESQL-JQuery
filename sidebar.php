

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
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="assets/js/jQuery/jquery-3.5.1.min.js"></script>
</head>

<style>

@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
.wrapper{
  height: 100%;
  width: 300px;
  position: relative;
}
.wrapper .menu-btn{
  position: absolute;
  left: 215px;
  top: 10px;
  background: #4a4a4a;
  color: #fff;
  height: 45px;
  width: 45px;
  border: 1px solid #333;
  border-radius: 5px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  z-index: 300;
}

#btn:checked ~ .menu-btn{
  left: 20px;
}
.wrapper .menu-btn i{
  position: absolute;
  transform: ;
  font-size: 23px;
  transition: all 0.3s ease;
}
.wrapper .menu-btn i.fa-times{
  opacity: 0;
}
#btn:checked ~ .menu-btn i.fa-times{
  opacity: 1;
  transform: rotate(-180deg);
}
#btn:checked ~ .menu-btn i.fa-bars{
  opacity: 0;
  transform: rotate(180deg);
}
#sidebar{
  position: fixed;
  background: #404040;
  height: 100%;
  width: 270px;
  overflow: hidden;
  left: 0;
  transition: all 0.3s ease;
  margin-left: -30px;
}
#btn:checked ~ #sidebar{
  left: -270px;
}
#sidebar .title{
  line-height: 65px;
  text-align: center;
  background: #333;
  font-size: 25px;
  font-weight: 600;
  color: #f2f2f2;
  border-bottom: 1px solid #222;
}
#sidebar .list-items{
  position: relative;
  background: #404040;
  width: 100%;
  height: 100%;
  list-style: none;
}
#sidebar .list-items li{
  padding-left: 40px;
  line-height: 50px;
  border-top: 1px solid rgba(255,255,255,0.1);
  border-bottom: 1px solid #333;
  transition: all 0.3s ease;
}
#sidebar .list-items li:hover{
  border-top: 1px solid transparent;
  border-bottom: 1px solid transparent;
  box-shadow: 0 0px 10px 3px #222;
}
#sidebar .list-items li:first-child{
  border-top: none;
}
#sidebar .list-items li a{
  color: #f2f2f2;
  text-decoration: none;
  font-size: 18px;
  font-weight: 500;
  height: 100%;
  width: 100%;
  display: block;
}
#sidebar .list-items li a i{
  margin-right: 20px;
}
#sidebar .list-items .icons{
  width: 100%;
  height: 40px;
  text-align: center;
  position: absolute;
  bottom: 100px;
  line-height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
}
#sidebar .list-items .icons a{
  height: 100%;
  width: 40px;
  display: block;
  margin: 0 5px;
  font-size: 18px;
  color: #f2f2f2;
  background: #4a4a4a;
  border-radius: 5px;
  border: 1px solid #383838;
  transition: all 0.3s ease;
}
#sidebar .list-items .icons a:hover{
  background: #404040;
}
.list-items .icons a:first-child{
  margin-left: 0px;
}
.content{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: #202020;
  width: 100%;
  text-align: center;
}
.content .header{
  font-size: 20px;
  font-weight: 700;
}
.content p{
  font-size: 20px;
  font-weight: 700;
}
.btn .btnSlide {
  width: 100%;
}

</style>

<body>

<div class="wrapper">
   <input type="checkbox" id="btn" hidden>
   <label for="btn" class="menu-btn">
   <i class="fas fa-bars"></i>
   <i class="fas fa-times"></i>
   </label>
   <nav id="sidebar">
      <div class="title">
         <span class="MG" style="color: red;">Marmoraria</span>
      </div>
      <ul class="list-items">
         <li><a href="home.php"><i class="fas fa-home"></i>Home</a></li>
              <button class="btn btnSlide" type="button" id="toggleButton">
                <li style="margin-left: -10px;"><a href="#"><i class="fas fa-solid fa-clipboard"></i>Cadastros    <i class="fa-solid fa-arrow-down fa-bounce"></i></a></li>
              </button>
          <div id="myCollapseSideBar" class="collapse">
            <div class="card card-body" style="background: #4c4c4c;">
                    <li><a href="funcionarios.php"><i class="fas fa-address-book"></i>Funcionários</a></li>
                    <li><a href="pessoas.php"><i class="fas fa-user"></i>Pessoas</a></li>
                    <li><a href="users.php"><i class="fas fa-solid fa-users"></i>Usuários</a></li>
            </div>
          </div>
              <button class="btn" type="button" id="toggleButton2">
                <li style="margin-left: -10px;"><a href="#"><i class="fas fa-regular fa-stopwatch"></i>Pontos    <i class="fa-solid fa-arrow-down fa-bounce"></i></a></li>
              </button>
          <div id="myCollapseSideBar2" class="collapse">
            <div class="card card-body" style="background: #4c4c4c;">
                    <li><a href="Turnos.php"><i class="fa-solid fa-clipboard-list"></i>Turnos</a></li>
                    <li><a href="Batimento.php"><i class="fa-solid fa-user-clock"></i>Batimento</a></li>
                    <li><a href="Faltas.php"><i class="fa-solid fa-calendar-xmark"></i>Faltas</a></li>
            </div>
          </div>
         <li><a href="emObras.php"><i class="fa-solid fa-sack-dollar"></i>Financeiro</a></li>
         <li><a href="#"><i class="fas fa-envelope"></i>Contact us</a></li>
         <div class="icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
         </div>
      </ul>
   </nav>
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
              $('#toggleButton').on('click', function() {
                  $('#myCollapseSideBar').slideToggle();
              });
          });
      $(document).ready(function() {
              $('#toggleButton2').on('click', function() {
                  $('#myCollapseSideBar2').slideToggle();
              });
          });
      
    </script>
</html>
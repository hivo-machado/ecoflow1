<!DOCTYPE html>
<html>
  <head>
    <!--the must have tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <!--the must have assets-->
      <link rel="stylesheet" href="css/main.css">
       <script src="js/main.js" defer></script>
    <!--page title-->
      <link rel="icon" href="img/6001icone.ico" type="image/x-icon" />
	    <link rel="shortcut icon" type="img/x-icon" href="./icone.ico">
    <title>De.Bugger</title>
  </head>
  <body>
      <main>
      <!-- == END CONTATOS==-->
        <div class="container" style="background-color: #ffffff">
            <div class="loginformataçao">
              <center><img src="img/logo.jpg"></center>
            </div>
            <div class="login">
                <center>  
                  <form method="post" action="valida.php">
                    <label>Usuário</label>
                    <center><input type="text" style=" text-align:center; margin-bottom: 5px;" name="usuario" /> </center>
                    <label>Senha</label>
                    <br>
                    <input type="password"  style="text-align:center; margin-bottom: 5px;" name="senha" />
                    <br>
                    <input class="botum" type="submit" value="Entrar" />
                  </form>
                </center>
            </div>
        </div>
      </main>
  </body>
  <div class="js-overlay js-close-navigation js-close-menu overlay"></div>
</html>
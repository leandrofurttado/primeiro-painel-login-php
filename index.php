<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VProtection</title>
</head>

<body>
    <form action="" method="POST">
        <h1>Acesse sua conta VProtection</h1>
        <p>
            <label>Email:</label>
            <input type="text" name="email">
        </p>
        <p>
            <label>Senha:</label>
            <input type="password" name="senha">
        </p>
        <p><button type="submit"> ENTRAR !</button></p>
    </form>
</body>

</html>

<?php
include "conexao_db.php";

if (isset($_POST["email"]) || isset($_POST["senha"])) {
    //criando verificação de cada campo
    if (strlen($_POST["email"]) == 0) {
        echo "Preencha o seu e-mail";
    } elseif (strlen($_POST["senha"]) == 0) {
        echo "Preencha a sua senha!";
    } else {
        //UM A FORMA DE LIMPAR OS CAMPOS PARA EVITAR SQL INJECT (ESTUDAR SQL INJECT DEPOIS)
        $email = $mysqlconnect->real_escape_string($_POST['email']);
        $senha = $mysqlconnect->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$senha'";
        $sql_query = $mysqlconnect->query($sql_code) or die("Falha na execução do código SQL: " . $mysqlconnect->error);

        $quantidade_na_db = $sql_query->num_rows; // verifica quantos encontrou

        if ($quantidade_na_db == 1) {
            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: painel.php");
        } else {
            echo "Usuário ou senha inválidos!";
        }
    }
}

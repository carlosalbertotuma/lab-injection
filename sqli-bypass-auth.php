<?php
session_start();

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bWAPP";

// Conectando ao banco de dados
$link = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$message = "";

if(isset($_POST["form"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];

    // Concatenação para permitir injeção SQL
    $sql = "SELECT * FROM users WHERE login = '" . $login . "' AND password = '" . $password . "'";

    $recordset = $link->query($sql);

    if($recordset && $recordset->num_rows > 0) {
        // Usuário encontrado, autenticação bem-sucedida
        $row = $recordset->fetch_object();

        session_regenerate_id(true);
        $_SESSION["login"] = $row->login;
        $_SESSION["admin"] = $row->admin;

        header("Location: portal.php");
        exit;
    } else {
        // Usuário não encontrado, credenciais inválidas
        $message = "<font color=\"red\">Invalid credentials!</font>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sql Injetion - Bypass Authentication</title>
</head>
<body>

<div id="main">
    <h1>.....Sql Injetion.....</h1>
    <h1>Bypass Authentication</h1>
    <p>Enter your credentials.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]); ?>" method="POST">
        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login" size="20" autocomplete="off"></p>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="20" autocomplete="off"></p>

        <button type="submit" name="form" value="submit">Login</button>
    </form>
    <br></br>
    <img src='2.png' width="200" height="200"/>
    <br />
    <?php echo $message; ?>
</div>

</body>
</html>

<?php $link->close(); ?>
<?php
include("connect_i.php");
session_start();

$message = "";

if(isset($_POST["form"]))
{
    $login = $_POST["login"];
    $password = $_POST["password"];

    // A vulnerabilidade de SQL Injection ocorre aqui
    $sql = "SELECT * FROM users WHERE login = '" . $login . "' AND password = '" . $password . "'";

    // Debugging
    // echo $sql;

    $recordset = $link->query($sql);

    if(!$recordset)
    {
        // Display the SQL error message
        die("Error: " . $link->error);
    }
    else
    {
        $row = $recordset->fetch_object();

        // Debugging
        // print_r($row);

        if($row)
        {
            session_regenerate_id(true);

            $_SESSION["login"] = $row->login;
            $_SESSION["admin"] = $row->admin;

            header("Location: portal.php");
            exit;
        }
        else
        {
            $message = "<font color=\"red\">Invalid credentials!</font>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sql Injection - Erro Base</title>
</head>
<body>

<div id="main">
    <h1>Sql Injection</h1>
    <h1>#Erro Base#</h1>
    <p>Enter your credentials.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">
        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login" size="20" autocomplete="off"></p>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="20" autocomplete="off"></p>

        <button type="submit" name="form" value="submit">Login</button>
    </form>
    <br></br>
    <img src='2.png' width="200" height="200"/>
    <br />
    <?php
    echo $message;
    $link->close();
    ?>
</div>

</body>
</html>
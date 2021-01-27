<?php
$hm = 'localhost';
$db = 'users';
$un = 'root';
$pw = 'root';

$conn = new mysqli($hm, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

if (isset($_POST['reg'])) {
    registr($conn);
}
if (isset($_POST['enter'])){
    enter_user($conn);
}

function registr($conn)
{
    if (isset($_POST['name']) && isset($_POST['login']) && isset($_POST['pass'])) {
        $name = $_POST['name'];
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $query_defence = "SELECT name FROM user WHERE name='$name' and login = '$login' and password ='$pass'";
        $res = $conn->query($query_defence);
        $row_cnt = mysqli_num_rows($res);
        if ($row_cnt > 0) {
            echo "Такой пользователь уже есть";
        } else {
            $query = "insert into user (name,login,password) values" . "('$name','$login','$pass')";
            $result = $conn->query($query);
            if (!$result) {
                echo "DONT WORK  $query";
            } else {
                echo "WORK";
            }
        }
    }
}

function enter_user($conn)
{
    if (isset($_POST['login_enter']) && isset($_POST['pass_enter'])) {
        $login = $_POST['login_enter'];
        $pass = $_POST['pass_enter'];
        $query_defence = "SELECT name FROM user WHERE  login = '$login' and password ='$pass'";
        $res = $conn->query($query_defence);
        $row_cnt = mysqli_num_rows($res);
        if ($row_cnt > 0) {
            echo "Добро пожаловать ";
        } else {
            echo "Неверный логин или пароль";
        }
    }
}


echo <<<END


    <form method="post" >

        Ваше имя ?<input type="text" name="name" placeholder="Max" required="required" value="null"><br>
        Логин <input type="text" name="login" placeholder="Max" required="required" value="null"><br>
        Пароль<input type="password" name="pass" placeholder="Max"   ><br>

        <input type="submit" value="регистрация" name="reg">
    <form/>



END;


echo <<<END
<hr>  
         <form method="post">
            Логин<input type="text" placeholder="введите логин" name="login_enter" >
            Пароль<input type="text" placeholder="введите пароль" name="pass_enter" >
            
            <input type="submit" value="Войти" name="enter">
            
         </form>

END;


echo <<<END
<hr>  
         <form method="post">
            Введите дело<input type="text" placeholder="введите логин" name="ToDo" value="null">
            <input type="submit" value="Добавить" name="add_do">
            
         </form>

END;

if (isset($_POST['add_do'])){
    add_do($conn);
}

function add_do($conn){
       if (isset($_POST['ToDo']) && $_POST['ToDo'] != "null"){
           echo $_POST['ToDo'];
           $todo = $_POST['ToDo'];
           $query = "insert into todo (name,user_id) values" . "('$todo',16)";
           $result = $conn->query($query);
           if (!$result) {
               echo "DONT WORK  $query";
           } else {
               echo "WORK";
           }
       }
    }




<?php

$hm = 'localhost';
$db = 'users';
$un = 'root';
$pw = 'root';
$conn = new mysqli($hm, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

$login = $_POST['login_enter'] ;
$pass = $_POST['pass_enter'];
if ($login && $pass != ''){
    setcookie('login',$login,0,'/');
    setcookie('password',$pass,0,'/');

}
$id = get_id($conn,$_COOKIE['login'],$_COOKIE['password']);
echo $id;

if (isset($_POST['enter'])) {
    enter_user($conn);
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
            echo $login,$pass;
        } else {
            echo "Неверный логин или пароль";
        }
    }
}

if (isset($_POST['add_do'])) {
    add_do($conn,$id);
}


function add_do($conn,$id)
{
    if (isset($_POST['add_do'])) {
        $login = $_POST['login_enter'];
        $pass = $_POST['pass_enter'];
        $todo = $_POST['ToDo'];
        $query = "insert into todo (name,user_id) values" . "('$todo',$id)";
        $result = $conn->query($query);
        if (!$result) {
            echo "DONT WORK  $query";
        } else {
            echo "WORK";
            $q = "SELECT todo.name FROM `user` INNER JOIN todo on user.id = todo.user_id WHERE user.id = $id";
            $r = $conn->query($q);
            $rows = mysqli_num_rows($r); // количество полученных строк
            for ($i = 0; $i < $rows; ++$i) {
                $row = mysqli_fetch_row($r);
                echo "<li>";
                for ($j = 0; $j < 1; ++$j) {
                    echo $row[$j];
                }
                echo "</li>";
            }

        }
    }
}

function get_id($conn,$login,$pass){
    $qq = "SELECT * FROM `user` WHERE login ='$login' and password ='$pass' ";
    $rr = $conn->query($qq);
    $roww = mysqli_fetch_row($rr);
    return (int)$roww[0];
}

?>
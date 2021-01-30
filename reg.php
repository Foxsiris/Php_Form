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
function registr($conn)
{
    if (isset($_POST['name']) && isset($_POST['login']) && isset($_POST['pass'])) {
        $name = $_POST['name'];
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $query_defence = "SELECT name FROM user WHERE  login = '$login' and password ='$pass'";
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
?>
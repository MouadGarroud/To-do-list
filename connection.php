<!-- Mouad Garroud -->
<?php
$localhost = 'localhost'; 
$username = 'root';
$password = '';
$dbname = 'to_do';
$conn = mysqli_connect($localhost, $username, $password, $dbname);
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
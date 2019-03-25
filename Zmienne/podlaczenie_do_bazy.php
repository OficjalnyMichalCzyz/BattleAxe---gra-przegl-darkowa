<?php
$login = new mysqli($server_ip, $admin_login, $admin_haslo, $admin_baza);
session_start();
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. <br />";
    echo "Debugging errno: " . mysqli_connect_errno() . "<br />";
    echo "Debugging error: " . mysqli_connect_error() . "<br />";
    exit(1);
}
echo "Zalogowano oraz podłączono do " . $admin_baza . "<br />";
echo mysqli_get_host_info($login) . "<br />";
?>

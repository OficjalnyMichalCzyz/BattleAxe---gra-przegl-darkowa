<?php
if (isset($_SESSION["wygenerowany_token"])){
  //echo "Zalogowano z tokenem: " . $_SESSION["wygenerowany_token"] . ".<br />";
}
if (isset($_SESSION["ip"])){
  //echo "Zalogowano z IP: " . $_SESSION["ip"] . ".<br />";
}
if (isset($_SESSION["nick"])){
  //echo "Zalogowano jako " . $_SESSION["nick"] . ".<br />";
}
if (isset($_SESSION["id"])){
  //echo "ID użytkownika to " . $_SESSION["id"] . "<br />";
}
//echo "ID sesji to: " . session_id() . ".<br />";
//echo "<hr />";

 ?>

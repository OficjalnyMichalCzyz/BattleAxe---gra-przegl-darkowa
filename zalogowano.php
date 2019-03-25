<?php include 'zmienne\zmienne_globalne.php'; ?>
<?php include 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php
echo "Zalogowano z tokenem: " . $_SESSION["wygenerowany_token"] . ".<br />";
echo "Zalogowano z IP: " . $_SESSION["ip"] . ".<Br />";
echo "Zalogowano jako " . $_SESSION["nick"] . ".<br />";
echo "ID sesji to: " . session_id() . ".<br />";
echo "<hr />";
?>
<a href='odzyskanie_hasla.php'>Haslo</a>
<a href='wylogowano.php'>Wyloguj</a>

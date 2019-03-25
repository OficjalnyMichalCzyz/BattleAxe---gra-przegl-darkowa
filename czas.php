<?php include 'zmienne\zmienne_globalne.php'; ?>
<?php include 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php


$wpisany_login = hash('sha512', "administrator");
$zapytanie = $login->prepare("SELECT godzina_zalogowania FROM uzytkownicy WHERE nazwa_uzytkownika = ?");

    $zapytanie->bind_param("s", $wpisany_login);
    $zapytanie->execute();
    $zapytanie->bind_result($godzina);
    $zapytanie->fetch();
    $zapytanie->close();
    $data = new DateTime($godzina);
    echo $data->format('H:i');
















?>

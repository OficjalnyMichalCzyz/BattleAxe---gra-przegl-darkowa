<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

<?php

//Pobieranie danych z forma + inne rzeczy------------------------------------------------------------------------------------------------------------

if (isset($_POST['wpisany_login']) and isset($_POST['wpisane_haslo'])){
////Resetowanie ID sesji po ponownym zalogowaniu (do HASHa)
session_regenerate_id();
////Hashowanie danych wpisanych przez użytkownika
$wpisany_login = $_POST['wpisany_login'];
$wpisane_haslo = hash('sha512', $_POST['wpisane_haslo']);
$data = date('l jS \of F Y h:i:s A');  //data jest zabezpieczeniem dodawanym do bazy

//Zapytanie o nazwę użytkownika oraz ilość nieudanych prób logowania-----------------------------------------------------

$zapytanie = $login->prepare("SELECT haslo_uzytkownika, ID_uzytkownika, nick_uzytkownika FROM uzytkownicy WHERE nazwa_uzytkownika = ?");
    $zapytanie->bind_param("s", $wpisany_login);
    $zapytanie->execute();
    $zapytanie->bind_result($haslo_uzytkownika, $ID_uzytkownika, $nick_uzytkownika);
    $zapytanie->fetch();
    $zapytanie->close();
//Sprawdzenie czy podany użytkownik istnieje, sprawdzając czy program zwrócił cokolwiek(było do blokowania za próby ale usunąłem)----------------------------------
    if($haslo_uzytkownika == ""){
      echo "Wpisano złą nazwe użytkownika.";
      echo "<a href='index.php'>Powrót</a>";
      exit();
    }
//Mechanizm blokowania konta-----------------------------------------------------------------------------------------------
    if($wpisane_haslo != $haslo_uzytkownika){
      echo "Niepoprawna nazwa użytkownika i/lub hasło.<br />";
      echo "<a href='index.php'>Powrót</a>";
      exit();
    }
//Zalogowano poprawnie, tworzenie sesji-----------------------------------------------------------------------------------------------
echo "Pomyślnie zalogowano na użytkownika " . $wpisany_login .".";


      $wygenerowany_token = hash('sha512', $wpisane_haslo . $ip_uzytkownika . $data . session_id());

      $zapytanie = $login->prepare("UPDATE uzytkownicy SET token_sesji = ?, godzina_zalogowania = ?, adres_ip_uzytkownika = ?, token_resetu_hasla = ? WHERE nazwa_uzytkownika = ?");
      $zapytanie->bind_param("sssss", $wygenerowany_token, $data, $ip_uzytkownika, $nic, $wpisany_login);
      $zapytanie->execute();
      $zapytanie->close();

      $_SESSION["wygenerowany_token"] = $wygenerowany_token;
      $_SESSION["ip"] = $ip_uzytkownika;
      $_SESSION["nick"] = $nick_uzytkownika;
      $_SESSION["id"] = $ID_uzytkownika;

      $login->close();
      echo "<script>location.href='zalogowano.php';</script>";
      exit();
}
$login->close();

if (isset($_SESSION["wygenerowany_token"]) && isset($_SESSION["ip"]) && isset($_SESSION["nick"]) && isset($_SESSION["id"])) {
  echo "Czy to Ty, " . $_SESSION["nick"] . "? <br /> Kliknij <a href='zalogowano.php'>tutaj</a> aby powrócić do gry. <br /> To nie Ty? Wyloguj się <a href='wylogowano.php'>tutaj</a>.";
} else {

echo '
        <form method="POST">
          <h2>Proszę się zalogować</h2>
          <div>
  	  <input type="text" name="wpisany_login" placeholder="Login" required>
  	</div>
          <input type="password" name="wpisane_haslo" placeholder="Hasło" required> <br>
          <button style="width: 170px;"type="submit">Login</button>
        </form>
';
}
        echo '
<h3><a href="odzyskanie_hasla.php">Odzyskaj hasło</a></h3><br />
<h3><a href="rejestracja.php">Zarejestruj się</a></h3>





';
?>
</body>
</html>

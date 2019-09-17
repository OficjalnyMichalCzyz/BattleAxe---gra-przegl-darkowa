<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>
<?php
//Sprawdzenie poprawności tokenu
if (isset($_POST['wpisany_token']) and isset($_POST['wpisane_haslo'])){
  if($_POST["wpisany_token"] == ""){
    echo "Błąd krytyczny: token nie może być NULL.";
    exit();
  }
  //Sprawdzenie poprawności zasad hasła
  if(strlen($_POST["wpisane_haslo"]) <= "7" || strlen($_POST["wpisane_haslo"]) >= "33"){
    echo "Błąd: hasło musi mieć pomiędzy 8 i 32 znakami.";
    echo 'Wróć do zmiany hasła: <a href="zresetowano_haslo.php">tutaj</a>';
    exit();
  }
  //Podmiana hasła oraz ilości nieudanych prób logowania (nie zaimplementowanie, nie planuję)
  $token_resetu_hasla = $_POST["wpisany_token"];
  $wpisane_haslo = hash('sha512', $_POST['wpisane_haslo']);
  $zapytanie = $login->prepare("UPDATE uzytkownicy SET haslo_uzytkownika = ?, INP_uzytkownika = ? WHERE token_resetu_hasla = ?");
  $zapytanie->bind_param("sis", $wpisane_haslo, $zero, $token_resetu_hasla);
  $zapytanie->execute();
  $zapytanie->close();
  $zapytanie = $login->prepare("SELECT haslo_uzytkownika FROM uzytkownicy WHERE token_resetu_hasla = ?");
  $zapytanie->bind_param("s", $token_resetu_hasla);
  $zapytanie->execute();
  $zapytanie->bind_result($haslo_uzytkownika);
  $zapytanie->fetch();
  $zapytanie->close();
 if($haslo_uzytkownika == $wpisane_haslo){
   echo "Hasło zostało zmienione poprawnie.";
   //Czyszczenie tokenu zmiany hasła z bazy by uniknąć wielokrotne resetowanie jednym kodem
   $zapytanie = $login->prepare("UPDATE uzytkownicy SET token_resetu_hasla = ? WHERE token_resetu_hasla = ?");
   $zapytanie->bind_param("ss", $nic, $token_resetu_hasla);
   $zapytanie->execute();
   $zapytanie->close();
 } else {
  // echo $token_resetu_hasla;
  // echo "<br />";
  // echo $haslo_uzytkownika;
  // echo "<br />";
  // echo $wpisane_haslo;
   echo "Bład zmiany hasła. Wewnętrzny błąd serwera lub podany token nie istnieje.<br />";
 }
  ////BAZA DANYCH GRZEBANIE Z HASŁEM I PRÓBAMI
}
  ?>
  <!DOCTYPE html>
  <html>
  <body>
  <form method="POST">
    <h2>Proszę wpisać nowe hasło</h2>
      <input type="text" name="wpisany_token" required> Token <br />
      <input type="password" name="wpisane_haslo" required> Nowe Hasło <br />
    <button type="submit">Zmień hasło</button>
  </form>



 <a href="index.php">Strona główna</a>

</body>
</html>

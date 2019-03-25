<?php include 'zmienne\zmienne_globalne.php'; ?>
<?php include 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php
if (isset($_POST['wpisany_token']) and isset($_POST['wpisane_haslo'])){
  if($_POST["wpisany_token"] == ""){
    echo "Błąd krytyczny: token nie może być NULL.";
    exit();
  }
  if(strlen($_POST["wpisane_haslo"]) <= "7" || strlen($_POST["wpisane_haslo"]) >= "33"){
    echo "Błąd: hasło musi mieć pomiędzy 8 i 32 znakami.";
    echo 'Wróć do zmiany hasła: <a href="zresetowano_haslo.php">tutaj</a>';
    exit();
  }
  $token_resetu_hasla = $_POST["wpisany_token"];
  $wpisane_haslo = hash('sha512', $_POST['wpisane_haslo']);
  $zapytanie = $login->prepare("UPDATE uzytkownicy SET haslo_uzytkownika = ?, INP_uzytkownika = ? WHERE token_resetu_hasla = ?");
  $zapytanie->bind_param("sss", $wpisane_haslo, $zero, $token_resetu_hasla);
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
   $zapytanie = $login->prepare("UPDATE uzytkownicy SET token_resetu_hasla = ? WHERE token_resetu_hasla = ?");
   $zapytanie->bind_param("ss", $nic, $token_resetu_hasla);
   $zapytanie->execute();
   $zapytanie->close();
 } else {
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
      <input type="text" name="wpisany_token" required>
      <input type="password" name="wpisane_haslo" required>
    <button type="submit">Zmień hasło</button>
  </form>



 <a href="index.php">Strona główna</a>

</body>
</html>

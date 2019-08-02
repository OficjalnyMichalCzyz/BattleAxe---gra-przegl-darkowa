<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>

<?php
if (isset($_POST['wpisany_login']) && isset($_POST['wpisany_haslo']) && isset($_POST['wpisany_haslo_p']) && isset($_POST['wpisany_mail']) && isset($_POST['wpisany_nick'])){
  $pattern = "/[A-Za-z0-9]{3,18}$/";
  if(preg_match($pattern, $_POST['wpisany_login']) == true ){
    echo "XDDDDDDDDDDD1 <br />";
  }
  $pattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/";
  if(preg_match($pattern, $_POST['wpisany_haslo']) == true ){
    echo "XDDDDDDDDDDD2 <br />";
  }
  if(preg_match($pattern, $_POST['wpisany_haslo_p']) == true ){
    echo "XDDDDDDDDDDD3 <br />";
  }
  $pattern = "/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{2,}$/";
  if(preg_match($pattern, $_POST['wpisany_mail']) == true ){
    echo "XDDDDDDDDDDD4 <br />";
  }
  $pattern = "/[A-Za-z0-9]{3,18}$/";
  if(preg_match($pattern, $_POST['wpisany_nick']) == true ){
    echo "XDDDDDDDDDDD5 <br />";
  }}/*

  $wpisany_mail = $_POST['wpisany_mail'];
echo $wpisany_mail;
  $wygenerowany_token_hasla = hash('sha512', $wpisany_mail . $ip_uzytkownika . $data);
      $zapytanie = $login->prepare("UPDATE uzytkownicy SET token_resetu_hasla = ? WHERE email_uzytkownika = ?");
      $zapytanie->bind_param("ss", $wygenerowany_token_hasla, $wpisany_mail);
      $zapytanie->execute();
      $zapytanie->close();
      $token_resetu_hasla = $wygenerowany_token_hasla;
      $zapytanie = $login->prepare("SELECT nazwa_uzytkownika FROM uzytkownicy WHERE token_resetu_hasla = ?");
      $zapytanie->bind_param("s", $wygenerowany_token_hasla);
      $zapytanie->execute();
      $zapytanie->bind_result($nazwa_uzytkownika);
      $zapytanie->fetch();
      $zapytanie->close();
      echo $nazwa_uzytkownika;
}


      if(preg_match($pattern, "Wnixqwzq1998@!''''") == true ){
        echo "XDDDDDDDDDDD";
      }
*/
?>
<!DOCTYPE html>
<html>

<body>
<form method="POST">
  <h2>Wpisz swoje dane:</h2> <br />
  <div>
  <h2>Login:</h2>         <input type="text" name="wpisany_login" required pattern="[A-Za-z0-9]{3,18}"><br />
  <h2>Hasło:</h2>         <input type="password" name="wpisany_haslo" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br />
  <h2>Powtórz hasło:</h2> <input type="password" name="wpisany_haslo_p" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br />
  <h2>Adres email:</h2>   <input type="email" name="wpisany_mail" required pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{2,}$"><br />
  <h2>Nick:</h2>          <input type="text" name="wpisany_nick" required pattern="[A-Za-z0-9]{3,18}"><br />
</div>
  <button type="submit">Zarejestruj</button>
</form>
<br />
 <a href="index.php">Strona główna</a>



</body>
</html>

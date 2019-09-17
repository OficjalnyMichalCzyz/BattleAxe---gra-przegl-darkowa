<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <style>
      input{
        background-color: white;
      }
    </style>
  </head>
<body>
<?php
///
$Temp_Login = "";$Temp_Haslo = "";$Temp_Haslo_P = "";$Temp_Mail = "";$Temp_Nick = "";$Login_Style = "";$Haslo_Style = "";$HasloP_Style = "";$Mail_Style = "";$Nick_Style = "";$Identycznosc_Style = "";
$stop_zapytaniom = false;
$RysujStrone = True;
$Login_Correct = "";
///
//Spradzenie czy strona jest uruchamiana bez parametrów lub czy strona jest uruchamiana już z wpisanym formularzem
if (isset($_POST['wpisany_login']) && isset($_POST['wpisany_haslo']) && isset($_POST['wpisany_haslo_p']) && isset($_POST['wpisany_mail']) && isset($_POST['wpisany_nick'])){
  //Sprawdzenie czy każde pole na dane zostało wypełnione
  if(isset($_POST['wpisany_login'])){ $Temp_Login = $_POST['wpisany_login'];}
  if(isset($_POST['wpisany_haslo'])){ $Temp_Haslo = $_POST['wpisany_haslo'];}
  if(isset($_POST['wpisany_haslo_p'])){ $Temp_Haslo_P = $_POST['wpisany_haslo_p'];}
  if(isset($_POST['wpisany_mail'])){ $Temp_Mail = $_POST['wpisany_mail'];}
  if(isset($_POST['wpisany_nick'])){ $Temp_Nick = $_POST['wpisany_nick'];}
  //Sprawdzanie patterów danych zmiennych: nicki bez spacji, skomplikowanie hasel, poprawność powtórzenia hasła itd
  $pattern = "/[A-Za-z0-9]{3,18}$/";
  if(preg_match($pattern, $_POST['wpisany_login']) == true ){
  //  echo "Login prawidlowy <br />";
    $Login_Correct = True;
    $Login_Style = "Green";
  } else {
  //  echo "Login nieprawidlowy <br />";
    $Login_Correct = False;
    $Login_Style = "Red";
  }
  $pattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/";
  if(preg_match($pattern, $_POST['wpisany_haslo']) == true ){
  //  echo "Haslo prawidlowe <br />";
    $Haslo_Correct = True;
    $Haslo_Style = "Green";
  } else {
  //  echo "Haslo nieprawidlowe <br />";
    $Haslo_Correct = False;
    $Haslo_Style = "Red";
  }
  if(preg_match($pattern, $_POST['wpisany_haslo_p']) == true ){
  //  echo "Haslo_P prawidlowe <br />";
    $HasloP_Correct = True;
    $HasloP_Style = "Green";
  } else {
  //  echo "Haslo_P nieprawidlowe <br />";
    $HasloP_Correct = False;
    $HasloP_Style = "Red";
  }
  $pattern = "/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{2,}$/";
  if(preg_match($pattern, $_POST['wpisany_mail']) == true ){
  //  echo "Mail prawidlowy <br />";
    $Mail_Correct = True;
    $Mail_Style = "Green";
  } else {
  //  echo "Mail nieprawidlowy <br />";
    $Mail_Correct = False;
    $Mail_Style = "Red";
  }
  $pattern = "/[A-Za-z0-9]{3,18}$/";
  if(preg_match($pattern, $_POST['wpisany_nick']) == true ){
  //  echo "Nick prawidlowy <br />";
    $Nick_Correct = True;
    $Nick_Style = "Green";
  } else {
  //  echo "Nick nieprawidlowy <br />";
    $Nick_Correct = False;
    $Nick_Style = "Red";
  }
  if($_POST['wpisany_haslo'] == $_POST['wpisany_haslo_p']){
  //  echo "Hasla identyczne";
    $Identycznosc_Correct = True;
    $Identycznosc_Style = "Green";
  } else {
  //  echo "Hasla rozne <br />";
    $Identycznosc_Correct = False;
    $Identycznosc_Style = "Red";
    $Temp_Haslo_P = "Hasła nie są identyczne!";
  }
}
//Sprawdzenie czy wszystko jest ok, jeśli ok to zakłada konto(NARAZIE BEZ TWORZENIA POSTACI)
//// TODO: zaimplementować tworzenie postaci przy zakładaniu konta
///////////////////////////////////////////////////////////////////////////////////////////////
if($Login_Correct && $Haslo_Correct && $HasloP_Correct && $Mail_Correct && $Nick_Correct && $Identycznosc_Correct && isset($Login_Correct)){

  $hashowane_haslo = hash('sha512', $_POST['wpisany_haslo']);
  //Sprawdzenie czy Mail/nazwa uzytkownika/nick są zajęte
  $zapytanie = $login->prepare("SELECT nazwa_uzytkownika FROM uzytkownicy WHERE nazwa_uzytkownika = ?");
  $zapytanie->bind_param("s", $Temp_Login);
  $zapytanie->execute();
  $zapytanie->bind_result($nazwa_uzytkownika);
  $zapytanie->fetch();
  $zapytanie->close();
  if(isset($nazwa_uzytkownika)){
    echo "Użytkownik z podanym loginem już istnieje. <br />";
    $stop_zapytaniom = true;
    $Login_Style = "Red";
  }
  $zapytanie = $login->prepare("SELECT nick_uzytkownika FROM uzytkownicy WHERE nick_uzytkownika = ?");
  $zapytanie->bind_param("s", $Temp_Nick);
  $zapytanie->execute();
  $zapytanie->bind_result($nick_uzytkownika);
  $zapytanie->fetch();
  $zapytanie->close();
  if(isset($nick_uzytkownika)){
    echo "Użytkownik z podanym nickiem już istnieje. <br />";
    $stop_zapytaniom = true;
    $Nick_Style = "Red";
  }
  $zapytanie = $login->prepare("SELECT email_uzytkownika FROM uzytkownicy WHERE email_uzytkownika = ?");
  $zapytanie->bind_param("s", $Temp_Mail);
  $zapytanie->execute();
  $zapytanie->bind_result($Mail_uzytkownika);
  $zapytanie->fetch();
  $zapytanie->close();
  if(isset($Mail_uzytkownika)){
    echo "Użytkownik z podanym adresem email już istnieje. <br />";
    $stop_zapytaniom = true;
    $Mail_Style = "Red";
  }
  //Jeśli nie ma żadnych przeszkód to program zakłada konto według wpisanych danych oraz nie przystępuje do rysowania reszty strony
        if($stop_zapytaniom == false){
           $zapytanie = $login->prepare("INSERT INTO uzytkownicy (nazwa_uzytkownika, haslo_uzytkownika, email_uzytkownika, nick_uzytkownika, INP_uzytkownika, token_sesji, adres_ip_uzytkownika) VALUES (?, ?, ?, ?, ?, ?, ?)");
           $zapytanie->bind_param("ssssiss", $Temp_Login, $hashowane_haslo, $Temp_Mail, $Temp_Nick, $zero, $brak, $brak);
           $zapytanie->execute();
           //printf("<br /> %d Row inserted.\n", $zapytanie->affected_rows);
           $zapytanie->close();
           $RysujStrone = False;

           $zapytanie = $login->prepare("SELECT email_uzytkownika FROM uzytkownicy WHERE email_uzytkownika = ?");
           $zapytanie->bind_param("s", $Temp_Mail);
           $zapytanie->execute();
           $zapytanie->bind_result($Mail_uzytkownika);
           $zapytanie->fetch();
           $zapytanie->close();
           if(isset($Mail_uzytkownika)){
             echo "Zarejestrowano pomyślnie. <br />";
           } else {
             echo "NIEZAREJESTROWANO - BŁĄD KRYTYCZNY";
           }
} else {
  $RysujStrone = True;
}
}
If($RysujStrone == True){
echo'
<form method="POST">
  <h2>Wpisz swoje dane:</h2> <br />
  <div>
  <h2>Login:</h2>         <input type="text" style="background-color:' . $Login_Style . '" value="' . $Temp_Login . '" name="wpisany_login" required pattern="[A-Za-z0-9]{3,18}"><br />
  <h2>Hasło:</h2>         <input type="password" style="background-color:' . $Haslo_Style . '" value="' . $Temp_Haslo . '" name="wpisany_haslo" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br />
  <h2>Powtórz hasło:</h2> <input type="password" style="background-color:' . $Identycznosc_Style . '" value="' . $Temp_Haslo_P . '" name="wpisany_haslo_p" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br />
  <h2>Adres email:</h2>   <input type="email" style="background-color:' . $Mail_Style . '" value="' . $Temp_Mail . '" name="wpisany_mail" required pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{2,}$"><br />
  <h2>Nick:</h2>          <input type="text" style="background-color:' . $Nick_Style . '" value="' . $Temp_Nick . '" name="wpisany_nick" required pattern="[A-Za-z0-9]{3,18}"><br />
  <h2>Akceptuje regulamin:</h2>          <input type="checkbox" name="regulamin" required /> <br />
</div>
  <button type="submit">Zarejestruj</button>
</form>
';
}
?>
<br />
 <a href="index.php">Strona główna</a>
</html>

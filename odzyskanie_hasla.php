<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>
<?php

$token_resetu_hasla = "";
if (isset($_POST['wpisany_mail'])){
  $wpisany_mail = $_POST['wpisany_mail'];
  $data = date('l jS \of F Y h:i:s A');
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

//Mechanizm wysyłania maila----------------------------------------------------------------------
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=UTF-8';
$headers[] = "From: BattleAxe@timotarea.wi.net.pl";
$headers[] = "Reply-To: BattleAxe@timotarea.wi.net.pl";
$headers[] = "Wersja PHP: " . phpversion();
$headers[] = "Content-Type: text/html; charset='UTF-8'"."\n";
$subject = "Odzyskiwanie hasła";
$message = '<h3 style="color:orange;">Dzień dobry ' . $nazwa_uzytkownika .  ',</h3><br />
Uwidzieliśmy że poprosiłeś nas o zmianę hasła, więc wysłaliśmy Ci tego maila.<br />
Jeżeli to nie Ty to proszę, zignoruj tę wiadomość.<br />
Skopiuj token i wklej go na stronie odzyskiwania hasła.<br />
<h2 style="color:orange;">         ' . $token_resetu_hasla . '</h3><br />
';
$to = $wpisany_mail;
mail($to, $subject, $message, implode("\r\n", $headers));
}
?>

<!DOCTYPE html>
<html>


<body>
        <form method="POST">
          <h2>Wpisz swój adres e-mail by zresetować hasło.</h2>
          <div>
  	  <input type="text" name="wpisany_mail" required>
  	</div>
          <button type="submit">Wyślij kod</button>
        </form>
        Masz już token? Wpisz go <a href="zresetowano_haslo.php">tutaj</a>

<br />
 <a href="index.php">Strona główna</a>






</body>
</html>

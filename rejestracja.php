<?php include 'zmienne\zmienne_globalne.php'; ?>
<?php include 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php










?>
<!DOCTYPE html>
<html>


<body>
        <form method="POST">
          <h2>Zarejestruj się</h2>
      Nazwa konta:    <input type="text" name="wpisana_nazwa_konta" required> <br />
      Wpisz hasło:    <input type="password" name="wpisane_haslo" required> <br />
      Ponownie wpisz hasło:    <input type="password" name="wpisane_haslo_powtorz" required> <br />
      Wpisz swój nick:    <input type="text" name="wpisany_nick" required> <br />
      Podaj swój email:    <input type="text" name="wpisany_mail" required> <br />
          <button type="submit">Zarejestruj</button> <br />
        </form>

<a href='index.php'>Strona główna</a><br />





</body>
</html>

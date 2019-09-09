<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>
<?php require_once 'zmienne\anty_pusta_sesja.php'; ?>


<!DOCTYPE html>
<html>
<script>
function Sila(Aktualna_Sila){
  window.open(window.location.href+"?TrenujSile="+Aktualna_Sila,"_self")
}
function Zrecznosc(Aktualna_Zrecznosc){
  window.open(window.location.href+"?TrenujZrecznosc="+Aktualna_Zrecznosc,"_self")
}
function Wytrzymalosc(Aktualna_Wytrzymalosc){
  window.open(window.location.href+"?TrenujWytrzymalosc="+Aktualna_Wytrzymalosc,"_self")
}


</script>
<?php

$zapytanie = $login->prepare("SELECT Poziom, Doswiadczenie, Zdrowie, Zloto, Sila, Zrecznosc, Wytrzymalosc, ID_broni, ID_pancerza, Godzina_zajecia, ID_misji, Postep FROM postacie WHERE ID_uzytkownika = ?");
    $zapytanie->bind_param("s", $_SESSION["id"]);
    $zapytanie->execute();
    $zapytanie->bind_result($poziom_uzytkownika, $Doswiadczenie_uzytkownika, $Zdrowie_uzytkownika, $Zloto_uzytkownika, $Sila_uzytkownika, $Zrecznosc_uzytkownika, $Wytrzymalosc_uzytkownika, $ID_broni_uzytkownika, $ID_pancerza_uzytkownika, $Godzina_zajecia_uzytkownika, $ID_misji_uzytkownika, $Postep_uzytkownika);
    $zapytanie->fetch();
    $zapytanie->close();



    if(isset($_GET["TrenujSile"])){
      if($Zloto_uzytkownika >= ($Sila_uzytkownika*2+3)){
        if($_GET["TrenujSile"] == $Sila_uzytkownika){
          $Zloto_uzytkownika = $Zloto_uzytkownika - $Sila_uzytkownika*2-3;
          $Sila_uzytkownika++;
          $zapytanie = $login->prepare("UPDATE postacie SET Sila = ?, Zloto = ? WHERE ID_uzytkownika = ?");
          $zapytanie->bind_param("iii", $Sila_uzytkownika, $Zloto_uzytkownika, $_SESSION["id"]);
          $zapytanie->execute();
          $zapytanie->close();
          echo "<script>alert('Dodano siłę.');
          window.location = window.location.pathname;
          </script>";
        } else {echo "<script>alert('Błąd zapytania');window.location = window.location.pathname;</script>"; }
      } else {echo "<script>alert('Za mało złota.');window.location = window.location.pathname;</script>"; }
    }
    if(isset($_GET["TrenujZrecznosc"])){
      if($Zloto_uzytkownika >= ($Zrecznosc_uzytkownika*2+3)){
        if($_GET["TrenujZrecznosc"] == $Zrecznosc_uzytkownika){
          $Zloto_uzytkownika = $Zloto_uzytkownika - $Zrecznosc_uzytkownika*2-3;
          $Zrecznosc_uzytkownika++;
          $zapytanie = $login->prepare("UPDATE postacie SET Zrecznosc = ?, Zloto = ? WHERE ID_uzytkownika = ?");
          $zapytanie->bind_param("iii", $Zrecznosc_uzytkownika, $Zloto_uzytkownika, $_SESSION["id"]);
          $zapytanie->execute();
          $zapytanie->close();
          echo "<script>alert('Dodano zręczność.');
          window.location = window.location.pathname;
          </script>";
        } else {echo "<script>alert('Błąd zapytania');window.location = window.location.pathname;</script>"; }
      } else {echo "<script>alert('Za mało złota.');window.location = window.location.pathname;</script>"; }
    }
    if(isset($_GET["TrenujWytrzymalosc"])){
      if($Zloto_uzytkownika >= ($Wytrzymalosc_uzytkownika*2+3)){
        if($_GET["TrenujWytrzymalosc"] == $Wytrzymalosc_uzytkownika){
          $Zloto_uzytkownika = $Zloto_uzytkownika - $Wytrzymalosc_uzytkownika*2-3;
          $Wytrzymalosc_uzytkownika++;
          $zapytanie = $login->prepare("UPDATE postacie SET Wytrzymalosc = ?, Zloto = ? WHERE ID_uzytkownika = ?");
          $zapytanie->bind_param("iii", $Wytrzymalosc_uzytkownika, $Zloto_uzytkownika, $_SESSION["id"]);
          $zapytanie->execute();
          $zapytanie->close();
          echo "<script>alert('Dodano Wytrzymalosc.');
          window.location = window.location.pathname;
          </script>";
        } else {echo "<script>alert('Błąd zapytania');window.location = window.location.pathname;</script>"; }
      } else {echo "<script>alert('Za mało złota.');window.location = window.location.pathname;</script>"; }
    }
    //echo $_GET["TrenujSile"];
    //echo $_GET["TrenujZrecznosc"];
    //echo $_GET["TrenujWytrzymalosc"];

echo "Poziom doświadczenia: " . $poziom_uzytkownika . " <br />
Doświadczenie: " . $Doswiadczenie_uzytkownika . "<br />
Punkty zdrowia: " . $Zdrowie_uzytkownika . "<br />
Złoto: " . $Zloto_uzytkownika . "<br />
Siła: " . $Sila_uzytkownika . "<button onclick='Sila(" . $Sila_uzytkownika . ")'>+</button> " . ($Sila_uzytkownika*2+3) .  " Złota <br />
Zręczność: " . $Zrecznosc_uzytkownika . "<button onclick='Zrecznosc(" . $Zrecznosc_uzytkownika . ")'>+</button> " . ($Zrecznosc_uzytkownika*2+3) .  " Złota <br />
Wytrzymalosc: " . $Wytrzymalosc_uzytkownika . "<button onclick='Wytrzymalosc(" . $Wytrzymalosc_uzytkownika . ")'>+</button> " . ($Wytrzymalosc_uzytkownika*2+3) .  " Złota <br />
Broń: " . $ID_broni_uzytkownika . "<br />
Pancerz: " . $ID_pancerza_uzytkownika . "<br />
Zajęty do: " . $Godzina_zajecia_uzytkownika . "<br />
Aktualna misja: " . $ID_misji_uzytkownika . "<br />
Postęp fabularny: " . $Postep_uzytkownika;
?>




<body>
<form method="POST">



<div>
 </div>

<h1>Battle Axe</h1><br />
Postać<br />









<button type="submit">Odśwież</button>
Zalogowano.<br />
<a href='wylogowano.php'>Wyloguj</a></h3>
</div>






</form>
</body>
</html>

<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>
<?php require_once 'zmienne\anty_pusta_sesja.php'; ?>
<script src='zmienne\przedmioty.js'></script>

<!DOCTYPE html>
<html>
<head>
  <!-- Narazie postawiłem na style w pliku, gdyż cacheowanie plików .css przez chrome jest uciążliwe-->
  <link rel="stylesheet" href="css/zalogowano.css">
</head>
  <!-- Funkcje przeładowywujące strone z odpowiednim parameterm GET, aby przekazać dane do trenowania lub zamiany przedmiotów -->
<script>
  function Sila(Aktualna_Sila){
    //Przeładowywuje strone z parametrem aktualnej siły aby uniknąć złośliwych linków zwiekszających siłę
    window.open(window.location.href+"?TrenujSile="+Aktualna_Sila,"_self")
  }
  function Zrecznosc(Aktualna_Zrecznosc){
    window.open(window.location.href+"?TrenujZrecznosc="+Aktualna_Zrecznosc,"_self")
  }
  function Wytrzymalosc(Aktualna_Wytrzymalosc){
    window.open(window.location.href+"?TrenujWytrzymalosc="+Aktualna_Wytrzymalosc,"_self")
  }
  function Sprzedaj(Numer_przedmiotu){
    //Przeładowywuje stronę z numerek przedmiotu do sprzedania
    //TODO zabezpieczenie przed złośliwymi linkami sprzedajacymi przedmioty po kliknięciu
    window.open(window.location.href+"?Sprzedaj="+Numer_przedmiotu,"_self")
  }
</script>
<?php
//Pobranie stanu gry z servera na podstawie ID użytkownika trzymanego w SESJI
$zapytanie = $login->prepare("SELECT Poziom, Doswiadczenie, Zdrowie, Zloto, Sila, Zrecznosc, Wytrzymalosc, ID_broni, ID_pancerza, Godzina_zajecia, ID_misji, Postep FROM postacie WHERE ID_uzytkownika = ?");
    $zapytanie->bind_param("s", $_SESSION["id"]);
    $zapytanie->execute();
    $zapytanie->bind_result($poziom_uzytkownika, $Doswiadczenie_uzytkownika, $Zdrowie_uzytkownika, $Zloto_uzytkownika, $Sila_uzytkownika, $Zrecznosc_uzytkownika, $Wytrzymalosc_uzytkownika, $ID_broni_uzytkownika, $ID_pancerza_uzytkownika, $Godzina_zajecia_uzytkownika, $ID_misji_uzytkownika, $Postep_uzytkownika);
    $zapytanie->fetch();
    $zapytanie->close();
    $zapytanie = $login->prepare("SELECT EQ_Slot_1_Item_ID, EQ_Slot_2_Item_ID, EQ_Slot_3_Item_ID, EQ_Slot_4_Item_ID, EQ_Slot_5_Item_ID, EQ_Slot_6_Item_ID, EQ_Slot_7_Item_ID, EQ_Slot_8_Item_ID, EQ_Slot_9_Item_ID FROM postacie WHERE ID_uzytkownika = ?");
        $zapytanie->bind_param("s", $_SESSION["id"]);
        $zapytanie->execute();
        $zapytanie->bind_result($EQ_Slot_1_Item_ID, $EQ_Slot_2_Item_ID, $EQ_Slot_3_Item_ID, $EQ_Slot_4_Item_ID, $EQ_Slot_5_Item_ID, $EQ_Slot_6_Item_ID, $EQ_Slot_7_Item_ID, $EQ_Slot_8_Item_ID, $EQ_Slot_9_Item_ID);
        $zapytanie->fetch();
        $zapytanie->close();
        $EQ_slots = array(0,$EQ_Slot_1_Item_ID, $EQ_Slot_2_Item_ID, $EQ_Slot_3_Item_ID, $EQ_Slot_4_Item_ID, $EQ_Slot_5_Item_ID, $EQ_Slot_6_Item_ID, $EQ_Slot_7_Item_ID, $EQ_Slot_8_Item_ID, $EQ_Slot_9_Item_ID);
if(isset($_GET["TrenujSile"])){
      //Sprawdzenie czy użytkownika stać na daną akcję
      if($Zloto_uzytkownika >= ($Sila_uzytkownika*2+3)){
        //Sprawdzenie czy link jest prawidłowy
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
if(isset($_GET["Sprzedaj"])){
  $Sprzedaj = $_GET["Sprzedaj"];
  //Sprawdzenie czy podane miejsce w plecaku nie jest puste, 0 = puste
  if($EQ_slots[$Sprzedaj] == 0){
    echo "<script>alert('Podany przedmiot nie istnieje! " . $EQ_slots[$Sprzedaj] . "');
    window.location = window.location.pathname;
    </script>";
  } else {
    echo $EQ_slots[$Sprzedaj];
    $ID_slotu = "EQ_Slot_" . $Sprzedaj . "_Item_ID";
    //6,3 czyli od 6 miejsca 3 znaki to wyciągniecie wartości przedmiotu z jego kodu. Np.: 00100400800PZbroja rycerska jest warta 8 złota
    $Finalna_ilosc_zlota = $Zloto_uzytkownika + substr($EQ_slots[$Sprzedaj], 6,3 );
    echo $ID_slotu;
    $zapytanie = $login->prepare("UPDATE postacie SET Zloto = ?, $ID_slotu = ? WHERE ID_uzytkownika = ?");
    $zapytanie->bind_param("isi", $Finalna_ilosc_zlota, $zero, $_SESSION["id"]);
    $zapytanie->execute();
    $zapytanie->close();
    echo "<script>alert('Sprzedano przedmiot.');
    window.location = window.location.pathname;
    </script>";
  }
}
echo "<div class='Main_container'>";
?>
<body>
<div class="Cala_szerokosc_div center_text">
  <span class="Tytul">BattleAxe</span>
</div>
<div class="Cala_szerokosc_div">
  <!-- menu główne -->
  <div class="Menu_opcja_active"><a href='zalogowano.php'>Podgląd</div>
  <div class="Menu_opcja"><a href='wyprawa.php'>Wyprawa</div>
  <div class="Menu_opcja"><a href='arena.php'>Arena</div>
  <div class="Menu_opcja"><a href='ranking.php'>Ranking</div>
  <div class="Menu_opcja"><a href='wylogowano.php'>Wyloguj</a></div>
</div>
<div class="Cala_szerokosc_div">
  <div class="Polowa_szerokosc_div">
    <?php echo $_SESSION["nick"] ?>
  </div>
  <div class="Polowa_szerokosc_div">
    Plecak
  </div>
</div>






<div class="EQ_main">
  <div class='EQ_rzad'>
    <div class='Nadprzedmiotami'>
      <div class='EQ_Sell_Equip'>
        <!-- Nad opisami przedmiotów jest zawieszony DIV który po najechanu ujawnia opcje sprzedaży oraz użycia przedmiotu-->
        <img src="placeholder/Hud/Sprzedaj.png" onclick="Sprzedaj(1);" />
      </div>
      <div class='EQ_Sell_Equip'>
        <img src="placeholder/Hud/Uzyj.png" onclick="Uzyj(1);" />
      </div>
      <div class='EQ_Sell_Equip'>
        <img src="placeholder/Hud/Sprzedaj.png" onclick="Sprzedaj(2);" />
      </div>
      <div class='EQ_Sell_Equip'>
        <img src="placeholder/Hud/Uzyj.png" onclick="Uzyj(2);" />
      </div>
      <div class='EQ_Sell_Equip'>
        <img src="placeholder/Hud/Sprzedaj.png" onclick="Sprzedaj(3);" />
      </div>
      <div class='EQ_Sell_Equip'>
        <img src="placeholder/Hud/Uzyj.png" onclick="Uzyj(3);" />
      </div>
    </div>
    <div class='EQ' id='EQ_Slot_1'></div>
    <div class='EQ' id='EQ_Slot_2'></div>
    <div class='EQ' id='EQ_Slot_3'></div>
  </div>
  <div class='EQ_rzad'>
    <div class='EQ' id='EQ_Slot_4'></div>
    <div class='EQ' id='EQ_Slot_5'></div>
    <div class='EQ' id='EQ_Slot_6'></div>
  </div>
  <div class='EQ_rzad'>
    <div class='EQ' id='EQ_Slot_7'></div>
    <div class='EQ' id='EQ_Slot_8'></div>
    <div class='EQ' id='EQ_Slot_9'></div>
  </div>
</div>
<div class="EQ_main">
  <span class="Statystyki_text">
  <?php
  //Wypisanie statystyk do odpowiedniego DIVa, wraz z przekierowaniami do trenowania oraz obliczeniami obrażeń oraz kosztów w złocie
  echo "Poziom doświadczenia: " . $poziom_uzytkownika . " <br />
  Doświadczenie: " . $Doswiadczenie_uzytkownika . "<br />
  Punkty zdrowia: " . $Zdrowie_uzytkownika . "/" . ($Wytrzymalosc_uzytkownika*4+4) ."<br />
  Złoto: " . $Zloto_uzytkownika . "<br />
  Obrażenia: " . ($Sila_uzytkownika + substr($ID_broni_uzytkownika, 0, 3))  . " - " . ($Sila_uzytkownika + substr($ID_broni_uzytkownika, 3, 3)) . "<br />
  Siła: " . ($Sila_uzytkownika + substr($ID_pancerza_uzytkownika, 0, 2)) . " <button onclick='Sila(" . $Sila_uzytkownika . ")'>+</button> " . ($Sila_uzytkownika*2+3) .  " Złota <br />
  Zręczność: " . ($Zrecznosc_uzytkownika + substr($ID_pancerza_uzytkownika, 0, 2)) . "<button onclick='Zrecznosc(" . $Zrecznosc_uzytkownika . ")'>+</button> " . ($Zrecznosc_uzytkownika*2+3) .  " Złota <br />
  Wytrzymalosc: " . ($Wytrzymalosc_uzytkownika  + substr($ID_pancerza_uzytkownika, 0, 2)) . "<button onclick='Wytrzymalosc(" . $Wytrzymalosc_uzytkownika . ")'>+</button> " . ($Wytrzymalosc_uzytkownika*2+3) .  " Złota <br />
  Aktualna misja: " . $ID_misji_uzytkownika . "<br />
  Postęp fabularny: " . $Postep_uzytkownika;
  ?>
  </span>
</div>
  <div class="Polowa_szerokosc_div">
    Wiadomości
  </div>
  <div class="Polowa_szerokosc_div">
    Uzbrojenie
  </div>

<div class="EQ_main">
  <div class='EQ_rzad'>
    <div class='EQ_zalozone' id='EQ_Slot_10'></div>
    <div class='EQ_zalozone' id='EQ_Slot_11'></div>
  </div>
</div>
<div class="EQ_main">bb
</div>
<?php
//Temporarne uruchamianie mechanizmu renderującego przedmioty na stronie
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_1_Item_ID . "', '1');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_2_Item_ID . "', '2');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_3_Item_ID . "', '3');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_4_Item_ID . "', '4');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_5_Item_ID . "', '5');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_6_Item_ID . "', '6');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_7_Item_ID . "', '7');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_8_Item_ID . "', '8');</script>";
echo "<script>RenderujPrzedmioty('" . $EQ_Slot_9_Item_ID . "', '9');</script>";
echo "<script>RenderujPrzedmioty('" . $ID_broni_uzytkownika . "', '10');</script>";
echo "<script>RenderujPrzedmioty('" . $ID_pancerza_uzytkownika . "', '11');</script>";
?>

<button type="submit">Odśwież</button>
</div>
</body>
</html>

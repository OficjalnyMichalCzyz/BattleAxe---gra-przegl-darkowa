<?php require_once 'zmienne\zmienne_globalne.php'; ?>
<?php require_once 'zmienne\podlaczenie_do_bazy.php'; ?>
<?php require_once 'zmienne\dane_sesji.php'; ?>
<?php require_once 'zmienne\anty_pusta_sesja.php'; ?>
<script src='zmienne\przedmioty.js'></script>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/zalogowano.css">
<style>
  .Menu_opcja_active{
    opacity: 1;
    width: 180px;
    height: 50px;
    display: block;
    float: left;
    text-align: center;
    font-size: 32px;
    background-color: yellow;
    line-height: 50px;
  }
  .Menu_opcja{
    width: 180px;
    height: 50px;
    display: block;
    float: left;
    text-align: center;
    font-size: 32px;
    opacity: 0.8;
    transition: 0.3s;
    background-color: yellow;
    line-height: 50px;
  }
  a:link {
    text-decoration: none;
  }
  a:visited {
    color: black;
  }
    .Menu_opcja:hover{
      width: 180px;
      height: 50px;
      opacity: 1;
      text-decoration: none;
    }
    .Cala_szerokosc_div{
    display: block;
    width: 900px;
    height: 50px;
    background-color: yellow;
    }
    .Polowa_szerokosc_div{
    display: block;
    width: 450px;
    height: 50px;
    background-color: green;
    float: left;
    text-align: center;
    font-size: 24px;
    line-height: 50px;
    }
    .Statystyki_text{
    font-size: 24px;
    line-height: 35px;
    }
    .Tytul{
    font-size: 48px;
    line-height: 50px;
    }
    .center_text{
    text-align: center;
    }
    .EQ_zalozone{
    position: relative;
    display: block;
    width:150px;
    height:125px;
    float: left;
    background-image: url("placeholder/Hud/EQ_Slot.png");
    color: white;
    margin: 8%;
    box-sizing: border-box;
    padding: 5px;
    }
    .Nadprzedmiotami{
    z-index: 10;
    position: absolute;
    top: 0px;
    left: 0px;
    width: 450px;
    height: 375px;
    }
    .EQ_Sell_Equip{
    position: relative;
    display: block;
    width:75px;
    height:125px;
    float: left;
    color: white;
    box-sizing: border-box;
    z-index: 15;
    opacity: 0;
    transition-duration: 0.5s;
    }
    .EQ_Sell_Equip:hover{
    opacity: 0.9;
    }
    .EQ_rzad{
      position: relative;
    }
  </style>
</head>
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
  function Sprzedaj(Numer_przedmiotu){
    window.open(window.location.href+"?Sprzedaj="+Numer_przedmiotu,"_self")
  }
</script>
<?php

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
if(isset($_GET["Sprzedaj"])){
  $Sprzedaj = $_GET["Sprzedaj"];
  if($EQ_slots[$Sprzedaj] == 0){
    echo "<script>alert('Podany przedmiot nie istnieje! " . $EQ_slots[$Sprzedaj] . "');
    window.location = window.location.pathname;
    </script>";
  } else {
    echo $EQ_slots[$Sprzedaj];
    $ID_slotu = "EQ_Slot_" . $Sprzedaj . "_Item_ID";
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

function RenderujPrzedmioty(ID, NR) {
  if ((ID.slice(11, 12)) == "B") {
    var ID = {
      ObrMin: parseInt(ID.slice(0, 3), 10),
      ObrMax: parseInt(ID.slice(3, 6), 10),
      Zloto: parseInt(ID.slice(6, 9), 10),
      Obrazek: ID.slice(9, 11),
      Typ: parseInt(ID.slice(11, 12), 10),
      Nazwa: ID.slice(12),
    }
    var Obrazek = "<img class='EQ_img_func' src='placeholder\\bronie\\Bron" + ID.Obrazek + ".png'>";
    document.getElementById(("EQ_Slot_" + NR)).innerHTML = ID.Nazwa + "<br>Obrażenia: " + ID.ObrMin + " - " + ID.ObrMax + "<br> <br> <br>Wartość: " + ID.Zloto + " <br>Broń<br>" + Obrazek;
  }
  if ((ID.slice(11, 12)) == "P") {
    var ID = {
      Sila: parseInt(ID.slice(0, 2), 10),
      Zrecznosc: parseInt(ID.slice(2, 4), 10),
      Wytrzymalosc: parseInt(ID.slice(4, 6), 10),
      Zloto: parseInt(ID.slice(6, 9), 10),
      Obrazek: ID.slice(9, 11),
      Typ: ID.slice(11, 12),
      Nazwa: ID.slice(12),
    }
    var Obrazek = "<img class='EQ_img_func' src='placeholder\\pancerze\\Pancerz" + ID.Obrazek + ".png'>";
    document.getElementById(("EQ_Slot_" + NR)).innerHTML = ID.Nazwa + "<br>Sila: " + ID.Sila + "<br>Zrecznosc: " + ID.Zrecznosc + "<br>Wytrzymalosc: " + ID.Wytrzymalosc + "<br>Wartość: " + ID.Zloto + "<br>Pancerz<br>" + Obrazek;
  }
  if ((ID.slice(11, 12)) == "J") {
    var ID = {
      Leczy: parseInt(ID.slice(0, 3), 10),
      Zloto: parseInt(ID.slice(6, 9), 10),
      Obrazek: ID.slice(9, 11),
      Typ: ID.slice(11, 12),
      Nazwa: ID.slice(12),
    }
    var Obrazek = "<img class='EQ_img_func' src='placeholder\\Jadalne\\Jadalne" + ID.Obrazek + ".png'>";
    document.getElementById(("EQ_Slot_" + NR)).innerHTML = ID.Nazwa + "<br>Leczy: " + ID.Leczy +  "<br><br> <br> Wartość: " + ID.Zloto + "<br>Jadalne<br>" + Obrazek;
  }
//www.php.net/manual/en/function.array-slice.php
}

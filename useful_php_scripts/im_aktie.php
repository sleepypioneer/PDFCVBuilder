<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php
   // Grafik erzeugen
   $im = imagecreate(400,400);

   // Farben, Schriftart
   $grau = imagecolorallocate($im, 192, 192, 192);
   imagefill ($im, 0, 0, $grau);
   $s = imagecolorallocate($im, 0, 0, 0);
   $r = imagecolorallocate($im, 255, 0, 0);
   $schriftart = "arial.ttf";

   // Startdatum
   $ds = "28.02.2016";
   $datum = mktime(0, 0, 0, substr($ds,3,2), substr($ds,0,2),
      substr($ds,6,4));
   $datum = strtotime("-35 day", $datum);

   // Kurse
   srand((double)microtime()*1000000);
   $kurs[0] = 25;
   for($i=1; $i<36; $i++)
   {
      $kurs[$i] = $kurs[$i-1] + rand(-3,3);
      if($kurs[$i]<1)
         $kurs[$i] = 1;
   }

   // Gitternetz, Beschriftung
   for($i=0; $i<6; $i++)
   {
      imageline($im, 30, 30 + $i * 340/5, 370, 30 + $i * 340/5, $s);
      imagettftext($im, 11, 0, 375, 30 + $i * 340/5, $s,
         $schriftart, 50-$i*10);
      imageline($im, 30 + $i * 340/5, 30, 30 + $i * 340/5, 370, $s);
      imagettftext($im, 11, 0, 12 + $i * 340/5, 385, $s,
         $schriftart, date("d.m.",$datum));
      $datum = strtotime("+7 day", $datum);
   }

   // Kurs darstellen
   for($i=0; $i<35; $i++)
      imageline($im, 30 + $i * 340/35, 370 - $kurs[$i] * 340/50,
         30 + ($i+1) * 340/35, 370 - $kurs[$i+1] * 340/50, $r);

   // Grafik darstellen und Speicher freigeben
   imagejpeg($im, "im_test.jpg");
   imagedestroy($im);
?>
<img src="im_test.jpg">
</body></html>

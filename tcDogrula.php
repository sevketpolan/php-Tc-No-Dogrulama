<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Yaşar Üniversitesi Web Servis</title>
</head>

<body>
<?php
function karakter_duzeltme($gelen){
    $karakterler = array("ç","ğ","ı","i","ö","ş","ü");
    $degistir = array("Ç","Ğ","I","İ","Ö","Ş","Ü");
    return str_replace($karakterler, $degistir, $gelen);
}
function tcDogrula($trID,$firstName,$lastName,$birthYear){
	try {
$service = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?wsdl");
$result = $service->TCKimlikNoDogrula(array("TCKimlikNo"=>trim($trID),"Ad"=>strtoupper(karakter_duzeltme(trim($firstName))),"Soyad"=>strtoupper(karakter_duzeltme(trim($lastName))),"DogumYili"=>trim($birthYear)));
//print_r($result);
if($result->TCKimlikNoDogrulaResult!=""){
if($result->TCKimlikNoDogrulaResult==1){return true;}
}else{return false;}
	}catch (Exception $hata){
       return false;
    }
}
if(isset($_POST['gonder'])){
	echo $tc=$_POST['tc'];
	echo $ad=$_POST['ad'];
	echo $soyad=$_POST['soyad'];
	echo $yil=$_POST['yil'];
    $x=tcDogrula($tc,$ad,$soyad,$yil);
print_r($x);
	}
?>
<form action="" method="post">
<input name="tc"  placeholder="Tc"><br>
<input name="ad" placeholder="Ad"><br>
<input name="soyad" placeholder="Soyad"><br>
<input name="yil" placeholder="Yıl"><br>
<input type="submit" name="gonder" value="Gönder"></form>
</body>
</html>

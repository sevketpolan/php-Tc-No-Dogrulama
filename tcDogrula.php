<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>TcDogrula</title>
</head>

<body>
<?php
//strtoupper fonksiyonu türkçe karakterleri büyük harf yapmaz onun için bu fonksiyonla düzeltiyoruz.
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
if($result->TCKimlikNoDogrulaResult==1){
	/doğru yanlış veya array olarak değer döndürebilirsiniz.
	//return true;
	return $result;
}
}else{
	//doğru yanlış veya array olarak değer döndürebilirsiniz.
	//return false;
	return $result;
}
	}catch (Exception $hata){
       return false;
    }
}
if(isset($_POST['gonder'])){
	echo $tc=$_POST['tc'];
	echo $ad=$_POST['ad'];
	echo $soyad=$_POST['soyad'];
	echo $yil=$_POST['yil'];
    $status=tcDogrula($tc,$ad,$soyad,$yil);
print_r($status);
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

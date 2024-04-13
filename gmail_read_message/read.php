<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Gmail</title>
</head>
<body>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";
$scriptUrl = "YOUR_APPS_SCRIPT_URL";

$data = array(
    "action" => "inboxRead",
    "id"  => $id,
);

$ch = curl_init($scriptUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
$result = json_decode($result, true);


$from = $result['data']['from'];
$subject = $result['data']['subject'];
$body = $result['data']['body'];
$plainBody = $result['data']['plainBody'];

echo "From:<br><b>$from</b><br><br>";
echo "Subject:<br><b>$subject</b><br><br>";
echo "Body:<br>$plainBody<br>";

?>
</body>
</html>
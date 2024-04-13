<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail Inbox</title>
</head>
<body>
<style>
    * {font-family: Arial, sans-serif;}
    table{ border-collapse: collapse; }
    td{ padding: 10px; }
</style>
<h1>Gmail Inbox</h1>
<table width="500" border="1">
    <tr bgcolor="#eeeeee">
        <td>From</td>
        <td>Subject</td>
        <td>Date</td>
    </tr>
    <?php
    $scriptUrl = "YOUR_APPS_SCRIPT_URL";
    $limit  = 20; //data show per page
    $offset = 0; //start from

    $data = array(
        "action" => "inboxList",
        "limit"  => $limit,
        "offset" => $offset
    );

    $ch = curl_init($scriptUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    $result = json_decode($result, true);


    if($result['status'] == 'success'){
        foreach($result['data'] as $inbox){
            echo "<tr>";
            echo "<td>{$inbox['from']}</td>";
            echo "<td><a href='read.php?id={$inbox['id']}'>{$inbox['subject']}</a></td>";
            echo "<td>{$inbox['date']}</td>";
            echo "</tr>";
        }
    }
    ?>
</table>



</body>
</html>
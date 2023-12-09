<?php

$hubVerifyToken='EAADQiCtG8xkBOZCqmsg71cHZBRhImJETFABhdkWxKpZBsR4dpFpIlvLmN06DKLOrbZCjmS0DWVZB6TYgWNyjWAYOve4RdyIizWc85PeoLwAZC3AWwNj0O1pIUtFGVbaeSTIs1jBwNllmZCfyjfPkYBM1ArJvAwzQdtKTi65wHc0Y1gr5D0Ymvwja4I0BZCn9GgCbZA1Oy53ZAnKNzG6nO5';
$accessToken ="Eksjsjksoacabaoisvskaisnaiagavanha";


if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}


  

 $input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];


if($messageText=="hi"){
$answer="hello From server";
}
  


//send message to facebook bot
$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];

$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
if(!empty($input)){
$result = curl_exec($ch);
}
curl_close($ch);


 
?>

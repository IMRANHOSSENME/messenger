<?php

$hubVerifyToken='EAAMg1bZB1a1UBAJ8kkmPNybVNxCk5qf6tMAsHiJ9P2KCMmqe0xvs8QWmJXP7FcbTXi8yHNZAfZALmbr48ijBpwAcfqWmQec96dIsNqYl8nmsMDZAkRn2u8yRsWjmkmMm1d87zyv0QfO74QhhQKUXvG9JENneZB0sSqZAGilMyGYLUbJaAd5zS4E6PfeiZAWR02ZBuPhjCzMdQQZDZD';
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
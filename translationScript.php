<?php

$url_fr = 'https://localise.biz/api/export/locale/fr.yml?format=nested';
$url_en = 'https://localise.biz/api/export/locale/en.yml?format=nested';

$url_tab = array('fr' => $url_fr, 'en' => $url_en);
$array_key_tab = array_keys($url_tab);

for($i = 0; $i < sizeof($array_key_tab) ; $i++ ){

  $ch = curl_init();

  // Disable SSL verification
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  // Will return the response, if false it print the response
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Set the url
  curl_setopt($ch, CURLOPT_USERPWD, "cGh3iVpGVtv79nSmXCOOcJaiFJG1EQTO:");

  curl_setopt($ch, CURLOPT_URL,$url_tab[$array_key_tab[$i]]);
  // Execute
  $result=curl_exec($ch);
  // Closing
  curl_close($ch);

  // Will dump a beauty json :3


  $translation = "src/PdfGenesis/CoreBundle/Resources/translations/messages.".$array_key_tab[$i].".yml";

  if(isset($result)){

    $result = str_replace('...','',$result);
    $result = str_replace('---','',$result);

    $header = $array_key_tab[$i].'-'. countryCode($array_key_tab[$i]).':';

    $result = str_replace($header,'',$result);

    unlink($translation);

    // Création du nouveau fichier et ouverture du fichier
    $open = fopen("$translation","a+");

    fwrite($open,$result);

    fclose($translation);

    echo $header;

  }
}


function countryCode($code){

  switch($code){
    case 'fr':
      return 'FR';
    case 'en':
      return 'GB';
    default:
      return '';
  }

}




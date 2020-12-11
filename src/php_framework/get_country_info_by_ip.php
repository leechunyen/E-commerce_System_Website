<?php
// PHP code to obtain country, city,  
// continent, etc using IP Address 
function getCountryInfo($ip){
    // Use JSON encoded string and converts 
    // it into a PHP variable 
    $info=@json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
    return$info;
} 
//echo 'Country Name: ' . $ipdat->geoplugin_countryName . "<br/>"; 
//echo 'City Name: ' . $ipdat->geoplugin_city . "<br/>"; 
//echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "<br/>"; 
//echo 'Latitude: ' . $ipdat->geoplugin_latitude . "<br/>"; 
//echo 'Longitude: ' . $ipdat->geoplugin_longitude . "<br/>"; 
//echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "<br/>"; 
//echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "<br/>"; 
//echo 'Timezone: ' . $ipdat->geoplugin_timezone;
?>
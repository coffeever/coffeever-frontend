<?php

defined('INDEX') or die();

function getToken($userData){
	if(empty($userData)){
		return '';
	}
	$userId = $userData['_id'].generateRandomString(strlen($userData['password'])-strlen($userData['_id']));
	$token = "";
	for($i=0;$i<strlen($userData['password']);$i++){
		$token .= $userId[$i].$userData['password'][$i];
	}
	return $token;
}

function getSafeUrl($link)
{
    if (startsWith($link, 'http://') !== false || startsWith($link, 'https://') !== false) {
        return $link;
    }
    return SITE_URL.$link;
}

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function excerptStringByWord($string,$length)
{

    $pieces = explode(" ",strip_tags($string));
    if(count($pieces)<$length){
        return $string;
    }
    return join(" ",array_slice($pieces, 0, $length)). " ...";
}

function excerptString($string, $limit)
{
    return substr($string, 0, $limit);
}

function cacheIt($filename, $content)
{
    file_put_contents(CACHE_DIR . $filename, $content);
}

function getCacheFile($filename)
{
    return file_get_contents(CACHE_DIR . $filename);
}

function cacheExists($filename)
{
    return file_exists(CACHE_DIR . $filename);
}

function clearCache($onlyHtml=false)
{
    $list = glob(CACHE_DIR . '*');
    foreach ($list as $file) {
        if($onlyHtml){
            if (strpos($file, '.html') !== false) {
                unlink($file);
            }
        }
        else{
            unlink($file);
        }
    }
}
function getFirstLetters($name){
    if(strlen($name)<2){
        return $name;
    }
    $pieces = explode(" ", $name);
    if(count($pieces)>=2){
        $first = $pieces[0][0];
        $second = $pieces[1][0];
        return mb_strtoupper($first.$second);
    }
    return mb_strtoupper(mb_substr($name, 0, 2));
}

function isLoggedInInstructor(){
    return isset($_SESSION['isLoggedInInstructor']) ? $_SESSION['isLoggedInInstructor'] : false;
}

function isLoggedIn(){
    return isset($_SESSION['isLoggedIn']) ? $_SESSION['isLoggedIn'] : false;
}

function getCurrentInstructor(){
    return isset($_SESSION['instructorObj']) && !empty($_SESSION['instructorObj']) ? $_SESSION['instructorObj'] : [];
}

function getCurrentSubscriber(){
    return isset($_SESSION['subscriberObj']) && !empty($_SESSION['subscriberObj']) ? $_SESSION['subscriberObj'] : [];
}

function getCurrentInstructorValue($key){
    if(isset($_SESSION['instructorObj']) && !empty($_SESSION['instructorObj']) && array_key_exists($key,$_SESSION['instructorObj'])){
        return $_SESSION['instructorObj'][$key];
    }
    return '';
}

function getCurrentSubscriberValue($key){
    if(isset($_SESSION['subscriberObj']) && !empty($_SESSION['subscriberObj']) && array_key_exists($key,$_SESSION['subscriberObj'])){
        return $_SESSION['subscriberObj'][$key];
    }
    return '';
}

function makeRequest($path, $body = array(), $method = "POST")
{
    debugPrint($body);
    $defaultFilter = array();
    $defaultParams = array();
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => (API_USE_SSL ? "https" : "http") . "://" . API_HOST . "/" . $path,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($err) {
//        if (DEBUG_MODE) {
//            debugPrint($response);
//            echo "DEBUG: Curl error occured: " . $err . "<br>";
//        }
        return false;
        //die("An error occured. Please contact with administrators!");
    } else {
        if ($httpcode == 200) {
            return json_decode($response, TRUE);
        } else {
//            if (DEBUG_MODE) {
//                debugPrint($path);
//                debugPrint($response);
//            }
            debugPrint($response);
            return  json_decode($response, TRUE);
            //die("An error occured. Please contact with administrators!");
        }
    }
}

function parseEsDate($str){
    $gun_dizi = array(
        'Monday'    => 'Lunes',
        'Tuesday'   => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday'  => 'Jueves',
        'Friday'    => 'Viernes',
        'Saturday'  => 'Sábado',
        'Sunday'    => 'Domingo',
        'January'   => 'Enero',
        'February'  => 'Febrero',
        'March'     => 'Marzo',
        'April'     => 'Abril',
        'May'       => 'Mayo',
        'June'      => 'Junio',
        'July'      => 'Julio',
        'August'    => 'Agosto',
        'September' => 'Septiembre',
        'October'   => 'Octubre',
        'November'  => 'Noviembre',
        'December'  => 'Diciembre',
        'Mon'       => 'Lun',
        'Tue'       => 'Mar',
        'Wed'       => 'Mie',
        'Thu'       => 'Jue',
        'Fri'       => 'Vie',
        'Sat'       => 'Sab',
        'Sun'       => 'Dom',
        'Jan'       => 'Ene',
        'Feb'       => 'Feb',
        'Mar'       => 'Mar',
        'Apr'       => 'Abr',
        'Jun'       => 'Jun',
        'Jul'       => 'Jul',
        'Aug'       => 'Ago',
        'Sep'       => 'Sep',
        'Oct'       => 'Oct',
        'Nov'       => 'Nov',
        'Dec'       => 'Dic',
    );
    return str_replace(array_keys($gun_dizi),array_values($gun_dizi),$str);
}

function formatDate($dateStr){
    $time = strtotime($dateStr);
    $newformat = date('d M Y',$time);
    //return $newformat;
    return parseEsDate($newformat);
}
function parseTrDate($str){
    $gun_dizi = array(
        'Monday'    => 'Pazartesi',
        'Tuesday'   => 'Salı',
        'Wednesday' => 'Çarşamba',
        'Thursday'  => 'Perşembe',
        'Friday'    => 'Cuma',
        'Saturday'  => 'Cumartesi',
        'Sunday'    => 'Pazar',
        'January'   => 'Ocak',
        'February'  => 'Şubat',
        'March'     => 'Mart',
        'April'     => 'Nisan',
        'May'       => 'Mayıs',
        'June'      => 'Haziran',
        'July'      => 'Temmuz',
        'August'    => 'Ağustos',
        'September' => 'Eylül',
        'October'   => 'Ekim',
        'November'  => 'Kasım',
        'December'  => 'Aralık',
        'Mon'       => 'Pzt',
        'Tue'       => 'Sal',
        'Wed'       => 'Çar',
        'Thu'       => 'Per',
        'Fri'       => 'Cum',
        'Sat'       => 'Cts',
        'Sun'       => 'Paz',
        'Jan'       => 'Oca',
        'Feb'       => 'Şub',
        'Mar'       => 'Mar',
        'Apr'       => 'Nis',
        'May'       => 'May',
        'Jun'       => 'Haz',
        'Jul'       => 'Tem',
        'Aug'       => 'Ağu',
        'Sep'       => 'Eyl',
        'Oct'       => 'Eki',
        'Nov'       => 'Kas',
        'Dec'       => 'Ara',
    );
    return str_replace(array_keys($gun_dizi),array_values($gun_dizi),$str);
}

function formatDateTime($dateStr){
    $time = strtotime($dateStr);
    $newformat = date('d M Y',$time);
    return parseTrDate($newformat);
}

function getTimthumbImage($src,$width=0,$height=0,$zc=1)
{
    if(strpos($src, 'http') !== false) {
        return $src;
    }

    if(empty($src) || !file_exists('./asset/img/' . $src)){
        return '/assets/img/default.jpg';
    }
    $addZc = false;
    if($zc!=1){
        $addZc = true;
    }
    $addHeight = false;
    if($height!=0){
        $addHeight = true;
    }
    if($addZc){
        return SITE_URL.'/resimler/'.$width.'x'.$height.'_'.$zc.'/'.$src;
    }
    if($addHeight){
        return SITE_URL.'/resimler/'.$width.'x'.$height.'/'.$src;
    }
    return SITE_URL.'/resimler/'.$width.'/'.$src;
}

function getPictureWithLink($filename)
{
    if(strpos($filename, 'http') !== false) {
        return $filename;
    }

    if(empty($filename) || !file_exists('./asset/img/' . $filename)){
        return '/assets/img/default.jpg';
    }

    return STATIC_URL  .'img/'. $filename;
}

function debugPrint(...$var)
{
    if(DEBUG_MODE){
        echo "<pre>";
        var_dump($var);
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,10);
        echo "</pre>";
    }
}

function getPaymentMethodStr($paymentMethod){
    if(empty($paymentMethod)){
        return "-";
    }

    switch($paymentMethod){
        case '1':
        case 1:
            return 'Transferencia Bancaria Directa';
        case '2':
        case 2:
            return 'RedSys';
        case '3':
        case 3:
            return 'SeQura';
        default:
            return '-';
    }
}
function replace_accent($str)
{
    $a = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç", 'á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü');
    $b = array("i", "g", "u", "s", "o", "c", "I", "G", "U", "S", "O", "C", 'a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'n', 'N', 'u', 'U');
    return str_replace($a, $b, $str);
}

function doubleAccentLetters($str){
    $a = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç", 'á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü');
    $b = array("i", "g", "u", "s", "o", "c", "I", "G", "U", "S", "O", "C", 'a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'n', 'N', 'u', 'U');
    //áéíóúüñ
    //ÁÉÍÓÚÜÑ
    //$str = preg_replace("@([ıií])@",'(ı|i|í)',$str);
    $str = str_replace(["(",")"],["\(","\)"],$str);
    $str = preg_replace("@(a|á|A|Á)@",'(a|á|A|Á)',$str);
    $str = preg_replace("@(e|é|E|É)@",'(e|é|E|É)',$str);
    $str = preg_replace("@(ı|i|í|I|İ|Í)@",'(ı|i|í|I|İ|Í)',$str);
    $str = preg_replace("@(o|ó|ö|O|Ó|Ö)@",'(o|ó|ö|O|Ó|Ö)',$str);
    $str = preg_replace("@(u|ú|ü|U|Ú|Ü)@",'(u|ú|ü|U|Ú|Ü)',$str);
    $str = preg_replace("@(n|ñ|N|Ñ)@",'(n|ñ|N|Ñ)',$str);
    $str = str_replace(["#","!","^","$","`",'"',"?","*"],"",$str);
    return $str;
}

function stringURLSafe($str, $replace = array(), $delimiter = '-')
{
    if (!empty($replace)) {
        $str = str_replace((array)$replace, ' ', $str);
    }

    $clean = replace_accent($str);
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}

function stringURLSafeV2($string)
{
    //remove any '-' from the string they will be used as concatonater
    $str = str_replace('-', ' ', $string);
    $str = str_replace('_', ' ', $string);

    //$str = $lang->transliterate($str);
    //convert unwanted characters
    $turkish = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç");
    $english = array("i", "g", "u", "s", "o", "c", "I", "G", "U", "S", "O", "C");
    $str = str_replace($turkish, $english, $str);

    // remove any duplicate whitespace, and ensure all characters are alphanumeric
    $str = preg_replace(array('/\s+/', '/[^A-Za-z0-9\-]/'), array('-', ''), $str);

    // lowercase and trim
    $str = trim(strtolower($str));
    return $str;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getPage(){
    return isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
}

function calcPageMax($total){
    $ps = getConfigParam('PAGE_SIZE');
    if($total<$ps){
        return 1;
    }
    return ceil($total/$ps);
}

function getQueryStringParam($key){
    $qs = $_SERVER['QUERY_STRING'];
    if(!empty($qs)){
        $pairs = explode('&',$qs);
        if(count($pairs)>0){
            foreach($pairs as $pair){
                $p = explode('=',$pair);
                if(count($p)>1 && $p[0] == $key){
                    return $p[1];
                }
            }
        }
    }
    return "";
}

function addParamsToQueryString($key,$value){
    $newQsArr = [];
    $qs = $_SERVER['QUERY_STRING'];
    if(!empty($qs)){
        $pairs = explode('&',$qs);
        if(count($pairs)>0){
            foreach($pairs as $pair){
                $p = explode('=',$pair);
                if(count($p)>1 && $p[0]!='p' && $p[0] != $key){
                    $newQsArr[] = $pair;
                }
            }
        }
    }
    $newQsArr[] = $key."=".urlencode($value);
    $newQsStr = "?".join('&',$newQsArr);
    return $newQsStr;
}
function getSkipSize(){
    $p = getPage();
    $skip = ($p-1) * getConfigParam('PAGE_SIZE');
    return $skip;
}

function getConfigParam($paramName){
    if(empty($paramName)){
        return "";
    }
    global $config;
    return array_key_exists($paramName,$config) && !empty(array_key_exists($paramName,$config)) ? $config[$paramName] : "";
}

function setConfigParam($paramName,$paramValue){
    if(empty($paramName)){
        return;
    }
    global $config;
    $config[$paramName] = $paramValue;
}

function printOnFooter($text){
    global $footerAppend;
    $footerAppend[]=$text;
}

function printFooterAppend(){
    global $footerAppend;
    echo join("\n",$footerAppend);
    echo "\n";
}

function unsetAuthParams(){
    if(isset($_SESSION) && !empty($_SESSION)){
        $_SESSION['isLoggedIn'] = false;
        $_SESSION['subscriberObj'] = array();
        $_SESSION['isLoggedInInstructor'] = false;
        $_SESSION['instructorObj'] = array();
        unset($_SESSION['isLoggedIn']);
        unset($_SESSION['subscriberObj']);
        unset($_SESSION['isLoggedInInstructor']);
        unset($_SESSION['instructorObj']);
    }
}

function makeNonce($seed,$i=0){
    $q=-4;
    //The epoch time stamp is truncated by $q chars,
    //making the algorthim to change evry 1000 seconds
    //using q=-4; will give 10000 seconds= 2 hours 46 minutes usable time

    $TimeReduced=substr(time(),0,$q)-$i;

    //the $seed is a constant string added to the string before hashing.
    $string=$seed.$TimeReduced;
    $hash=hash('sha1', $string, false);
    return  $hash;
}

function checkNonce($nonce,$seed){
    //Note that the previous nonce is also checked giving  between
    // useful interval $t: 1*$qInterval < $t < 2* $qInterval where qInterval is the time deterimined by $q:
    //$q=-2: 100 seconds, $q=-3 1000 seconds, $q=-4 10000 seconds, etc.
    if($nonce==makeNonce($seed,0)||$nonce==makeNonce($seed,1))     {
        //handle data here
        return true;
    } else {
        //reject nonce code
        return false;
    }
}


function lang()
{
    global $currentLanguage;
    return $currentLanguage;
}
function _lang()
{
    global $currentLanguage;
    echo $currentLanguage;
}
function getLocalizedText($text){
    global $currentLanguage;
    global $translations;
    if(empty($text) || empty($translations)){
        return '';
    }
    $list = array_filter($translations,function ($v) use($text){return $v['keyword']==$text;});
    return !empty($list) ? $list[0][$currentLanguage] : '';
}
function __($string)
{
    $t = getLocalizedText($string);
    echo $t;
    return $t;
}
function _t($string)
{
    return getLocalizedText($string);
}
function detectLanguage(){
    $allowedLanguages = ['es','en'];
    $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if(isset($_GET['lang']) && in_array($_GET['lang'],$allowedLanguages)){
        $lang = $_GET['lang'];
    }
    elseif(isset($_SESSION['lang']) && in_array($_SESSION['lang'],$allowedLanguages)){
        $lang = $_SESSION['lang'];
    }
    elseif(!empty($browserLang) && in_array($browserLang,$allowedLanguages)){
        $lang = $browserLang;
    }
    else{
        $lang = 'es'; //default language is spanish
    }
    $_SESSION['lang'] = $lang; //save language to session
    return $lang;
}

function parseUrlStructure($urlStructure){
    $find = [
        '%alias%',
        '%etiket%'
    ];
    $replace = [
        '([a-zA-Z0-9-]+)',
        '([a-zA-Z0-9-]+)'
    ];
    return str_replace($find,$replace,$urlStructure);
}
function titleToSentence($string) {
    $re = '/(?#! splitCamelCase Rev:20140412)
    # Split camelCase "words". Two global alternatives. Either g1of2:
      (?<=[a-z])      # Position is after a lowercase,
      (?=[A-Z])       # and before an uppercase letter.
    | (?<=[A-Z])      # Or g2of2; Position is after uppercase,
      (?=[A-Z][a-z])  # and before upper-then-lower case.
    /x';
    $a = preg_split($re, $string);
    $word = "";
    for ($i = 0; $i < count($a); ++$i) {
        $a[$i] = strtolower($a[$i]);
        if ($a[$i] == "turu") {
            $a[$i] = "türü";
        }
        if ($a[$i] == "kumas") {
            $a[$i] = "kumaş";
        }
        if ($a[$i] == "sadece-kilif") {
            $a[$i] = "sadece kılıf";
        }
        if ($a[$i] == "firfir") {
            $a[$i] = "fırfır";
        }
        $word .=  $a[$i]. " ";
    }
    return ucfirst($word);
}

function getOrderStateString($state){
    switch ($state) {
        case 'waiting':
            return 'Beklemede';
            break;
        case 'approved':
            return 'Onaylandı';
            break;
        case 'shipping':
            return 'Kargoda';
            break;
        case 'arrived':
            return 'Ulaştı';
            break;
        case 'completed':
            return 'Tamamlandı';
            break;
    }
}

function getTemplateFile($file){
    global $currentTemplate;
    return SITE_URL.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$currentTemplate.DIRECTORY_SEPARATOR.$file;
}

function calculatePrice($price, $priceCurrency, $discountType, $discountAmount, $isTaxIncluded, $taxRate) {

    $xml = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
    $dolar = $xml->Currency[0]->ForexSelling;
    $euro = $xml->Currency[3]->ForexSelling;

    $newPrice = $price;

    switch ($priceCurrency) {
        case 'try':
            $newPrice = $price;
            break;
        case 'usd':
            $newPrice = $price * $dolar;
            break;
        case 'eur':
            $newPrice = $price * $euro;
            break;
    }

    if ($isTaxIncluded == 'no') {
        $newPrice = $newPrice + ($newPrice * $taxRate / 100);
    }

    if ($discountType == 'ratio') {
        $newPrice = $newPrice - ($newPrice * $discountAmount / 100);
    }
    if ($discountType == 'fixed') {
        $newPrice =$newPrice - $discountAmount;
    }

    return number_format($newPrice, 2);
}
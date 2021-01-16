<?php
defined('INDEX') or die();
global $REMOTE_ADDR;
global $recaptcha;
$HTTP_ORIGIN = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "";
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header ("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$_PHPINPUT = json_decode(file_get_contents("php://input"),true);
$_POST = empty($_POST) ? empty($_PHPINPUT) ? $_POST : $_PHPINPUT : $_POST;
$_POST = isset($_GET['nane']) ? $_GET : $_POST;
if(isset($_POST) && !empty($_POST)){
    if (isset($_POST['hash']) && !empty($_POST['hash']) && isset($_POST['status']) && !empty($_POST['status']) && isset($_POST['total_amount']) && !empty($_POST['total_amount'])) {
        $hash = base64_encode( hash_hmac('sha256', $_POST['merchant_oid'].MERCHANT_SALT.$_POST['status'].$_POST['total_amount'], MERCHANT_KEY, true) );
        if( $hash != $_POST['hash'] ){
            die('PAYTR notification failed: bad hash');
        }
        if( $_POST['status'] == 'success' ) {
            $result = makeRequest('orders/setPaymentStatus', [], ['fields' => ['orderNumber'=>$_POST['merchant_oid'], 'status' => 'success']]);
            setcookie('wishList', '');
        } else {
            $paymentFailLog = ['code' => $_POST['failed_reason_code'], 'message' => $_POST['failed_reason_msg']];
            $result = makeRequest('orders/setPaymentStatus', [], ['fields' => ['orderNumber'=>$_POST['merchant_oid'], 'status' => 'fail', ]]);
        }
        echo "OK";
        exit;
    }
    global $actionResult;
	$issetRecaptcha = false;
	$resolvedRecaptcha = false;
	if(!isset($_POST['_nonce']) || md5(INDEX) != $_POST['_nonce'] || !isset($_POST['action'])){
        die("Invalid request");
    }
    // Check if form was submitted:
    else if (isset($_POST['recaptcha_response']) || isset($_POST['g-recaptcha-response'])) {

		$issetRecaptcha = true;
		$captcha = empty($_POST['recaptcha_response']) ? $_POST['g-recaptcha-response'] : $_POST['recaptcha_response'];
		$secretKey = "6LeMc-QUAAAAAKV7QJ8WtCYqXq4dTDZH4fRRDL-3";
		$ip = $REMOTE_ADDR;
		// post request to server
		$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
		$response = file_get_contents($url);
		$responseKeys = json_decode($response,true);
		// should return JSON with success as true
		if($responseKeys["success"]) {
			$resolvedRecaptcha = true;
		} else {
			$resolvedRecaptcha = false;
		}
    }
    $action = isset($_POST['action']) ? $_POST['action'] : "";
    $resolvedRecaptcha = true; // recaptcha eklendiğinde bu satırı sil
    $issetRecaptcha = true; // recaptcha eklendiğinde bu satırı sil
    switch($action){
        case 'add-fav':
            if(!isLoggedIn()){                        
                header("Refresh:5; url=/login");
            }
            $userId = intval($_POST['user-id']);
            $cofffeeSlug = $_POST['coffee-slug'];
            $user = [
                "google_id"=> $userId,
                "favorites"=> $cofffeeSlug
            ];
            $result = makeRequest('addFavorite',$user,'GET');
            $user = makeRequest("login", $_SESSION['subscriberObj'], 'POST');
            $_SESSION['subscriberObj'] = $user;
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
            }
            break;
        case 'delete-fav':
            if(!isLoggedIn()){                        
                header("Refresh:5; url=/login");
            }
            $userId = intval($_POST['user-id']);
            $cofffeeSlug = $_POST['coffee-slug'];
            $user = [
                "google_id"=> $userId,
                "favorites"=> $cofffeeSlug
            ];
            $result = makeRequest('deleteUserFavorite',$user,'GET');
            $user = makeRequest("login", $_SESSION['subscriberObj'], 'POST');
            $_SESSION['subscriberObj'] = $user;
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
            }
            break;
        case 'register':
            if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']){
                $actionResult['status'] = false;
                $actionResult['message'] = 'Zaten giriş yaptınız!!';
                break;
            }
            $name = trim( $_POST['customer-name']);
            $surname = trim( $_POST['customer-surname'] );
            $email = trim( $_POST['customer-email']);
            $password = trim( $_POST['customer-password']);
            $repassword = trim($_POST['customer-repassword']);
            if($password != $repassword){
                $actionResult['status'] = false;
                $actionResult['message'] = "Parolalar uyuşmuyor!";
                break;
            }
            if($issetRecaptcha && $resolvedRecaptcha){
                $result = makeRequest('subscribers/registerSubscriber',[],['fields'=>['name'=>$name, 'surname'=> $surname, 'email'=>$email,'password'=>$password]]);
                if(!empty($result)){
                    if($result['success']){
                        $actionResult['status'] = true;
                        $actionResult['message'] = "Hesap başarıyla oluşturulmuştur. E-posta adresiniz ve şifreniz ile giriş yapabilirsiniz.";
                        header("Refresh:5; url=/giris-yap");
                    }
                    else{
                        $actionResult['status'] = false;
                        $actionResult['message'] = $result['message'];
                    }
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = "Bir hata oluştu!!";
                }
            }else {
                $actionResult['status'] = false;
                $actionResult['message'] = "Recaptcha doğrulanmadı!";
            }
            break;
        case 'login':
            unsetAuthParams();
            $email = trim( $_POST['customer-email']);
            $password = md5($_POST['customer-password']);
            $result = makeRequest('get',['email'=>$email,'password'=>$password],['collection'=>'subscribers']);
            if(!empty($result)){
                if(isset($result['success']) && !$result['success']){
                    $actionResult['status'] = false;
                    $actionResult['message'] = "E-posta ve şifre uyuşmuyor!";
                    $_SESSION['isLoggedIn'] = false;
                    $_SESSION['subscriberObj'] = array();
                }
                else{
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Başarılı";
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['subscriberObj'] = $result;
                    if($_SESSION["referenceUrl"] == "siparis-onay") {
                        header('Location: '.getSafeUrl('/siparis-onay'));
                    }
                    else {
                        header('Location: '.getSafeUrl('/hesap/kullanici-paneli'));
                    }
                    exit();
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "E-posta ve şifre uyuşmuyor!";
                $_SESSION['isLoggedIn'] = false;
            }
            break;
        case 'forgot-password':
            if(isLoggedIn()){
                header('Location: '.getSafeUrl('/giris-yap'));
                exit();
            }
//            if ($recaptcha->score >= 0.5) {
            $email = trim( $_POST['email']);
            $result = makeRequest('get',['email'=>$email],['collection'=>'subscribers']);
            if(!empty($result)){
                if(isset($result['success']) && !$result['success']){
                    $actionResult['status'] = false;
                    $actionResult['message'] = "E-posta mevcut değil!";
                }
                else{
                    $result2 = makeRequest('subscribers/sendResetPasswordLink',[],['subscriberId'=>$result['_id'],'requestIp'=>$REMOTE_ADDR]);
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Şifre sıfırlama bağlantısı e-posta adresinize gönderildi. Lütfen gelen kutunuzu kontrol edin.";
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "E-posta mevcut değil!";
            }
            break;
		case 'change-password':
			if(!$_SESSION['isLoggedIn']){
				header('Location: '.getSafeUrl('/giris-yap'));
				exit();
			}
			$actionResult['status'] = true;
			if(!isset($_POST['subscriberId']) || empty($_POST['subscriberId'])){
				$actionResult['status'] = false;
				$actionResult['message'] = "Bir hata oluştu! [0001]";
			}
			if(!isset($_POST['new-password']) || empty($_POST['new-password']) || !isset($_POST['new-password2']) || empty($_POST['new-password2']) || !isset($_POST['old-password']) || empty($_POST['old-password'])){
				$actionResult['status'] = false;
				$actionResult['message'] = "Bir hata oluştu! [0003]";
				echo "2";
			}
			if($_POST['new-password'] != $_POST['new-password2']){
				$actionResult['status'] = false;
				$actionResult['message'] = 'Parolalar uyuşmamaktadır! [0004]';
			}
			if($actionResult['status']){
				$subscriberId = trim( $_POST['subscriberId']);
                $password = md5($_POST['old-password']);
                $newPassword =  $_POST['new-password'];
                $newPassword2 =  $_POST['new-password2'];
				$result = makeRequest('subscribers/changePassword',[],['fields'=>['subscriberId'=>$subscriberId,'newPassword'=>$newPassword,'newPassword2'=>$newPassword2, 'oldPassword'=>$password]]);
				if(!empty($result)){
					if($result['success']){
						$actionResult['status'] = true;
						$actionResult['message'] = "Şifre başarıyla güncellendi";
					}
					else{
						$actionResult['status'] = false;
						$actionResult['message'] = $result['message'];
					}
				}
				else{
					$actionResult['status'] = false;
					$actionResult['message'] = "Bir hata oluştu!";
				}
			}
			break;
        case 'renew-password':
            $actionResult['status'] = true;
            if(!isset($_POST['subscriberId']) || empty($_POST['subscriberId'])){
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata meydana geldi! [0001]";
            }
            if(!isset($_POST['token']) || empty($_POST['token'])){
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata meydana geldi! [0002]";
            }
            if(!isset($_POST['password']) || empty($_POST['password']) || !isset($_POST['password2']) || empty($_POST['password2'])){
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata meydana geldi! [0003]";
                echo "2";
            }
            if($_POST['password'] != $_POST['password2']){
                $actionResult['status'] = false;
                $actionResult['message'] = 'Parolalar aynı değil! [0004]';
            }
            if($actionResult['status']){
                $subscriberId = trim( $_POST['subscriberId']);
                $token = trim( $_POST['token']);
                $password =  $_POST['password'];
                $password2 =  $_POST['password2'];
                $result = makeRequest('subscribers/renewPassword',[],['fields'=>['subscriberId'=>$subscriberId,'token'=>$token,'newPassword'=>$password,'newPassword2'=>$password2]]);
                if(!empty($result)){
                    if($result['success']){
                        $actionResult['status'] = true;
                        $actionResult['message'] = "Şifre başarıyla güncellendi";
                        header('Location: '.getSafeUrl('/giris-yap'));
                        die();
                    }
                    else{
                        $actionResult['status'] = false;
                        $actionResult['message'] = $result['message'];
                    }
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = "Bir hata oluştu!";
                }
            }
            break;
        case 'update_profile':
            if(!$_SESSION['isLoggedIn']){
                header('Location: '.getSafeUrl('/head'));
                exit();
            }

            $subscriberId = $_SESSION['subscriberObj']['_id'];
            $name = trim( $_POST['name']);
            $surname = trim( $_POST['surname']);
            $email = trim( $_POST['email']);
            $fields = ['subscriberId'=>$subscriberId,'name'=>$name,'surname'=>$surname,'email'=>$email];

            if (isset($_POST['action-detail']) == "update_adress") {
                $fields['address1'] = trim( $_POST['address1']);
                $fields['address2'] = trim( $_POST['address2']);
                $fields['city'] = trim( $_POST['city']);
                $fields['province'] = trim( $_POST['province']);
                $fields['postalCode'] = trim( $_POST['postalCode']);
            }

            $result = makeRequest('subscribers/updateSubscriber',[],['fields'=> $fields]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Profil başarıyla güncellendi";
                    $_SESSION['subscriberObj'] = $result['subscriberObj'];
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata oluştu!";
            }
            break;
        case 'update_password':
            if(!$_SESSION['isLoggedIn']){
                header('Location: '.getSafeUrl('/giris-yap'));
                exit();
            }
            $subscriberId = $_SESSION['subscriberObj']['_id'];
            $currentPassword = trim( $_POST['currentPassword']);
            $newPassword = trim( $_POST['newPassword']);
            $newPassword2 = trim( $_POST['newPassword2']);

            $result = makeRequest('subscribers/updatePassword',[],['fields'=>['subscriberId'=>$subscriberId,'currentPassword'=>$currentPassword,'newPassword'=>$newPassword,'newPassword2'=>$newPassword2]]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Password updated successfully";
                    $_SESSION['subscriberObj'] = $result['subscriberObj'];
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Ocurrió un error!";
            }
            break;
        case 'add_address':
            if(!$_SESSION['isLoggedIn']){
                header('Location: '.getSafeUrl('/giris-yap'));
                exit();
            }
            $subscriberId = $_SESSION['subscriberObj']['_id'];
            $title = trim( $_POST['title']);
            $name = trim( $_POST['name']);
            $surname = trim( $_POST['surname']);
            $phone = trim( $_POST['phone']);
            $city = trim( $_POST['city']);
            $county = trim( $_POST['county']);
            $district = trim( $_POST['district']);
            $address = trim( $_POST['address']);

            $result = makeRequest('subscribers/addSubscriberAddress',[],['fields'=>['subscriberId'=>$subscriberId,'title'=>$title,'name'=>$name,'surname'=>$surname, 'phone' =>$phone, 'city'=>$city, 'county'=> $county, 'district'=>$district, 'address'=>$address]]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Yeni adres oluşturuldu";
                    $_SESSION['subscriberObj'] = $result['subscriberObj'];
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata oulştu!";
            }
            break;
        case 'update_address':
            if(!$_SESSION['isLoggedIn']){
                header('Location: '.getSafeUrl('/giris-yap'));
                exit();
            }
            $subscriberId = $_SESSION['subscriberObj']['_id'];
            $addressId = trim( $_POST['addressId']);
            $title = trim( $_POST['title']);
            $name = trim( $_POST['name']);
            $surname = trim( $_POST['surname']);
            $phone = trim( $_POST['phone']);
            $city = trim( $_POST['city']);
            $county = trim( $_POST['county']);
            $district = trim( $_POST['district']);
            $address = trim( $_POST['address']);

            $result = makeRequest('subscribers/updateSubscriberAddress',[],['fields'=>['addressId'=>$addressId, 'subscriberId'=>$subscriberId,'title'=>$title,'name'=>$name,'surname'=>$surname, 'phone' =>$phone, 'city'=>$city, 'county'=> $county, 'district'=>$district, 'address'=>$address]]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Adres güncellendi";
                    $_SESSION['subscriberObj'] = $result['subscriberObj'];
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata oulştu!";
            }
            break;
        case 'delete_address':
            $addressId = trim($_POST['addressId']);
            $subscriberId = $_SESSION['subscriberObj']['_id'];
            if (empty($addressId)) {
                $actionResult['status'] = false;
                $actionResult['message'] = 'Silinecek adres belirtilmedi.';
                exit();
            }
            if (empty($subscriberId)) {
                $actionResult['status'] = false;
                $actionResult['message'] = 'Lütfen giriş yapınız.';
                header('Location: /giris-yap');
            }
            $result = makeRequest('subscribers/deleteSubscriberAddress', [], ['fields'=>['subscriberId'=>$subscriberId, 'addressId'=>$addressId]]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Adres silindi";
                    $_SESSION['subscriberObj'] = $result['subscriberObj'];
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata oulştu!";
            }
            break;
        case 'send_comment':
            $postId = $_POST['postId'];
            $name = $_POST['comment-name'];
            $email = $_POST['comment-email'];
            $title = $_POST['comment-title'];
            $message = $_POST['comment-message'];
            $success = false;
            if(!isset($postId) || empty($postId)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata oluştu! [0001]";
            }
            if(!isset($name) || empty($name)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen isminizi yazın!";
            }
            if(!isset($email) || empty($email)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen mail adresinizi yazın!";
            }
            if(!isset($title) || empty($title)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen başlık kısmını doldurun!";
            }
            if(!isset($message) || empty($message)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen yorum kısmını doldurun!";
            }
            $result = makeRequest('forms/commentForm', ['postId' => $postId, 'name'=>$name, 'email'=>$email, 'commentSubject'=>$title, 'commentMessage'=>$message, 'requestIp'=>$REMOTE_ADDR]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Yorum Eklendi";
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata meydana geldi!";
            }
            break;
        case 'send_review':
            $productId = $_POST['productId'];
            $name = $_POST['review-name'];
            $email = $_POST['review-email'];
            $review = $_POST['review-rate'];
            $title = $_POST['review-title'];
            $message = $_POST['review-message'];
            if(!isset($productId) || empty($productId)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata oluştu! [0001]";
            }
            if(!isset($name) || empty($name)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen isminizi yazın!";
            }
            if(!isset($email) || empty($email)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen mail adresinizi yazın!";
            }
            if(!isset($title) || empty($title)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen başlık kısmını doldurun!";
            }
            if(!isset($message) || empty($message)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen yorum kısmını doldurun!";
            }
            $result = makeRequest('forms/reviewForm', ['productId' => $productId, 'name'=>$name, 'email'=>$email, 'review'=>$review, 'reviewTitle'=>$title, 'reviewMessage'=>$message, 'requestIp'=>$REMOTE_ADDR]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "İncelemeniz başarıyla oluşturuldu, moderatörler tarafından onaylandığında yayına alınacaktır.";
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata meydana geldi!";
            }
            break;
        case 'send_contact':
            $formName = $_POST['form-name'];
            $name = $_POST['contact-name'];
            $email = $_POST['contact-email'];
            $subject = $_POST['contact-subject'];
            $message = $_POST['contact-message'];
            $success = false;
            if(!isset($name) || empty($name)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen isminizi yazın!";
            }
            if(!isset($email) || empty($email)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen mail adresinizi yazın!";
            }
            if(!isset($subject) || empty($subject)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen başlık kısmını doldurun!";
            }
            if(!isset($message) || empty($message)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen yorum kısmını doldurun!";
            }

            $response = makeRequest('forms/contactForm', ['formName'=>$formName, 'name'=>$name, 'email'=>$email, 'subject'=>$subject, 'message'=>$message,'requestIp'=>$REMOTE_ADDR]);
            if (!empty($response)) {
                $actionResult['status'] = true;
                $actionResult['message'] = "Formunuz başarıyla oluşturuldu, en kısa sürede sizinle iletişime geçeceğiz!";
            }
            else {
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata oluştu!";
            }
            break;
		case 'add-mail-subscriber':
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $success = false;
            $response = makeRequest('forms/addMailSubscriber', ['email' => $email, 'name' => $name, 'requestIp'=>$REMOTE_ADDR]);
            if (!empty($response)) {
                $success = $response['success'];
                $message = $response['message'];
            }
            echo json_encode(['success' => $success, 'message' => $message]);
            exit();
            break;
		case 'send-forum-reply':
			$actionResult['status'] = true;
			$courseId = isset($_POST['courseId']) ? $_POST['courseId'] : "";
			$subscriberId = isset($_POST['subscriberId']) ? $_POST['subscriberId'] : "";
			$subscriberName = isset($_POST['subscriberName']) ? $_POST['subscriberName'] : "";
			$replySubject = isset($_POST['replySubject']) ? $_POST['replySubject'] : "";
			$replyMessage = isset($_POST['replyMessage']) ? $_POST['replyMessage'] : "";
			if(empty($courseId) || empty($subscriberId) || empty($subscriberName)){
				$actionResult['status'] = false;
				$actionResult['message'] = "¡Error! Por favor, inténtelo de nuevo más tarde";
			}
			else if(empty($replySubject)){
				$actionResult['status'] = false;
				$actionResult['message'] = "Por favor escriba asunto";
			}
			else if(empty($replyMessage)){
				$actionResult['status'] = false;
				$actionResult['message'] = "Por favor escriba mensaje";
			}
			else if(strlen($replyMessage)<10){
				$actionResult['status'] = false;
				$actionResult['message'] = "La longitud mínima del mensaje es 10";
			}
			if($actionResult['status']){
				$result = makeRequest('forms/replyForm', ['courseId' => $courseId, 'subscriberId' => $subscriberId, 'subscriberName'=>$subscriberName, 'replySubject'=>$replySubject, 'replyMessage'=>$replyMessage,'requestIp'=>$REMOTE_ADDR]);
				if(isset($result['success']) && !$result['success']){
					$actionResult['status'] = false;
					$actionResult['message'] = "¡Error! Por favor, inténtelo de nuevo más tarde";
				}
				else{
					$actionResult['status'] = true;
					$actionResult['message'] = "Tu mensaje ha sido enviado exitosamente";
				}
			}
			else{
				$actionResult['status'] = false;
				$actionResult['message'] = "¡Error! Por favor, inténtelo de nuevo más tarde";
			}
			break;
        case 'payment':
            $subscriberObj = $_SESSION['subscriberObj'];
            if (!isset($subscriberObj) || empty($subscriberObj)) {
                header('Location: '.getSafeUrl('/giris-yap'));
                exit();
            }

            $shippingMethod = $_POST['shippingMethod'];
            $copyPersonalInfo = isset( $_POST['copyPersonalInfo']);
            $additionalNotes = trim($_POST['additionalNotes']);

            if (empty(trim( $_POST['selectedDeliveryAddressId']))) {
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen teslimat adresini seçiniz.";
                break;
            }
            $selectedAddressId = trim( $_POST['selectedDeliveryAddressId']);
            if (!$copyPersonalInfo) {
                if (empty(trim( $_POST['selectedDeliveryAddressId']))) {
                    $actionResult['status'] = false;
                    $actionResult['message'] = "Lütfen fatura adresini seçiniz.";
                    break;
                }
                $selectedInvoiceAddressId = trim( $_POST['selectedInvoiceAddressId']);
            } else {
                $selectedInvoiceAddressId = $selectedAddressId;
            }

            foreach ($_SESSION['subscriberObj']['addresses'] as $address) {
                if ($selectedAddressId == $address['id']) {
                    $deliveryAddress = $address;
                }
            }
            foreach ($_SESSION['subscriberObj']['addresses'] as $address) {
                if ($selectedInvoiceAddressId == $address['id']) {
                    $invoiceAddress = $address;
                }
            }

            $paymentMethod = trim($_POST['paymentMethod']);
            $items = $_POST['items'];
            $quantities = $_POST['quantities'];
            $specs = $_POST['specs'];
            $specificPrice = $_POST['specificPrice'];

            $croppedImage = (isset($_POST['hidden-cropped-image']) && !empty($_POST['hidden-cropped-image'])) ? $_POST['hidden-cropped-image'] : '';

            if(empty($paymentMethod)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen ödeme yöntemini seçiniz";
                break;
            }
            if(empty($shippingMethod)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Lütfen kargo yöntemini seçiniz";
                break;
            }
            if(empty($items)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Sepette ürün bulunmamaktadır";
                break;
            }
            if(empty($quantities)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Ön tarafta bir hata oluştu.";
                break;
            }
            if(empty($specificPrice || $specs)){
                $actionResult['status'] = false;
                $actionResult['message'] = "Ön tarafta bir hata oluştu.";
                break;
            }
            $specificPrice = array_map('floatval', $specificPrice);

            $fields = [
                'userId' => isLoggedIn() ? getCurrentSubscriber()['_id'] : '',
                'name' => $subscriberObj['name'],
                'surname' => $subscriberObj['surname'],
                'email' => $subscriberObj['email'],
                'address' => $deliveryAddress,
                'paymentMethod' => $paymentMethod,
                'shippingMethod' => $shippingMethod,
                'additionalNotes' => $additionalNotes,
                "invoiceAddress" => $invoiceAddress,
                "copyPersonalInfo" => $copyPersonalInfo,
                'items' => $items,
                'quantities' => $quantities,
                'customFields' => ['specs' => $specs, 'specificPrice' => $specificPrice, 'croppedImage' => $croppedImage]
            ];

            $result = makeRequest('orders/addOrder',[],['fields'=>$fields]);
            if(!empty($result)){
                if($result['success']){
                    $actionResult['status'] = true;
                    $actionResult['message'] = "Order Received";
                    if($result['orderData']['paymentMethod'] == 'paytr'){
                        header('Location: /odeme/'.$result['orderData']['_id']);
                        exit();
                    }
                    else{
                        debugPrint($result);
                        die();
                        $actionResult['status'] = false;
                        $actionResult['message'] = "Bir hata das meydana geldi.";
                    }
                }
                else{
                    $actionResult['status'] = false;
                    $actionResult['message'] = $result['message'];
                }
            }
            else{
                $actionResult['status'] = false;
                $actionResult['message'] = "Bir hata sad meydana geldi.";
            }
            break;
		default:
			//do nothing...
			break;
    }
}

<?php
class lwj
{
        /*===== 私鑰 =====*/
        private $_privKey;
       
	   
        /*===== 公鑰 =====*/
        private $_pubKey;
       
	   
        /*===== 公、私鑰儲存路徑 =====*/
        private $_keyPath;
       
        /*===== 設定公、私鑰儲存路徑 =====*/
        public function __construct($path)
        {
                if(empty($path) || !is_dir($path)){
                        throw new Exception('Must set the keys save path');
                }
               
                $this->_keyPath = $path;
        }

        /*===== 產生公、私鑰 =====*/
        public function createKey()
        {       /*== 公鑰 ==*/
		        $passphrase = NULL;
                $r = openssl_pkey_new();
                openssl_pkey_export($r, $privKey, $passphrase, $config);
                file_put_contents($this->_keyPath . DIRECTORY_SEPARATOR . 'priv.key', $privKey);
                $this->_privKey = openssl_pkey_get_private($privKey);
                /*== 私鑰 ==*/
                $pubKey = openssl_pkey_get_details($r);
                $pubKey = $pubKey['key'];
                file_put_contents($this->_keyPath . DIRECTORY_SEPARATOR .  'pub.key', $pubKey);
                $this->_pubKey = openssl_pkey_get_public($pubKey);
        }

		
		
        /*========= 設定私鑰 =========*/		
        public function setupPrivKey()
        {
                if(is_resource($this->_privKey)){
                        return true;
                }
                $file = $this->_keyPath . DIRECTORY_SEPARATOR . 'priv.key';
                $prk = file_get_contents($file);
                $this->_privKey = openssl_pkey_get_private($prk);
                return true;
        }
       
	   
	   
        /*========= 設定公鑰 =========*/
        public function setupPubKey()
        {
                if(is_resource($this->_pubKey)){
                        return true;
                }
                $file = $this->_keyPath . DIRECTORY_SEPARATOR .  'pub.key';
                $puk = file_get_contents($file);
                $this->_pubKey = openssl_pkey_get_public($puk);
                return true;
        }
       
	   
	   
        /*========= 私鑰加密 =========*/
        public function privEncrypt($data)
        {
                if(!is_string($data)){
                        return null;
                }
               
                $this->setupPrivKey();
               
                $r = openssl_private_encrypt($data, $encrypted, $this->_privKey);
                if($r){
                        return base64_encode($encrypted);
                }
                return null;
        }
       
	   
	   
        /*========= 私鑰解密 =========*/
        public function privDecrypt($encrypted)
        {
                if(!is_string($encrypted)){
                        return null;
                }
               
                $this->setupPrivKey();
               
                $encrypted = base64_decode($encrypted);

                $r = openssl_private_decrypt($encrypted, $decrypted, $this->_privKey);
                if($r){
                        return $decrypted;
                }
                return null;
        }
		
		
       
        /*========= 公鑰加密 =========*/
        public function pubEncrypt($data)
        {
                if(!is_string($data)){
                        return null;
                }
               
                $this->setupPubKey();
               
                $r = openssl_public_encrypt($data, $encrypted, $this->_pubKey);
                if($r){
                        return base64_encode($encrypted);
                }
                return null;
        }
		
		
       
        /*========= 公鑰解密 =========*/
        public function pubDecrypt($crypted)
        {
                if(!is_string($crypted)){
                        return null;
                }
               
                $this->setupPubKey();
               
                $crypted = base64_decode($crypted);

                $r = openssl_public_decrypt($crypted, $decrypted, $this->_pubKey);
                if($r){
                        return $decrypted;
                }
                return null;
        }
       
        public function __destruct()
        {
                @ fclose($this->_privKey);
                @ fclose($this->_pubKey);
        }

}
/*================================ Test ==============================*/
//$rsa = new opensslrsa('openssl-key'); 

/*===== 產生公、私鑰，如果沒有公、私鑰再調用 =====*/
//$rsa->createKey();
/*===== 私鑰加密，公鑰解密 =====*/
//echo 'source:諾亞克美國<br /><br />';
//$pre = $rsa->privEncrypt('諾亞克美國');
//echo 'private encrypted:<br /><br />' . $pre . '<br /><br />';
//$pud = $rsa->pubDecrypt($pre);
//echo 'public decrypted:' . $pud . '<br /><br /><br /><br />';

/*===== 公鑰加密，私鑰解密 =====*/
//echo 'source:英文:65、中文:35、白日依山盡，黃河入海流，欲窮千里目，更上一層樓。月落烏啼霜滿天，江楓漁火對愁眠，姑蘇城外寒山寺，夜半鐘聲到客船。ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz<br /><br />';
//$data = '白日依山盡，黃河入海流，欲窮千里目，更上一層樓。月落烏啼霜滿天，江楓漁火對愁眠，姑蘇城外寒山寺，夜半鐘聲到客船。ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLM';
//$pue = $rsa->pubEncrypt($data);
//echo 'public encrypt:<br /><br />' . $pue . '<br /><br />';
//$prd = $rsa->privDecrypt($pue);
//echo 'private decrypt:' . $prd;
/*===== 字元分割，公鑰加密，私鑰解密 =====*/
/* 加密 */
/*
$part = ceil(strlen($data)/117);
echo '<br>';
$datapart = str_split($data, 117);
for($i=0;$i<$part;$i++){
	echo $datapart[$i];
    echo '<br>';
	$puepart = $rsa->pubEncrypt($datapart[$i]);
	echo 'public encrypt:<br />' . $puepart . '<br /><br />';
	$pue = $pue.$puepart." ";
	echo 'public encrypt Mix:<br />' . $pue . '<br /><br /><br /><br />';
}
*/
/* 解密 */
/*
	$puepart = explode(" ",$pue);
	$puepartcount = count($puepart);
	if($puepartcount>1){
      for($i=0;$i<$puepartcount;$i++){
        $prdpart = $rsa->privDecrypt($puepart[$i]);
        $prd = $prd.$prdpart;
      }		
	}else{
		$prd = $rsa->privDecrypt($row_result["ssl"]);
	}
    echo 'private decrypt:<br>' . $prd;
*/
/*================================ Test ==============================*/
?>
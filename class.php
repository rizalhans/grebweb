<?php
class Grabweb {
    var $htmlResult = '';
    var $ch         = false; 
    var $ip         = ''; 

    function getPage($target,$data=array()) {
        $res = $this->my_curl_post($target,$data);
        $this->htmlResult = $res['response'];
    }

    function save($file,$data) {
        if(!is_dir(SAVETO)) {
            mkdir(SAVETO,0777,1);
        }
        if(!is_dir(SAVETO.date("Ymd")."/")) {
            mkdir(SAVETO.date("Ymd")."/",0777,1);
        }
        $file_log	 = SAVETO.date("Ymd")."/".$file.".json";
		$myfile = fopen($file_log, "w") or die("Unable to open file $file_log !");
		fwrite($myfile, $data);
		fclose($myfile);
    }

    function my_curl_close() {
        if ($this->ch != false) {
            curl_close($this->ch);
        }
    }
 
    function my_curl_get($url, $ref = '') {
        if ($this->ch == false) {
            $this->my_curl_open();
        }
 
        $ssl = false;
        if (preg_match('/^https/i', $url)) {
            $ssl = true;
        }
 
        if ($ssl) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        }
 
        if ($ref == '') {
            $ref = $url;
        }
 
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_REFERER, $ref);
        $res = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);
        return array(
            'response' => trim($res),
            'info' => $info
            );
    }
 
 
 
    function my_curl_open() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
        @curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/curl-cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/curl-cookie.txt');
        curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
 
    }
 
    function my_curl_post($url, $post_data, $ref = '') {
        if ($this->ch == false) {
            $this->my_curl_open();
        }
        $ssl = false;
        if (preg_match('/^https/i', $url)) {
            $ssl = true;
        }
        if ($ssl) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false); 
        }
        if ($ref == '') {
            $ref = $url;
        } 
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_REFERER, $ref);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);
        $res = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);
        return array(
            'response' => trim($res),
            'info' => $info
            );
 
    }
}

?>
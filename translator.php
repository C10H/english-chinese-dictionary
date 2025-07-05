<?php
class BaiduTranslator {
    private $appId = '20240531002066782';
    private $secretKey = '2UYrEDwvtMgOShDLo3u8';
    private $apiUrl = 'https://fanyi-api.baidu.com/api/trans/vip/translate';
    
    public function detectLanguage($text) {
        if (preg_match('/[\x{4e00}-\x{9fff}]/u', $text)) {
            return 'zh';
        } else {
            return 'en';
        }
    }
    
    public function translate($text) {
        $from = $this->detectLanguage($text);
        $to = ($from == 'zh') ? 'en' : 'zh';
        
        $salt = time();
        $sign = md5($this->appId . $text . $salt . $this->secretKey);
        
        $params = [
            'q' => $text,
            'from' => $from,
            'to' => $to,
            'appid' => $this->appId,
            'salt' => $salt,
            'sign' => $sign
        ];
        
        $url = $this->apiUrl . '?' . http_build_query($params);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $result = json_decode($response, true);
            if (isset($result['trans_result'][0]['dst'])) {
                return $result['trans_result'][0]['dst'];
            }
        }
        
        return false;
    }
}
?>
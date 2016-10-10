<?php
/**
* curl 的封装
* @copyfu
* Date 2016/10/7
*/

class myCurl {	
	private static $url = '';
	private static $data = array();
	private static $method;	//默认get
	private static $header = array();

	function send($url, $header = array(), $data = array(), $method = 'get'){
		if (!$url) exit('url can not be null');
		self::$url    = $url;
		self::$data   = $data;
		self::$method = $method;
		self::$header = $header;
		if ( !in_array(
                self::$method,
                array('get', 'post', 'put', 'delete')
             )
           ) {
                exit('error request method type!');
             }
        
        $func = self::$method . 'Request';
        return self::$func(self::$url);
	}

	private function getRequest(){
		return self::doRequest(0);
	}

	private function postRequest(){
		return self::doRequest(1);
	}

	private function doRequest($is_post = 0){
		$ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, self::$url); //抓取指定网页
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https 请求
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , false);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::$header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //要求结果为字符串且输出到屏幕上
        if($is_post == 1) curl_setopt($ch, CURLOPT_POST, true);
        if (!empty(self::$data)) {
            self::$data = self::dealPostData(self::$data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::$data);
        }
        $res = curl_exec($ch);//运行curl    
        curl_close($ch);
       
        return $res;
        
	}

	public function dealPostData($postData) {
        if (!is_array($postData)) exit('post data should be array');
        foreach ($postData as $k => $v) {
            $str .= "$k=" . urlencode($v) . "&";
        }
        $postData = substr($str, 0, -1);
        return $postData;
    }

}
?>

<?php 
class CURL
{
	// private $headers = array();
	private $ch;

	public function httpGet($url){
		$this->ch = curl_init($url);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_HEADER, false);

		$exec = curl_exec($this->ch);
		$info = curl_getinfo($this->ch);
		$result = $this->response($info, $exec);
		curl_close($this->ch);
		return $result;
	}

	public function httpPost($url, $postFields)
	{
		$this->ch = curl_init($url);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_POST, true);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postFields);

		$exec = curl_exec($this->ch);
		$info = curl_getinfo($this->ch);
		$result = $this->response($info, $exec);
		curl_close($this->ch);
		return $result;
	}

	private function response($info, $result)
	{
		if(isset($info['http_code']) && $info['http_code'] == 200){
			return array(
				'http_code' => $info['http_code'],
				'content' => $result
			);
		}else{
			return array(
				'http_code' => isset($info['http_code']) ? $info['http_code'] : null,
				'error' => curl_error($this->ch),
				'errno' => curl_errno($this->ch)
			);
		}
	}
}
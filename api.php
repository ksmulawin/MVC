<?php
	Class API
	{
		function postData($post_data = array())
		{
			$post_items = array();
			foreach ( $post_data as $key => $value) 
			{
				$post_items[] = $key . '=' . $value;
			}
			$post_string = implode ('&', $post_items);
			return $post_string;
		}
		
		
		public function setConnection($url,$data,$method){
		
			$curl_connection = curl_init($url);
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
			
			
	
			$post_string = $this->postData($data);
			
			curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
			$result = curl_exec($curl_connection);
			curl_close($curl_connection);

			if($result != "")
				return json_decode($result);

			return false;
		}
	}

	
<?php 
    class api{

        //protected $token = "o4HZO+asLqbjinZcWAjHiXuIoZ8Ca4upcB4Gg+Hyvsc=";
        protected $app_ref = "bsitc_test";
        public $endpoints = [
            'staff_authorise' => 'authorise',
            'product_detail' => 'product-service/product/'
        ];

        public function __construct(){
            
        }

        public function getURL($endpoint_name, $uri){
            return API_URL.$this->endpoints[$endpoint_name].$uri;
        }

        public function generateToken(){
            $data = ['apiAccountCredentials' => ['emailAddress' => STAFF_USER, 'password' => STAFF_PASSWORD]];
            $get_data = $this->call('POST', TOKEN_API, json_encode($data));
            $response = json_decode($get_data, true);
            return $response;
        }

        public function call($method, $url, $data, $token=''){
            $curl = curl_init();
            switch ($method){
               case "POST":
                  curl_setopt($curl, CURLOPT_POST, 1);
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                  break;
               case "PUT":
                  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
                  break;
               default:
                  if ($data)
                     $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            
            curl_setopt($curl, CURLOPT_URL, $url);
            $headers = array(
                'brightpearl-app-ref: '.$this->app_ref.'',
                'Content-Type: application/json',
            );
            if($token){array_push($headers, 'brightpearl-staff-token: '.$token.'');}
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
            $result = curl_exec($curl);
            if(!$result){die("Connection Failure");}
            curl_close($curl);
            return $result;
         }
    }
?>
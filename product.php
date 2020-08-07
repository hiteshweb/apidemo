<?php 
        class product{
            
                public function saveProduct($product_id){
                    $response = $this->getProductResponse($product_id);
                    if(isset($response['response'])){
                        $this->insertProductToDB($response['response'][0]);
                    } else{
                        echo "Error: ".$response['errors'][0]['message'];
                    }
                }

                public function insertProductToDB($data){
                    $DB = new database();
                    extract($data);
                    $array = ['pid' => $id, 'brandId' => $brandId, 'collectionId' => @$collectionId, 'sku' => @$identity['sku'], 
                                'productGroupId' => @$productGroupId, 'featured' => $featured, 'stock' => serialize($stock), 
                                'variations' => serialize(@$variations), 'statuss' => $status, 'api_response' => serialize($data)];
                    
                    $string = "INSERT INTO ".DB_PRODUCT_TABLE." (";            
                    $string .= implode(",", array_keys($array)) . ') VALUES (';            
                    $string .= "'" . implode("','", array_values($array)) . "')";
                    
                    $res = $DB->executeQuery("products", $string);
                    if($res){
                        echo "Sucess: Product inserted successfully!";
                    } else{
                        echo 'Error: '.$res;
                    }
                }

                public function getProductResponse($product_id){
                    $api = new api();
                    // generate token
                    $token_response = $api->generateToken();
                    if(isset($token_response['response'])){
                        // call product detail api
                        $url = $api->getURL('product_detail', $product_id);
                        $get_data = $api->call('GET', $url, false, $token_response['response']);
                        $response = json_decode($get_data, true);
                        return $response;
                    } else {
                        return $token_response;
                    }
                }
        }
?>
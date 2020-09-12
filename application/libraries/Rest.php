<?php
    class Rest{
        public $request;
        public $serviceName;
        public $param;
        public $dbConn;
        public $userId;

        public function __construct() {
            if(!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
                $this->throwError(REQUEST_METHOD_NOT_VALID, 'Request Method is not valid.');
            }

            if($_SERVER['CONTENT_TYPE'] !== 'application/json') {
                $this->throwError(REQUEST_CONTENTTYPE_NOT_VALID, 'Request content type is not valid');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $handler = fopen('php://input', 'r');
                $this->request = stream_get_contents($handler);
            }
            if($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->request = json_encode($_GET);
            }

            $this->param = json_decode($this->request, true);
        }

        public function validateParameter($fieldName, $value, $dataType, $required = true) {
            if($required == true && empty($value) == true) {
                $this->throwError(VALIDATE_PARAMETER_REQUIRED, $fieldName . " parameter is required.");
            }

            switch ($dataType) {
                case BOOLEAN:
                    if(!is_bool($value)) {
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be boolean.');
                    }
                    break;
                case INTEGER:
                    if(!is_numeric($value)) {
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be numeric.');
                    }
                    break;

                case STRING:
                    if(!is_string($value)) {
                        $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be string.');
                    }
                    break;
                
                default:
                    $this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName);
                    break;
            }

            return $value;

        }

        public function processApi() {
            try {
                $api = new API;
                $rMethod = new reflectionMethod('API', $this->serviceName);
                if(!method_exists($api, $this->serviceName)) {
                    $this->throwError(API_DOST_NOT_EXIST, "API does not exist.");
                }
                $rMethod->invoke($api);
            } catch (Exception $e) {
                $this->throwError(API_DOST_NOT_EXIST, "API does not exist.");
            }
            
        }

        public function throwError($code, $message) {
            header("content-type: application/json");
            $errorMsg = json_encode(['error' => ['status'=>$code, 'message'=>$message]]);
            echo $errorMsg; exit;
        }

        public function returnResponse($code, $data) {
            header("content-type: application/json");
            $response = json_encode(['response' => ['status' => $code, "result" => $data]]);
            echo $response; exit;
        }
    }
<?php

if (!function_exists('p')) {
    function p($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

if (!function_exists('vd')) {
    function vd($data) {
        var_dump($data);
    }
}

function api_response($type, $url, $data = "") {
    $parameter = array();
    $parameter["key_request"] = base64_encode('123456' . 'ebXML');
    $parameter["from_system"] = 'ebXML';
    $parameter_file = array();
    $parameter["company"] = isset($data["company"]) || !empty($data["company"]) ? $data["company"] : "";
    $cFile = "";

    $request_method;
    switch ($type) {
        case "get":
            // TODO
            $method = "GET";
            break;
        case "post":
            $method = "POST";
            if (isset($data["file"]) && is_file($data["file"])) { // Check key 'file' and check type  
                $filename = '';
                if (function_exists('curl_file_create')) { // php 5.5+
                    $path_info = pathinfo($data["file"]);
                    $filename = basename($data["file"]);
                    $cFile = curl_file_create($data["file"]);
                    $parameter["file_contents"] = array("name" => $data["file"], "mime" => $path_info['extension'], "postname" => $filename);
                } else {
                    $cFile = '@' . realpath($data["file"]);
                }
            } else {
                unset($data["company"]);
                $parameter["data_contents"] = $data;
            }
            $data["p"] = json_encode($parameter);
            if (!empty($cFile)) {
                $data["f"] = $cFile;
            }

            break;
        case "put":
            // TODO
            $method = "PUT";
            break;
        case "delete":
            // TODO
            $method = "DELETE";
            break;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    if (!empty($result)) {
        if (!is_JSON($result)) {
            if (is_object($result)) {
                $return["type_response"] = "Object";
            } else if (is_array($result)) {
                $return["type_response"] = "Array";
            } else {
                $return["type_response"] = "Raw data";
            }
            $return["response_detail"] = $result;
            return $return;
        } else {
            $return["type_response"] = "Json";
            $return["response_detail"] = json_decode($result);
            return $return;
        }
    } else {
        $return["type_response"] = "";
        $return["response_detail"] = "No data return from api";
        return $return;
    }
}

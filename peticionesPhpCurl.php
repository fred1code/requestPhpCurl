<?php

function peticionesCurl($url, $peticion, $field, $name, $pass, $jwt, $responseJwt, $arrays)
    {
        try {
            if ($responseJwt === false AND $arrays === false) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url . $peticion,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $field,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization:  ' . $jwt,
                        'cache - control: no - cache'
                    ),
                ));
                $responseD = curl_exec($curl);
                $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($status == 200) {
                    return $responseD;
                }
                if ($status == 401) {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url . '/login/signIn',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => 'user=' . $name . '&pass=' . $pass . '&undefined=',
                        CURLOPT_HTTPHEADER => array(
                            'Authorization:  ' . $jwt,
                            'cache - control: no - cache'
                        ),
                    ));
                    $response = curl_exec($curl);
                    $headers = array();
                    $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
                    foreach (explode("\r\n", $header_text) as $i => $line)
                        if ($i == 0)
                            $headers['http_code'] = $line;
                        else {
                            list ($key, $value) = explode(': ', $line);
                            $headers[$key] = $value;
                        }
                    $this->tempBearer = $headers['Authorization'];
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url . $peticion,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $field,
                        CURLOPT_HTTPHEADER => array(
                            'Authorization:  ' . $headers['Authorization'],
                            'cache - control: no - cache'
                        ),
                    ));
                    $responses = curl_exec($curl);
                    return $responses;
                }
            }
            if ($responseJwt === true AND $arrays === true) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $field,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization:  ' . $jwt,
                        'cache - control: no - cache'
                    ),
                ));
                $response = curl_exec($curl);
                $headers = array();
                $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
                foreach (explode("\r\n", $header_text) as $i => $line)
                    if ($i == 0)
                        $headers['http_code'] = $line;
                    else {
                        list ($key, $value) = explode(': ', $line);
                        $headers[$key] = $value;
                    }
                $this->tempBearer = $headers['Authorization'];
                return [$headers['Authorization'], $response];
            }
            if ($responseJwt === true AND $arrays === false) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url . $peticion,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $field,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization:  ' . $jwt,
                        'cache - control: no - cache'
                    ),
                ));
                $response = curl_exec($curl);
                $headers = array();
                $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
                foreach (explode("\r\n", $header_text) as $i => $line)
                    if ($i == 0)
                        $headers['http_code'] = $line;
                    else {
                        list ($key, $value) = explode(': ', $line);
                        $headers[$key] = $value;
                    }
                $this->tempBearer = $headers['Authorization'];
                return $headers['Authorization'];
            } else {
                return 'fallo';
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
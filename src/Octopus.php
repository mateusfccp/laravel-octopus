<?php

namespace Octopus;

use Config;

/**
 * Octopus ─ A package integrating Octopus with laravel 5.* framework applications
 *
 * @author Mateus Felipe <mateusfccp@gmail.com>
 * @package Octopus
 * @version 0.1.0
 */
class Octopus {
    /**
     * Provides the URL for API invokation
     * @static
     */
    public static $invokeURL = "https://mtv5l7ue99.execute-api.us-east-1.amazonaws.com/Production";

    /**
     * Queue an action
     * @access public
     * @param string|array $param1 If a string is passed, the function will queue an action with this name. If you want to queue multiple actions, an array must be passed listing all the actions and its params.
     * @param array $param2 Should only be passed if $param1 is a sring. $param2 are the params of the action which name is $param1.
     * @static
     * @return array An array containing the status and data of the Response
     */
    public static function queue($param1, array $param2 = []) {
        return self::call_endpoint('queue', $param1, $param2);
    }

    /**
     * Send an action
     * @access public
     * @param string|array $param1 If a string is passed, the function will send an action with this name. If you want to send multiple actions, an array must be passed listing all the actions and its params.
     * @param array $param2 Should only be passed if $param1 is a sring. $param2 are the params of the action which name is $param1.
     * @static
     * @return array An array containing the status and data of the Response
     */
    public static function send($param1, array $param2 = []) {
        return self::call_endpoint('send', $param1, $param2);
    }

    /**
     * A middleware that deals with $param1 verification for queue() and send()
     * @access private
     * @param string|array $param1 If a string is passed, the function will insert it into the call url. If an array is passed it will be sent as data.
     * @param array $param2 Should only be passed if $param1 is a sring. $param2 are the params of the action which name is $param1.
     * @static
     * @return array
     */
    private static function call_endpoint(string $endpoint, $param1, array $param2) {
        if (is_string($param1)) {
            return self::call("{$endpoint}/{$param1}", $param2);
        } elseif (is_array($param1)) {
            return self::call("{$endpoint}", $param1);
        } else {
            throw Exception('The first param must be an action name (string) or list (array)!');
        }
    }

    /**
     * An abstraction for cURL request
     * @access private
     * @param string $endpoint The endpoint name that will be concatenated to invoke URL.
     * @param array $data The data to be sent in the body of the request.
     * @static
     * @return array
     */
    private static function call(string $endpoint, array $data = []) {
        $ch = curl_init();

        if ($ch === false) {
            throw new Exception('Error on cURL initialization.');
        }
        
        curl_setopt_array($ch, [
            CURLOPT_URL => self::$invokeURL . "/{$endpoint}",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'x-api-key: ' . Config::get('octopus.OCTOPUS_API_KEY'),   
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);

        $data = curl_exec($ch);

        if ($data === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);

        return ['status' => $http_code, 'data' => json_decode($data)];
    }
}


<?php
class HTTPRequester
{

    /**
     * @description Make HTTP-GET call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPGet($url, array $params, $token)
    {

        //$tokenFinal = isset($_SESSION['logged']['token']) ? $_SESSION['logged']['token'] : "";
        $query = http_build_query($params);
        $ch    = curl_init($url . '?' . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    /**
     * @description Make HTTP-GET call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPOpenGet($url, array $params)
    {

        $query = http_build_query($params);
        $ch    = curl_init($url . '?' . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Authorization: Bearer ' . $token
        // ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }





    /**
     * @description Make HTTP-POST call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPPostOld($url, array $params)
    {
        $tokenFinal = isset($_SESSION['loggedAdmin']['token']) ? $_SESSION['loggedAdmin']['token'] : $_SESSION['logged']['token'];

        $query = http_build_query($params);
        $ch    = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'accept: application/json',
        //     'Authorization: Bearer ' . $tokenFinal
        // ));

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
            print_r('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);

        //$responseArray = json_decode($response, true);

        // echo '<pre>';
        // print_r($response);
        return $response;
    }

    public static function HTTPPost($url, array $params, $token)
    {
        //$tokenFinal = isset($_SESSION['loggedAdmin']['token']) ? $_SESSION['loggedAdmin']['token'] : $_SESSION['logged']['token'];
        $buildQuery = json_encode($params);

        $ch = curl_init($url);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: Bearer " . $token,
                "Content-Type: application/json"
            )
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $buildQuery);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
            print_r('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

    // open for register only
    public static function HTTPPostFreeReg($url, array $params)
    {
        $query = http_build_query($params);
        $ch    = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
            print_r('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }



    public static function HTTPPostLogin($url, array $params)
    {
        $query = http_build_query($params);
        $ch    = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseArray = json_decode($response, true);
        return $response;
    }



    /**
     * @description Make HTTP-PUT call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPPut($url, array $params)
    {

        $query = \http_build_query($params);
        $ch    = \curl_init();
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'PUT');
        \curl_setopt($ch, \CURLOPT_POSTFIELDS, $query);
        \curl_setopt($ch, \CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . trim(isset($_SESSION['loggedAdmin']['token'])?$_SESSION['loggedAdmin']['token']:$_SESSION['logged']['token'])
        ));
        $response = \curl_exec($ch);
        \curl_close($ch);

        //print_r($response);
        return $response;
    }

      /**
     * @category Make HTTP-DELETE call
     * @param    $url
     * @param    array $params
     * @return   HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPPutTeste($url, array $params)
    {
        
        $query = \http_build_query($params);
        $ch    = \curl_init();
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'PUT');
        \curl_setopt($ch, \CURLOPT_POSTFIELDS, $query);
        \curl_setopt($ch, \CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer' . trim($_SESSION['loggedAdmin']['token'])  
        ));
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }


    /**
     * @category Make HTTP-DELETE call
     * @param    $url
     * @param    array $params
     * @return   HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function HTTPDelete($url, array $params, $token)
    {
        //$tokenFinal = isset($_SESSION['loggedAdmin']['token']) ? $_SESSION['loggedAdmin']['token'] : $_SESSION['logged']['token'];
        $query = \http_build_query($params);
        $ch    = \curl_init();
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'DELETE');
        \curl_setopt($ch, \CURLOPT_POSTFIELDS, $query);
        \curl_setopt($ch, \CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }




    /**
     * @category Make HTTP-LOGIN call to Laravel API "me" and retrieve users details
     * @param    $url
     * @param    array $params
     * @return   HTTP-Response data from user if true
     */
    public static function HTTPMeLaravelApi($token, $apiUrl)
    {
        //$tokenFinal = isset($_SESSION['loggedAdmin']['token']) ? $_SESSION['loggedAdmin']['token'] : $_SESSION['logged']['token'];
        $ch = curl_init($apiUrl . 'auth/me');
        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        // get stringified data/output. See CURLOPT_RETURNTRANSFER
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @category Make HTTP-LOGOUT call to Laravel API "me" and retrieve users details
     * @param    $url
     * @param    array $params
     * @return   HTTP-Response data from user if true
     */
    public static function HTTPLogoutLaravelApi($token, $apiUrl)
    {
        //$tokenFinal = isset($_SESSION['loggedAdmin']['token']) ? $_SESSION['loggedAdmin']['token'] : $_SESSION['logged']['token'];
        $ch = curl_init($apiUrl . 'auth/logout');
        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        // get stringified data/output. See CURLOPT_RETURNTRANSFER
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}

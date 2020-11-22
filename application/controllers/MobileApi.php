<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class MobileApi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->API_ACCESS_KEY = 'AIzaSyDexvTRWYvnqy5DM1OhCpZ0u3VFlticyk4';
        // (iOS) Private key's passphrase.
        $this->passphrase = 'joashp';
        // (Windows Phone 8) The name of our push channel.
        $this->channelName = "joashp";
    }

    private function useCurl($url, $headers, $fields = null) {
        // Open connection
        $ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);

            return $result;
        }
    }

    public function android($data, $reg_id_array) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = array(
            'title' => $data['title'],
            'message' => $data['message'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1
        );

        $headers = array(
            'Authorization: key=' . $this->API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => $reg_id_array,
            'data' => $message,
        );

        return $this->useCurl($url, $headers, json_encode($fields));
    }

    public function iOS($data, $devicetoken) {
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);
        // Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['mtitle'],
                'body' => $data['mdesc'],
            ),
            'sound' => 'default'
        );
        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);
        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;
    }

    function registration_get($name, $contact_no) {
        $this->config->load('rest', TRUE);
        $usercode = rand(10000000, 99999999);
        $regArray = array(
            "name" => $name,
            "email" => "",
            "contact_no" => $contact_no,
            "password" => $usercode,
            "usercode" => $usercode,
            "datetime" => date("Y-m-d H:i:s a")
        );
        $this->db->where('contact_no', $contact_no);
        $query = $this->db->get('app_user');
        $userdata = $query->row();
        if ($userdata) {
            $profiledata = array(
                'name' => $name,
                'contact_no' => $contact_no,
            );
            $this->db->set($profiledata);
            $this->db->where('contact_no', $contact_no); //set column_name and value in which row need to update
            $this->db->update("app_user");
            $this->response(array("status" => "already", "userdata" => $userdata));
        } else {

            $this->db->insert('app_user', $regArray);
            $last_id = $this->db->insert_id();
            $regArray['id'] = $last_id;
            $this->response(array("status" => "done", "userdata" => $regArray));
        }
    }
    
    function registrationMob_get(){
        $this->response(array("hello"=>"hello"));
    }

    function synctable_post() {
        $this->config->load('rest', TRUE);
        // $tempfilename = rand(100, 1000000);
        $postdata = $this->post();
        $tablename = "sync_" . $postdata['table_name'];
        unset($postdata['table_name']);
        $this->db->insert($tablename, $postdata);
        $last_id = $this->db->insert_id();
        $this->db->set("server_id", $last_id);
        $this->db->where('id', $last_id); //set column_name and value in which row need to update
        $this->db->update($tablename);
        $this->response($postdata);
    }

    function getUserSyncData_get($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('sync_notes');
        $userdatasync = $query->result_array();
        $this->response($userdatasync);
    }

}

?>
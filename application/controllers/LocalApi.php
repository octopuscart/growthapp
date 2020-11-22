<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class LocalApi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->API_ACCESS_KEY = 'AIzaSyDexvTRWYvnqy5DM1OhCpZ0u3VFlticyk4';
        // (iOS) Private key's passphrase.
        $this->passphrase = 'joashp';
        // (Windows Phone 8) The name of our push channel.
        $this->channelName = "joashp";
        $this->checklogin = $this->session->userdata('logged_in');
        $this->load->model('Order_model');
    }

    function testGet_get() {
        print_r($this->checklogin['user_type']);
    }

    //function for user settingt
    function updateUserSession_post() {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update("admin_users", $data);
            if (isset($this->checklogin[$fieldname])) {

                $this->checklogin[$fieldname] = $value;
                $this->session->set_userdata('logged_in', $this->checklogin);
            }
        }
    }

    function updateUserClient_post() {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update("admin_users", $data);
        }
    }

    function updateUser() {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');

        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update("admin_user", $data);
        }
    }

    //function for curd update
    function updateCurd_post() {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        $tablename = $this->post('tablename');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update($tablename, $data);
        }
    }

    //function for curd update
    function curd_get($table_name) {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update($table_name, $data);
        }
    }

    //function for product list
    function deleteCurd_post($table_name) {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update($table_name, $data);
        }
    }

    function registerMobileGuest_post() {
        $this->config->load('rest', TRUE);
        $reg_id = $this->post('reg_id');
        $model = $this->post('model');
        $manufacturer = $this->post('manufacturer');
        $uuid = $this->post('uuid');
        $regArray = array(
            "reg_id" => $reg_id,
            "manufacturer" => $manufacturer,
            "uuid" => $uuid,
            "model" => $model,
            "user_id" => "",
            "user_type" => "",
            "datetime" => date("Y-m-d H:i:s a")
        );

        $this->db->where('uuid', $uuid);
        $query = $this->db->get('gcm_registration');
        $regarraydata = $query->result_array();
        print_r($regarraydata);
        if ($regarraydata) {
            $this->db->set($regArray);
            $this->db->where('uuid', $uuid);
            $this->db->update("gcm_registration");
        } else {
            $this->db->insert('gcm_registration', $regArray);
        }
        $this->response(array("status" => "done"));
    }

    function registerMobileUser_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $reg_id = $this->post('reg_id');
        $model = $this->post('model');
        $manufacturer = $this->post('manufacturer');
        $uuid = $this->post('uuid');
        $regArray = array(
            "reg_id" => $reg_id,
            "manufacturer" => $manufacturer,
            "uuid" => $uuid,
            "model" => $model,
            "user_id" => "Admin",
            "user_type" => "Admin",
            "datetime" => date("Y-m-d H:i:s a")
        );
        $this->db->where('reg_id', $reg_id);
        $query = $this->db->get('gcm_registration');
        $regarray = $query->result_array();
        if ($regArray) {
            
        } else {
            $this->db->insert('gcm_registration', $regArray);
        }
        $this->response(array("status" => "done"));
    }

    // Curl 
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

    function ganarateNotificationForAdmin_get() {
        header('Content-type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        $unseenData = $this->School_model->unseenClassData();
        $unseenMessage = $this->School_model->unseenMessages();

        $classdatacount = count($unseenData);
        $messagecount = count($unseenMessage);

        $totalcount = $classdatacount + $messagecount;

        $title = "$totalcount Unseen Notifications";
        $message = "";
        $messageo = "";
        $messagem = "";
        if ($classdatacount) {
            $messageo = "Total $classdatacount Unseen Data Need Be Approved";
        }
        if ($messagecount) {
            $messagem = ($messageo ? " and " : "Total ") . "$messagecount Unseen Messages(s)";
        }
        $message = $messageo . $messagem;
        $returnData = array(
            "message" => $message,
            "unssenclassdata" => $unseenData,
            "unseenmessagedata" => $unseenMessage,
            "totalclassdata" => $classdatacount,
            "totalmessagedata" => $messagecount,
            "totalunseen" => $totalcount
        );
        $this->response($returnData);
    }

    //school function 
    //
    //
    //

    function classData_get($tablename) {
        $this->config->load('rest', TRUE);
        header("Access-Control-Allow-Origin: *");
        $assignmentData = $this->School_model->classDataByClassId($tablename, "0", "");
        foreach ($assignmentData as $key => $value) {
            $teacherid = $value->user_id;
            $value->teacherdata = $this->School_model->userDataFromId($teacherid);
        }
        $this->response($assignmentData);
    }

    function classDataGet_get($post_id, $tablename) {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $data = array("status" => "1");
        $this->db->set($data);
        $this->db->where("id", $post_id);
        $this->db->update($tablename);

        try {
            $regidsmessage = $this->School_model->sendNotificationToClassData($post_id, $tablename);
            // print_r($regidsmessage);
            $data = $regidsmessage["message"];
            $this->android($data, $regidsmessage['regids']);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }


        $this->response(array("status" => "done"));
    }

    function classDataGetTest_get($post_id, $tablename) {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $data = array("status" => "1");
        $this->db->set($data);
        $this->db->where("id", $post_id);
        $this->db->update($tablename);

        try {
            $regidsmessage = $this->School_model->sendNotificationToClassData($post_id, $tablename);
            print_r($regidsmessage);
            $data = $regidsmessage["message"];
            echo $this->android($data, $regidsmessage['regids']);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }


        $this->response(array("status" => "done"));
    }

    function classDataDelete_get($post_id, $tablename) {
        $this->config->load('rest', TRUE);
        header("Access-Control-Allow-Origin: *");
        $this->db->where("id", $post_id);
        $this->db->delete($tablename);
        $this->response(array("status" => "done"));
    }

    public function tableData_get($table) {
        $this->config->load('rest', TRUE);
        header("Access-Control-Allow-Origin: *");
        $this->db->order_by('id', "desc");
        $query = $this->db->get($table);
        $data = $query->result_array();
        $this->response($data);
    }

    public function circularData_get($usertype) {
        $this->config->load('rest', TRUE);
        header("Access-Control-Allow-Origin: *");
        $this->db->order_by('id', "desc");
        $query = $this->db->get($table);
        $data = $query->result_array();
        $this->response($data);
    }

    public function tableDataDelete_get($post_id, $tablename) {
        $this->config->load('rest', TRUE);
        header("Access-Control-Allow-Origin: *");
        $this->db->where("id", $post_id);
        $this->db->delete($tablename);
        $this->response(array("status" => "done"));
    }

}

?>
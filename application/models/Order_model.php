<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    function __construct() {
// Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function convert_num_word($number) {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $wordsz = array('0' => 'zero', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',);
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
            } else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $result = $result ? $result : $wordsz[$result / 10];
        $points = ($point) ?
                " and " . $wordsz[$point / 10] . " " .
                $wordsz[$point = $point % 10] : '';
        return "Only " . GLOBAL_CURRENCY . $result . " " . ($points ? "" . $points . " Cents" : "") . "";
    }

    function recalculateOrder($order_id) {
        $this->db->select('sum(total_price) as total_price');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('cart');
        $cart_items = $query->row();

        $totalPrice = $cart_items->total_price;
        $orderupdate = array(
            'amount_in_word' => $this->convert_num_word($totalPrice),
            'sub_total_price' => $totalPrice,
            'total_price' => $totalPrice);
        $this->db->set($orderupdate);
        $this->db->where("id", $order_id);
        $this->db->update('user_order');
    }

//get order details  
    public function getOrderDetails($key_id, $is_key = 0) {
        $order_data = array();
        if ($is_key === 'key') {
            $this->db->where('order_key', $key_id);
        } else {
            $this->db->where('id', $key_id);
        }
        $query = $this->db->get('user_order');
        $order_details = $query->row();
        if ($order_details) {

            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('cart');
            $cart_items = $query->result();

            $this->db->order_by('display_index', 'asc');
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('custom_measurement');
            $custom_measurement = $query->result_array();

            $order_data['measurements_items'] = $custom_measurement;

            foreach ($cart_items as $key => $value) {
                $cart_id = $value->id;

                $this->db->where('cart_id', $cart_id);
                $query = $this->db->get('cart_customization');
                $cartcustom = $query->result_array();

                $customdata = array();
                foreach ($cartcustom as $key1 => $value1) {
                    $customdata[$value1['style_key']] = $value1['style_value'];
                }
                $value->custom_dict = $customdata;
                $value->product_status = array();
            }
            $order_data['cart_data'] = $cart_items;
        }
        return $order_data;
    }

    public function getOrderDetailsV2($key_id, $is_key = 0) {
        $order_data = array();
        if ($is_key === 'key') {
            $this->db->where('order_key', $key_id);
        } else {
            $this->db->where('id', $key_id);
        }
        $query = $this->db->get('user_order');
        $order_details = $query->row();
        $payment_details = array("payment_mode" => "", "txn_id" => "", "payment_date" => "");

        if ($order_details) {

            $this->db->order_by('id', 'desc');
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('user_order_status');
            $userorderstatus = $query->result();
            $order_data['order_status'] = $userorderstatus;

            if ($order_details->payment_mode == 'PayPal') {
                $this->db->where('order_id', $order_details->id);
                $query = $this->db->get('paypal_status');
                $paypal_details = $query->result();

                if ($paypal_details) {
                    $paypal_details = end($paypal_details);
                    $payment_details['payment_mode'] = "PayPal";
                    $payment_details['txn_id'] = $paypal_details->txn_no;
                    $payment_details['payment_date'] = $paypal_details->timestemp;
                }
            }

            $order_id = $order_details->id;
            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('cart');
            $cart_items = $query->result();

            $this->db->order_by('display_index', 'asc');
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('custom_measurement');
            $custom_measurement = $query->result_array();

            $order_data['measurements_items'] = $custom_measurement;

            foreach ($cart_items as $key => $value) {
                $cart_id = $value->id;

                $this->db->where('cart_id', $cart_id);
                $query = $this->db->get('cart_customization');
                $cartcustom = $query->result_array();

                $customdata = array();
                foreach ($cartcustom as $key1 => $value1) {
                    $customdata[$value1['style_key']] = $value1['style_value'];
                }
                $value->custom_dict = $customdata;

//                $this->db->where('order_id', $order_id);
//                $this->db->where('vendor_id', $vendor_id);
//                $query = $this->db->get('vendor_order_status');
//                $orderstatus = $query->result();
                $value->product_status = array();
            }
            $order_data['payment_details'] = $payment_details;
            $order_data['cart_data'] = $cart_items;
//            $order_data['amount_in_word'] = $this->convert_num_word($order_data['order_data']->total_price);
        }
        return $order_data;
    }

    public function getOrderDetailsV3($key_id, $is_key = 0) {
        $order_data = array();

        $this->db->where('id', $key_id);

        $query = $this->db->get('web_order');
        $order_details = $query->row();
        $payment_details = array("payment_mode" => "", "txn_id" => "", "payment_date" => "");

        if ($order_details) {

            $this->db->order_by('id', 'desc');
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('user_order_status');
            $userorderstatus = $query->result();
            $order_data['order_status'] = $userorderstatus;



            $order_id = $order_details->id;
            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('cart');
            $cart_items = $query->result();

            $order_data['payment_details'] = array();
            $order_data['cart_data'] = array();
//            $order_data['amount_in_word'] = $this->convert_num_word($order_data['order_data']->total_price);
        }
        return $order_data;
    }

    public function getVendorsOrder($key_id) {
        $order_data = array();
        $this->db->where('order_key', $key_id);
        $query = $this->db->get('user_order');
        $order_details = $query->row();
        $venderarray = array();
        if ($order_details) {
            $order_id = $order_details->id;
            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_id);
            $query = $this->db->get('vendor_order');
            $vendor_orders = $query->result();
            $order_data['vendor'] = array();
            foreach ($vendor_orders as $key => $value) {
                $vid = $value->vendor_id;
                $order_data['vendor'][$vid] = array();
                $order_data['vendor'][$vid]['vendor'] = $value;

                $this->db->order_by('id', 'desc');
                $this->db->where('vendor_order_id', $value->id);
                $query = $this->db->get('vendor_order_status');
                $status = $query->row();

                $order_data['vendor'][$vid]['status'] = $status ? $status->status : $value->status;
                $order_data['vendor'][$vid]['remark'] = $status ? $status->remark : $value->status;

                $this->db->where('order_id', $order_id);
                $this->db->where('vendor_id', $vid);
                $query = $this->db->get('cart');
                $order_data['vendor'][$vid]['cart_items'] = $query->result();
            }
        }

        return $order_data;
    }

    function order_mail($order_id, $subject = "") {
        setlocale(LC_MONETARY, 'en_US');
        $order_details = $this->getOrderDetailsV3($order_id, 'key');
        $emailsender = EMAIL_SENDER;
        $sendername = EMAIL_SENDER_NAME;
        $email_bcc = EMAIL_BCC;
        echo EMAILCC;

        if ($order_details) {
            $currentstatus = $order_details['order_status'][0];
            $order_no = $order_details['order_data']->id;
            $this->email->from(EMAIL_BCC, $sendername);
            $this->email->to($order_details['order_data']->email);
          
            $this->email->bcc(EMAIL_BCC);
            $subject = SITE_NAME . " - " . $currentstatus->remark;
            $this->email->subject($subject);
            $checkcode = REPORT_MODE;
            $orderhtml = $this->load->view('Email/order_mail', $order_details, true);
            if ($checkcode == 0) {
//                ob_clean();
                echo $orderhtml;
            } else {
                
                   $this->email->message($orderhtml);
                   $this->email->print_debugger();
                   echo $result = $this->email->send();
            }
        }
    }

    function order_mail_confirm($order_id, $subject = "") {
        setlocale(LC_MONETARY, 'en_US');
        $order_details = $this->getOrderDetailsV2($order_id, 'key');
        $emailsender = EMAIL_SENDER;
        $sendername = EMAIL_SENDER_NAME;
        $email_bcc = EMAIL_BCC;

        if ($order_details) {
            $currentstatus = $order_details['order_status'][0];
            $order_no = $order_details['order_data']->order_no;
            $this->email->from(EMAIL_BCC, $sendername);
            $this->email->to($order_details['order_data']->email);
            $this->email->cc(EMAILCC);
            $this->email->bcc(EMAIL_BCC);
            $subject = SITE_NAME . " - " . $currentstatus->remark;
            $this->email->subject($subject);
            $checkcode = REPORT_MODE;
            if ($checkcode == 0) {
//                ob_clean();
                echo $this->load->view('Email/order_mail_confirm', $order_details, true);
            } else {
                $this->email->message($this->load->view('Email/order_mail_confirm', $order_details, true));
                $this->email->print_debugger();
                echo $result = $this->email->send();
            }
        }
    }

    function order_pdf($order_id, $subject = "") {
        setlocale(LC_MONETARY, 'en_US');
        $order_details = $this->getOrderDetailsV3($order_id, 0);
        if ($order_details) {
            $order_no = $order_details['order_data']->id;
            $html = $this->load->view('Email/order_pdf', $order_details, true);
            $html_header = $this->load->view('Email/order_mail_header', $order_details, true);
            $html_footer = $this->load->view('Email/order_mail_footer', $order_details, true);
            $pdfFilePath = $order_no . ".pdf";
            $checkcode = REPORT_MODE;
            if ($checkcode == 0) {
                echo $html;
            } else {
                $this->load->library('m_pdf');
                $this->m_pdf->pdf->SetHTMLHeader($html_header);
                $this->m_pdf->pdf->SetHTMLFooter($html_footer);

                $this->m_pdf->pdf->WriteHTML($html);
                $this->m_pdf->pdf->Output($pdfFilePath, "D");
            }
        }
    }

    function order_pdf_worker($order_id, $subject = "") {
        setlocale(LC_MONETARY, 'en_US');
        $order_details = $this->getOrderDetails($order_id, 0);
        if ($order_details) {
            $order_no = $order_details['order_data']->order_no;
            $html = $this->load->view('Email/order_pdf_worker', $order_details, true);
            $html_header = $this->load->view('Email/order_mail_header', $order_details, true);
            $html_footer = $this->load->view('Email/order_mail_footer', $order_details, true);
            $pdfFilePath = $order_no . "_worker_report.pdf";
            $checkcode = REPORT_MODE;
            if ($checkcode == 0) {
                echo $html;
            } else {
                $this->load->library('m_pdf');
                $this->m_pdf->pdf->SetHTMLHeader($html_header);
                $this->m_pdf->pdf->SetHTMLFooter($html_footer);

                $this->m_pdf->pdf->WriteHTML($html);
                $this->m_pdf->pdf->Output($pdfFilePath, "D");
            }
        }
    }

    public function orderInboxEmail() {
        $hostname = '{server.costcokart.com:143/imap/notls}INBOX';
        $username = 'sales@baanthai.costcokart.com';
        $password = 'baansales$2019';
        $inboxarray = [];

        /* try to connect */
        $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Email: ' . imap_last_error());

        /* grab emails */
        $emails = imap_search($inbox, 'ALL');

        /* if emails are returned, cycle through each... */
        if ($emails) {

            /* begin output var */
            $output = '';

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach ($emails as $email_number) {

                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox, $email_number, 0);
                $message = (imap_body($inbox, $overview[0]->msgno));


                $tempbox = array(
                    "from_email" => $overview[0]->from,
                    "subject" => $overview[0]->subject,
                    "datetime" => $overview[0]->date,
                    "message" => $message,
                    "uid" => $overview[0]->uid,
                    "msgno" => $overview[0]->msgno,
                    "udate" => $overview[0]->udate,
                    "seen" => "0",
                );

                $this->db->where('uid', $overview[0]->uid);
                $query = $this->db->get('web_order_email');
                $emailpre = $query->result_array();
                if ($emailpre) {
                    
                } else {
                    $this->db->insert('web_order_email', $tempbox);
                }
            }
        }

        /* close the connection */
        imap_close($inbox);
    }

}

?>

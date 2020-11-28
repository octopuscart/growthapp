<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BibleStudy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');

        $this->load->model('Order_model');
        $this->curd = $this->load->model('Curd_model');
        $session_user = $this->session->userdata('logged_in');
        $this->session_user = $session_user;
        if ($session_user) {
            $this->user_id = $session_user['login_id'];
        } else {
            $this->user_id = 0;
        }
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
    }

    public function listPage($char_id) {

        $query = $this->db->get('bible_study_index');
        $bible_study_index = $query->result();


        $this->db->where('id', $char_id);
        $query = $this->db->get('bible_study_index');
        $indexobj = $query->row();
        $chartext = "A";
        if ($indexobj) {
            $char_text = $indexobj->title;
        } else {
            redirect(site_url("/"));
        }


        $this->db->where('index_id', $char_id);
        $query = $this->db->get('bible_study');
        $bible_study = $query->result();


        $data = [];
        $data['indexlist'] = $bible_study_index;
        $data['char_id'] = $char_id;
        $data['char_text'] = $char_text;
        $data['bible_study'] = $bible_study;


        if (isset($_POST['addnew'])) {
            $insertArray = array(
                "title" => $this->input->post("title"),
                "body" => $this->input->post("body"),
                'index_id' => $char_id,
                "char_text" => $char_text,
            );

            $this->db->insert("bible_study", $insertArray);
            redirect("BibleStudy/listPage/" . $char_id );
        }

        if (isset($_POST['delete_data'])) {
            $sid = $this->input->post("table_id");
            $this->db->where('id', $sid);
            $this->db->delete("bible_study");
             redirect("BibleStudy/listPage/" . $char_id );
        }


        if (isset($_POST['update_data'])) {
            $insertArray = array(
                "title" => $this->input->post("title"),
                "body" => $this->input->post("body"),
            );
            $sid = $this->input->post("table_id");
            $this->db->where('id', $sid);
            $this->db->update("bible_study", $insertArray);
            redirect("BibleStudy/listPage/" . $char_id );
        }



     


        $this->load->view('BibleStudy/listpage', $data);
    }


}

?>

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CMS extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->curd = $this->load->model('Curd_model');
        $session_user = $this->session->userdata('logged_in');
        if ($session_user) {
            $this->user_id = $session_user['login_id'];
        } else {
            $this->user_id = 0;
        }
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
    }

    public function deletePrayer($id) {
        $this->db->where('id', $id);
        $this->db->delete('prayer_request');
        redirect("CMS/prayerRequest");
    }

    public function prayerRequest() {
        $data['prayer_request'] = [];
        $this->load->view('CMS/prayer_request', $data);
    }

    public function deleteContact($id) {
        $this->db->where('id', $id);
        $this->db->delete('contact_us');
        redirect("CMS/contactList");
    }

    public function contactList() {
        $data['prayer_request'] = [];
        $this->load->view('CMS/contactList', $data);
    }

    public function applicationPages($pageid = 1) {
        $data = array();

        $query = $this->db->get('app_pages');
        $app_pageslist = $query->result();
        $data['pagelist'] = $app_pageslist;

        $this->db->where('id', $pageid);
        $query = $this->db->get('app_pages');
        $pageobj = $query->row();

        $data['pageobj'] = $pageobj;


        if (isset($_POST['update_data'])) {

            $this->db->where('id', $pageid);
            $insertArray = array(
                "sub_title" => $this->input->post("sub_title"),
                "body" => $this->input->post("body"),
            );
            $this->db->update("app_pages", $insertArray);

            $realfilename = $this->input->post("file_real_name");
            if ($realfilename) {
                $config['upload_path'] = 'assets/images';
                $config['allowed_types'] = '*';
                $tempfilename = rand(10000, 1000000);
                $tempfilename = "" . $tempfilename . $tableid;
                $ext2 = explode('.', $_FILES['file']['name']);
                $ext3 = strtolower(end($ext2));
                $ext22 = explode('.', $tempfilename);
                $ext33 = strtolower(end($ext22));
                $filename = $ext22[0];
                $file_newname = $filename . '.' . $ext3;
                $config['file_name'] = $file_newname;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $file_newname = $uploadData['file_name'];
                    $this->db->set('image', $file_newname);
                    $this->db->where('id', $pageid); //set column_name and value in which row need to update
                    $this->db->update("app_pages"); //
                }
            }


            redirect("CMS/applicationPages/" . $pageid);
        }


        $data['page_id'] = $pageid;
        $this->load->view('CMS/applicationPage', $data);
    }
    
    public function songTemplate() {
        $data = array();
        $query = $this->db->get('song_request_template');
        $songtemplate = $query->row();
        $data['songtemplate'] = $songtemplate;
        if (isset($_POST['update_data'])) {
            $this->db->where('id', $songtemplate->id);
            $insertArray = array(
                "request_template" => $this->input->post("request_template"),
            );
            $this->db->update("song_request_template", $insertArray);
            redirect("CMS/songTemplate");
        }
        $this->load->view('CMS/songTemplate', $data);
    }

}

?>

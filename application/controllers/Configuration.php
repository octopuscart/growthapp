<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();

class Configuration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
    }

  
    public function reportConfiguration() {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('configuration_report');
        $systemlog = $query->row();
  $data['configuration_report'] = $systemlog;


  
        



        if (isset($_POST['update_data'])) {
            $confArray = array(
           "email_header" => $this->input->post("email_header"),
          "email_footer" => $this->input->post("email_footer"),
                "pdf_report_header" => $this->input->post("pdf_report_header"),
            );
            $this->db->update('configuration_report', $confArray);
            redirect("Configuration/reportConfiguration");
        }


        $this->load->view("configuration/reportConfiguration", $data);
    }

    public function migration() {
        
    }

    public function test() {
        $classData = $this->School_model->makeUserId("T", 20);
    }

    public function classManagement() {
        $data = array();
        $classData = $this->School_model->ClassListData();
        $data['class_data'] = $classData;
        if (isset($_POST['addclass'])) {
            $data = array(
                "class_name" => $this->input->post("class_name"),
                "section_name" => "",
                "class_id" => "0",
                "description" => "",
            );
            $this->db->insert("configuration_class", $data);
            $insert_id = $this->db->insert_id();
            $data2 = array(
                "class_name" => $this->input->post("class_name"),
                "section_name" => "A",
                "class_id" => $insert_id,
                "description" => "",
            );
            $this->db->insert("configuration_class", $data2);
            redirect("Configuration/classManagement");
        }
        if (isset($_POST['addsection'])) {
            $data = array(
                "class_name" => $this->input->post("class_name"),
                "section_name" => $this->input->post("section_name"),
                "class_id" => $this->input->post("class_id"),
                "description" => "",
            );
            $this->db->insert("configuration_class", $data);
            redirect("Configuration/classManagement");
        }



        $this->load->view("configuration/classManagement", $data);
    }

    public function schoolTeacherManagement() {
        $data = array();
        $classData = $this->School_model->getClassAll();
$classTecherData = $this->School_model->getSchoolUsers("teacher");

        $data["class_teachers"] = $classTecherData;
        $data['class_data'] = $classData;
if (isset($_POST['removeuser'])) {
            $userid = $this->input->post("userid");
            $this->School_model->removeSchoolUser($userid);
            redirect("Configuration/schoolTeacherManagement");
        }

        if (isset($_POST['adduser'])) {
            $classid = $this->input->post("class_id");
            $classobj = $classData[$classid];
                       $data = array(
                "name" => $this->input->post("name"),
                "mobile_no" => $this->input->post("mobile_no"),
                "email" => $this->input->post("email"),
 "gender" => $this->input->post("gender"),
                "section" => $classobj->section_name,
                "class" => $classobj->class_name,
                "class_id" => $classid,
                "user_type" => "teacher",
            );
            $this->db->insert("school_user", $data);
            $insert_id = $this->db->insert_id();
            $this->School_model->makeUserId("T", $insert_id);

            redirect("Configuration/schoolTeacherManagement");
        }



        $this->load->view("configuration/teacherManagement", $data);
    }

    public function schoolParentManagement() {
        $data = array();
        $classTecherData = $this->School_model->getSchoolUsers("parent");
        $data["class_teachers"] = $classTecherData;

        if (isset($_POST['removeuser'])) {
            $userid = $this->input->post("userid");
            $this->School_model->removeSchoolUser($userid);
            redirect("Configuration/schoolParentManagement");
        }

        if (isset($_POST['adduser'])) {
            $data = array(
                "name" => $this->input->post("name"),
                "mobile_no" => $this->input->post("mobile_no"),
                "email" => $this->input->post("email"),
                "gender" => $this->input->post("gender"),
                "section" => "",
                "class" => "",
                "class_id" => "",
                "user_type" => "parent",
            );
            $this->db->insert("school_user", $data);
            $insert_id = $this->db->insert_id();
            $this->School_model->makeUserId("P", $insert_id);

            redirect("Configuration/schoolParentManagement");
        }



        $this->load->view("configuration/parentManagement", $data);
    }

    public function schoolStudentManagement($class_id = 0) {

        $data = array();
        $classData = $this->School_model->getClassAll();


        $data['selected_class'] = array();
        if ($class_id) {
            $data['selected_class'] = $classData[$class_id];
        }

        $classTecherData = $this->School_model->classStudents($class_id);

        $data["class_teachers"] = $classTecherData;
        $data['class_data'] = $classData;
        if (isset($_POST['removeuser'])) {
            $userid = $this->input->post("userid");
            $this->School_model->removeSchoolUser($userid);
            redirect("Configuration/schoolStudentManagement/".$class_id);
        }

        if (isset($_POST['adduser'])) {
            $data = array(
                "name" => $this->input->post("name"),
                "mobile_no" => "",
                "email" => "",
                "gender" => $this->input->post("gender"),
                "section" => $this->input->post("section"),
                "class" => $this->input->post("class"),
                "class_id" => $this->input->post("class_id"),
                "user_type" => "student",
            );
            $this->db->insert("school_user", $data);
            $insert_id = $this->db->insert_id();
            $this->School_model->makeUserId("S", $insert_id);

            redirect("Configuration/schoolStudentManagement/".$class_id);
        }



        $this->load->view("configuration/studentManagement", $data);
    }

}
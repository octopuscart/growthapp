<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class School_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function makeUserId($usertype, $last_id) {
        $pnum = "" . $last_id;
        $removel = strlen($pnum) * (-1);
        $randomno = rand(100000, 999999);
        $randomno = "000000";
        $substring = substr($randomno, 0, $removel);
        $userid = $usertype . $substring . $pnum;
        $this->db->set(array("userid" => $userid));
        $this->db->where('id', $last_id); //set column_name and value in which row need to update
        $this->db->update("school_user");
    }

    function removeSchoolUser($userid) {
        $this->db->where('userid', $userid); //set column_name and value in which row need to update
        $this->db->delete("school_user");
    }

    function getSchoolUsers($user_type) {
        if ($user_type == 'all') {
            
        } else {
            $this->db->where('user_type', $user_type);
        }
        $this->db->order_by('id desc');
        $query = $this->db->get("school_user");
        $classData = $query->result();
        return $classData;
    }

    function getClass($class_id) {
        $this->db->where('class_id', $class_id);

        $query = $this->db->get("configuration_class");
        $classData = $query->result();
        return $classData;
    }

    function getClassALL() {
        $this->db->where('class_id!=', "0");
        $this->db->order_by('class_name');
        $query = $this->db->get("configuration_class");
        $classData = $query->result();
        $classArray = array();
        foreach ($classData as $skey => $svalue) {
            $classArray[$svalue->id] = $svalue;
        }
        return $classArray;
    }

    function ClassListData() {
        $classData = $this->getClass("0");
        $classSectionData = array();
        foreach ($classData as $key => $value) {
            $sectiondata = $this->getClass($value->id);
            $sectionArray = array();
            foreach ($sectiondata as $skey => $svalue) {
                $sectionArray[$svalue->id] = array("class_id" => $svalue->id, "section" => $svalue->section_name);
            }
            $classSectionData[$value->id] = array(
                "id" => $value->id,
                "title" => $value->class_name,
                "section" => $sectionArray
            );
        }
        return $classSectionData;
    }

    //
    //
    //Class Assignment, class_notice, class_note data list accroding to user id
    function classDataByUserId($tablename, $status, $userid = "") {
        if ($status == '0') {
            $this->db->where('status', '0');
        }
        if ($status == '1') {
            $this->db->where('status', '1');
        }
        if ($userid != "") {
            $this->db->where('user_id', $userid);
        }
        $this->db->order_by('id desc');
        $query = $this->db->get($tablename);
        $classnoteData = $query->result();
        $classtempdata = array();
        $filerul = base_url() . "assets/schoolfiles/";
        foreach ($classnoteData as $key => $value) {
            $table_id = $value->id;
            
            $this->db->select("concat('$filerul', file_name) as file, file_name ");
            $this->db->where('table_id', $table_id);
            $this->db->where('table_name', $tablename);
            $this->db->order_by('id desc');
            $query = $this->db->get("school_files");
            $classfiles = $query->result();
            $value->files = $classfiles;
            array_push($classtempdata, $value);
        }
        return $classtempdata;
    }

    //
    //
    //Class Assignment, class_notice, class_note data list accroding to class id
    function classDataByClassId($tablename, $status, $class_id = "") {
        if ($status == 'all') {
            
        }
        if ($status == '0') {
            $this->db->where('status', '0');
        }
        if ($status == '1') {
            $this->db->where('status', '1');
        }

        if ($class_id) {
            $this->db->where('class_id', $class_id);
        }


        $this->db->order_by('id desc');
        $query = $this->db->get($tablename);
        $classnoteData = $query->result();
        $classtempdata = array();
        foreach ($classnoteData as $key => $value) {
            $table_id = $value->id;
            $this->db->where('table_id', $table_id);
            $this->db->where('table_name', $tablename);
            $this->db->order_by('id desc');
            $query = $this->db->get("school_files");
            $classfiles = $query->result();
            $value->files = $classfiles;
            array_push($classtempdata, $value);
        }
        return $classtempdata;
    }

    //
    //
    //school circular list
    function circularData($usertype = "") {
        //        $this->db->where('status', '1');
        if ($usertype) {
            $this->db->where('user_type', $usertype);
        }
        $this->db->order_by('id desc');
        $query = $this->db->get('school_circular');
        $circularData = $query->result();
        return $circularData;
    }

    //
    //
    //school news data
    function newsData() {
        $this->db->order_by('id desc');
        $query = $this->db->get('school_news');
        $newsData = $query->result();
        return $newsData;
    }

    //
    //
    //Album function
    function galleryAlbum() {
        $tempdata = array(
            "id" => "1",
            "title" => "Test Album",
            "description" => "Description Of Test News.",
            "main_image" => base_url() . "assets/gallary/" . "1.jpg",
            "stackimage" => [
                base_url() . "assets/gallary/" . "1.jpg",
                base_url() . "assets/gallary/" . "2.jpg",
                base_url() . "assets/gallary/" . "3.jpg",
                base_url() . "assets/gallary/" . "4.jpg",
            ],
            "datetime" => date("Y-m-d H:i:s a"),
        );
        $gallaryData = [];
        for ($i = 0; $i < 15; $i++) {
            array_push($gallaryData, $tempdata);
        }

        $this->db->order_by('id asc');
        $query = $this->db->get('school_album');
        $albumData = $query->result();
        $gallaryData = [];
        foreach ($albumData as $keyalbum => $album) {
            $this->db->where('table_name', "school_album");
            $this->db->where('table_id', $album->id);
            $this->db->order_by('id desc');
            $query = $this->db->get('school_files');
            $albumImageData = $query->result();
            $img1 = array();
            $img = SITE_LOGO;
            foreach ($albumImageData as $key => $value) {
                $img = base_url() . "assets/schoolfiles/" . $value->file_name;
                array_push($img1, $img);
            }
            $album->main_image = $img;
            $album->stackimage = $img1;
            array_push($gallaryData, $album);
        }
        return $gallaryData;
    }

    //
    //
    //Gallary by album id
    function GalleryAlbumById($albumid) {
        $this->db->where('id', $albumid);
        $this->db->order_by('id asc');
        $query = $this->db->get('school_album');
        $albumData = $query->row();

        $this->db->where('table_name', "school_album");
        $this->db->where('table_id', $albumid);
        $this->db->order_by('id desc');
        $query = $this->db->get('school_files');
        $albumImageData = $query->result();
        $img1 = array();
        $img2 = array();
        foreach ($albumImageData as $key => $value) {
            $temp = array(
                "img" => base_url() . "assets/schoolfiles/" . $value->file_name,
                "index" => $key,
                "id" => $value->id,
            );
            if ($key % 2 == 0) {
                array_push($img1, $temp);
            } else {
                array_push($img2, $temp);
            }
        }
        $albumData->images1 = $img1;
        $albumData->images2 = $img2;
        return $albumData;
    }

    //
    //
    //User data from Id
    function userDataFromId($user_id, $user_type = "") {
        if ($user_type == 'student') {
            $this->db->where('user_type', "student");
        }
        $this->db->where('userid', $user_id);
        $this->db->order_by('name asc');
        $query = $this->db->get('school_user');
        $userData = $query->row();
        return $userData;
    }

    //
    //
    //Student List By Class Id
    function classStudents($classid) {
//        $this->db->where('status', '1');
        $this->db->where('class_id', $classid);
        $this->db->where('user_type', "student");
        $this->db->order_by('name asc');
        $query = $this->db->get('school_user');
        $userData = $query->result();
        return $userData;
    }

    //
    //
    //Get Children by parent id
    function childToParent($parent_id) {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('user_type', "student");
        $this->db->order_by('name asc');
        $query = $this->db->get('school_user');
        $userData = $query->result();
        $userDataF = array();
        foreach ($userData as $key => $value) {
            $userDataF[$value->userid] = $value;
        }
        return $userDataF;
    }

    //end of child to parent
    //
    //Leave request function 
    function leaveRequestData($rltype, $typeid) {
        $this->db->select('slr.*, su.name, su.class_id, su.class, su.section, su.gender');
//        $this->db->where('slr.status', '0');
        if ($rltype == 'all') {
            
        }
        if ($rltype == 'class') {
            $this->db->where('slr.class_id', $typeid);
        }
        if ($rltype == 'parent') {
            $this->db->where('slr.parent_id', $typeid);
        }
        $this->db->order_by('slr.id desc');
        $this->db->from('student_leave_request as slr');
        $this->db->join('school_user as su', 'su.userid = slr.student_id', 'LEFT');
        $query = $this->db->get();
        $userLeaveData = $query->result_array();
        return $userLeaveData;
    }

    //end fo leave request function
    //
    //
    //
    //Attendance Controller 
    function attendanceByDate($class_id, $date) {
        $this->db->where('class_id', $class_id);
        $this->db->where('at_date', $date);
        $query = $this->db->get('student_attendance');
        $attendata = $query->result_array();
        $attenArray = array();
        foreach ($attendata as $key => $value) {
            $attenArray[$value['student_id']] = $value;
        }
        return $attenArray;
    }

    //
    //
    //class student attendance
    function classStudentsAttendance($classid, $cdate, $default_status = "P") {
        $userData = $this->classStudents($classid);
        $attendancestatus = "0";
        $attendanceArray = $this->attendanceByDate($classid, $cdate);
        if ($attendanceArray) {
            $attendancestatus = "1";
        }
        $studentdata = [];
        foreach ($userData as $key => $value) {
            if (isset($attendanceArray[$value->userid])) {
                $atnobj = $attendanceArray[$value->userid];
                $value->attendance = $atnobj['status'];
            } else {
                $value->attendance = "P";
            }

            array_push($studentdata, $value);
        }
        return array("students" => $studentdata, "attendancestatus" => $attendancestatus);
    }

    //get attendance by student id
    function attendanceByStudent($student_id) {
        $this->db->where('student_id', $student_id);
//        $this->db->where('at_date', $date); //Here sould be year wise attandance
        $query = $this->db->get('student_attendance');
        $attendata = $query->result_array();
        return $attendata;
    }

    //
    //
    //
    //Get Message Data
    function messageConversation($userid) {
        $this->db->where('reply_id', "0");
        $this->db->where('user_id', $userid);
        $this->db->order_by('id desc');
        $query = $this->db->get('school_message');
        $MessageData = $query->result();
        $messageListData = [];
        foreach ($MessageData as $key => $value) {
            $this->db->where('reply_id', $value->id);
            $this->db->order_by('id desc');
            $query = $this->db->get('school_message');
            $replyData = $query->result();
            $value->replydata = $replyData;
        }
        return $MessageData;
    }

    function collectClassDataUsers() {
        try {
            
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    function getRegIdById($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('gcm_registration');
        return $regarray = $query->row();
    }

    function sendNotificationToClassData($post_id, $tablename) {
        $this->db->where('id', $post_id);
        $this->db->order_by('id desc');
        $query = $this->db->get($tablename);
        $classData = $query->row();
        $class_id = $classData->class_id;
        $students = $this->classStudents($class_id);
        $collectuserids = [];
        foreach ($students as $key => $value) {
            $regids = $this->getRegIdById($value->userid);
            if ($regids) {
                array_push($collectuserids, $regids->reg_id);
            }
            if ($value->parent_id) {
                $regids2 = $this->getRegIdById($value->parent_id);
                if ($regids2) {
                    array_push($collectuserids, $regids2->reg_id);
                }
            }
        }
        $titleArray = array("class_assignment" => "Assignment", "class_notice" => "Class Notice", "class_notes" => "Study Note");

        $title = isset($titleArray[$tablename]) ? "New " . $titleArray[$tablename] . " Received" : "Notification From School";
        $messageData = array('title' => $title, "message" => $classData->title);
        return array("regids" => $collectuserids, "message" => $messageData);
    }

    function unseenClassData() {
        $querystr = "select * from (
             SELECT *, 'class_notes' as tablename, 'Class Notes' as datatype, 'circular.svg' as icon  FROM `class_notes` where status='0'
UNION
             select *, 'class_assignment' as tablename, 'Assignments' as datatype, 'assignment.svg' as icon from class_assignment where status='0'
UNION
             select *, 'class_notice' as tablename, 'Class Notice' as datatyp, 'classnotice.svg' as icone from class_notice where status='0') as a order by datetime desc";
        $query = $this->db->query($querystr);
        $classDataUnseen = $query->result_array();
        return $classDataUnseen;
    }

    function unseenMessages() {
        $this->db->where('status', "0");
        $this->db->order_by('id desc');
        $query = $this->db->get('school_message');
        $replyData = $query->result();
        return $replyData;
    }

}

?>
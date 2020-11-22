<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function AppointmentDataByCountry($country) {
        $this->db->where('country', $country);
        $this->db->group_by('days');
        $this->db->order_by('id');
        $query = $this->db->get('appointment_entry');
        $countryAppointment = $query->result_array();

        $appointmentData = array();

        foreach ($countryAppointment as $akey => $avalue) {
            $aid = $avalue['aid'];
            $this->db->where('aid', $aid);

            $query = $this->db->get('appointment_entry');
            $timeData = $query->result_array();
            $avalue['dates'] = array();
            foreach ($timeData as $tkey => $tvalue) {
                $temparray = array();
                $temparray['date'] = $tvalue['date'];
                $temparray['timing1'] = $tvalue['from_time'];
                $temparray['timing2'] = $tvalue['to_time'];
                array_push($avalue['dates'], $temparray);
            }
            array_push($appointmentData, $avalue);
        }

        return $appointmentData;
    }

    public function AppointmentDataAll() {
        $date = date("Y-m-d");
        $this->db->where('date>=', $date);
        $this->db->group_by('days');
        $this->db->order_by('date');
        $query = $this->db->get('appointment_entry');
        $countryAppointment = $query->result_array();

        $appointmentData = array();

        foreach ($countryAppointment as $akey => $avalue) {
            $aid = $avalue['days'];

//            $this->db->set('aid', $avalue['id']);
//            $this->db->where_in('days', $aid);
//            $this->db->update('appointment_entry');


            $this->db->where('days', $aid);

            $query = $this->db->get('appointment_entry');
            $timeData = $query->result_array();
            $avalue['dates'] = array();
            foreach ($timeData as $tkey => $tvalue) {
                $temparray = array();
                $temparray['date'] = $tvalue['date'];
                $temparray['timing1'] = $tvalue['from_time'];
                $temparray['timing2'] = $tvalue['to_time'];
                array_push($avalue['dates'], $temparray);
            }
            array_push($appointmentData, $avalue);
        }

        return $appointmentData;
    }

    function AppointmentData($appId) {

        $appointmentSingle = array();
        $this->db->where('aid', $appId);
        $this->db->group_by('date');
        $query = $this->db->get('appointment_entry');
        $appData = $query->result_array();
        $appDataAppointment = $appData[0];
        $appointmentSingle["appointment"] = $appDataAppointment;
        $appointmentSingle['date_time_list'] = [];
        foreach ($appData as $key => $value) {
            $temp = array(
                'from_time' => $value['from_time'],
                'to_time' => $value['to_time'],
                'date' => $value['date'],
                'id' => $value['id']
            );
            array_push($appointmentSingle['date_time_list'], $temp);
        }
       return $appointmentSingle;
  
    }

}

<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Serverside_model extends CI_Model
{

  function __construct()
  {
    // code...
    parent::__construct();
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->helper('url');
    $this->load->helper('security');
  }

  public function pending_view_est_list(){



    $this->crs = $this->load->database('crs', TRUE);
    $this->embis = $this->load->database('embis', TRUE);
    $query = $this->crs->query('SELECT est.est_id , cer.req_id FROM crs.client_est_requests as cer
    LEFT JOIN crs.establishment as est ON cer.est_id = est.est_id
    LEFT JOIN embis.dms_province AS pl ON pl.id = est.est_province
    LEFT JOIN embis.dms_city as ct ON ct.id = est.est_city
    LEFT JOIN embis.dms_barangay as brgy ON brgy.id = est.est_barangay
    WHERE cer.client_id = "'.$this->session->userdata('client_id').'" AND cer.deleted = "0" AND cer.status != 1')->result_array();

       // $embis->select('dp.name, est.establishment');
       // $embis->from('dms_province as dp');
       // $embis->join($crsdb->database.'.establishment as est','dp.id = est.est_province');
       // $res = $embis->get();
       // $query = $embis->result_array();


    print_r($query);
  }
}

 ?>

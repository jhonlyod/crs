<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SWM extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    $this->load->database();
    $this->load->model('SWM_model');

    session_start();
    if ( ! $this->session->userdata('is_login'))
    {
          $this->session->sess_destroy();
          redirect('Login/logout_user');
    }

    // echo $this->session->userdata('logged_in');

  }

  function index(){
    $this->_show_view('swm/dashboard');
  }

  public function _show_view($content)
  {

    $query['lgu_patrolled_id'] = $this->SWM_model->checkifhaslguswm();

    if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 3) {
      $this->load->view('admin/nav',$query);
    }else {
      $this->load->view('common/nav',$query);
    }

    $this->load->view('common/header', @$this->my_data);
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);
    $this->load->view('common/footer');
  }

  function map($token = ''){
    $getalllguswm = $this->SWM_model->getalllguswm();
    $condition = "";
    $counter = 0;
    for ($i=0; $i < sizeof($getalllguswm); $i++) {
      if(!empty($getalllguswm[$i]['lgu_patrolled_id'])){
        $counter++;
        $con = ($counter == sizeof($getalllguswm)) ? '' : ' OR ';
        $condition .= "lgu_patrolled_id = '".$getalllguswm[$i]['lgu_patrolled_id']."'".$con;
      }
    }

    $embisdb = $this->load->database('embis',TRUE);
    $queryselect['data'] = $embisdb->select('sf.creator_name, sf.report_type, sf.date_created, sf.region, sfa.attachment_name, sf.trans_no, sf.latitude, sf.longitude, sf.cnt, sf.lgu_patrolled_id, sf.lgu_patrolled_name, sf.barangay_name, sf.street, sf.type_of_area_desc')
                  ->from('embis.sweet_form AS sf')
                  ->join('er_transactions AS et','et.token = sf.trans_no','left')
                  ->join('sweet_form_attachments AS sfa','sfa.trans_no = sf.trans_no AND sfa.report_number = sf.report_number','left')
                    ->where('et.status != "0" AND sf.region = "'.$this->session->userdata('region_name').'" AND '.$condition.'')
                  ->get()
                  ->result_array();
    $this->load->view('swm/map',$queryselect);
  }
}

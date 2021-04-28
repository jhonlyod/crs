<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Postdata extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    $this->load->database();
    $this->load->model('SWM_model');
    date_default_timezone_set("Asia/Manila");

    session_start();
    if ( ! $this->session->userdata('is_login'))
    {
          $this->session->sess_destroy();
          redirect('Login/logout_user');
    }

    // echo $this->session->userdata('logged_in');

  }

  function savedata(){

    $explodedata = explode('|',$_POST['token']);
    $trans_no = $this->encrypt->decode($explodedata[0]);
    $report_number = $explodedata[1];

    if(!empty($trans_no) AND !empty($report_number)){
      $wheredataqry = $this->db->where('sfl.trans_no = "'.$trans_no.'"');
      $quertdata = $this->SWM_model->selectdata('embis.sweet_form AS sfl','sfl.feedback','',$wheredataqry);

      $countnotify = $quertdata[0]['feedback']+1;

      $setdata = array('feedback' => $countnotify,);
      $wheredata = array('trans_no' => $trans_no,);
      $updatedata = $this->SWM_model->updatedata($setdata, 'embis.sweet_form', $wheredata);

      $wheredataqrysfl = $this->db->where('sfl.trans_no = "'.$trans_no.'" AND sfl.report_number = "'.$report_number.'"');
      $quertdatasfl = $this->SWM_model->selectdata('embis.sweet_form_log AS sfl',',sfl.feedback, sfl.report_type','',$wheredataqrysfl);

      $countnotifysfl = $quertdatasfl[0]['feedback']+1;

      $setdatalog = array('feedback' => $countnotifysfl, );
      $wheredatalog = array('trans_no' => $trans_no, 'report_number' => $report_number, );
      $updatedatalog = $this->SWM_model->updatedata($setdatalog, 'embis.sweet_form_log', $wheredatalog);

      //CHECK IF ALREADY EXIST
      $chkwheredata = $this->db->where('sff.trans_no = "'.$trans_no.'" AND sff.status = "Inactive"');
      $chkdata = $this->SWM_model->selectdata('embis.sweet_form_feedback AS sff','sff.attachments, sff.cnt','',$chkwheredata);

      if(!empty($chkdata[0]['cnt'])){
        $setdata = array('datefeedback' => date('Y-m-d h:i'), 'remarks' => $_POST['remarks'], 'status' => 'Active', );
        $wheredata = array('trans_no' => $trans_no, 'status' => 'Inactive', );
        $updatedata = $this->SWM_model->updatedata($setdata, 'embis.sweet_form_feedback', $wheredata);
      }else{
        $data = array('userid' => $this->session->userdata('client_id'), 'trans_no' => $trans_no, 'report_number' => $report_number, 'report_type' => $quertdatasfl[0]['report_type'], 'datefeedback' => date('Y-m-d h:i'), 'remarks' => $_POST['remarks'], 'status' => 'Active', );
        $insertdata = $this->SWM_model->insertdata('embis.sweet_form_feedback', $data);
      }

      if($updatedatalog){
        echo "<script>alert('Feedback successfully sent.')</script>";
        echo "<script>window.location.href='".base_url()."SWM'</script>";
      }
    }

  }

  function onsite_photo_lgu(){
    $explodedata = explode('|',$_POST['token']);
    $trans_no = $this->encrypt->decode($explodedata[0]);
    $report_number = $explodedata[1];

    if((count($_FILES['site_photo_lgu']['name'])) >= '1'){

      $wheredata = $this->db->where('sfl.trans_no = "'.$trans_no.'" AND sfl.report_number = "'.$report_number.'"');
      $querydata = $this->SWM_model->selectdata('embis.sweet_form_log AS sfl',',sfl.region,sfl.date_created,sfl.report_type','',$wheredata);

      $error = array();

      $config = array(
           'upload_path'   => '../iis-images/sweet_report/'.date('Y', strtotime($querydata[0]['date_created'])).'/'.$querydata[0]['region'].'/'.$trans_no.'/',
           'allowed_types' => 'jpeg|jpg|png|gif',
           'max_size'			 => '100000',
           'overwrite'     => TRUE,
       );

      $this->load->library('upload',$config);

      $counter = 0;

      for ($i=0; $i < count($_FILES['site_photo_lgu']['name']); $i++) {
        $_FILES['file']['name']      = $_FILES['site_photo_lgu']['name'][$i];
        $_FILES['file']['type']      = $_FILES['site_photo_lgu']['type'][$i];
        $_FILES['file']['tmp_name']  = $_FILES['site_photo_lgu']['tmp_name'][$i];
        $_FILES['file']['error']     = $_FILES['site_photo_lgu']['error'][$i];
        $_FILES['file']['size']      = $_FILES['site_photo_lgu']['size'][$i];

        $filename = rand().".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = $filename;

        $this->upload->initialize($config);

          if($this->upload->do_upload('file')){

              $wherechkdata = $this->db->where('sff.trans_no = "'.$trans_no.'" AND sff.status = "Inactive"');
              $chkdata = $this->SWM_model->selectdata('embis.sweet_form_feedback AS sff','sff.cnt, sff.attachments, sff.attachment_name','',$wherechkdata);

              if(!empty($chkdata[0]['cnt'])){
                $setdata = array('attachments' => $chkdata[0]['attachments'].'|'.$config['file_name'], 'attachment_name' => $chkdata[0]['attachment_name'].'|'.$_FILES['site_photo_lgu']['name'][$i], );
                $wheredata = array('trans_no' => $trans_no, 'status' => "Inactive", );
                $updatedata = $this->SWM_model->updatedata($setdata, 'embis.sweet_form_feedback', $wheredata);
              }else{
                $data = array('userid' => $this->session->userdata('client_id'), 'trans_no' => $trans_no, 'report_number' => $report_number, 'report_type' => $querydata[0]['report_type'], 'attachments' => $config['file_name'], 'attachment_name' => $_FILES['site_photo_lgu']['name'][$i], 'status' => "Inactive",);
                $insertdata = $this->SWM_model->insertdata('embis.sweet_form_feedback', $data);
              }

              $pathurl = base_url().'../iis-images/sweet_report/'.date('Y', strtotime($querydata[0]['date_created'])).'/'.$querydata[0]['region'].'/'.$trans_no.'/'.$config['file_name'];
              chmod($config['upload_path'].$config['file_name'],0777,TRUE);
              echo json_encode(array('status' => 'success',));

          }else{
            echo json_encode(array('status' => 'failed',));
          }
      }
    }
    clearstatcache();
  }
}

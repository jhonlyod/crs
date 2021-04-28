<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    $this->load->database();
    $this->load->model('SWM_model');
    $this->load->model('Serverside_model','svmodel');
    $this->load->model('My_model','mm');
    if ( ! $this->session->userdata('is_login'))
    {
      redirect('login');
    }
  }


  function dashboard(){
    $query['lgu_patrolled_id'] = $this->SWM_model->checkifhaslguswm();
    $this->load->view('common/header');
    $this->load->view('common/nav',$query);
    if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 3) {
      $this->load->view('admin/dashboard');
      // $this->load->view('maintenance');
    }else {
      // if ($this->session->userdata('username') == 'sampleclient1' || $this->session->userdata('username') == 'clientr3') {
      //   // $this->mm->getRows()
      //   $array_data = array(
      //     'select' => 'mobile_number',
      //     'where' => 'acc.client_id = '.$this->session->userdata('client_id').'', );
      //   $data['cnt_number'] = $this->mm->getRows('crs.acc',$array_data,'array');
      //   $this->load->view('dashboard_1',$data);
      // }else {
      //   $this->load->view('dashboard');
      // }
      $array_data = array(
        'select' => 'mobile_number',
        'where' => 'acc.client_id = '.$this->session->userdata('client_id').'', );
      $data['cnt_number'] = $this->mm->getRows('crs.acc',$array_data,'array');
      $this->load->view('dashboard_1',$data);
      // $this->load->view('maintenance');
    }
      $this->load->view('common/footer');

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

  function remove_request(){
    $req_id = $this->input->post('req_id',TRUE);
    $this->db->set('deleted','1');
    $this->db->where('req_id', $req_id);
    $this->db->where('client_id', $this->session->userdata('client_id'));
    $query = $this->db->update('client_est_requests');
    if ($query){
      return true;
    }else {
      $this->load->view('404');
    }

  }

  function resend_verification_email(){
    $client_id = $this->input->post('client_id',TRUE);
    $query = $this->db->select('*')->from('acc')->where('client_id',$client_id)->get()->result_array();
    $data = $query[0];
    if ($query) {
        $this->db->set('verified',1);
        $this->db->where('client_id',$data['client_id']);
        $this->db->update('acc');

        $query2 = $this->db->select('client_id')->from('resend_email')->where('client_id',$client_id)->get()->num_rows();
        $this->db->set('status',1);
        $this->db->set('email',$data['email']);
        $this->db->set('client_id',$data['client_id']);
        if ($query2 > 0) {
          $this->db->where('client_id',$data['client_id']);
          $this->db->update('resend_email');
        }else {
          $this->db->insert('resend_email');
        }

        $this->load->library('email');

        $this->load->config('email');
        $this->load->library('email');
        $this->email->set_crlf( "\r\n" );
        $from = $this->config->item('smtp_user');

        $to 	 = $data['email'];
        $subject = '***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE D1O NOT REPLY***';
        $message = 'EMB USER REGISTRATION !.<br><br>';
        $message.="RESEND EMAIL CONFIRMATION.<br><br>";
        $message.="Hi,<br><br>";
        $message.="Username: ".$data['username']." password: ".$this->encrypt->decode($data['raw_password'])." <br><br>";
        $message.="Your account is now activated. Please try to login using credentials above.<br><br>";
        $message.="if you received this email by mistake, simply delete it..<br><br>";
        $message.="For questions about this. Please email us at : crs.emb.2020@gmail.com";
        $to 	 = $data['email'];
        $subject = '***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***';
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->cc('crs.emb.2020@gmail.com');
        $this->email->subject($subject);
        $this->email->message($message);

      if ($this->email->send()) {
        $msg['msg']='sent';
      }else {
        $msg['msg'] = $this->email->print_debugger();
      }
      echo json_encode($msg);
    }
  }

  function resend_verification_hwms(){
    $embisdb = $this->load->database('embis',TRUE);
    $client_req_id = $this->input->post('client_req_id',TRUE);
    $query = $embisdb->select('*')->from('approved_client_req')->where('client_req_id',$client_req_id)->get()->result_array();
    $data = $query[0];
    if ($query) {

        $query2 = $this->db->select('client_id')->from('resend_hwms_credentials')->where('client_id',$data['client_id'])->get()->num_rows();

        $this->db->set('status',1);
        $this->db->set('req_id',$data['req_id']);
        $this->db->set('client_id',$data['client_id']);
        $this->db->set('apr_req_id',$data['client_req_id']);
        if ($query2 > 0) {
          $this->db->where('client_id',$data['client_id']);
          $queryhwms = $this->db->update('resend_hwms_credentials');
        }else {
          $queryhwms = $this->db->insert('resend_hwms_credentials');
        }
        if ($queryhwms) {
          // code...
          $comp_details = $embisdb->select('*')->from('dms_company')->where('company_id',$data['company_id'])->get()->result_array();
          $userdetails =  $this->db->select('*')->from('acc')->where('client_id',$data['client_id'])->get()->result_array();
          $this->load->library('email');
          $date_text = date("F-d-Y", strtotime($comp_details[0]['input_date']));
          $this->load->config('email');
          $this->load->library('email');
          $this->email->set_crlf( "\r\n" );
          $from = $this->config->item('smtp_user');
          $subject = 'Environmental Management Bureau Online Services';
          $email_body  = "***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***<br>";
          $email_body .= "COMPANY REGISTRATION STATUS!.  Your requested Establishment<br>";
          $email_body .= "".$comp_details[0]['company_name']."<br><br>";
          $email_body .= "has been approved by the system admin with<br><br>";
          $email_body .= "Company Reference ID: ".$comp_details[0]['emb_id']."<br>";
          $email_body .= "Applicant of Company Reference ID: ".$userdetails[0]['first_name'].' '.$userdetails[0]['last_name']."<br>";
          $email_body .= "Date Approved: ".$date_text."<br><br>";
          $email_body .= "Your company is now active on EMB online systems.<br>";
          $email_body .= "You can now process transactions under your company.<br>";
          $email_body .= "Thank you for registering!";

          $to 	 = $userdetails[0]['email'];
          $this->email->set_newline("\r\n");
          $this->email->from($from);
          $this->email->to($to);
          $this->email->subject($subject);
          $this->email->message($email_body);

          if ($this->email->send()) {
            $msg['msg']='sent';
            $msg['email']= $userdetails[0]['email'];
          }else {
            $msg['msg'] = $this->email->print_debugger();
            print_r($this->email->print_debugger());
            exit;
          }
          echo json_encode($msg);
        }
    }
  }

  function view_dissapproved_data(){
    $request_id = $this->input->post('req_id');
    $cleint_req_data = $this->db->select('crd.disapproved_by,crd.reason,crd.req_id')
    ->from('client_request_disapprove as crd')->where('req_id',$request_id)->order_by('client_disapproved_id','DESC')->get()->result_array();

    if (empty($cleint_req_data[0]['reason'])) {
      echo "Isang Makalikasang Pagbati!
       Upon the evaluation of your request, we regret to inform you that your application is disproved.  The refusal might be one of the following reason(s):
       1. The name indicated in the authorization letter does not match with the submitted Company ID and/or Government-issued ID.
       Kindly  resubmit your request with the appropriate attached document.
       Thank you!
       ";
    }else {
      echo $cleint_req_data[0]['reason'];
    }
  }


}

 ?>

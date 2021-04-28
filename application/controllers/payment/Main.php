<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
// error_reporting(0);

class Main extends CI_Controller
{
   private $thisdata;
   function __construct()
   {
      parent::__construct();
      // USER SESSION CHECK
      // if ( empty($this->session->userdata('token')) ) {
      //    echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      // }

      // $this->load->model('Embismodel');
      $this->load->helper(array('form', 'url'));


      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');
      $this->load->database();
      $this->load->model('SWM_model');
      // $this->load->model('Serverside_model','svmodel');

      date_default_timezone_set("Asia/Manila");

      $thisdata['user'] = array(
         'id'     => $this->session->userdata('client_id'),
         'token'  => $this->session->userdata('user_code'),
         'region' => $this->session->userdata('region_name'),
         'email'  => $this->session->userdata('email'),
         'region' => $this->session->userdata('region_name'),
      );
   }

   function index()
   {
      // $data = $thisdata;

      $this->load->view('common/header');
      $this->load->view('common/nav');

      $this->load->view('payment/dashboard', $data);

      $this->load->view('common/footer');


      // Array ( [] => R7 [region] => 8 [username] => sampleclient [] => jhonlyod23227@gmail.com [] => 5149 [user_code] => 7c0da7429ef4bbb90c6854f7ea87ce20 [role_id] => 2 [is_login] => 1 [host] => 192.168.91.198:3306 [user] => overseer [pass] => agentx3mbvii158459 )



   }

   function op_submit()
   {
      $this->input->post();
      // $this->mainModel->selectdata();

      // $this
   }

}
?>

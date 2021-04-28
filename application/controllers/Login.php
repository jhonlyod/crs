<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      $this->load->helper(array('form', 'url'));
      $this->load->database();
      $this->load->library('session');
      $this->load->model('My_model','mm');
      $this->load->model('Establishment_model','em');
      // session_start();
      // if ( ! $this->session->userdata('is_login'))
      // {
      //     redirect('login');
      //   }
      // }else {
      //   redirect('dashboard');
      // }
    }

    public function index(){
      $this->_show_view('login');
      // $this->load->view('maintenance');
    }
    // public function index_2(){
    //   $this->_show_view('login');
    //   // $this->load->view('maintenance');
    // }
    public function admin(){$this->_show_view('login');}
    public function rest_pass(){
      $this->_show_view('reset_pass');
    }
    public function send_reset_pass(){
      $email = $this->input->post('email',TRUE);
      $where = array(
        'email' => $email,
        // 'verified' => 1,
        'deleted' => 0,
      );
      $query = $this->db->select('email,user_code')->from('acc')->where($where)->get();
      // echo $query->num_rows();exit;
      if ($query->num_rows() == 0) {
        $this->my_data['error'] = 'UNREGISTERED ! , PLEASE PROVIDE REGISTERED EMAIL';
          $this->_show_view('reset_pass');
      }else {
        $this->resend_user_verification($query->result_array());
      }
    }

    function resend_user_verification($data)
    {
      $message = 'EMB USER RESEND VERIFICATION LINK !.<br><br>';
      $message.="EMAIL CONFIRMATION.<br><br>";
      $message.="Hi,<br><br>";
      $message.="You are almost ready to start using EMB Online Services.<br><br>";
      $message.="Simply click the link below to verify your email address..<br><br>";
      $message.="<a href='".base_url()."Login/verify_user_registration/?user_code=".$data[0]['user_code']."'>Verify Email Address</a><br><br>";
      $message.="To view profile, click username and click 'profile' on navigation area upper right side of the page.<br>";
      $message.="if you received this email by mistake, simply delete it..<br><br>";
      // $message.="For questions about this. Please email us at : crs.emb.2020@gmail.com";

      $this->load->config('email');
      $this->load->library('email');
      $this->email->set_crlf( "\r\n" );
      $from = $this->config->item('smtp_user');
      $to 	 = $data[0]['email'];
      $subject = '***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***';
      $msg_new = $message;
      $this->email->set_newline("\r\n");
      $this->email->from($from);
      $this->email->to($to);
      $this->email->subject($subject);
      $this->email->message($msg_new);
      if ($this->email->send()) {

        echo ("<script LANGUAGE='JavaScript'>
  window.alert('SUCCESS ! , Please check your email. Thank you !');
  window.location.href='".base_url()."';
  </script>");
      }else {
        print_r( $this->email->print_debugger());
      }
    }

    public function verify_user_registration(){
        $user_code = $this->input->get('user_code',TRUE);
        $this->db->set('acc.verified',1);
        $this->db->where('acc.user_code',$user_code);
        $this->db->where('acc.deleted',0);
        $query = $this->db->update('acc');

        $where1 = array('acc.user_code' => $user_code, );
        $query2 = $this->db->select('*')->from('acc')->where($where1)->get()->result_array();

        if ($query2){
          // echo "<pre>";print_r($query2);exit;
          $ses_user_data = array(
            'region'    => $query2[0]['region'] ,
            'username'  => $query2[0]['username'],
            'email'     => $query2[0]['email'],
            'client_id' => $query2[0]['client_id'],
            'user_code' => $query2[0]['user_code'],
            'role_id'   => $query2[0]['role_id'],
            'is_login' => TRUE,
            'host' 				  => '192.168.91.198:3306',
            'user' 				  => 'clientaccess',
            'pass' 				  => 'agentx3mbvii158459',
           );
           $this->session->set_userdata($ses_user_data);


          $where2 = array('est.client_id' => $_SESSION['client_id'], );
          $cnt_est = $this->db->select('*')->from('establishment as est')->where($where2)->get()->num_rows();
          if ($cnt_est > 0) {
              redirect('Dashboard/dashboard');
          }else {
              redirect('Establishment');
          }
        }else {
          echo ("<script LANGUAGE='JavaScript'>
    window.alert('THERE WAS AN ERROR DURING THE THE VERIFICATION PROCESS:  PLEASE TRY TO LOGIN USERING YOUR CREDENTIALS ON THE LOGIN PAGE.
    TO GET NEW VERIFICATION, Click 'FORGOT PASSWORD ON THE LOGIN PAGE'. THEN INPUT YOUR REGISTERED EMAIL.  THANK YOU !');
    window.location.href='https://iis.emb.gov.ph/crs/';
    </script>");
        }
    }
    public function validate_login(){
      $username = $this->input->post('username',TRUE);
      $password = $this->input->post('password',TRUE);
      $embisdb = $this->load->database('embis',TRUE);
      $password = preg_replace('/\s+/', '', $password);
      if (isset($username) && isset($password) && !empty($username) && !empty($password)) {
         $credentials = array(
          'username' => $username,
          'verified' => 1,
          'deleted' => 0,
         );
         $this->db->select('*');
         $this->db->where($credentials);
         $this->db->from('acc');
         $query  = $this->db->get();
         $result = $query->result_array();
         if ($result){
           $where2 = array('rg.rgnid' => $result[0]['region'], );
           $rgnum = $embisdb->select('rg.rgnnum')->from('acc_region as rg')->where($where2)->get()->result_array();

              if (password_verify($password, @$result[0]['password'])) {
             $ses_user_data = array(
               'region_name'    => $rgnum[0]['rgnnum'] ,
               'region'         => $result[0]['region'] ,
               'username'       => $result[0]['username'],
               'email'          => $result[0]['email'],
               'client_id'      => $result[0]['client_id'],
               'user_code'      => $result[0]['user_code'],
               'role_id'        => $result[0]['role_id'],
               'is_login'       => TRUE,
               'host' 				  => '192.168.91.198:3306',
               'user' 				  => 'clientaccess',
               'pass' 				  => 'agentx3mbvii158459',
              );
              $this->session->set_userdata($ses_user_data);
              $where1 = array('apr.client_id' => $result[0]['client_id'], );
              $cnt_est = $embisdb->select('*')->from('approved_client_req as apr')->where($where1)->get()->num_rows();

              redirect('dashboard');

           }else {
              $this->session->set_flashdata('login_msg','Invalid username or password !');
              redirect('Login');
           }
         }else {
           $this->session->set_flashdata('login_msg','Invalid username or password !');
           redirect('Login');
         }
      }
    }

    function logout_user(){
  		$this->session->sess_destroy();
  		redirect('Login');
  	}
    public function _show_view($content)
    {
      $this->load->view('common/header', @$this->my_data);
      if ( ! empty($content))
        $this->load->view($content, @$this->my_data);

      $this->load->view('common/footer');
    }

  }

 ?>

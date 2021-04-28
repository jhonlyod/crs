<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller
{

  function __construct()
  {
      // session_start();
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
     $this->load->model('users', 'users');
     $this->load->model('My_model','mm');
  }

  function index(){
    $embis_db = $this->load->database('embis',TRUE);
    $this->my_data['regions'] = $embis_db->select('*')->from('acc_region')->where('rgnid !=', 18)->get()->result_array();
    $this->_show_view('register');
  }
  function update_mobile_number(){
    $where = array('client_id' => $this->session->userdata('client_id'), );
    $set = array('mobile_number' => $this->input->post('mobile_number',TRUE), );
    $query = $this->mm->update('crs.acc',$set,$where);
    if ($query) {
      redirect($_SERVER['HTTP_REFERER']);
    }else {
      echo '<script type="text/javascript">alert("Something went wrong ! Please contact Administrator");history.go(-1);</script>';
    }
  }

  // for saving user data
  function save_user_data($data='')
	{
    $data = $this->input->post();
		$result = $this->users->save_user_data($data);
    $data['user_code'] = $result;
    if (!empty($data['user_id']) && $data['user_id'] != '') {

      $userid = $this->encrypt->decode($data['user_id']);
      if (!empty($_FILES['government_id']['name'])) {
        // echo "string";exit;
        $pathgov = $_FILES['government_id']['name'];
        // $newNamegov = "gov_id".".".pathinfo($pathgov, PATHINFO_EXTENSION);
        $newNamegov = "gov_id.png";
        $filename = 'uploads/user_attch_id/gov_id/'.$userid.'/'.$newNamegov;
        $countgov = $this->db->select('*')->from('acc_attch_id')->where('user_id',$userid)->where('name',$newNamegov)->get()->num_rows();
        if ($countgov > 0) {
          $this->db->set('name',$newNamegov);
          $this->db->where('user_id',$this->session->userdata('user_id'));
          $this->db->update('acc_attch_id');
        }else {
          $fileinsertdata = array(
            'user_id' => $userid,
            'name' => $newNamegov,
            'deleted' => 0,
            'type' => 1, #1 if gov id
          );
          $this->db->insert('acc_attch_id',$fileinsertdata);
        }

        if (file_exists($filename))
            unlink($filename);
          // echo "string";exit;
          if (!empty($_FILES['government_id']['name'])){

            if (!is_dir('uploads/user_attch_id/gov_id/'.$userid))
            mkdir('uploads/user_attch_id/gov_id/'.$userid, 0777, TRUE);
            $config['upload_path']   = 'uploads/user_attch_id/gov_id/'.$userid;
            $config['allowed_types'] = '*';
            $config['max_size']      = '50000'; // max_size in kb
            $config['file_name']     =  $newNamegov;
            // $config['overwrite']     =  FALSE;
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(! $this->upload->do_upload('government_id')){
              $error = array('error' => $this->upload->display_errors());
            }else{
              $this->upload->data();
            }
          }
      }

      // for company
      if (!empty($_FILES['company_id']['name'])) {
        // echo "string";exit;
        $pathgov = $_FILES['company_id']['name'];
        // echo $pathgov;exit;
        // $newNamecomp = "comp_id".".".pathinfo($pathgov, PATHINFO_EXTENSION);
        $newNamecomp = "comp_id.png";
        $filename = 'uploads/user_attch_id/company_id/'.$userid.'/'.$newNamecomp;

        $countgov = $this->db->select('*')->from('acc_attch_id')->where('user_id',$userid)->where('name',$newNamecomp)->get()->num_rows();
        // echo $countgov;exit;
        if ($countgov > 0) {
          $this->db->set('name',$newNamecomp);
          $this->db->where('user_id',$this->session->userdata('user_id'));
          $this->db->update('acc_attch_id');
        }else {
          $fileinsertdata = array(
            'user_id' => $userid,
            'name' => $newNamecomp,
            'deleted' => 0,
            'type' => 1, #1 if gov id
          );
          $this->db->insert('acc_attch_id',$fileinsertdata);
        }

        if (file_exists($filename))
            unlink($filename);
          // echo "string";exit;
          if (!empty($_FILES['company_id']['name'])){

            if (!is_dir('uploads/user_attch_id/company_id/'.$userid))
            mkdir('uploads/user_attch_id/company_id/'.$userid, 0777, TRUE);
            $config['upload_path']   = 'uploads/user_attch_id/company_id/'.$userid;
            $config['allowed_types'] = '*';
            $config['max_size']      = '50000'; // max_size in kb
            $config['file_name']     =  $newNamecomp;
            // $config['overwrite']     =  FALSE;
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(! $this->upload->do_upload('company_id')){
              $error = array('error' => $this->upload->display_errors());
            }else{
              $this->upload->data();
            }
          }
      }

      $this->session->set_flashdata('update_est_msg', $data['email']);
      redirect('User/user_profile');
    }else {
      if ($result)
      {
        // echo "<pre>";print_r($data['email']);exit;
        $this->session->set_flashdata('save_est_msg', $data['email']);

        $maxid = 0;
        $row = $this->db->query('SELECT MAX(client_id) AS `maxid` FROM `acc`')->row();
        $usermaxid = $row->maxid;
        // for user government ids
        // echo "<pre>";print_r($_FILES);exit;
        if (!empty($_FILES['government_id']['name'])) {
          // echo "string";exit;
          $pathgov = $_FILES['government_id']['name'];
          // $newNamegov = "gov_id".".".pathinfo($pathgov, PATHINFO_EXTENSION);
            $newNamegov = "gov_id.png";
          $fileinsertdata = array(
            'user_id' => $usermaxid,
            'name' => $newNamegov,
            'deleted' => 0,
            'type' => 1, #1 if gov id
          );
          $querygov = $this->db->insert('acc_attch_id',$fileinsertdata);

          if ($querygov){
            if (!empty($_FILES['government_id']['name'])){

              if (!is_dir('uploads/user_attch_id/gov_id/'.$usermaxid))
              mkdir('uploads/user_attch_id/gov_id/'.$usermaxid, 0777, TRUE);
              $config['upload_path']   = 'uploads/user_attch_id/gov_id/'.$usermaxid;
              $config['allowed_types'] = '*';
              $config['max_size']      = '50000'; // max_size in kb
              $config['file_name']     =  $newNamegov;
              // $config['overwrite']     =  FALSE;
              $this->load->library('upload',$config);
              $this->upload->initialize($config);
              if(! $this->upload->do_upload('government_id')){
                $error = array('error' => $this->upload->display_errors());
              }else{
                $this->upload->data();
              }
            }
          }
        }
        // for user company id's
        // echo "<pre>";print_r($_FILES);exit;
        if (!empty($_FILES['company_id']['name'])) {
          // echo "string";exit;
          $pathnamecomp = $_FILES['company_id']['name'];
          // $newNamecomp = "comp_id".".".pathinfo($pathnamecomp, PATHINFO_EXTENSION);
            $newNamecomp = "comp_id.png";
          $fileinsertdata = array(
            'user_id' => $usermaxid,
            'name' => $newNamecomp,
            'deleted' => 0,
            'type' => 2, #2 if comp id
            );
            $querygov = $this->db->insert('acc_attch_id',$fileinsertdata);

            if ($querygov){
              if (!empty($_FILES['company_id']['name'])){

                if (!is_dir('uploads/user_attch_id/company_id/'.$usermaxid))
                mkdir('uploads/user_attch_id/company_id/'.$usermaxid, 0777, TRUE);

                $config['upload_path']   = 'uploads/user_attch_id/company_id/'.$usermaxid;
                $config['allowed_types'] = '*';
                $config['max_size']      = '50000'; // max_size in kb
                $config['file_name']     =  $newNamecomp;
                // $config['overwrite']     =  FALSE;
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if(! $this->upload->do_upload('company_id')){
                  $error = array('error' => $this->upload->display_errors());
                }else{
                  $this->upload->data();
                }
              }
            }
          }
          redirect('User');
        }
    }


	}

   // for validation save establishment
  function check_fields(){
    $username = $this->input->post('username',TRUE);
    $email = $this->input->post('email',TRUE);
    if (!empty($username)) {
      $this->db->where('username', $username);
      $cnt_user = $this->db->get('acc');
      if ($cnt_user->num_rows() > 0) {
        echo "false";
      }else {
        echo "true";
      }
    }

    if (!empty($email)) {
      $this->db->where('email', $email);
      $cnt_user_email = $this->db->get('acc');
      if ($cnt_user_email->num_rows() > 0) {
        echo "false";
      }else {
        echo "true";
      }
    }
  }

  function send_user_notification($data,$message = '')
  {
    $this->load->config('email');
    $this->load->library('email');
    $this->email->set_crlf( "\r\n" );
    $from = $this->config->item('smtp_user');
    $to 	 = $data['email'];
    $subject = '***THIS IS AUTOMATICALLY GENERATED EMAIL, PLEASE DO NOT REPLY***';
    $msg_new = $message;
    $this->email->set_newline("\r\n");
    $this->email->from($from);
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($msg_new);
    if ($this->email->send()) {
      echo "sent";
    }else {
      print_r( $this->email->print_debugger());
    }
  }

  function user_profile($userid = ''){
    if ( $userid != '' || !empty($userid)) {
      $userid = $userid;
    }else {
      $userid = $this->session->userdata('client_id');
    }
    $this->session->set_userdata('view_user_id',$userid);
    // echo $userid;exit;
    $embis_db  = $this->load->database('embis',TRUE);
    $this->my_data['regions'] = $embis_db->select('*')->from('acc_region')->get()->result_array();
      $where1 = array(
      'client_id' => $userid,
      );
      $where2 = array(
       'user_id' => $userid,
       'type'    => 1,
      );
      $where3 = array(
        'user_id' => $userid,
        'type'    => 2,
       );
       // echo $userid;exit;
       $query  = $this->my_data['acc_data'] =$this->db->select('*')->from('acc')->where($where1)->get()->result_array();
      $this->my_data['acc_gov_attch'] =$this->db->select('name')->from('acc_attch_id')->where($where2)->get()->result_array();
      $this->my_data['acc_comp_attch'] =$this->db->select('name')->from('acc_attch_id')->where($where3)->get()->result_array();
    if ($query) {
      if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 3) {
        $this->load->view('admin/nav');
      }else {
          $this->load->view('common/nav');
      }
      $this->_show_view('update-profile');
    }else {
      $this->_show_view('404');
    }
  }
  function _show_view($content)
  {
    $this->load->view('common/header', @$this->my_data);
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);

    $this->load->view('common/footer');
  }

  function  reference_co_user_list(){
    $this->_show_view('co_user_view');
  }
}

 ?>

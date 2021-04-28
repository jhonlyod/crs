<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Establishment extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('Establishment_model','est');
    $this->load->database();
    $this->load->library('session');
      // session_start();
    // if (! $this->session->userdata('is_login'))
    // {
    //       redirect('Login/logout_user');
    // }
    if(empty($_SESSION['client_id']))
    {
      echo "<script>alert('Your session has expired. Please relogin.')</script>";
      redirect('Login/logout_user');
    }
  }

  public function index(){
    // if ($this->session->userdata('username') == 'sampleclient1') {
      # code...

    $embis_db = $this->load->database('embis',TRUE);
    // $crs_db = $this->load->database('crs',TRUE);
    $client_approved_comapanies = $embis_db->select('acr.company_id')->from('approved_client_req as acr')->where('client_id',$this->session->userdata('client_id'))->where('deleted',0)->get()->result_array();
        //echo "<pre>";print_r($client_pending_request_comapanies);exit;
    $client_pending_request_comapanies = $this->db->distinct()->select('cer.est_id,est.establishment')->from('client_est_requests as cer')->join('establishment as est','est.est_id=cer.est_id')->where('cer.client_id',$this->session->userdata('client_id'))->where('cer.requested',1)->where('cer.deleted !=',1)->get()->result_array();
    // echo $crs_db->last_query();

    // echo $crs_db->last_query();

    $cprc = array();
    foreach($client_pending_request_comapanies as $cprcval){
        $cprc[] = $cprcval['est_id'];
    }
    $cerlist = array();
    foreach($client_approved_comapanies as $cacval){
        $cerlist[] = $cacval['company_id'];
    }
    // merging approved comapanies and requested companies
    $req_and_apr =   array_unique(array_merge($cprc,$cerlist));
    if (count($req_and_apr) == 0) {
      $req_and_apr = '';
    }

    // echo "string";
    // print_r($cerlist);exit;
    // echo $cerlistapr;
// echo $_SESSION['client_id'];exit;
    // print_r($this->session->userdata());exit;
    $ext_region = $this->input->post('ext_region',TRUE);
    $ses_add_est = array('est_region' => $ext_region, );
    $this->session->set_userdata($ses_add_est);
    if (!empty($_POST['all_est']))
      unset($_SESSION['est_region']);

    $where1 = array('acg.rgnid' => $ext_region, );
    $rgnnum = $embis_db->select('acg.rgnnum')->from('acc_region as acg')->where($where1)->get()->result_array();

    $where2 = array(
      'dc.region_name' => @$rgnnum[0]['rgnnum'],
      'dc.deleted'     => 0,
    );
    // for development 1
    if (isset($_POST['btn_est_add']) && !empty($_POST['btn_est_add'])) {
      $this->my_data['establishment'] = $embis_db->select('dc.company_name,dc.company_id,dc.region_name')->from('dms_company as dc')->where($where2)->order_by('dc.company_name','ASC')->where('deleted',0)->where_not_in('company_id',$req_and_apr)->get()->result_array();

    }else {
      $this->my_data['establishment'] = $embis_db->select('dc.company_name,dc.company_id')->from('dms_company as dc')->where('deleted',0)->order_by('dc.company_name','ASC')->where($where2)->where_not_in('company_id',$req_and_apr)->get()->result_array();
    }
    $this->my_data['project_type_data'] = $embis_db->select('dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header')->from('dms_project_type AS dpt')->get()->result_array();

    // for development 2
    $this->my_data['all_establishment'] = $embis_db->select('dc.company_name,dc.company_id')->from('dms_company as dc')->get()->result_array();

    $this->my_data['regions'] = $embis_db->select('*')->from('acc_region as acreg')->where('rgnid !=','18')->get()->result_array();

    $est_id = $this->uri->segment(3);
    // $est_id = 0;
    if ($est_id != '') {
      $wher1 = array(
        'est_id' => $est_id,
        'client_id' => $this->session->userdata('client_id'),
      );
      $this->my_data['est_data_by_id'] = $this->db->select('est.*')->from('establishment as est')->where($wher1)->get()->result_array();
    }
    $this->my_data['main_company'] = $embis_db->select('company_id,company_name,region_name')->from('dms_company')->where('deleted',0)->where('company_id',$this->my_data['est_data_by_id'][0]['main_company_id'])->get()->result_array();


    if ($this->session->userdata('role_id') == '1' || $this->session->userdata('role_id') == '3') {
        redirect('https://iis.emb.gov.ph/crs/Dashboard/dashboard');
    }else {

        $this->_show_view('add_establishment');

    }
  // }else{
  //   $this->load->view('maintenance');
  // }
  }

  // for adding main company
  function add_main_company(){
    $embisdb = $this->load->database('embis',TRUE);
    $query = $embisdb->select('company_id,company_name,emb_id')->from('dms_company')->where('company_id',$this->input->post('main_company_id',TRUE))->get()->result_array();
    // echo $this->db->last_query();exit;
    if ($query) {
        echo json_encode($query);exit;
    }else {
       echo "<script>alert('something's wrong , Please contact administrator - r7support@emb.gov.ph')</script>";
    }
  }

  function view_est_data(){
    $embis_db = $this->load->database('embis',TRUE);
    $est_id = $this->uri->segment(3);
    $wher1 = array(
      'est_id' => $est_id,
        'client_id' => $this->session->userdata('client_id'),
    );
      $this->my_data['est_data_by_id'] = $this->db->select('est.*')->from('establishment as est')->where($wher1)->get()->result_array();
      $this->my_data['main_company'] = $embis_db->select('company_id,company_name,region_name')->from('dms_company')->where('deleted',0)->where('company_id',$this->my_data['est_data_by_id'][0]['main_company_id'])->get()->result_array();
      // echo $embis_db->last_query();
      // echo "<pre>";print_r($this->my_data['main_company'] );exit;

     $est_id = $this->uri->segment(3);
     // echo $est_id;
     if ($est_id != '') {
       ($this->session->userdata('role_id') == '1') ?
       $wher1 = array('est_id' => $est_id):
       $wher1 = array('est_id' => $est_id,'client_id' => $this->session->userdata('client_id'));

       $this->my_data['est_data_by_id'] = $this->db->select('est.*')->from('establishment as est')->where($wher1)->get()->result_array();
       // echo "<pre>";print_r($this->my_data['est_data_by_id']);exit;
       $this->my_data['project_type_data'] = $embis_db->select('dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header')->from('dms_project_type AS dpt')->get()->result_array();
       $this->my_data['all_establishment'] = $embis_db->select('dc.company_name,dc.company_id')->from('dms_company as dc')->where('deleted',0)->get()->result_array();
       $this->my_data['regions'] = $embis_db->select('*')->from('acc_region')->get()->result_array();

        // $this->_show_view('add_establishment',$this->my_data);
       if (count($this->my_data['est_data_by_id']) > 0) {
         unset($_SESSION['client_request_est_msg']);
         $this->_show_view('add_establishment');
       }else {
         $this->_show_view('404');
       }
     }
  }

  function view_apr_est_data($company_id = ''){

     // echo $company_id;exit;
     if ($company_id != '') {
       $wher1 = array('company_id' => $company_id);
       $embis_db = $this->load->database('embis',TRUE);
       $this->my_data['est_data_by_id'] = $embis_db->select('dcomp.*')->from('dms_company as dcomp')->where($wher1)->get()->result_array();
       // echo "<pre>";print_r($this->my_data['est_data_by_id']);exit;
       $this->my_data['project_type_data'] = $embis_db->select('dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header')->from('dms_project_type AS dpt')->get()->result_array();
       $this->my_data['all_establishment'] = $embis_db->select('dc.company_name,dc.company_id')->from('dms_company as dc')->where('deleted',0)->get()->result_array();
       $this->my_data['regions'] = $embis_db->select('*')->from('acc_region')->get()->result_array();

        $this->_show_view('view_apr_establishment');

     }
  }

  public function company_list_by_region(){
//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    $embis_db = $this->load->database('embis',TRUE);
    $region_id = $this->input->post('ext_region',TRUE);
    $where_rgn= array('rgnid' => $region_id, );
    $query = $embis_db->select('*')->from('acc_region')->where($where_rgn)->get()->result_array();
    $querycomp  = $embis_db->select('*')->from('dms_company')->where('region_name',$query[0]['rgnnum'])->get()->result_array();
      echo "<select class='form-control' name='est_req_comp_id' id='company_list_by_region'>";
      echo "<option value='' selected disabled>EMB REGISTERED ESTABLISHMENT LIST</option>";
      echo "<option value='0'>NOT IN THE LIST</option>";
      foreach ($querycomp as $key => $valcomp) {
        echo "<option value='".$valcomp['company_id']."'>".$valcomp['company_name']."</option>";
      }
      echo "</select>";
  }

  public function select_region(){
    $embis_db = $this->load->database('embis',TRUE);
    $region_id = $this->input->post('ext_region',TRUE);
    $where_rgn= array('region_id' => $region_id, );
    $query = $embis_db->select('*')->from('dms_province')->where($where_rgn)->get()->result_array();
      echo "<option value='' selected disabled>SELECT PROVINCE</option>";
    foreach ($query as $key => $valprov) {
      echo "<option value='".$valprov['id']."'>".$valprov['name']."</option>";
    }
  }

  public function select_province(){
    $embis_db = $this->load->database('embis',TRUE);
    $province_id = $this->input->post('est_province_id',TRUE);
    $where_city= array('province_id' => $province_id, );
    $query = $embis_db->select('*')->from('dms_city')->where($where_city)->get()->result_array();
      echo "<option value='' selected disabled>SELECT CITY</option>";
    foreach ($query as $key => $valcity) {
      echo "<option value='".$valcity['id']."'>".$valcity['name']."</option>";
    }
  }
  public function select_city(){
    $embis_db = $this->load->database('embis',TRUE);
    $city_id = $this->input->post('est_city_id',TRUE);
    $where_city= array('city_id' => $city_id, );
    $query = $embis_db->select('*')->from('dms_barangay')->where($where_city)->get()->result_array();
      echo "<option value='' selected disabled>SELECT BARANGGAY</option>";
    foreach ($query as $key => $valbrgy) {
      echo "<option value='".$valbrgy['id']."'>".$valbrgy['name']."</option>";
    }
  }

  // for client request existing company_id
  function client_request_est(){
    $embis = $this->load->database('embis',TRUE);
    $company_id 	= $this->input->post('est_req_comp_id',TRUE);

    $where1 = "`dc`.`deleted` = '0' AND `dc`.`company_id` = '".$company_id."'";
    $company_details = $embis->select('dc.*')->from('dms_company AS dc')->where($where1)->get()->result_array();
    $region 				= $company_details[0]['region_name'];
    $where2= "`acc`.`rgnnum` = '".$region."'";
    $acc_region = $embis->select('acc.rgnid,acc.rgnnam')->from('acc_region AS acc')->where($where2)->get()->result_array();
    $region_id 				= $acc_region[0]['rgnid'];
    // echo $region_id;exit;

    $client_id 			= $this->session->userdata('client_id');
    $date_submitted = date('Y-m-d H:i:s');

    if ( ! empty($company_details))
    {
      // echo "string";exit;
      $this->db->set('establishment', $company_details[0]['company_name']);
      $this->db->set('project_type',  $company_details[0]['project_type']);
      $this->db->set('est_street', $company_details[0]['street']);
      $this->db->set('est_region', $region_id);
      $this->db->set('est_province', $company_details[0]['province_id']);
      $this->db->set('est_city',$company_details[0]['city_id']);
      $this->db->set('est_barangay', $company_details[0]['barangay_id']);
      $this->db->set('psi_code_no', $company_details[0]['psi_code_no']);
      $this->db->set('psi_descriptor', $company_details[0]['psi_descriptor']);

      $this->db->set('ceo_first_name', $company_details[0]['ceo_fname']);
      $this->db->set('ceo_last_name', $company_details[0]['ceo_sname']);
      $this->db->set('ceo_mi', $company_details[0]['ceo_mname']);
      $this->db->set('ceo_sufx', $company_details[0]['ceo_suffix']);
      $this->db->set('ceo_phone_no', $company_details[0]['ceo_contact_num']);
      $this->db->set('ceo_fax_no', $company_details[0]['ceo_fax_no']);
      $this->db->set('ceo_email', $company_details[0]['ceo_email']);
      $this->db->set('plant_manager', $company_details[0]['plant_manager_name']);
      $this->db->set('plant_manager_coa_no', $company_details[0]['plant_manager_coe']);
      $this->db->set('plant_manager_phone_no', $company_details[0]['plant_manager_tel_num']);
      $this->db->set('plant_manager_fax_no', $company_details[0]['plant_manager_fax_num']);
      $this->db->set('plant_manager_email', $company_details[0]['plant_manager_email']);
      $this->db->set('plant_manager_mobile_no',  $company_details[0]['plant_manager_mobile_num']);
      $this->db->set('pollution_officer', $company_details[0]['pco']);
      $this->db->set('pollution_officer_coa_no', $company_details[0]['pco_coa_num']);
      $this->db->set('pollution_officer_phone_no', $company_details[0]['pco_phone_num']);
      $this->db->set('pollution_officer_fax_no', $company_details[0]['pco_fax_num']);
      $this->db->set('pollution_officer_email', $company_details[0]['pco_email']);
      $this->db->set('pollution_officer_mobile_no',  $company_details[0]['pco_mobile_num']);

      // $this->db->set('status', '5');#5 if request
      // $this->db->set('deleted', '0');
      $this->db->set('est_id',  $company_details[0]['company_id']);

      $this->db->set('client_id', $this->session->userdata('client_id'));
      $this->db->set('date_created', date('Y-m-d H:i:s'));
        // $this->db->set('created_by', $this->session->userdata('username'));
      $query = $this->db->insert('establishment');

      $this->db->set('system_inquery', $this->input->post('system_inquery_type',TRUE));
      $this->db->set('date_submitted', date('Y-m-d H:i:s'));
      $this->db->set('client_id', $this->session->userdata('client_id'));
      $this->db->set('est_id', $company_details[0]['company_id']);
      $this->db->set('status', 5);
      $this->db->set('requested', 1);
      $this->db->set('deleted', 0);
      $query2 = $this->db->insert('client_est_requests');
      $req_id = $this->db->insert_id();
      // echo $lastid;exit;
        if ($query){

          if (!is_dir('uploads/authorization_letter/'.$req_id))
          mkdir('uploads/authorization_letter/'.$req_id, 0777, TRUE);

          $config['upload_path']   = 'uploads/authorization_letter/'.$req_id;
          $config['allowed_types'] = '*';
          $config['max_size']      = '50000'; // max_size in kb

          if (!empty($_FILES['authorization_letter_existing_comp']['name'])) {
            $filename_auto = $_FILES['authorization_letter_existing_comp']['name'];
            $newNamedp = "authorization_letter".".".pathinfo($filename_auto, PATHINFO_EXTENSION);
            $auto_filename = 'uploads/authorization_letter/'.$req_id.'/'.$newNamedp;
            // echo $newNamedp;
            // echo "1";exit;

            (file_exists($auto_filename)) ? unlink($auto_filename) : '';

              $config['file_name']      = $newNamedp;
              $this->load->library('upload',$config);
              $this->upload->initialize($config);

              if (!$this->upload->do_upload('authorization_letter_existing_comp')) {
                 $error = array('error' => $this->upload->display_errors());
                 echo $error;exit;
              }else {
                $this->upload->data("authorization_letter_existing_comp");
              }
            }

          $this->session->set_flashdata('client_request_est_msg', $_SESSION['email']);
          redirect('Establishment');
        }else {
          echo $this->db->error();
        }
    }
  }

  public function add_new_establishment(){
    $data = $this->input->post();
    // echo "<pre>";print_r($data);exit;
      $this->load->model('Establishment_model','est');
    $client_id = $this->session->userdata('client_id');
    $query = $this->est->save_establishment_data($data);
    // echo $query;exit;
    if ($query)
      $estid = $query ;
      if (!is_dir('uploads/permits/'.$client_id.'/'.$estid))
      mkdir('uploads/permits/'.$client_id.'/'.$estid, 0777, TRUE);

      $config['upload_path']   = 'uploads/permits/'.$client_id.'/'.$estid;
      $config['allowed_types'] = '*';
      $config['max_size']      = '50000'; // max_size in kb

      if (!empty($_FILES['dp_file']['name'])) {
        // echo "1";exit;
        $filenamedp = $_FILES['dp_file']['name'];
        $newNamedp = "dp_file".".".pathinfo($filenamedp, PATHINFO_EXTENSION);
        $dpfilename = 'uploads/permits/'.$client_id.'/'.$estid.'/'.$newNamedp;
        (!empty($newNamedp)) ? $this->db->set('dp_attch',$newNamedp) : '';
        $this->db->where('client_id',$client_id);
        $query = $this->db->update('establishment');

        (file_exists($dpfilename)) ? unlink($dpfilename) : '';

        if ($query) {
          $config['file_name']      = $newNamedp;
          $this->load->library('upload',$config);
          $this->upload->initialize($config);

          if (!$this->upload->do_upload('dp_file')) {
             $error = array('error' => $this->upload->display_errors());
             echo $error;
          }else {
            $this->upload->data("dp_file");
          }
        }

        }

        if (!empty($_FILES['po_file']['name'])) {

          $filenamepo = $_FILES['po_file']['name'];
          $newNamepo = "po_file".".".pathinfo($filenamepo, PATHINFO_EXTENSION);
          $pofilename = 'uploads/permits/'.$client_id.'/'.$estid.'/'.$newNamepo;
          (!empty($newNamepo)) ? $this->db->set('po_attch',$newNamepo) : '';
          $this->db->where('client_id',$client_id);
          $query = $this->db->update('establishment');

          (file_exists($pofilename)) ? unlink($pofilename) : '';

          if ($query) {
            $config['file_name']      = $newNamepo;
            $this->load->library('upload',$newNamepo);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('po_file')) {
               $error = array('error' => $this->upload->display_errors());
            }else {
              $this->upload->data("po_file");
            }

          }

        }

        if (!empty($_FILES['ecc_file']['name'])) {
          $filenameecc = $_FILES['ecc_file']['name'];
          $newNameecc = "ecc_file".".".pathinfo($filenameecc, PATHINFO_EXTENSION);
          $eccfilename = 'uploads/permits/'.$client_id.'/'.$estid.'/'.$newNameecc;
          (!empty($newNameecc)) ? $this->db->set('ecc_attch',$newNameecc) : '';
          $this->db->where('client_id',$client_id);
          $query = $this->db->update('establishment');

          (file_exists($eccfilename)) ? unlink($eccfilename) : '';

          if ($query) {
            $config['file_name']      = $newNameecc;
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('ecc_file')) {
               $error = array('error' => $this->upload->display_errors());
            }else {
              $this->upload->data("ecc_file");
            }

          }
        }



        if(!empty($data['req_id'])){
          $req_id = $data['req_id'];
        }else {
          $this->db->select_max('req_id');
          $query = $this->db->get('client_est_requests');
          $req_id  =  $query->row()->req_id;
        }
        // echo $req_id;exit;
        // echo $this->db->last_query();
        // echo $req_id;
        // exit;
        if (!is_dir('uploads/authorization_letter/'.$req_id))
        mkdir('uploads/authorization_letter/'.$req_id, 0777, TRUE);

        $config['upload_path']   = 'uploads/authorization_letter/'.$req_id;
        $config['allowed_types'] = '*';
        $config['max_size']      = '50000'; // max_size in kb

        if (!empty($_FILES['authorization_letter_new_comp']['name'])) {
          $filename_auto = $_FILES['authorization_letter_new_comp']['name'];
          $newNamedp = "authorization_letter".".".pathinfo($filename_auto, PATHINFO_EXTENSION);
          $auto_filename = 'uploads/authorization_letter/'.$req_id.'/'.$newNamedp;
          // echo $newNamedp;
          // echo "1";exit;

          (file_exists($auto_filename)) ? unlink($auto_filename) : '';

            $config['file_name']      = $newNamedp;
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('authorization_letter_new_comp')) {
               $error = array('error' => $this->upload->display_errors());
               echo $error;exit;
            }else {
              $this->upload->data("authorization_letter_new_comp");
            }
          }

      $this->session->set_flashdata('client_request_est_msg', $_SESSION['email']);
      if(!empty($data['est_id'])){
          redirect('Establishment/view_est_data/'.$data['est_id'],'refresh');
      }else {
          redirect(base_url().'Establishment','refresh');
      }

  }
  public function selected_company_data(){
    $embis_db = $this->load->database('embis',TRUE);
    $est_id = $this->input->post('est_id',TRUE);
    $query = $embis_db->select('dc.*')->from('dms_company as dc')->where('deleted',0)->where('company_id',$est_id)->get()->result_array();
    echo json_encode($query);
  }
  function edit_apr_comp($embid = ''){
    $this->load->helper('common_helper');
    $embisdb = $this->load->database('embis',TRUE);
    $query['est_data_by_id'] = $embisdb->select('*')->from('dms_company')->where('emb_id',$embid)->get()->result_array();

    $query['project_type_data'] = $embisdb->select('dpt.proid,dpt.prj,dpt.base,dpt.chap,dpt.part,dpt.branch,dpt.header')->from('dms_project_type AS dpt')->get()->result_array();
    // echo "<pre>";print_r($query['project_type_data']);exit;
    $this->load->view('common/nav');
    $this->load->view('common/header');
    $this->load->view('edit_company',$query);
    $this->load->view('common/footer');
  }

  function update_establishment(){
    $data = $this->input->post();
    // echo "<pre>";print_r($data);
    // echo $this->encrypt->decode($data['company_id']);

    $embisdb= $this->load->database('embis',TRUE);
    $queryrgn = $embisdb->select('rgnid,rgnnum')->from('acc_region')->where('rgnid',$data['est_region'])->get()->result_array();
    ($data['est-type'] == 'main') ? $company_id = $this->encrypt->decode($data['company_id']) : $company_id = $data['main_company_id'];
    // exit;
    // echo $company_id;exit;
    $embisdb->set('company_type',$company_id);
    $embisdb->set('company_name',$data['establishment']);
    $embisdb->set('project_type',$data['project_type']);
    $embisdb->set('contact_no',$data['comp_tel']);
    $embisdb->set('email',$data['comp_email']);
    $embisdb->set('street',$data['est_street']);
    $embisdb->set('region_name',$queryrgn[0]['rgnnum']);
    $embisdb->set('region_id',$data['est_region']);
    $embisdb->set('province_id',$data['est_province']);
    $embisdb->set('city_id',$data['est_city']);
    $embisdb->set('barangay_id',$data['est_barangay']);
    $embisdb->set('longitude',$data['longitude']);
    $embisdb->set('latitude',$data['latitude']);
    $embisdb->set('psi_code_no',$data['psi_code_no']);
    $embisdb->set('psi_descriptor',$data['psi_descriptor']);
    $embisdb->set('ceo_fname',$data['ceo_first_name']);
    $embisdb->set('ceo_sname',$data['ceo_last_name']);
    $embisdb->set('ceo_contact_num',$data['ceo_phone_no']);
    $embisdb->set('ceo_fax_no',$data['ceo_fax_no']);
    $embisdb->set('ceo_email',$data['ceo_email']);
    $embisdb->set('plant_manager_name',$data['plant_manager']);
    $embisdb->set('plant_manager_coe',$data['plant_manager_coe']);
    $embisdb->set('plant_manager_email',$data['plant_manager_email']);
    $embisdb->set('plant_manager_tel_num',$data['plant_manager_phone_no']);
    $embisdb->set('plant_manager_fax_num',$data['plant_manager_fax_no']);
    $embisdb->set('plant_manager_mobile_num',$data['plant_manager_mobile_no']);
    $embisdb->set('pco',$data['pollution_officer']);
    $embisdb->set('pco_coe',$data['pollution_officer_coa_no']);
    $embisdb->set('pco_email',$data['pollution_officer_email']);
    $embisdb->set('pco_tel_num',$data['pollution_officer_tel_no']);
    $embisdb->set('pco_fax_num',$data['pollution_officer_fax_no']);
    $embisdb->set('pco_mobile_num',$data['pollution_officer_mobile_no']);
    $embisdb->set('managing_head', $data['managing_head']);
    $embisdb->set('managing_head_email', $data['managing_head_email']);
    $embisdb->set('managing_head_tel_no', $data['managing_head_tel_no']);
    $embisdb->set('managing_head_fax_no', $data['managing_head_fax_no']);
    $embisdb->set('managing_head_mobile_no', $data['managing_head_mobile_no']);


    $embisdb->where('emb_id',$data['emb_id']);
    $query = $embisdb->update('dms_company');
      if ($query) {
        //echo $embisdb->last_query();exit;
          echo "<script>alert('Successfully updated !')</script>";
          echo "<script>window.location.href='".base_url()."Establishment/edit_apr_comp/".$data['emb_id']."'</script>";
      }else {
        echo "<script>alert('Something went wrong, Please try again. Thank you.')</script>";
      }
  }
  public function _show_view($content)
  {
    if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 3) {
      $this->load->view('admin/nav');
    }else {
        $this->load->view('common/nav');
    }
    $this->load->view('common/header', @$this->my_data);
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);

    $this->load->view('common/footer');
  }
}

 ?>

<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Establishment_ extends CI_Controller
{

  function __construct()
  {

    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('Establishment_model','est');
    $this->load->model('My_model','mm');
    $this->load->database();
    $this->load->library('session');
    ini_set('display_errors',  0);
    ini_set('display_startup_errors',  0);
    error_reporting(E_ALL);
      // session_start();
    if (! $this->session->userdata('is_login'))
    {
        redirect('Login/logout_user');
    }
  }

  public function view_est_data($company = ''){
    $this->my_data['company_id'] = $company;
    $array_data = array(
      'where' => 'est_id = "'.$company.'" AND client_id = "'.$this->session->userdata('client_id').'"',
     );
    $this->my_data['est_data_by_id'] = $this->mm->getRows('crs.establishment',$array_data,'array');
    if (count($this->my_data['est_data_by_id']) > 0)  {
      $this->load->view('common/header');
      $tabs_data['mod1link'] = base_url().'add_establishment_steps/1';
      $tabs_data['mod2link'] = base_url().'add_establishment_steps/2';
      $tabs_data['mod3link'] = base_url().'add_establishment_steps/3';
      $tabs_data['mod4link'] = base_url().'add_establishment_steps/4';
      $this->my_data['banner'] = $this->load->view('banner',$tabs_data,true);
      $this->my_data['region_list'] = $this->mm->getRows('acc_region','','array');

      $array_data1 = array('where' => 'region_id = "'.$this->my_data['est_data_by_id'][0]['est_region'].'"', );
      $this->my_data['province_list'] = $this->mm->getRows('embis.dms_province',$array_data1,'array');

      $array_data2 = array('where' => 'province_id = "'.$this->my_data['est_data_by_id'][0]['est_province'].'"', );
      $this->my_data['city_list'] = $this->mm->getRows('embis.dms_city',$array_data2,'array');

      $array_data3 = array('where' => 'city_id = "'.$this->my_data['est_data_by_id'][0]['est_city'].'"', );
      $this->my_data['brgy_list'] = $this->mm->getRows('embis.dms_barangay',$array_data3,'array');

      $this->my_data['project_type_data'] = $this->mm->getRows('embis.dms_project_type','','array');
      $this->my_data['main_company'] = $this->db->select('company_id,company_name,region_name')->from('embis.dms_company')->where('deleted',0)->where('company_id',$this->my_data['est_data_by_id'][0]['main_company_id'])->get()->result_array();

      $this->_show_view('view_establishment_data');
    }else {
      $this->load->view('404');
    }

  }
  public function view_approved_establishment($company = ''){
    (!empty($company) || $company != '') ?$company = $company : $company = '';

    $array_data = array('where' => 'company_id = "'.$company.'"', );
    $this->my_data['est_data_by_id'] = $this->mm->getRows('embis.dms_company',$array_data,'array');
    // echo "<pre>";print_r($this->my_data['est_data_by_id']);exit;
    $array_data1 = array('where' => 'rgnnum = "'.  $this->my_data['est_data_by_id'][0]['region_name'].'"', );
    $this->my_data['region_id'] = $this->mm->getRows('acc_region',$array_data1,'array');
    $tabs_data['mod3'] = 'active ';
    $tabs_data['company_id'] = $company;
    $this->my_data['tabs_menu'] = $this->load->view('add_buttons',$tabs_data,true);
    $this->my_data['banner'] = $this->load->view('banner',$tabs_data,true);
    $this->_show_view('view_approved_establishment');
  }
  public function add_establishment_steps($steps,$company){
  if ($company == 0)
    $this->session->unset_userdata('selected_company');
    $year =  date("y");
    $this->load->view('common/header');
    $tabs_data['mod1link'] = base_url().'add_establishment_steps/1';
    $tabs_data['mod2link'] = base_url().'add_establishment_steps/2';
    $tabs_data['mod3link'] = base_url().'add_establishment_steps/3';
    $tabs_data['mod4link'] = base_url().'add_establishment_steps/4';
    $this->my_data['banner'] = $this->load->view('banner',$tabs_data,true);
    $optreg = array('where' => 'rgnnum != "CO"');
    $this->my_data['region_list'] = $this->mm->getRows('acc_region',$optreg,'array');

    // $this->my_data['region_list'] = $this->mm->getRows('acc_region','','array');
    $this->my_data['city_list'] = $this->mm->getRows('acc_region','','array');
    $this->my_data['project_type_data'] = $this->mm->getRows('embis.dms_project_type','','array');
    if (!empty($company))
      $this->session->set_userdata('selected_company',$company);
  switch ($steps) {
    case '1':
      // getRows($table,$options = array(),$result = 'array'){
        $tabs_data['mod1'] = 'active';
        $array_data = array('select' => '*');
        $this->my_data['tabs_menu'] = $this->load->view('add_buttons',$tabs_data,true);
        $this->_show_view('add_establishment_select_region');
      break;
    case '2':
      $tabs_data['mod2'] = 'active ';
      $est_region = $this->input->post('est_region',TRUE);
      (!empty($est_region) || $est_region != '') ?$this->session->set_userdata('selected_region',$est_region): $this->session->unset_userdata('selected_region');;
      $array_data = array('where' => 'region_name = "'.$est_region.'"', );
      $this->my_data['company_list'] = $this->mm->getRows('embis.dms_company',$array_data,'array');
      $this->my_data['tabs_menu'] = $this->load->view('add_buttons',$tabs_data,true);
      $this->_show_view('search_compananies');
    break;
    case '3':
      (!empty($company) || $company != '') ?$company = $company : $company = '';

      $array_data = array('where' => 'company_id = "'.$company.'"', );
      $this->my_data['est_data_by_id'] = $this->mm->getRows('embis.dms_company',$array_data,'array');
      // echo "<pre>";print_r($this->my_data['est_data_by_id']);exit;
      $array_data1 = array('where' => 'rgnnum = "'.  $this->my_data['est_data_by_id'][0]['region_name'].'"', );
      $this->my_data['region_id'] = $this->mm->getRows('acc_region',$array_data1,'array');
      $tabs_data['mod3'] = 'active ';
      $tabs_data['company_id'] = $company;
      $this->my_data['tabs_menu'] = $this->load->view('add_buttons',$tabs_data,true);
      $this->_show_view('add_new_establishment');
    break;
    case '4':
     $data = $this->input->post();
     // echo "<pre>";print_r($_POST);exit;
      $query = $this->est->save_establishment_data_v2($data,$company);
      $req_id =   $query;
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
            (file_exists($auto_filename)) ? unlink($auto_filename) : '';
              $config['file_name']      = $newNamedp;
              $this->load->library('upload',$config);
              $this->upload->initialize($config);
          if (!$this->upload->do_upload('authorization_letter_existing_comp')) {
              $error = array('error' => $this->upload->display_errors());
              print_r($error);
              echo $error;exit;
            }else {
              $this->upload->data("authorization_letter_existing_comp");
            }
          }
          // for discharge permit
          if (!empty($_FILES['dp_no_file']['name'][0])){
            $path = 'uploads/new_permits/dp/'.$req_id;
            $title = 'dp';
            if ($this->upload_files($title,$path, $_FILES['dp_no_file']) === FALSE) {
              $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {
              foreach ($_FILES['dp_no_file']['name'] as $key => $file) {
                $file = str_replace(" ","_", $file);
                if (!empty($file)) {
                  $fileinsertdata = array(
                      'req_id'    => $req_id,
                      'client_id' => $this->session->userdata('client_id'),
                      'file_name' => $title.$key.'-'.$year.'-'.$file,
                      'status'    => 1,
                    );
                    $query = $this->db->insert('dp_permit_per_establishment_attachments', $fileinsertdata);
                }
              }
              foreach ($data['dp_no'] as $key => $dp_no) {
                if (!empty($dp_no)) {
                  $dpdata = array(
                      'req_id'    => $req_id,
                      'client_id' => $this->session->userdata('client_id'),
                      'dp_no'     => $dp_no,
                    );
                    $query = $this->db->insert('dp_permit_per_establishment', $dpdata);
                }
              }
            }
          }
          // for CNC permit
          if (!empty($_FILES['cnc_no_file']['name'][0])) {
            $title = 'cnc';
            $path = 'uploads/new_permits/cnc/'.$req_id;
            if ($this->upload_files($title,$path, $_FILES['cnc_no_file']) === FALSE) {
              $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {
              foreach ($_FILES['cnc_no_file']['name'] as $key => $file) {
                  $file = str_replace(" ","_", $file);
                  $fileinsertdata = array(
                    'req_id'    => $req_id,
                    'client_id' => $this->session->userdata('client_id'),
                    'file_name' => $title.$key.'-'.$year.'-'.$file,
                  );
                  $query = $this->db->insert('cnc_permit_per_establishment_attachments', $fileinsertdata);
              }
              foreach ($data['cnc_no'] as $key => $cnc) {
                if (!empty($cnc)) {
                  $cncdata = array(
                      'req_id'    => $req_id,
                      'client_id' => $this->session->userdata('client_id'),
                      'cnc_no'    => $cnc,
                    );
                    $query = $this->db->insert('cnc_permit_per_establishment', $cncdata);
                }
              }
            }
          }
          // ecc file
          if (!empty($_FILES['ecc_no_file']['name'][0])) {
            $title = 'ecc';
            $path = 'uploads/new_permits/ecc/'.$req_id;
            if ($this->upload_files($title,$path, $_FILES['ecc_no_file']) === FALSE) {
              $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {
              foreach ($_FILES['ecc_no_file']['name'] as $key => $file) {
                  $file = str_replace(" ","_", $file);
                $fileinsertdata = array(
                  'req_id'    => $req_id,
                  'client_id' => $this->session->userdata('client_id'),
                  'file_name' =>  $title.$key.'-'.$year.'-'.$file,
                );
              $query = $this->db->insert('ecc_permit_per_establishment_attachments', $fileinsertdata);
              }
              foreach ($data['ecc_no'] as $key => $ecc) {
                if (!empty($ecc)) {
                  $eccdata = array(
                      'req_id'    => $req_id,
                      'client_id' => $this->session->userdata('client_id'),
                      'ecc_no'    => $ecc,
                    );
                    $query = $this->db->insert('ecc_permit_per_establishment', $eccdata);
                }
              }

          }
        }

        // po permit
        if (!empty($_FILES['po_no_file']['name'][0])) {
          $title = 'po';
          $path = 'uploads/new_permits/po/'.$req_id;
          if ($this->upload_files($title,$path, $_FILES['po_no_file']) === FALSE) {
            $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
          }else {
              foreach ($_FILES['po_no_file']['name'] as $key => $file) {
                $file = str_replace(" ","_", $file);
                $fileinsertdata = array(
                  'req_id'    => $req_id,
                  'client_id' => $this->session->userdata('client_id'),
                  'file_name' =>  $title.$key.'-'.$year.'-'.$file,
                );
                $query = $this->db->insert('po_permit_per_establishment_attachments', $fileinsertdata);
              }
              if (!empty($data['po_no'])) {
                $podata = array(
                  'req_id'    => $req_id,
                  'client_id' => $this->session->userdata('client_id'),
                  'po_no'    => $data['po_no'],
                );
                $query = $this->db->insert('po_permit_per_establishment', $podata);
              }
            }
          }
      }else {
        echo '<script type="text/javascript">alert("Something went wrong ! Please contact Administrator");history.go(-1);</script>';
      }
      $tabs_data['mod4'] = 'active ';
      $this->my_data['tabs_menu'] = $this->load->view('add_buttons',$tabs_data,true);

      $options = array('where' => 'client_id = '.$this->session->userdata('client_id').'','select' => 'first_name,last_name,client_id',);
      $this->my_data['client_details'] = $this->mm->getRows('acc',$options,'array');

      $options2 = array('where' => 'cnt = '.$req_id.'','limit' => 1,);
      $this->my_data['establishment_details'] = $this->mm->getRows('establishment',$options2,'array');
      $options3 = array('where' => 'id = '.$this->my_data['establishment_details'][0]['est_province'].'','select' => 'name','limit' => 1,);
      $this->my_data['province'] = $this->mm->getRows('embis.dms_province',$options3,'array');

      $options4 = array('where' => 'id = '.$this->my_data['establishment_details'][0]['est_city'].'','select' => 'name','limit' => 1,);
      $this->my_data['city'] = $this->mm->getRows('embis.dms_city',$options4,'array');

      $options5 = array('where' => 'id = '.$this->my_data['establishment_details'][0]['est_barangay'].'','select' => 'name','limit' => 1,);
      $this->my_data['barangay'] = $this->mm->getRows('embis.dms_city',$options5,'array');


      $options6 = array('where' => 'rgnid = '.$this->my_data['establishment_details'][0]['est_region'].'','select' => 'rgnnam,rgnnum','limit' => 1,);
      $this->my_data['region'] = $this->mm->getRows('embis.acc_region',$options6,'array');
      $options7 = array('where' => 'region = "'.$this->my_data['region'][0]['rgnnum'].'"','select' =>'file_name','limit' => 1,);
      $this->my_data['header'] = $this->mm->getRows('embis.office_uploads_document_header',$options7,'array');

      $this->my_data['region_support'] = $this->email_region($this->my_data['region'][0]['rgnnum']);
      $this->_show_view_2('acknowledgement.php');
    break;
    default:
      $tabs_data['mod1'] = 'active ';
      $this->my_data['tabs_menu'] = $this->load->view('add_buttons',$tabs_data,true);
      $this->_show_view('add_establishment_select_region');
      break;
  }
}

// for updating establishment
function update_establishment($company = '' ){
  // echo "<pre>";
  // print_r($_FILES);
  // echo $company;exit;
  $data = $this->input->post();
   $query = $this->est->save_establishment_data_v2($data,$company);
   $req_id = $query;
   if ($req_id) {

     if (!is_dir('uploads/authorization_letter/'.$company))
     mkdir('uploads/authorization_letter/'.$company, 0777, TRUE);
       $config['upload_path']   = 'uploads/authorization_letter/'.$company;
       $config['allowed_types'] = '*';
       $config['max_size']      = '50000'; // max_size in kb
     if (!empty($_FILES['authorization_letter_existing_comp']['name'])) {
       $filename_auto = $_FILES['authorization_letter_existing_comp']['name'];
       $newNamedp = "authorization_letter".".".pathinfo($filename_auto, PATHINFO_EXTENSION);
       $auto_filename = 'uploads/authorization_letter/'.$company.'/'.$newNamedp;
       (file_exists($auto_filename)) ? unlink($auto_filename) : '';
         $config['file_name']      = $newNamedp;
         $this->load->library('upload',$config);
         $this->upload->initialize($config);
     if (!$this->upload->do_upload('authorization_letter_existing_comp')) {
         $error = array('error' => $this->upload->display_errors());
         print_r($error);
         echo $error;exit;
       }else {
         $this->upload->data("authorization_letter_existing_comp");
       }
     }

     echo '<script type="text/javascript">alert("Successfully Updated !");history.go(-1);</script>';
   }  else {
     echo '<script type="text/javascript">alert("Something went wrong ! Please contact Administrator");history.go(-1);</script>';
   }
}

  public function email_region($region = ''){
   $region_ses = $region;

     switch ($region_ses) {
     case 'R1':
     $ccemail = 'r1support@emb.gov.ph';
       break;

     case 'R2':
       $ccemail = 'r2support@emb.gov.ph';
     break;

     case 'R3':
     $ccemail = 'r3support@emb.gov.ph';
     break;

     case 'R4A':
     $ccemail = 'r4asupport@emb.gov.ph';
     break;

     case 'R4B':
       $ccemail = 'r4bsupport@emb.gov.ph';
     break;

     case 'R5':
       $ccemail = 'r5support@emb.gov.ph';
     break;

     case 'R6':
       $ccemail = 'r6support@emb.gov.ph';
     break;
     case 'R7':
       $ccemail = 'r7support@emb.gov.ph';
     break;
     case 'R8':
     $ccemail = 'r8support@emb.gov.ph';
     break;
     case 'R9':
     $ccemail = 'r9support@emb.gov.ph';
     break;
     case 'R10':
     $ccemail = 'r10support@emb.gov.ph';
     break;
     case 'R11':
       $ccemail = 'r11support@emb.gov.ph';
     break;
     case 'R12':
     $ccemail = 'r12support@emb.gov.ph';
     break;
     case 'R13':
     $ccemail = 'r13support@emb.gov.ph';
     break;

     case 'NCR':
     $ccemail = 'ncrsupport@emb.gov.ph';
     break;


     case 'CAR':
     $ccemail = 'smrcmr@car.emb.gov.ph';
     break;

     case 'ARMM':
       $ccemail = 'armmsupport@emb.gov.ph';
     break;

     default:
       $ccemail = 'crs.emb.2020@gmail.com';
       break;
   }
   return $ccemail;
  }

  private function upload_files($title,$path, $files){
      if (!is_dir($path))
      mkdir($path, 0777, TRUE);
          $config = array(
              'upload_path'   => $path,
              'allowed_types' => '*',
              'overwrite'     => 1,
          );
          $this->load->library('upload', $config);

          $images = array();

          foreach ($files['name'] as $key => $image) {
              $_FILES['images[]']['name']= $files['name'][$key];
              $_FILES['images[]']['type']= $files['type'][$key];
              $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
              $_FILES['images[]']['error']= $files['error'][$key];
              $_FILES['images[]']['size']= $files['size'][$key];

              $fileName = $image;

              $images[] = $fileName;
              $year =  date("y");
              $year = substr( $year, -2);
              $config['file_name'] = $title.$key.'-'.$year.'-'.$fileName;

              $this->upload->initialize($config);

              if ($this->upload->do_upload('images[]')) {
                  $this->upload->data();
              } else {
                  return false;
              }
          }

          return $images;
  }
  // for adding main company
  public function add_main_company(){
    $embisdb = $this->load->database('embis',TRUE);
    $query = $embisdb->select('company_id,company_name,emb_id')->from('dms_company')->where('company_id',$this->input->post('main_company_id',TRUE))->get()->result_array();
    // echo $this->db->last_query();exit;
    if ($query) {
        echo json_encode($query);exit;
    }else {
       echo "<script>alert('something's wrong , Please contact administrator - r7support@emb.gov.ph')</script>";
    }
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

  function check_permits_apr_establishment($id = ''){
      $option = array(
        'select'  => 'dcomp.company_name,acr.req_id',
        'where'   => 'acr.client_id = '.$this->session->userdata('client_id').' AND acr.deleted = 0',
      );
      $this->db->join('embis.dms_company dcomp','dcomp.company_id = acr.company_id','left');
      $this->my_data['establishment']  = $this->mm->getRows('embis.approved_client_req as acr',$option,'array');
      $this->my_data['selected_est'] = $id;
      // if ($this->session->userdata('username') != 'sampleclient1') {
      //     $this->load->view('maintenance');
      // }else {
      //     $this->_show_view('check_apr_permits');
      // }
      $this->_show_view('check_apr_permits');
  }

  function check_permits($id = ''){

      $option = array(
        'select'  => 'est.establishment,est.cnt,cer.deleted',
        'where'  => 'est.client_id = '.$this->session->userdata('client_id').' AND cer.deleted = 0 AND cer.status != 1',
      );
      $this->db->join('client_est_requests as cer','cer.req_id = est.cnt');
      $this->my_data['establishment']  = $this->mm->getRows('crs.establishment as est',$option,'array');
      $this->my_data['selected_est'] = $id;
      $this->_show_view('check_permits');
  }

  function get_permits_per_apr_establishment_attch($est_id = ''){
    $est_id = $this->input->post('req_id',TRUE);
          // for dp data
          $option1 = array(
            'select'  => 'dp.dp_permit_id,dp.file_name,dp.req_id,dcomp.company_name,dppe.dp_no,dppe.dp_no_id',
            'where'  => 'dp.deleted = 0 AND dp.client_id = '.$this->session->userdata('client_id').' AND dp.req_id = '.$est_id.'',
          );
          $this->db->join('embis.approved_client_req as apr','apr.req_id = dp.req_id','left');
          $this->db->join('embis.dms_company as dcomp','dcomp.company_id = apr.company_id','left');
          $this->db->join('dp_permit_per_establishment as dppe','dppe.dp_no_id = dp.dp_no_id','left');
          $query['dp'] = $this->mm->getRows('dp_permit_per_establishment_attachments as dp',$option1,'array');

          // echo $this->db->last_query();exit;
          // $optiondpno = array(
          //   'select'  => 'dp_no.dp_permit_id,dp_no.dp_no,dp_no.req_id,est.establishment',
          //   'where'  => 'dp_no.deleted = 0 AND dp_no.client_id = '.$this->session->userdata('client_id').' AND dp.req_id = '.$est_id.'',
          // );
          // $query['dp_no'] = $this->mm->getRows('dp_permit_per_establishment as dp_no',$optiondpno,'array');
          // echo $this->db->last_query();exit;

          $option2 = array(
            'select'  => 'cnc.cnc_permit_id,cnc.file_name,cnc.req_id,dcomp.company_name,cppe.cnc_no,cppe.cnc_no_id',
            'where'  => 'cnc.deleted = 0 AND cnc.client_id = '.$this->session->userdata('client_id').' AND cnc.req_id = '.$est_id.'',
          );
          // $this->db->join('establishment as est','est.cnt = cnc.req_id');
          $this->db->join('embis.approved_client_req as apr','apr.req_id = cnc.req_id','left');
          $this->db->join('embis.dms_company as dcomp','dcomp.company_id = apr.company_id','left');
          $this->db->join('cnc_permit_per_establishment as cppe','cppe.cnc_no_id = cnc.cnc_no_id','left');
          $query['cnc'] = $this->mm->getRows('cnc_permit_per_establishment_attachments as cnc',$option2,'array');
          // for ecc
          $option3 = array(
            'select'  => 'dcomp.company_name,ecc.file_name,ecc.ecc_permit_id,ecc.req_id,eppe.ecc_no,eppe.ecc_no_id',
            'where'  => 'ecc.deleted = 0 AND ecc.client_id = '.$this->session->userdata('client_id').' AND ecc.req_id = '.$est_id.'',
          );
          // $this->db->join('establishment as est','est.cnt = ecc.req_id');
          $this->db->join('embis.approved_client_req as apr','apr.req_id = ecc.req_id','left');
          $this->db->join('embis.dms_company as dcomp','dcomp.company_id = apr.company_id','left');
          $this->db->join('ecc_permit_per_establishment as eppe','eppe.ecc_no_id = ecc.ecc_no_id','left');
          $query['ecc'] = $this->mm->getRows('ecc_permit_per_establishment_attachments as ecc',$option3,'array');
          // echo "<pre>";print_r(  $query['ecc']);exit;
          // for po
          $option4 = array(
            'select'  => 'dcomp.company_name,pppe.file_name,pppe.req_id,ppp.po_no,ppp.po_no_id,pppe.po_permit_id',
            'where'  => 'pppe.deleted = 0 AND pppe.client_id = '.$this->session->userdata('client_id').' AND pppe.req_id = '.$est_id.'',
          );
          // $this->db->join('establishment as est','est.cnt = pppe.req_id');
          $this->db->join('embis.approved_client_req as apr','apr.req_id = pppe.req_id','left');
          $this->db->join('embis.dms_company as dcomp','dcomp.company_id = apr.company_id','left');
          $this->db->join('po_permit_per_establishment as ppp','ppp.po_no_id = pppe.po_no_id','left');
          $query['po']  = $this->mm->getRows('po_permit_per_establishment_attachments as pppe',$option4,'array');
          // echo $this->db->last_query();
          // echo "<pre>";
          // print_r($query['po']);exit;
          echo json_encode($query);
  }

  function get_permits_per_establishment_attachments($est_id = ''){
    $est_id = $this->input->post('est_id',TRUE);
          // for dp data
          $option1 = array(
            'select'  => 'dp.dp_permit_id,dp.file_name,dp.req_id,est.establishment,dppe.dp_no,dppe.dp_no_id',
            'where'  => 'dp.deleted = 0 AND dp.client_id = '.$this->session->userdata('client_id').' AND dp.req_id = '.$est_id.'',
          );
          $this->db->join('establishment as est','est.cnt = dp.req_id');
          $this->db->join('dp_permit_per_establishment as dppe','dppe.dp_no_id = dp.dp_permit_id');
          $query['dp'] = $this->mm->getRows('dp_permit_per_establishment_attachments as dp',$option1,'array');

          // $optiondpno = array(
          //   'select'  => 'dp_no.dp_permit_id,dp_no.dp_no,dp_no.req_id,est.establishment',
          //   'where'  => 'dp_no.deleted = 0 AND dp_no.client_id = '.$this->session->userdata('client_id').' AND dp.req_id = '.$est_id.'',
          // );
          // $query['dp_no'] = $this->mm->getRows('dp_permit_per_establishment as dp_no',$optiondpno,'array');
          // echo $this->db->last_query();exit;

          $option2 = array(
            'select'  => 'cnc.cnc_permit_id,cnc.file_name,cnc.req_id,est.establishment,cppe.cnc_no,cppe.cnc_no_id',
            'where'  => 'cnc.deleted = 0 AND cnc.client_id = '.$this->session->userdata('client_id').' AND cnc.req_id = '.$est_id.'',
          );
          $this->db->join('establishment as est','est.cnt = cnc.req_id');
          $this->db->join('cnc_permit_per_establishment as cppe','cppe.cnc_no_id = cnc.cnc_permit_id');
          $query['cnc'] = $this->mm->getRows('cnc_permit_per_establishment_attachments as cnc',$option2,'array');
          // for ecc
          $option3 = array(
            'select'  => 'est.establishment,ecc.file_name,ecc.ecc_permit_id,ecc.req_id,eppe.ecc_no,eppe.ecc_no_id',
            'where'  => 'ecc.deleted = 0 AND ecc.client_id = '.$this->session->userdata('client_id').' AND ecc.req_id = '.$est_id.'',
          );
          $this->db->join('establishment as est','est.cnt = ecc.req_id');
          $this->db->join('ecc_permit_per_establishment as eppe','eppe.ecc_no_id = ecc.ecc_permit_id');
          $query['ecc'] = $this->mm->getRows('ecc_permit_per_establishment_attachments as ecc',$option3,'array');
          // echo "<pre>";print_r(  $query['ecc']);exit;
          // for po
          $option4 = array(
            'select'  => 'est.establishment,pppe.file_name,pppe.req_id,ppp.po_no,ppp.po_no_id,pppe.po_permit_id',
            'where'  => 'pppe.deleted = 0 AND pppe.client_id = '.$this->session->userdata('client_id').' AND pppe.req_id = '.$est_id.'',
          );
          $this->db->join('establishment as est','est.cnt = pppe.req_id');
          $this->db->join('po_permit_per_establishment as ppp','ppp.po_no_id = pppe.po_permit_id');
          $query['po']  = $this->mm->getRows('po_permit_per_establishment_attachments as pppe',$option4,'array');
          // echo $this->db->last_query();
          // echo "<pre>";
          // print_r($query['po']);exit;
          echo json_encode($query);
  }

  public function get_permit_name($id = ''){
    $query = $this->mm->getRows('embis.office_uploads_document_header',$options7,'array');
  }
  public function upload_permits(){
      $year =  date("y");
      $year = substr($year, -2);
      switch ($this->input->post('permit_type')) {
        case '1':
        $type = 'dp';
        if (!empty($_FILES['uploadpermitfile']['name'][0])) {
          $path = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id');
          $unlinkpath = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id').'/'.$this->input->post('old_file_name');
            unlink($unlinkpath); //($path);
          if ($this->upload_files($type,$path, $_FILES['uploadpermitfile']) === FALSE) {
            $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
          }else {
            foreach ($_FILES['uploadpermitfile']['name'] as $key => $file) {
                $filename = str_replace(" ","_",$_FILES['uploadpermitfile']['name'][0]);
                $this->db->set('file_name',$type.$key.'-'.$year.'-'.$filename);
                $this->db->where('dp_permit_id',$this->input->post('file_id'));
                $this->db->where('client_id',$this->session->userdata('client_id'));
                $query1 = $this->db->update('dp_permit_per_establishment_attachments');
              }
              if ($query1){
                if (!empty($this->input->post('permit_no_id'))) {
                  $this->db->set('dp_no',$this->input->post('permit_no_id'));
                  $this->db->where('dp_no_id',$this->input->post('permit_unq_no_id'));
                  $this->db->where('client_id',$this->session->userdata('client_id'));
                  $query = $this->db->update('dp_permit_per_establishment');
                  if ($query){
                    echo 'success';
                  }else {
                    echo 'error';
                  }
                }
              }else {
                echo 'error';
              }
            }
        }else {
          echo 'empty';
          exit;
        }
          break;
          case '2':
          $type = 'cnc';
          if (!empty($_FILES['uploadpermitfile']['name'][0])) {
            $path = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id');
            $unlinkpath = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id').'/'.$this->input->post('old_file_name');
              unlink($unlinkpath); //($path);
            if ($this->upload_files($type,$path, $_FILES['uploadpermitfile']) === FALSE) {
              $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {
              foreach ($_FILES['uploadpermitfile']['name'] as $key => $file) {
                  $year =  date("y");
                  $year = substr($year, -2);
                  $filename = str_replace(" ","_",$_FILES['uploadpermitfile']['name'][0]);
                  $this->db->set('file_name',$type.$key.'-'.$year.'-'.$filename);
                  $this->db->where('cnc_permit_id',$this->input->post('file_id'));
                  $this->db->where('client_id',$this->session->userdata('client_id'));
                  $query1 = $this->db->update('cnc_permit_per_establishment_attachments');
                }
                if ($query1)
                  if (!empty($this->input->post('permit_no_id'))) {
                    $this->db->set('cnc_no',$this->input->post('permit_no_id'));
                    $this->db->where('cnc_no_id',$this->input->post('permit_unq_no_id'));
                    $this->db->where('client_id',$this->session->userdata('client_id'));
                    $query = $this->db->update('cnc_permit_per_establishment');
                    if ($query)
                      echo "success";
                      exit;
                  }
              }
          }else {
            echo "empty";
            exit;
          }
        case '3':
          $type = 'ecc';
          if (!empty($_FILES['uploadpermitfile']['name'][0])) {
            $path = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id');
            $unlinkpath = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id').'/'.$this->input->post('old_file_name');
              unlink($unlinkpath); //($path);
            if ($this->upload_files($type,$path, $_FILES['uploadpermitfile']) === FALSE) {
              $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {
              foreach ($_FILES['uploadpermitfile']['name'] as $key => $file) {
                  $filename = str_replace(" ","_",$_FILES['uploadpermitfile']['name'][0]);
                  $this->db->set('file_name',$type.$key.'-'.$year.'-'.$filename);
                  $this->db->where('ecc_permit_id',$this->input->post('file_id'));
                  $this->db->where('client_id',$this->session->userdata('client_id'));
                  $query1 = $this->db->update('ecc_permit_per_establishment_attachments');
                }
                if ($query1)
                  if (!empty($this->input->post('permit_no_id'))) {
                    $this->db->set('ecc_no',$this->input->post('permit_no_id'));
                    $this->db->where('ecc_no_id',$this->input->post('permit_unq_no_id'));
                    $this->db->where('client_id',$this->session->userdata('client_id'));
                    $query = $this->db->update('ecc_permit_per_establishment');
                    if ($query)
                      echo 'success';
                      exit;
                  }
              }
          }else {
            echo 'empty';
          }
        break;
        case '4':
          $type = 'po';
          if (!empty($_FILES['uploadpermitfile']['name'][0])) {
            $path = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id');
            $unlinkpath = 'uploads/new_permits/'.$type.'/'.$this->input->post('file_directory_id').'/'.$this->input->post('old_file_name');
              unlink($unlinkpath); //($path);
            if ($this->upload_files($type,$path, $_FILES['uploadpermitfile']) === FALSE) {
              $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {
              foreach ($_FILES['uploadpermitfile']['name'] as $key => $file) {
                  $filename = str_replace(" ","_",$_FILES['uploadpermitfile']['name'][0]);
                  $this->db->set('file_name',$type.$key.'-'.$year.'-'.$filename);
                  $this->db->where('po_permit_id',$this->input->post('file_id'));
                  $this->db->where('client_id',$this->session->userdata('client_id'));
                  $query1 = $this->db->update('po_permit_per_establishment_attachments');
                }
                if ($query1)
                  if (!empty($this->input->post('permit_no_id'))) {
                    $this->db->set('po_no',$this->input->post('permit_no_id'));
                    $this->db->where('po_no_id',$this->input->post('permit_unq_no_id'));
                    $this->db->where('client_id',$this->session->userdata('client_id'));
                    $query = $this->db->update('po_permit_per_establishment');
                    if ($query)
                      echo "success";
                  }
              }
          }else {
            echo "empty";
          }
        break;
        default:
          // code...
          break;
      }

  }

  // public function check_permit_per_establishment($id){
  //   $options6 = array('where' => 'req_id = '.$id.' AND client_id = '.$this->session->userdata('client_id').'',);
  //   $count = $this->mm->getRows('crs.dp_permit_per_establishment',$options6,'count');
  //   return $count ;
  // }
  public function get_new_dp_data($id){

  }
  public function upload_new_permits(){
    $data = $this->input->post();
    $req_id = $data['req_id'];
    // $validate = $this->check_permit_per_establishment($data['req_id']);
    // $cnt = $validate + 1;
    // echo $cnt;exit;
    // echo "<pre>";print_r($_POST);
    // print_r($_FILES);
    // exit;
    // if ($validate > 0) {
      if (!empty($_FILES['uploadpermitnewfile'])) {
        switch ($this->input->post('permit_type')) {
          case '1':
            $path = 'uploads/new_permits/dp/'.$req_id;
            $title = 'dp';
            if ($this->upload_files($title,$path, $_FILES['uploadpermitnewfile']) === FALSE) {
              $msg = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {
                $file = str_replace(" ","_", $_FILES['uploadpermitnewfile']['name'][0]);
                $year =  date("y");
                $year = substr($year, -2);
                $fileName = $title.'0-'.$year.'-'.$file;

                if (!empty($data['dp_no'])) {
                  $dpdata = array(
                      'req_id'    => $req_id,
                      'client_id' => $this->session->userdata('client_id'),
                      'dp_no'     => $data['dp_no'],
                    );
                    $query = $this->db->insert('dp_permit_per_establishment', $dpdata);
                }

                $maxiddp = $this->db->query('SELECT MAX(dp_no_id) AS `maxid` FROM `dp_permit_per_establishment`')->row()->maxid;
                if (!empty($file)) {
                  $fileinsertdata = array(
                      'req_id'    => $req_id,
                      'client_id' => $this->session->userdata('client_id'),
                      'file_name' => $fileName,
                      'status'    => 1,
                      'dp_no_id'  => $maxiddp,
                    );
                    $query = $this->db->insert('dp_permit_per_establishment_attachments', $fileinsertdata);
                }


              // }

              if ($query) {
                $msg =  "success";
              }else {
                $msg =  "failed";
              }
              echo   $msg;
            }
            break;
            case '2':
              // for CNC permit
              // echo "<pre>";print_r($_POST);
              // print_r($_FILES);
              // exit;
                $title = 'cnc';
                $path = 'uploads/new_permits/cnc/'.$req_id;
                if ($this->upload_files($title,$path, $_FILES['uploadpermitnewfile']) === FALSE) {
                  $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
                }else {

                    $file = str_replace(" ","_", $_FILES['uploadpermitnewfile']['name'][0]);
                    $year =  date("y");
                    $year = substr( $year, -2);
                    $fileName = $title.'0-'.$year.'-'.$file;
                    $maxidcnc = $this->db->query('SELECT MAX(cnc_no_id) AS `maxid` FROM `cnc_permit_per_establishment`')->row()->maxid;
                    if (!empty($data['cnc_no'])) {
                      $cncdata = array(
                        'req_id'    => $req_id,
                        'client_id' => $this->session->userdata('client_id'),
                        'cnc_no'    => $data['cnc_no'],
                      );
                      $query = $this->db->insert('cnc_permit_per_establishment', $cncdata);
                    }

                    if (!empty($file)) {
                      $fileinsertdata = array(
                          'req_id'    => $req_id,
                          'client_id' => $this->session->userdata('client_id'),
                          'file_name' => $fileName,
                          'cnc_no_id' => $maxidcnc+1,
                        );
                        $query = $this->db->insert('cnc_permit_per_establishment_attachments', $fileinsertdata);
                    }


                  // }
                  // foreach ($data['cnc_no'] as $key => $cnc) {

                  // }
                  if ($query) {
                    $msg =  "success";
                  }else {
                    $msg =  "failed";
                  }
                  echo   $msg;
                }
            break;
            case '3':
            $title = 'ecc';
            $path = 'uploads/new_permits/ecc/'.$req_id;
            if ($this->upload_files($title,$path, $_FILES['uploadpermitnewfile']) === FALSE) {
              $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
            }else {

              $file = str_replace(" ","_", $_FILES['uploadpermitnewfile']['name'][0]);
              $year =  date("y");
              $year = substr( $year, -2);
              $fileName = $title.'0-'.$year.'-'.$file;
              $maxid = $this->db->query('SELECT MAX(ecc_no_id) AS `maxid` FROM `ecc_permit_per_establishment`')->row()->maxid;
              if (!empty($data['ecc_no'])) {
                $eccdata = array(
                  'req_id'    => $req_id,
                  'client_id' => $this->session->userdata('client_id'),
                  'ecc_no'    => $data['ecc_no'],
                );
                $query = $this->db->insert('ecc_permit_per_establishment', $eccdata);
              }

              if (!empty($file)) {
                $fileinsertdata = array(
                    'req_id'    => $req_id,
                    'client_id' => $this->session->userdata('client_id'),
                    'file_name' => $fileName,
                    'ecc_no_id' => $maxid + 1,
                  );
                  $query = $this->db->insert('ecc_permit_per_establishment_attachments', $fileinsertdata);
              }



                if ($query) {
                  $msg =  "success";
                }else {
                  $msg =  "failed";
                }
                echo   $msg;

          }
            break;
            case '4':
            // echo "<pre>";print_r($data);exit;
              $title = 'po';
              $path = 'uploads/new_permits/po/'.$req_id;
              if ($this->upload_files($title,$path, $_FILES['uploadpermitnewfile']) === FALSE) {
                $this->my_data['error_file'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
              }else {


              $file = str_replace(" ","_", $_FILES['uploadpermitnewfile']['name'][0]);
              $year =  date("y");
              $year = substr( $year, -2);
              $fileName = $title.'0-'.$year.'-'.$file;
              $maxidpo = $this->db->query('SELECT MAX(po_no_id) AS `maxid` FROM `po_permit_per_establishment`')->row()->maxid;
              if (!empty($data['po_no'])) {
                $podata = array(
                  'req_id'    => $req_id,
                  'client_id' => $this->session->userdata('client_id'),
                  'po_no'     => $data['po_no'],
                );
                $query = $this->db->insert('po_permit_per_establishment', $podata);
              }
              if (!empty($file)) {
                $fileinsertdata = array(
                    'req_id'    => $req_id,
                    'client_id' => $this->session->userdata('client_id'),
                    'file_name' => $fileName,
                    'po_no_id' => $maxidpo + 1,
                  );
                  $query = $this->db->insert('po_permit_per_establishment_attachments', $fileinsertdata);
              }



                  if ($query) {
                    $msg =  "success";
                  }else {
                    $msg =  "failed";
                  }
                  echo   $msg;
              }
            break;

          default:

            break;
        }
      }
    // }
  }
  public function _show_view_2($content)
  {
    if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 3) {
      $this->load->view('admin/nav');
    }else {
        $this->load->view('common/nav');
    }
    $this->load->view('common/header', @$this->my_data);
    if ( ! empty($content))
      $this->load->view($content, @$this->my_data);

    // $this->load->view('common/footer');
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

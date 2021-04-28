<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Serverside extends CI_Controller
{

  public function __construct() {

    parent::__construct();
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->helper('url');
    $this->load->helper('security');
    session_start();

  }

    public function pending_view_est_list(){

        // Database connection info
        $dbDetails = array(
            'host' => '192.168.91.198:3306',
            'user' => 'clientaccess',
            'pass' => 'agentx3mbvii158459',
            'db'   => 'crs'
        );
        // $dbDetails = array(
        //     'host' => $this->session->userdata('hostiis'),
        //     'user' => $this->session->userdata('user'),
        //     'pass' => $this->session->userdata('pass'),
        //     'db'   => 'embis'
        // );

        // DB table to use

        $table ="establishment";

        // Table's primary key

        $primaryKey = 'est_id';


         $columns = array(
          array( 'db' => '`est`.`establishment`', 'dt'   => 'establishment', 'field' => 'establishment'),

          array( 'db' => '`cer`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
          if ($row['status'] == '0') {
            $status  = 'FOR EMB APPROVAL';
          }elseif ($row['status'] == '1') {
            $status  = 'Approved';
          }elseif ($row['status'] == '5') {
            $status  = 'Requested/For Emb Approval';
          } else {
            // print_r($row);
            if ($row['requested'] == 1) {
              $status  = 'Disapproved/Requested';
            }elseif ($row['requested'] == 0) {
              $status  = 'Disapproved';
            }
          }
            return $status;
          }),
          // for province
          array( 'db' => '`ct`.`name`', 'dt'   => 'name', 'field' => 'name'),
          array( 'db' => '`brgy`.`name`', 'dt'   => 'name', 'field' => 'name'),
          array( 'db' => '`pl`.`name`', 'dt'     => 'name', 'field' => 'name', 'formatter'=>function($x,$row){
            $address = array(
              'prov_name' => $row['name'],
              'city_name' => $row['2'],
              'brgy_name' => $row['3'],
             );
             // echo "<pre>";print_r($address);
            return $address;
          }),
          // for city
          // array( 'db' => '`pl`.`name`', 'dt'     => '2', 'field' => 'name', 'formatter'=>function($x,$row){
          //   return $row['3'];
          // }),
          // // for barrangay
          // array( 'db' => '`pl`.`name`', 'dt'     => '3', 'field' => 'name', 'formatter'=>function($x,$row){
          //     return $row['4'];
          // }),

          // array( 'db' => '`est`.`est_id`', 'dt'   => 'est_id', 'field' => 'est_id','formatter'=>function($x,$row){
          //     return $this->encrypt->encode($row['est_id']);
          //   }),
          // array( 'db' => '`cer`.`est_ext_id`', 'dt'   => 'est_ext_id', 'field' => 'est_ext_id'),

          array( 'db' => '`est`.`est_id`', 'dt'   => 'est_id', 'field' => 'est_id'),
          array( 'db' => '`cer`.`req_id`', 'dt'   => 'req_id', 'field' => 'req_id'),
          array( 'db' => '`est`.`client_id`', 'dt'   => 'client_id', 'field' => 'client_id'),
          array( 'db' => '`est`.`est_street`', 'dt'   => 'est_street', 'field' => 'est_street'),
          array( 'db' => '`est`.`est_barangay`', 'dt'   => 'est_barangay', 'field' => 'est_barangay'),
          array( 'db' => '`est`.`est_province`', 'dt'    => 'est_province', 'field' => 'est_province'),
          array( 'db' => '`est`.`est_city`', 'dt'    => 'est_city', 'field' => 'est_city'),

          array( 'db' => '`est`.`plant_manager`', 'dt'    => 'plant_manager', 'field' => 'plant_manager'),
          array( 'db' => '`est`.`plant_manager_phone_no`', 'dt'    => 'plant_manager_phone_no', 'field' => 'plant_manager_phone_no'),
          array( 'db' => '`est`.`pollution_officer`', 'dt'    => 'pollution_officer', 'field' => 'pollution_officer'),
          array( 'db' => '`est`.`pollution_officer_phone_no`', 'dt'    => 'pollution_officer_phone_no', 'field' => 'pollution_officer_phone_no'),
          array( 'db' => '`est`.`pollution_officer_fax_no`', 'dt'    => 'pollution_officer_fax_no', 'field' => 'pollution_officer_fax_no'),
          array( 'db' => '`est`.`pollution_officer_email`', 'dt'    => 'pollution_officer_email', 'field' => 'pollution_officer_email'),
          array( 'db' => '`est`.`date_created`', 'dt'    => 'date_created', 'field' => 'date_created'),
          array( 'db' => '`cer`.`requested`', 'dt'   => 'requested', 'field' => 'requested'),
          );
                    // print_r($columns);exit;

        // Include SQL query processing class

          $this->load->view('common/ssp.customized.class.php');



          $joinQuery  = "FROM crs.client_est_requests as cer
          LEFT JOIN crs.establishment as est ON cer.req_id = est.cnt
          LEFT JOIN embis.dms_province AS pl ON pl.id = est.est_province
          LEFT JOIN embis.dms_city as ct ON ct.id = est.est_city
          LEFT JOIN embis.dms_barangay as brgy ON brgy.id = est.est_barangay
          ";
          // $joinQuery  = "FROM crs.client_est_requests as cer
          // LEFT JOIN crs.establishment as est ON cer.est_id = est.est_id
          // LEFT JOIN embis.dms_province AS pl ON pl.id = est.est_province
          // LEFT JOIN embis.dms_city as ct ON ct.id = est.est_city
          // LEFT JOIN embis.dms_barangay as brgy ON brgy.id = est.est_barangay
          // ";
          // $joinQuery  = "FROM crs.establishment as est";

          $extraWhere = 'cer.client_id = "'.$this->session->userdata('client_id').'" AND cer.deleted = "0" AND cer.status != 1';
          // echo $extraWhere;
          // .$this->session->userdata('user_id').
            // $extraWhere = '';
            // echo $extraWhere;exit;
          $groupBy = 'cer.req_id';
          $having = null;
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
    public function approved_view_est_list(){

        // Database connection info
        // $dbDetails = array(
        //   'host' => $this->session->userdata('host'),
        //   'user' => $this->session->userdata('user'),
        //   'pass' => $this->session->userdata('pass'),
        //   'db'   => 'embis'
        // );
        $dbDetails = array(
          'host' => '192.168.91.198:3306',
          'user' => 'clientaccess',
          'pass' => 'agentx3mbvii158459',
          'db'   => 'embis'
        );

        // DB table to use

        $table ="dms_company";

        // Table's primary key

        $primaryKey = 'cnt';


         $columns = array(
              array( 'db' => '`dcomp`.`input_date`', 'dt'      => 'input_date', 'field' => 'input_date','formatter' => function($x, $row){
                // echo $row['input_date'];exit;
                  $newDate = date("F-d-Y", strtotime($row['input_date']));
                  return $newDate;
                }),
              array( 'db' => '`dcomp`.`emb_id`', 'dt'          => 'emb_id', 'field' => 'emb_id'),
              array( 'db' => '`dcomp`.`company_id`', 'dt'          => 'company_id', 'field' => 'company_id'),
              array( 'db' => '`dcomp`.`company_name`', 'dt'    => 'company_name', 'field' => 'company_name'),
              array( 'db' => '`dcomp`.`street`', 'dt'          => 'street', 'field' => 'street'),
              array( 'db' => '`dcomp`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
              array( 'db' => '`dcomp`.`city_name`', 'dt'       => 'city_name', 'field' => 'city_name'),
              array( 'db' => '`dcomp`.`province_name`', 'dt'   => 'province_name', 'field' => 'province_name'),
              // array( 'db' => '`dcomp`.`status`', 'dt'          => 'status', 'field' => 'status'),
                array( 'db' => 'dcomp.status', 'dt'   => 'status' , 'field' => 'status', 'formatter' => function($x, $row){
                  if ($row['status'] == 0) {
                    $status = 'ACTIVE';
                  }else {
                    $status = 'INACTIVE';
                  }
                  return $status;
                  }),
                    array( 'db' => '`acr`.`req_id`', 'dt'   => 'req_id', 'field' => 'req_id'),
              // array( 'db' => '`fc`.`facility_id`', 'dt'    => 'facility_id', 'field' => 'facility_id','formatter'=>function($x,$row){
              //
              //   return $this->encrypt->encode($row['facility_id']);
              //   }),

          );
                    // print_r($columns);exit;

        // Include SQL query processing class

            $this->load->view('common/ssp.customized.class.php');

          // "SELECT dp.client_id
          // //     , dp.company_id
          // //     , dc.company_name
          // //     , dc.company_id
          // // FROM dms_personnel dp
          // // LEFT JOIN dms_company dc
          // //     on dp.company_id = dc.company_id WHERE dp.client_id = ".$this->session->userdata('user_id').""

          $joinQuery  = "FROM embis.approved_client_req   acr
          LEFT JOIN dms_company dcomp on dcomp.company_id = acr.company_id
          ";
          $extraWhere = "acr.client_id ='".$this->session->userdata('client_id')."' AND acr.deleted = 0";
          // $groupBy = 'dcomp.emb_id';
          $groupBy = '';
          $having = null;
          // echo $this->db->last_query();
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
    // for admin
    public function admin_pending_view_est_list(){

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
            'db'   => 'crs'
        );

        // DB table to use

        $table ="establishment";

        // Table's primary key

        $primaryKey = 'est_id';


         $columns = array(
          array( 'db' => '`est`.`establishment`', 'dt'   => 'establishment', 'field' => 'establishment'),

          array( 'db' => '`cer`.`status`', 'dt'     => 'status', 'field' => 'status', 'formatter'=>function($x,$row){
          if ($row['status'] == '0') {
            $status  = 'FOR EMB APPROVAL';
          }elseif ($row['status'] == '1') {
            $status  = 'Approved';
          }elseif ($row['status'] == '5') {
            $status  = 'Requested/For Emb Approval';
          } else {
            $status  = 'Disapproved';
          }
            return $status;
          }),
          // for province
          array( 'db' => '`ct`.`name`', 'dt'   => 'name', 'field' => 'name'),
          array( 'db' => '`brgy`.`name`', 'dt'   => 'name', 'field' => 'name'),
          array( 'db' => '`pl`.`name`', 'dt'     => 'name', 'field' => 'name', 'formatter'=>function($x,$row){
            $address = array(
              'prov_name' => $row['name'],
              'city_name' => $row['2'],
              'brgy_name' => $row['3'],
             );
             // echo "<pre>";print_r($address);
            return $address;
          }),
          // for city
          // array( 'db' => '`pl`.`name`', 'dt'     => '2', 'field' => 'name', 'formatter'=>function($x,$row){
          //   return $row['3'];
          // }),
          // // for barrangay
          // array( 'db' => '`pl`.`name`', 'dt'     => '3', 'field' => 'name', 'formatter'=>function($x,$row){
          //     return $row['4'];
          // }),

          // array( 'db' => '`est`.`est_id`', 'dt'   => 'est_id', 'field' => 'est_id','formatter'=>function($x,$row){
          //     return $this->encrypt->encode($row['est_id']);
          //   }),
          // array( 'db' => '`cer`.`est_ext_id`', 'dt'   => 'est_ext_id', 'field' => 'est_ext_id'),
          array( 'db' => '`est`.`est_id`', 'dt'   => 'est_id', 'field' => 'est_id'),
          array( 'db' => '`cer`.`req_id`', 'dt'   => 'req_id', 'field' => 'req_id'),
          array( 'db' => '`est`.`client_id`', 'dt'   => 'client_id', 'field' => 'client_id'),
          array( 'db' => '`est`.`est_street`', 'dt'   => 'est_street', 'field' => 'est_street'),
          array( 'db' => '`est`.`est_barangay`', 'dt'   => 'est_barangay', 'field' => 'est_barangay'),
          array( 'db' => '`est`.`est_province`', 'dt'    => 'est_province', 'field' => 'est_province'),
          array( 'db' => '`est`.`est_city`', 'dt'    => 'est_city', 'field' => 'est_city'),

          array( 'db' => '`est`.`plant_manager`', 'dt'    => 'plant_manager', 'field' => 'plant_manager'),
          array( 'db' => '`est`.`plant_manager_phone_no`', 'dt'    => 'plant_manager_phone_no', 'field' => 'plant_manager_phone_no'),
          array( 'db' => '`est`.`pollution_officer`', 'dt'    => 'pollution_officer', 'field' => 'pollution_officer'),
          array( 'db' => '`est`.`pollution_officer_phone_no`', 'dt'    => 'pollution_officer_phone_no', 'field' => 'pollution_officer_phone_no'),
          array( 'db' => '`est`.`pollution_officer_fax_no`', 'dt'    => 'pollution_officer_fax_no', 'field' => 'pollution_officer_fax_no'),
          array( 'db' => '`est`.`pollution_officer_email`', 'dt'    => 'pollution_officer_email', 'field' => 'pollution_officer_email'),
          array( 'db' => '`est`.`date_created`', 'dt'    => 'date_created', 'field' => 'date_created'),
          );
                    // print_r($columns);exit;

        // Include SQL query processing class

          $this->load->view('common/ssp.customized.class.php');



          $joinQuery  = "FROM crs.client_est_requests as cer
          LEFT JOIN crs.establishment as est ON cer.est_id = est.est_id
          LEFT JOIN embis.dms_province AS pl ON pl.id = est.est_province
          LEFT JOIN embis.dms_city as ct ON ct.id = est.est_city
          LEFT JOIN embis.dms_barangay as brgy ON brgy.id = est.est_barangay
          ";
          // $joinQuery  = "FROM crs.establishment as est";

          $extraWhere = 'est.est_region = "'.$this->session->userdata('region').'" AND cer.deleted = "0" AND cer.status IN ("0","2","5")';
          // echo $extraWhere;
          // .$this->session->userdata('user_id').
            // $extraWhere = '';
            // echo $extraWhere;exit;
          $groupBy = '';
          $having = null;
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
    public function admin_approved_view_est_list(){

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
            'db'   => 'embis'
        );

        // DB table to use

        $table ="dms_company";

        // Table's primary key

        $primaryKey = 'cnt';


         $columns = array(
              array( 'db' => '`acc`.`first_name`', 'dt'      => 'client_name', 'field' => 'first_name','formatter'=>function($x,$row){
                  return $row['first_name'].' '.$row['last_name'];
                }),
              array( 'db' => '`acc`.`last_name`', 'dt'      => 'last_name', 'field' => 'last_name'),
              array( 'db' => '`dcomp`.`input_date`', 'dt'      => 'input_date', 'field' => 'input_date'),
              array( 'db' => '`dcomp`.`emb_id`', 'dt'          => 'emb_id', 'field' => 'emb_id'),
              array( 'db' => '`dcomp`.`company_name`', 'dt'    => 'company_name', 'field' => 'company_name'),
              array( 'db' => '`dcomp`.`street`', 'dt'          => 'street', 'field' => 'street'),
              array( 'db' => '`dcomp`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
              array( 'db' => '`dcomp`.`city_name`', 'dt'       => 'city_name', 'field' => 'city_name'),
              array( 'db' => '`dcomp`.`province_name`', 'dt'   => 'province_name', 'field' => 'province_name'),
              // array( 'db' => '`dcomp`.`status`', 'dt'          => 'status', 'field' => 'status'),
                array( 'db' => 'dcomp.status', 'dt'   => 'status' , 'field' => 'status', 'formatter' => function($x, $row){
                  if ($row['status'] == 0) {
                    $status = 'ACTIVE';
                  }else {
                    $status = 'INACTIVE';
                  }
                  return $status;
                  }),
              //   }),

          );
                    // print_r($columns);exit;

        // Include SQL query processing class

            $this->load->view('common/ssp.customized.class.php');
          $joinQuery  = "FROM embis.approved_client_req   acr
          LEFT JOIN dms_company dcomp on dcomp.company_id = acr.company_id
          LEFT JOIN crs.acc acc on acc.client_id = acr.client_id
          ";
          $embisdb = $this->load->database('embis',TRUE);
          $where1 = array('rgnid' => $this->session->userdata('region'), );
          $rgnum = $embisdb->select('rg.rgnnum')->from('acc_region as rg')->where($where1)->get()->result_array();
          $extraWhere = "dcomp.region_name ='".$rgnum[0]['rgnnum']."'";
          $groupBy = '';
          $having = null;
          // echo $this->db->last_query();
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
    public function user_list(){

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => 'crs'
        );

        // DB table to use

        $table ="acc";

        // Table's primary key

        $primaryKey = 'client_id';


         $columns = array(
          array( 'db' => '`acc`.`last_name`', 'dt'      => 'last_name', 'field' => 'last_name'),
          array( 'db' => '`acc`.`region`', 'dt'      => 'region', 'field' => 'region'),
          array( 'db' => '`acc`.`first_name`', 'dt'      => 'client_name', 'field' => 'first_name','formatter'=>function($x,$row){
            return $row['first_name'].' '.$row['last_name'];
          }),
          array( 'db' => '`acc`.`raw_password`', 'dt'      => 'raw_password', 'field' => 'raw_password','formatter'=>function($x,$row){
            return $this->encrypt->decode($row['raw_password']);
          }),
          array( 'db' => '`acc`.`email`', 'dt'          => 'email', 'field' => 'email'),
          array( 'db' => '`acc`.`client_id`', 'dt'          => 'client_id', 'field' => 'client_id'),
          array( 'db' => '`acc`.`username`', 'dt'          => 'username', 'field' => 'username'),
            array( 'db' => '`res`.`status`', 'dt'      => 'status', 'field' => 'status','formatter'=>function($x,$row){
              if ($row['status'] == '' || $row['status'] == 0) {
                $status = 'pending';
              }else {
              $status = 'sent';
              }
              return $status;
            }),
          );
                    // print_r($columns);exit;

        // Include SQL query processing class

            $this->load->view('common/ssp.customized.class.php');
          $joinQuery  = "FROM crs.acc acc LEFT JOIN crs.resend_email as res ON res.client_id = acc.client_id";

          // $embisdb = $this->load->database('embis',TRUE);
          // $where1 = array('rgnid' => $this->session->userdata('region'), );
          // $rgnum = $embisdb->select('rg.rgnnum')->from('acc_region as rg')->where($where1)->get()->result_array();
          $extraWhere = "deleted = 0";
          $groupBy = '';
          $having = null;
          // echo $this->db->last_query();
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
    public function resend_hwms_credentials(){

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
            'db'   => 'embis'
        );

        // DB table to use

        $table ="approved_client_req";

        // Table's primary key

        $primaryKey = 'client_req_id';


         $columns = array(
          array( 'db' => '`acr`.`client_req_id`', 'dt'      => 'client_req_id', 'field' => 'client_req_id'),
          array( 'db' => '`dcomp`.`emb_id`', 'dt'      => 'emb_id', 'field' => 'emb_id'),
          array( 'db' => '`dcomp`.`company_name`', 'dt'      => 'company_name', 'field' => 'company_name'),
          array( 'db' => '`acc`.`first_name`', 'dt'      => 'first_name', 'field' => 'first_name'),
          array( 'db' => '`acc`.`email`', 'dt'      => 'email', 'field' => 'email'),
          array( 'db' => '`acc`.`last_name`', 'dt'      => 'client_name', 'field' => 'last_name','formatter'=>function($x,$row){
            return $row['first_name'].' '.$row['last_name'];
          }),
          array( 'db' => '`rhc`.`status`', 'dt'      => 'status', 'field' => 'status','formatter'=>function($x,$row){
            if ($row['status'] == '' || $row['status'] == 0) {
              $status = 'pending';
            }else {
            $status = 'sent';
            }
            return $status;
          }),
          );
                    // print_r($columns);exit;

        // Include SQL query processing class

            $this->load->view('common/ssp.customized.class.php');
          $joinQuery  = "FROM approved_client_req as acr
                        LEFT JOIN crs.acc as acc ON acc.client_id = acr.client_id
                        LEFT JOIN embis.dms_company as dcomp ON acr.company_id = dcomp.company_id
                        LEFT JOIN crs.resend_hwms_credentials as rhc ON rhc.req_id = acr.req_id
                          ";

          // $embisdb = $this->load->database('embis',TRUE);
          // $where1 = array('rgnid' => $this->session->userdata('region'), );
          // $rgnum = $embisdb->select('rg.rgnnum')->from('acc_region as rg')->where($where1)->get()->result_array();
          $extraWhere = "acr.deleted = 0 AND  acc.first_name='Ailene'";
          $groupBy = '';
          $having = null;
          // echo $this->db->last_query();
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
    public function co_user_list(){

        // Database connection info
        $dbDetails = array(
          'host' => $this->session->userdata('host'),
          'user' => $this->session->userdata('user'),
          'pass' => $this->session->userdata('pass'),
          'db'   => 'crs'
        );

        // DB table to use

        $table ="acc";

        // Table's primary key

        $primaryKey = 'client_id';


         $columns = array(
          array( 'db' => '`acc`.`last_name`', 'dt'      => 'last_name', 'field' => 'last_name'),
          array( 'db' => '`acc`.`first_name`', 'dt'      => 'client_name', 'field' => 'first_name','formatter'=>function($x,$row){
            return $row['first_name'].' '.$row['last_name'];
          }),
          array( 'db' => '`acc`.`raw_password`', 'dt'      => 'raw_password', 'field' => 'raw_password','formatter'=>function($x,$row){
            return $this->encrypt->decode($row['raw_password']);
          }),
          array( 'db' => '`acc`.`email`', 'dt'          => 'email', 'field' => 'email'),
          array( 'db' => '`acc`.`client_id`', 'dt'          => 'client_id', 'field' => 'client_id'),
          array( 'db' => '`acc`.`username`', 'dt'          => 'username', 'field' => 'username'),
            array( 'db' => '`res`.`status`', 'dt'      => 'status', 'field' => 'status','formatter'=>function($x,$row){
              if ($row['status'] == '' || $row['status'] == 0) {
                $status = 'pending';
              }else {
              $status = 'sent';
              }
              return $status;
            }),
            array( 'db' => '`acc`.`verified`', 'dt'      => 'verified', 'field' => 'verified','formatter'=>function($x,$row){
              if ($row['status'] == '' || $row['status'] == 0) {
                $acc_status = 'verified';
              }else {
              $acc_status = 'unverified';
              }
              return $acc_status;
            }),
          );
                    // print_r($columns);exit;

        // Include SQL query processing class

          $this->load->view('common/ssp.customized.class.php');
          $joinQuery  = "FROM crs.acc acc LEFT JOIN crs.resend_email as res ON res.client_id = acc.client_id";

          // $embisdb = $this->load->database('embis',TRUE);
          // $where1 = array('rgnid' => $this->session->userdata('region'), );
          // $rgnum = $embisdb->select('rg.rgnnum')->from('acc_region as rg')->where($where1)->get()->result_array();
          $extraWhere = "acc.verified = 1 AND deleted = 0";
          $groupBy = '';
          $having = null;
          // echo $this->db->last_query();
        echo json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
        );
        $this->load->database();
        $this->db->close();
    }
    public function add_main_company_list(){
          $dbDetails = array(
            // 'host' => $this->session->userdata('host'),
            // 'user' => $this->session->userdata('user'),
            // 'pass' => $this->session->userdata('pass'),
            'host' => '192.168.91.198:3306',
            'user' => 'clientaccess',
            'pass' => 'agentx3mbvii158459',
            'db'   => 'embis'
          );
          $table ="dms_company";
          $primaryKey = 'cnt';
           $columns = array(
               array( 'db' => '`dc`.`company_type`', 'dt'   => 'company_type', 'field' => 'company_type'),
                array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
                array( 'db' => '`dc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
                array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
                array( 'db' => '`dc`.`city_name`', 'dt'   => 'city_name', 'field' => 'city_name'),
                  array( 'db' => '`dc`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
              // array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name'),
              array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name','formatter'=>function($x,$row){


                return $row['province_name'].','.$row['city_name'].','.$row['barangay_name'];
                }),
            );

              $this->load->view('common/ssp.customized.class.php');
            $joinQuery="FROM embis.dms_company AS dc";
            if($_GET['region']) {
              $extraWhere = 'dc.region_name  = "'.$_GET['region'].'" AND dc.deleted  = 0';
            }else {
              $extraWhere = 'dc.deleted  = 0 ';
             }
            $groupBy = '';
            $having = null;

          echo json_encode(
              SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
          );
          $this->load->database();
          $this->db->close();
      }
      public function select_existing_company(){
            $dbDetails = array(
              // 'host' => $this->session->userdata('host'),
              // 'user' => $this->session->userdata('user'),
              // 'pass' => $this->session->userdata('pass'),
              'host' => '192.168.91.198:3306',
              'user' => 'clientaccess',
              'pass' => 'agentx3mbvii158459',
              'db'   => 'embis'
            );
            $table ="dms_company";
            $primaryKey = 'cnt';
             $columns = array(
                 array( 'db' => '`dc`.`company_type`', 'dt'   => 'company_type', 'field' => 'company_type'),
                  array( 'db' => '`dc`.`company_id`', 'dt'   => 'company_id', 'field' => 'company_id'),
                  array( 'db' => '`dc`.`emb_id`', 'dt'   => 'emb_id', 'field' => 'emb_id'),
                  array( 'db' => '`dc`.`company_name`', 'dt'   => 'company_name', 'field' => 'company_name'),
                  array( 'db' => '`dc`.`city_name`', 'dt'   => 'city_name', 'field' => 'city_name'),
                    array( 'db' => '`dc`.`barangay_name`', 'dt'   => 'barangay_name', 'field' => 'barangay_name'),
                // array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name'),
                array( 'db' => '`dc`.`province_name`', 'dt'    => 'province_name', 'field' => 'province_name','formatter'=>function($x,$row){


                  return $row['province_name'].','.$row['city_name'].','.$row['barangay_name'];
                  }),
              );

                $this->load->view('common/ssp.customized.class.php');
              $joinQuery="FROM embis.dms_company AS dc";


              if ($this->session->userdata('selected_company') != '') {
                if ($_GET['selected_company'] == 1) {
                  $extraWhere = 'dc.deleted  = 0';
                }else {
                    $extraWhere = 'dc.company_id  = "'.$this->session->userdata('selected_company').'" AND dc.deleted  = 0';
                }
              }else {
                  $extraWhere = 'dc.region_name  = "'.$this->session->userdata('selected_region').'" AND dc.deleted  = 0';
               }
              $groupBy = '';
              $having = null;
            echo json_encode(
                SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
            );
            $this->load->database();
            $this->db->close();
        }
}

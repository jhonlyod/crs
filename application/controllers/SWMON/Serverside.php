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
    $this->load->database();
    $this->load->model('SWM_model');
    session_start();

  }

  public function getsweetdata(){

      // Database connection info
      $dbDetails = array(
          'host' => '192.168.91.198:3306',
          'user' => 'clientaccess',
          'pass' => 'agentx3mbvii158459',
          'db'   => 'embis'
      );

      // DB table to use

      $table ="sweet_form";

      // Table's primary key

      $primaryKey = 'cnt';

      // Array of database columns which should be read and sent back to DataTables.
      // The `db` parameter represents the column name in the database.
      // The `dt` parameter represents the DataTables column identifier.x

       $columns = array(
                       array( 'db' => '`sf`.`trans_no`', 'dt' => 0, 'field' => 'trans_no','formatter'=>function($x,$row){
                         return $this->encrypt->encode($row['trans_no']);
                       }),
                      array( 'db' => '`sf`.`trans_no`', 'dt' => 1, 'field' => 'trans_no','formatter'=>function($x,$row){
                        return $row['trans_no'];
                      }),
                      array( 'db' => '`sf`.`report_number`', 'dt' => 'report_number', 'field' => 'report_number','formatter'=>function($x,$row){
                        return $row['report_number'];
                      }),
                      array( 'db' => '`sf`.`cnt`', 'dt' => 'cnt', 'field' => 'cnt','formatter'=>function($x,$row){
                        return $row['cnt'];
                      }),
                      array( 'db' => '`sf`.`lgu_patrolled_name`', 'dt' => 'lgu_patrolled_name', 'field' => 'lgu_patrolled_name'),
                      array( 'db' => '`sf`.`barangay_name`', 'dt' => 'barangay_name', 'field' => 'barangay_name'),
                      array( 'db' => '`sf`.`report_type`', 'dt' => 'report_type', 'field' => 'report_type'),
                      array( 'db' => '`sf`.`date_patrolled`', 'dt' => 'date_patrolled', 'field' => 'date_patrolled'),
                      array( 'db' => '`sf`.`time_patrolled`', 'dt' => 'time_patrolled', 'field' => 'time_patrolled','formatter'=>function($x,$row){
                        $datepatrolled = date('F d, Y', strtotime($row['date_patrolled']));
                        $timepatrolled = date('h:ia', strtotime($row['time_patrolled']));
                        return $datepatrolled.' - '.$timepatrolled;
                      }),
                      array( 'db' => '`sf`.`status`', 'dt' => 'status', 'field' => 'status'),
                  );

      // Include SQL query processing class

        $this->load->view('common/ssp.customized.class.php');

        $joinQuery  = "FROM embis.sweet_form_log AS sf LEFT JOIN embis.er_transactions AS et ON et.token = sf.trans_no";
        $extraWhere = "et.status != 0 AND ";
          $getalllguswm = $this->SWM_model->getalllguswm();
          $maxsize = sizeof($getalllguswm);
          $concatwhere = '';
          $counter = 0;
          for ($i=0; $i < sizeof($getalllguswm); $i++) {
            if($getalllguswm[$i]['lgu_patrolled_id'] != ''){
              $conwhr = ((!empty($getalllguswm[$i]['lgu_patrolled_id']) AND $counter == $maxsize) OR ($counter == '0')) ? '' : ' OR ';
              $concatwhere .= $conwhr."sf.lgu_patrolled_id = '".$getalllguswm[$i]['lgu_patrolled_id']."'";
              $counter++;
            }
          }
        $extraWhere .= " (".$concatwhere.")";

        $groupBy    = "";
        $having     = null;

      echo json_encode(
          SSP::simple($_POST, $dbDetails, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
      );

  }
}

<?php
/**
 *
 */
class SWM_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    session_start();
  }

  function checkifhaslguswm()
	{
    $embisdb = $this->load->database('embis',TRUE);
    $queryest = $embisdb->select('dc.emb_id')->from('approved_client_req AS acr')->join('dms_company as dc','dc.company_id = acr.company_id')->where('acr.client_id = "'.$this->session->userdata('client_id').'" AND acr.deleted = 0')->get()->result_array();
    $cntr = 0;
    for ($e=0; $e < sizeof($queryest); $e++) {
      if($cntr == 0){
        $queryifhas_swmreport = $embisdb->select('sf.lgu_patrolled_id')->from('sweet_form AS sf')->where('sf.lgu_patrolled_id = "'.$queryest[$e]['emb_id'].'" GROUP BY sf.lgu_patrolled_id')->get()->result_array();
        if(!empty($queryifhas_swmreport[0]['lgu_patrolled_id'])){
          $cntr++;
          $lgu_patrolled_id = $queryifhas_swmreport[0]['lgu_patrolled_id'];
        }else{
          $lgu_patrolled_id = '';
        }
      }
    }
    return $lgu_patrolled_id;
  }

  function getalllguswm()
	{
    $embisdb = $this->load->database('embis',TRUE);
    $queryest = $embisdb->select('dc.emb_id')->from('embis.approved_client_req AS acr')->join('embis.dms_company as dc','dc.company_id = acr.company_id')->where('acr.client_id = "'.$this->session->userdata('client_id').'" AND acr.deleted = 0')->get()->result_array();
    $concatwhere = '';
    for ($e=0; $e < sizeof($queryest); $e++) {
      $concat = ($e != 0) ? ' OR ': '';
      $concatwhere .= $concat.'sf.lgu_patrolled_id = "'.$queryest[$e]['emb_id'].'"';
    }
    $queryifhas_swmreport = $embisdb->select('sf.lgu_patrolled_id')->from('embis.sweet_form AS sf')->where(''.$concatwhere.' GROUP BY sf.lgu_patrolled_id')->get()->result_array();
    return $queryifhas_swmreport;
  }

  function insertdata($table,$data){
    if (!empty($data)) {
      $this->db->set($data);
    }
    if (!empty($table)) {
    $result =  $this->db->insert($table);
    }
    return $result;
    $this->db->close();
  }

  function selectdata($table = '' ,$select = '', $where = '' ){
     if (!empty($select)) {
       $this->db->select($select);
     }
     if (!empty($where)) {
       $this->db->where($where);
     }

     if (!empty($table)) {
       $this->db->from($table);
     }

     $query  = $this->db->get();
     $result = $query->result_array();
     $count  = count($result);
     // echo $this->db->last_query();
     // exit;
     if(empty($count)){
          return false;
      }
      else{
          return $result;
      }
      $this->db->close();
  }

  function updatedata($data,$table,$where){
    if (!empty($data)) {
      $this->db->set($data);
    }
    if (!empty($where)) {
    $this->db->where($where);
    }
    if (!empty($table)) {
      $result = $this->db->update($table);
    }
    return $result;
    $this->db->close();
  }

  function deletedata($table,$where){
    if (!empty($where)) {
    $this->db->where($where);
    }
    if (!empty($table)) {
      $result = $this->db->delete($table);
    }
    return $result;
    $this->db->close();
  }
}

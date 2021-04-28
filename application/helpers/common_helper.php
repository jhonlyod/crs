<?php


/**
 *
 */

function regions(){
  $sTag = "";
  $CI =& get_instance();
  $embisdb = $CI->load->database('embis', TRUE);
  $query = $embisdb->select('*')->from('acc_region as acreg')->where('rgnid !=','18')->get()->result_array();
  return $query;
}

function province($rgnnum = ''){
  $sTag = "";
  $CI =& get_instance();
  $embisdb = $CI->load->database('embis', TRUE);
  $queryrgn = $embisdb->select('rgnid')->from('acc_region')->where('rgnnum',$rgnnum)->get()->result_array();

  $where_rgn2= array('region_id' => $queryrgn[0]['rgnid'], );
  $query = $embisdb->select('*')->from('dms_province')->where($where_rgn2)->get()->result_array();
  return $query;
}

function city($province_id = ''){
  $sTag = "";
  $CI =& get_instance();
  $embisdb = $CI->load->database('embis', TRUE);
  $query = $embisdb->select('*')->from('dms_city')->where('province_id',$province_id)->get()->result_array();
  return $query;
}

function baranggay($city_id = ''){
  $sTag = "";
  $CI =& get_instance();
  $embisdb = $CI->load->database('embis', TRUE);
  $where_city= array('city_id' => $city_id, );
  $query = $embisdb->select('*')->from('dms_barangay')->where($where_city)->get()->result_array();
  return $query;
}


function all_companies(){
  $sTag = "";
  $CI =& get_instance();
  $embisdb = $CI->load->database('embis', TRUE);
  $query = $embisdb->select('company_name,company_id')->from('dms_company')->limit(5)->get()->result_array();
  return $query;
}

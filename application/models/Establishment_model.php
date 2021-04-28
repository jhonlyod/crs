<?php
/**
 *
 */
class Establishment_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->tbl_name = 'establishment';
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    $this->load->model('My_model','mm');
        session_start();
  }

  function save_establishment_data($data='')
	{
		if ( ! empty($data))
		{
			$est_id = '';
			if (!empty($data['est_id']) && $data['est_id'] != '')
				$est_id = $data['est_id'];
        if ($data['est-type'] == 'main') {
          $main_comp_id = 0;
        }elseif($data['est-type'] == 'branch') {
          	$main_comp_id = $data['main_company_id'];
        }
      $this->db->set('main_company_id',  $main_comp_id);
      $this->db->set('establishment', $data['establishment']);
      $this->db->set('project_type',  $data['project_type']);
      $this->db->set('comp_tel',  $data['comp_tel']);
      $this->db->set('comp_email',  $data['comp_email']);
			$this->db->set('est_street', $data['est_street']);
      $this->db->set('est_region', $data['est_region']);
      $this->db->set('est_province', $data['est_province']);
      $this->db->set('est_city',$data['est_city']);
			$this->db->set('est_barangay', $data['est_barangay']);
			$this->db->set('psi_code_no', $data['psi_code_no']);
			$this->db->set('psi_descriptor', $data['psi_descriptor']);
			$this->db->set('ceo_first_name', $data['ceo_first_name']);
			$this->db->set('ceo_last_name', $data['ceo_last_name']);
			$this->db->set('ceo_mi', $data['ceo_mi']);
			$this->db->set('ceo_sufx', $data['ceo_sufx']);
			$this->db->set('ceo_phone_no', $data['ceo_phone_no']);
			$this->db->set('ceo_fax_no', $data['ceo_fax_no']);
			$this->db->set('ceo_email', $data['ceo_email']);
			$this->db->set('plant_manager', $data['plant_manager']);
			$this->db->set('plant_manager_coa_no', $data['plant_manager_coa_no']);
			$this->db->set('plant_manager_phone_no', $data['plant_manager_phone_no']);
			$this->db->set('plant_manager_fax_no', $data['plant_manager_fax_no']);
			$this->db->set('plant_manager_email', $data['plant_manager_email']);
			$this->db->set('plant_manager_mobile_no',  $data['plant_manager_mobile_no']);
			$this->db->set('pollution_officer', $data['pollution_officer']);
			$this->db->set('pollution_officer_coa_no', $data['pollution_officer_coa_no']);
			$this->db->set('pollution_officer_phone_no', $data['pollution_officer_phone_no']);
			$this->db->set('pollution_officer_fax_no', $data['pollution_officer_fax_no']);
			$this->db->set('pollution_officer_email', $data['pollution_officer_email']);
      $this->db->set('pollution_officer_mobile_no',  $data['pollution_officer_mobile_no']);
      $this->db->set('managing_head', $data['managing_head']);
      $this->db->set('managing_head_email', $data['managing_head_email']);
      $this->db->set('managing_head_tel_no', $data['managing_head_tel_no']);
      $this->db->set('managing_head_fax_no', $data['managing_head_fax_no']);
      $this->db->set('managing_head_mobile_no', $data['managing_head_mobile_no']);
      $this->db->set('dp_num',   $data['dp_num']);
      $this->db->set('po_num',   $data['po_num']);
      $this->db->set('ecc_num',  $data['ecc_num']);
			$this->db->set('est_certification', $data['est_certification']);
			$this->db->set('certified_doc', $data['certified_doc']);
			$this->db->set('date_modified', date('Y-m-d H:i:s'));
      $this->db->set('longitude', $data['longitude']);
      $this->db->set('latitude', $data['latitude']);


			if ($est_id && !empty($est_id))
			{
				$this->db->where('est_id', $est_id);
				$this->db->update($this->tbl_name);
        $this->db->set('status', 0);
        $this->db->where('est_id', $est_id);
        $this->db->where('client_id', $this->session->userdata('client_id'));
        $this->db->update('client_est_requests');
			}
			else
			{
				$this->db->set('client_id', $this->session->userdata('client_id'));
				$this->db->set('date_created', date('Y-m-d H:i:s'));
        $count_max_id = $this->db->select('cnt')->order_by('cnt','desc')->limit(1)->get('establishment')->row('cnt');
        $this->db->set('est_id', $count_max_id + 1);
				$this->db->insert($this->tbl_name);
        $est_id = $this->db->insert_id();
        $this->db->set('system_inquery',  $data['system_inquery_type']);
        $this->db->set('date_submitted', date('Y-m-d H:i:s'));
        $this->db->set('client_id', $this->session->userdata('client_id'));
        $this->db->set('est_id', $count_max_id + 1);
        $this->db->set('status', 0);
        $this->db->set('requested', 0);
        $this->db->set('deleted', 0);
        $query2 = $this->db->insert('client_est_requests');
			}
			return $est_id;
		}

		return FALSE;
	}

  function validate_id($company_id){
    // public function getRows($table,$options = array(),$result = 'array'){
    $options = array(
      'where' => 'est.cnt='.$company_id.' AND est.client_id='.$this->session->userdata('client_id').'',
      'select'=>'est.cnt,est.client_id'
    );
    $query = $this->mm->getRows('establishment as est',$options,'count');
    return $query;
  }

  function save_establishment_data_v2($data='',$company_id = '')
  {
      if ( ! empty($data))
      {
        $est_id = '';

        if (!empty($company_id) && $company_id != ''){
          $est_id = $company_id;
        }


          if ($data['est-type'] == 'main') {
            $main_comp_id = 0;
          }elseif($data['est-type'] == 'branch') {
              $main_comp_id = $data['main_company_id'];
          }
          // echo $est_id;exit;
          $this->db->set('main_company_id',  $main_comp_id);
          $this->db->set('establishment', $data['establishment']);
          $this->db->set('project_type',  $data['project_type']);
          $this->db->set('comp_tel',  $data['comp_tel']);
          $this->db->set('comp_email',  $data['comp_email']);
          $this->db->set('est_street', $data['est_street']);
          $this->db->set('est_region', $data['est_region']);
          $this->db->set('est_province', $data['est_province']);
          $this->db->set('est_city',$data['est_city']);
          $this->db->set('est_barangay', $data['est_barangay']);
          $this->db->set('psi_code_no', $data['psi_code_no']);
          $this->db->set('psi_descriptor', $data['psi_descriptor']);
          $this->db->set('ceo_first_name', $data['ceo_first_name']);
          $this->db->set('ceo_last_name', $data['ceo_last_name']);
          $this->db->set('ceo_mi', $data['ceo_mi']);
          $this->db->set('ceo_sufx', $data['ceo_sufx']);
          $this->db->set('ceo_phone_no', $data['ceo_phone_no']);
          $this->db->set('ceo_fax_no', $data['ceo_fax_no']);
          $this->db->set('ceo_email', $data['ceo_email']);
          $this->db->set('plant_manager', $data['plant_manager']);
          $this->db->set('plant_manager_coa_no', $data['plant_manager_coa_no']);
          $this->db->set('plant_manager_phone_no', $data['plant_manager_phone_no']);
          $this->db->set('plant_manager_fax_no', $data['plant_manager_fax_no']);
          $this->db->set('plant_manager_email', $data['plant_manager_email']);
          $this->db->set('plant_manager_mobile_no',  $data['plant_manager_mobile_no']);
          $this->db->set('pollution_officer', $data['pollution_officer']);
          $this->db->set('pollution_officer_coa_no', $data['pollution_officer_coa_no']);
          $this->db->set('pollution_officer_phone_no', $data['pollution_officer_phone_no']);
          $this->db->set('pollution_officer_fax_no', $data['pollution_officer_fax_no']);
          $this->db->set('pollution_officer_email', $data['pollution_officer_email']);
          $this->db->set('pollution_officer_mobile_no',  $data['pollution_officer_mobile_no']);
          $this->db->set('managing_head', $data['managing_head']);
          $this->db->set('managing_head_email', $data['managing_head_email']);
          $this->db->set('managing_head_tel_no', $data['managing_head_tel_no']);
          $this->db->set('managing_head_fax_no', $data['managing_head_fax_no']);
          $this->db->set('managing_head_mobile_no', $data['managing_head_mobile_no']);
          // $this->db->set('dp_num',   $data['dp_no']);
          $this->db->set('po_num',   $data['po_no']);
          // $this->db->set('ecc_num',  $data['ecc_no']);
          $this->db->set('est_certification', $data['est_certification']);
          $this->db->set('certified_doc', $data['certified_doc']);
          $this->db->set('date_modified', date('Y-m-d H:i:s'));
          $this->db->set('longitude', $data['longitude']);
          $this->db->set('latitude', $data['latitude']);


        if ($est_id && !empty($est_id))
        {
          $validate = $this->validate_id($company_id);
          if ($validate > 0) {
            $this->db->where('est_id', $est_id);
            $this->db->update($this->tbl_name);
            $this->db->set('status', 0);
            $this->db->where('est_id', $est_id);
            $this->db->where('client_id', $this->session->userdata('client_id'));
            $this->db->update('client_est_requests');
            return $est_id;
          }else {
            $this->db->set('client_id', $this->session->userdata('client_id'));
            $this->db->set('date_created', date('Y-m-d H:i:s'));
            $count_max_id = $this->db->select('cnt')->order_by('cnt','desc')->limit(1)->get('establishment')->row('cnt');
            $this->db->set('est_id', $est_id);
            $this->db->insert($this->tbl_name);
            // $est_id = $this->db->insert_id();

            $this->db->set('system_inquery',  $data['system_inquery_type']);
            $this->db->set('date_submitted', date('Y-m-d H:i:s'));
            $this->db->set('client_id', $this->session->userdata('client_id'));
            $this->db->set('est_id', $est_id);

            if (!empty($this->session->userdata('selected_company')) || $this->session->userdata('selected_company') != '') {
              $this->db->set('status', 5);
              $this->db->set('requested', 1);
            }else {
              $this->db->set('status', 0);
              $this->db->set('requested', 0);
            }
            $this->db->set('deleted', 0);
            $query2 = $this->db->insert('client_est_requests');
            $req_id = $this->db->insert_id();
          }
        }else{
          $this->db->set('client_id', $this->session->userdata('client_id'));
          $this->db->set('date_created', date('Y-m-d H:i:s'));
          $count_max_id = $this->db->select('cnt')->order_by('cnt','desc')->limit(1)->get('establishment')->row('cnt');
          $this->db->set('est_id', $count_max_id + 1);
          $this->db->insert($this->tbl_name);
          $est_id = $this->db->insert_id();
          $this->db->set('system_inquery',  $data['system_inquery_type']);
          $this->db->set('date_submitted', date('Y-m-d H:i:s'));
          $this->db->set('client_id', $this->session->userdata('client_id'));
          $this->db->set('est_id', $count_max_id + 1);

          if (!empty($this->session->userdata('selected_company')) || $this->session->userdata('selected_company') != '') {
            $this->db->set('status', 5);
            $this->db->set('requested', 1);
          }else {
            $this->db->set('status', 0);
            $this->db->set('requested', 0);
          }

          $this->db->set('deleted', 0);
          $query2 = $this->db->insert('client_est_requests');
          $req_id = $this->db->insert_id();
        }
        return $req_id;
      }
    // }else {
      return FALSE;
    // }


  }

  function save_attachments_data($data='',$table)
  {
    if ( ! empty($data))
    {
      $req_id = '';
      if (isset($data['req_id']) && $data['req_id'] && $data['req_id'] != 0)
        $req_id = $data['req_id'];

      $this->db->set('req_id', $data['req_id']);
      $this->db->set('client_id', $data['client_id']);
      $this->db->set('file_name', $data['file_name']);
      $this->db->set('dp_no', $data['dp_no']);

      if ($req_id && !empty($req_id))
      {
        $this->db->where('deleted', 0);
        $this->db->where('req_id', $req_id);
        $this->db->update($table);
      }
      else
        $this->db->insert($table);

      return TRUE;
    }

    return FALSE;
  }

}

 ?>

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model
{
	var $tbl_name;

	function __construct()
	{
		parent::__construct();
		$this->tbl_name = 'acc';
		$this->load->database();
		$this->load->library('encryption');
		$this->load->helper('string');
		session_start();
	}


	function save_user_data($data='')
	{
		if ( ! empty($data))
		{
			$user_id = $this->encrypt->decode($data['user_id']);
			if (isset($user_id) && $user_id && $user_id != 0)
				$user_id = $user_id;
				// echo $user_id;exit;
				// echo "<pre>";print_r($data);
				// echo $user_id;exit;
				// password_hash($raw_password,PASSWORD_DEFAULT);
			$user_password = password_hash($data['password'],PASSWORD_DEFAULT);
			$user_code = random_string('unique');
			//$role_id = ROLE_USER;  //default to Guest/Client

			// if ($data['role_id'])
				// $role_id = $data['role_id'];

			$this->db->set('username', $data['username']);
			$this->db->set('first_name', $data['first_name']);
			$this->db->set('last_name', $data['last_name']);
			$this->db->set('role_id', 2);
			$this->db->set('email', $data['email']);
			$this->db->set('contact_no', $data['contact_no']);
			$this->db->set('raw_password', $this->encrypt->encode($data['password']));
			$this->db->set('position', $data['position']);
			$this->db->set('password', $user_password);
			$this->db->set('user_code', $user_code);
			$this->db->set('salutation', $data['salutation']);
			$this->db->set('region', $data['region']);
			$this->db->set('locked', 0);
			$this->db->set('verified', 1);
		  $this->db->set('deleted', 0);
		  // $this->db->set('verified_by', 0);
			$this->db->set('failed_count', 0);
			$this->db->set('date_registered', date('Y-m-d H:i:s'));
			//$this->db->set('ecc_no', $data['ecc_no']);
			// if ($data['verified'])
			// 	$this->db->set('verified', $data['verified']);

			if ($user_id && !empty($user_id))
			{
				$this->db->set('verified', 1);
				$this->db->where('deleted', 0);
				$this->db->where('client_id', $user_id);
				$this->db->update($this->tbl_name);
			}else {
				$this->db->insert($this->tbl_name);
			}
			// else


				return $user_code;
				// return $query;
		}

		return FALSE;
	}



}

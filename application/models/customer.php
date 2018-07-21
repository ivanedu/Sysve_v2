<?php
class Customer extends Person
{	
	/*
	Determines if a given person_id is a customer
	*/
	function exists($person_id)
	{
		$this->db->from('customers');	
		$this->db->join('people', 'people.person_id = customers.person_id');
		$this->db->where('customers.person_id',$person_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	/*
	Returns all the customers
	*/
	function get_all($limit=10000, $offset=0)
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');			
		$this->db->where('deleted',0);
		$this->db->order_by("last_name", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();		
	}
	
	function count_all()
	{
		$this->db->from('customers');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
	
	/*
	Gets information about a particular customer
	*/
	function get_info($customer_id)
	{
		$this->db->from('customers');	
		$this->db->join('people', 'people.person_id = customers.person_id');
		$this->db->where('customers.person_id',$customer_id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $customer_id is NOT an customer
			$person_obj=parent::get_info(-1);
			
			//Get all the fields from customer table
			$fields = $this->db->list_fields('customers');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}
			
			return $person_obj;
		}
	}
	
	/*
	Gets information about multiple customers
	*/
	function get_multiple_info($customer_ids)
	{
		$this->db->from('customers');
		$this->db->join('people', 'people.person_id = customers.person_id');		
		$this->db->where_in('customers.person_id',$customer_ids);
		$this->db->order_by("last_name", "asc");
		return $this->db->get();		
	}
	
	/*
	Inserts or updates a customer
	*/
	function save(&$person_data, &$customer_data,$customer_id=false){		
		$success = false;
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		// $customer_obj =  $this->get_info($person_data['person_id']);
		if($customer_id){
			if(parent::save($person_data,$customer_id)){
				if (!$customer_id or !$this->exists($customer_id)){
					$customer_data['person_id'] = $person_data['person_id'];
					$success = $this->db->insert('customers',$customer_data);				
				}else{
					$this->db->where('person_id', $customer_id);
					$success = $this->db->update('customers',$customer_data);
				}
			}
			$this->db->trans_complete();		
			return $success;
		}else{
			if(empty($customer_obj->person_id)){
				if(parent::save($person_data,$customer_id)){
					if (!$customer_id or !$this->exists($customer_id)){
						$customer_data['person_id'] = $person_data['person_id'];
						$success = $this->db->insert('customers',$customer_data);				
					}else{
						$this->db->where('person_id', $customer_id);
						$success = $this->db->update('customers',$customer_data);
					}
				}
				$this->db->trans_complete();		
				return $success;
			}else{
				return $customer_obj;
			}
		}
	}
	
	/*
	Deletes one customer
	*/
	function delete($customer_id)
	{
		$this->db->where('person_id', $customer_id);
		return $this->db->update('customers', array('deleted' => 1));
	}
	
	/*
	Deletes a list of customers
	*/
	function delete_list($customer_ids)
	{
		$this->db->where_in('person_id',$customer_ids);
		return $this->db->update('customers', array('deleted' => 1));
 	}
 	
 	/*
	GET CUSTOMER BY SEARCH
 	*/
 	function get_search_customer($search,$limit=25){
 		$suggestions = array();
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row){
			$suggestions[] = array(
				"person_id" => $row->person_id,
				"name" => $row->first_name.' '.$row->last_name,
				"address" => $row->address_1
			);
		}
		return $suggestions;
 	}

 	/*
	Get search suggestions to find customers
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("email",$search);
		$this->db->order_by("email", "asc");		
		$by_email = $this->db->get();
		foreach($by_email->result() as $row)
		{
			$suggestions[]=$row->email;		
		}

		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("phone_number",$search);
		$this->db->order_by("phone_number", "asc");		
		$by_phone = $this->db->get();
		foreach($by_phone->result() as $row)
		{
			$suggestions[]=$row->phone_number;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("account_number",$search);
		$this->db->order_by("account_number", "asc");		
		$by_account_number = $this->db->get();
		foreach($by_account_number->result() as $row)
		{
			$suggestions[]=$row->account_number;		
		}
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
	
	/*
	Get search suggestions to find customers
	*/
	function get_customer_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where('deleted',0);		
		$this->db->like("account_number",$search);
		$this->db->order_by("account_number", "asc");		
		$by_account_number = $this->db->get();
		foreach($by_account_number->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$row->account_number;
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	/*
	Preform a search on customers
	*/
	function search($search)
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');		
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		email LIKE '%".$this->db->escape_like_str($search)."%' or 
		phone_number LIKE '%".$this->db->escape_like_str($search)."%' or 
		account_number LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");		
		$this->db->order_by("last_name", "asc");
		
		return $this->db->get();	
	}

	function updateCustomerData($customer_id,$data_customer){
		$this->db->where_in('person_id',$customer_id);
		return $this->db->update('customers', array('data_customer' => $data_customer));
 	}
	
	/* METODOS DE CLIENTES */

	 function getClient($client_id){
		$response = null;
		$this->db->from('clients');
		$this->db->where('id',$client_id);
		$this->db->where('deleted',0);
		$client = $this->db->get();
		if($client->num_rows()==1){
			$response = $client->row();
		}
		return $response;
	 }

	function listClients(){
		$response = [];
		$this->db->from('clients');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "desc");
		$clients = $this->db->get();
		foreach($clients->result() as $row){
			$response[] = $row;
		}
		return $response;

	}
	/* BUSCAR COTIZACION */

	function getClientCoti($client_id, $cotizacion_id){
		$response = null;
		$this->db->from('clients');
		$this->db->join('cotizaciones', 'cotizaciones.cliente_id = clients.id');
		$this->db->where('clients.id',$client_id);		
		$this->db->where('deleted',0);
		$client = $this->db->get();
		if($client->num_rows()==1){
			$response = $client->row();
		}
		return $response;
	 }


	function listCotizacion(){
		$response = [];
		$this->db->from('cotizaciones');
		$this->db->join('clients', 'cotizaciones.cliente_id = clients.id');		
		$this->db->join('employees', 'cotizaciones.asesor = employees.person_id');	
	//	$this->db->where('deleted',0);
		$this->db->order_by("cotizaciones.fecha", "desc");
		$clients = $this->db->get();
		foreach($clients->result() as $row){
			$response[] = $row;
		}
		return $response;

	}

	function insertCotizacion($client_data){
		$success = $this->db->insert('cotizaciones',$client_data);
		return ($this->db->affected_rows() !== 1) ? false : true;
	}

	function insertClient($client_data){
		$success = $this->db->insert('clients',$client_data);
		return ($this->db->affected_rows() !== 1) ? false : true;
	}

	function updateClient($client_data,$client_id){
		$this->db->where('id', $client_id);
		$success = $this->db->update('clients',$client_data);
		return ($this->db->affected_rows() !== 1) ? false : true;
	}

	function deleteClient($client_data,$client_id){
		$this->db->where('id', $client_id);
		$success = $this->db->update('clients',$client_data);
		return ($this->db->affected_rows() !== 1) ? false : true;
	}

	/* METODOS DE COTIZACION */
	function getCotizacionBycode($cotizacion_code){
		$response = null;
		$this->db->from('cotizaciones');
		$this->db->where('cotizacion_id',$cotizacion_code);
		$cotizacion = $this->db->get();
		if($cotizacion->num_rows()==1){
			$response = $cotizacion->row();
		}
		return $response;
	}

	function addCotizacion($cotizaciones_data){
		$success = $this->db->insert('cotizaciones',$cotizaciones_data);
		return ($this->db->affected_rows() !== 1) ? false : true;
	}

	function addCotizacionService($cotizaciones_service_data){
		$success = $this->db->insert('cotizaciones_servicios',$cotizaciones_service_data);
		return ($this->db->affected_rows() !== 1) ? false : true;
	}

}
?>

<?php
require_once ("secure_area.php");
class Sales extends Secure_area{

	function __construct(){
		parent::__construct('sales');
		$this->load->library('sale_lib');
		$this->load->model("item");
	}

	function index()
	{
		$this->load->view("sales/receipt",$data);
	}

	function Venta($id = null, $cotizacion_id = null){
		$cliente = [];
		if(!empty($id)){
			$client = $this->Customer->getClientCoti($id,$cotizacion_id);
			$data = json_decode($client->data);



			//OBTENIENDO DATOS DE EMAIL
			$email_pos = array_search('empresa', array_column($data->emails, 'type_email'));
			$email_arr = $data->emails[$email_pos];
			$email = (!empty($email_arr)) ? $email_arr->email : "";

			//OBTENIENDO DATOS DE TELEFONO
			$phone_pos = array_search('celular_personal', array_column($data->emails, 'type_phone'));
			$phone_arr = $data->phones[$phone_pos];
			$phone = (!empty($phone_arr)) ? $phone_arr->nro_phone : "";
			
			$cliente['datos']     = array(
		    	'person_id'       => $client->id,
	            'firstname'       => $client->firstname,
	            'middlename'      => $client->middlename,
	            'lastname'        => $client->lastname,
	            'mother_lastname' => $client->mother_lastname,
				'last_name_casada'=> $client->last_name_casada,
				'documents' 	  => $data->documents,
				'description' 	  => $data->description,
				'cotizacion_id'	  => $client->cotizacion_id,
				'emails'		  => $email,
				'phones'	      => $phone,	  
        	);
		}
		$this->load->view('sales/venta',$cliente, $data);
	}

	function Document($id = null, $cotizacion_id = null){
		$cliente = [];
		if(!empty($id)){
			$client = $this->Customer->getClientCoti($id,$cotizacion_id);
			$data = json_decode($client->data);



			//OBTENIENDO DATOS DE EMAIL
			$email_pos = array_search('empresa', array_column($data->emails, 'type_email'));
			$email_arr = $data->emails[$email_pos];
			$email = (!empty($email_arr)) ? $email_arr->email : "";

			//OBTENIENDO DATOS DE TELEFONO
			$phone_pos = array_search('celular_personal', array_column($data->emails, 'type_phone'));
			$phone_arr = $data->phones[$phone_pos];
			$phone = (!empty($phone_arr)) ? $phone_arr->nro_phone : "";
			
			$cliente['datos']     = array(
		    	'person_id'       => $client->id,
	            'firstname'       => $client->firstname,
	            'middlename'      => $client->middlename,
	            'lastname'        => $client->lastname,
	            'mother_lastname' => $client->mother_lastname,
				'last_name_casada'=> $client->last_name_casada,
				'documents' 	  => $data->documents,
				'description' 	  => $data->description,
				'cotizacion_id'	  => $client->cotizacion_id,
				'emails'		  => $email,
				'phones'	      => $phone,	  
        	);
		}
		$this->load->view('sales/document',$cliente, $data);
	}


	function getCotizacion($cotizacion_id){
		$response = null;
		$this->db->from('cotizaciones');
		$this->db->where('cotizacion_id',$cotizacion_id);
		$client = $this->db->get();
		if($client->num_rows()==1){
			$response = $client->row();
		}
		return $response;
	 }

  	function listServicios(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServicios($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosBoleto(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosBoleto($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosHotel(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosHotel($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosAuto(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosAuto($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosTarjeta(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosTarjeta($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosPaquete(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosPaquete($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosExcursion(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosExcursion($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosEntrada(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosEntrada($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosTren(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosTren($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosCrucero(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosCrucero($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

  	function listServiciosOtro(){
 		$cotizacion_id = $this->input->post("id");
		$response = $this->Sale->listServiciosOtro($cotizacion_id);
		if(!empty($response)){
			echo json_encode(array('success'=>true,'data'=>$response));
		}else{
			echo json_encode(array('success'=>false,'data'=>[]));
		}
	}

	function getServicios(){
		$response = [];
		if($this->input->post()){
			$servicio_id = $this->input->post("id");
			$result = $this->Sale->getServicios($servicio_id);
			if(!empty($result)){
				$response = array('success'=>true,'data'=>$result);
			}else{
				$response = array('success'=>false);
			}
		}else{
			$response = array('success'=>false);
		}
		echo json_encode($response);
	}

	function saveService(){
		if($this->input->post()){
			$service_data = array(
				'proveedor'=>$this->input->post('proveedor'),
				'tarifa_neta'=>$this->input->post('tarifa_neta'),
				'comi_proveedor'=>$this->input->post('comi_proveedor'),
				'fee_agencia'=>$this->input->post('fee_agencia'),
				'fee_proveedor'=>$this->input->post('fee_proveedor'),
				'descripcion'=>$this->input->post('descripcion'),
				'tipo_boleto'=>$this->input->post('tipo_boleto')
			);
			$response = $this->Sale->insertService($service_data);
			if(!empty($response) && (int)$response === 1){
				$this->load->view("sales/receipt",$service_data);
				echo json_encode(array('success'=>true,'message'=>"Operación correcta"));
			}else{
				echo json_encode(array('success'=>false,'message'=>"Ha ocurrido un error interno"));
			}
		}else{
			echo json_encode(array('success'=>false,'message'=>"No se ha enviado ningún registro"));
		}
	}


	function item_search(){
		$suggestions = $this->Item->get_item_search_suggestions(
							$this->input->post('q'),
							$this->input->post('limit')
						);
		$suggestions = array_merge($suggestions,$this->Item_kit->get_item_kit_search_suggestions($this->input->post('q'),$this->input->post('limit')));
		echo implode("\n",$suggestions);
	}

	function customer_search()
	{
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function select_customer()
	{
		$customer_id = $this->input->post("customer");
		$this->sale_lib->set_customer($customer_id);
		$this->_reload();
	}

	function change_mode()
	{
		$mode = $this->input->post("mode");
		$this->sale_lib->set_mode($mode);
		$this->_reload();
	}
	
	function set_comment() 
	{
 	  $this->sale_lib->set_comment($this->input->post('comment'));
	}
	
	function set_email_receipt()
	{
 	  $this->sale_lib->set_email_receipt($this->input->post('email_receipt'));
	}

	//Alain Multiple Payments
	function add_payment(){		
		$data = array();
		$this->form_validation->set_rules( 'amount_tendered', 'lang:sales_amount_tendered', 'numeric' );
		if ($this->form_validation->run() == FALSE ){
			if ($this->input->post('payment_type') == $this->lang->line('sales_gift_card')){
				$data['error']=$this->lang->line('sales_must_enter_numeric_giftcard');
			}else{
				$data['error']=$this->lang->line('sales_must_enter_numeric');
			}
 			$this->_reload($data);
 			return;
		}
		
		$payment_type = $this->input->post('payment_type');
		if ($payment_type == $this->lang->line('sales_giftcard')){
			$payments = $this->sale_lib->get_payments();
			$payment_type = $this->input->post('payment_type').':'.$payment_amount = $this->input->post( 'amount_tendered' );
			$current_payments_with_giftcard = isset($payments[$payment_type]) ? $payments[$payment_type]['payment_amount'] : 0;
			$cur_giftcard_value = $this->Giftcard->get_giftcard_value($this->input->post('amount_tendered')) - $current_payments_with_giftcard;
			if($cur_giftcard_value <= 0){
				$data['error'] = 'Giftcard balance is '.to_currency($this->Giftcard->get_giftcard_value($this->input->post('amount_tendered'))).' !';
				$this->_reload( $data );
				return;
			}
			$new_giftcard_value = $this->Giftcard->get_giftcard_value($this->input->post('amount_tendered'))-$this->sale_lib->get_amount_due();
			$new_giftcard_value = ($new_giftcard_value >= 0) ? $new_giftcard_value : 0;
			$data['warning'] = 'Giftcard '.$this->input->post('amount_tendered') . ' balance is ' . to_currency( $new_giftcard_value ) . ' !';
			$payment_amount = min( $this->sale_lib->get_amount_due( ), $this->Giftcard->get_giftcard_value( $this->input->post( 'amount_tendered' ) ) );
		}else{
			$payment_amount = $this->input->post( 'amount_tendered' );
		}
		if(!$this->sale_lib->add_payment($payment_type,$payment_amount)){
			$data['error']='Unable to Add Payment! Please try again!';
		}
		$this->_reload($data);
	}

	//Alain Multiple Payments
	function delete_payment( $payment_id )
	{
		$this->sale_lib->delete_payment( $payment_id );
		$this->_reload();
	}

	function add(){
		$data=array();
		$mode = $this->sale_lib->get_mode();
		$item_id_or_number_or_item_kit_or_receipt = $this->input->post("item");
		$quantity = $mode=="sale" ? 1:-1;
		if($this->sale_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) 
			&& $mode=='return'){
			$this->sale_lib->return_entire_sale($item_id_or_number_or_item_kit_or_receipt);
		}elseif($this->sale_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)){
			$this->sale_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
		}elseif(!$this->sale_lib->add_item($item_id_or_number_or_item_kit_or_receipt,$quantity)){
			$data['error']=$this->lang->line('sales_unable_to_add_item');
		}
		if($this->sale_lib->out_of_stock($item_id_or_number_or_item_kit_or_receipt)){
			$data['warning'] = $this->lang->line('sales_quantity_less_than_zero');
		}
		$this->_reload($data);
	}

	function add_item_by_number(){
		$data=array();
		$mode = $this->sale_lib->get_mode();
		$item_id = $this->item->get_item_number($this->input->post("item_number"));
		$item_id_or_number_or_item_kit_or_receipt = $item_id;
		$quantity = $mode=="sale" ? 1:-1;
		if(!empty($item_id)){
			if($this->sale_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) 
				&& $mode=='return'){
				$this->sale_lib->return_entire_sale($item_id_or_number_or_item_kit_or_receipt);
			}elseif($this->sale_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)){
				$this->sale_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
			}elseif(!$this->sale_lib->add_item($item_id_or_number_or_item_kit_or_receipt,$quantity)){
				$data['error']=$this->lang->line('sales_unable_to_add_item');
			}
			if($this->sale_lib->out_of_stock($item_id_or_number_or_item_kit_or_receipt)){
				$data['warning'] = $this->lang->line('sales_quantity_less_than_zero');
			}
		}
		$this->_reload($data);
	}

	function edit_item($line){
		$data= array();

		$this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
		$this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|numeric');

        $description = $this->input->post("description");
        $serialnumber = $this->input->post("serialnumber");
		$price = $this->input->post("price");
		$quantity = $this->input->post("quantity");
		$discount = $this->input->post("discount");


		if ($this->form_validation->run() != FALSE)
		{
			$this->sale_lib->edit_item($line,$description,$serialnumber,$quantity,$discount,$price);
		}
		else
		{
			$data['error']=$this->lang->line('sales_error_editing_item');
		}
		
		if($this->sale_lib->out_of_stock($this->sale_lib->get_item_id($line)))
		{
			$data['warning'] = $this->lang->line('sales_quantity_less_than_zero');
		}


		$this->_reload($data);
	}

	function delete_item($item_number)
	{
		$this->sale_lib->delete_item($item_number);
		$this->_reload();
	}

	function remove_customer()
	{
		$this->sale_lib->remove_customer();
		$this->_reload();
	}

	function complete(){
		$igv = $this->input->post("igv");
		$data['cart']=$this->sale_lib->get_cart(); 
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['igv']=$this->input->post("igv");
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total() + $igv;
		$doc = "";
		if($igv > 0){
			$doc = "FAC - ";
			$data['receipt_title'] = "FACTURA DE VENTA";
		}else{
			$doc = "BOL - ";
			$data['receipt_title'] = "RECIBO DE VENTA";
		}
		//$data['receipt_title']= $this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$customer_id=$this->sale_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->sale_lib->get_comment();
		$emp_info=$this->Employee->get_info($employee_id);
		$data['payments']=$this->sale_lib->get_payments();
		$data['amount_change']=to_currency(($this->sale_lib->get_amount_due() * -1)); 
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($customer_id!=-1) {
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}

		//SAVE sale to database
		$data['sale_id']=$doc.$this->Sale->save($data['cart'], $customer_id,$employee_id,$comment,$data['payments']);
		if ($data['sale_id'] == 'POS -1') {
			$data['error_message'] = $this->lang->line('sales_transaction_failed');
		} else {
			if ($this->sale_lib->get_email_receipt() && !empty($cust_info->email)) {
				$this->load->library('email');
				$config['mailtype'] = 'html';				
				$this->email->initialize($config);
				$this->email->from($this->config->item('email'), $this->config->item('company'));
				$this->email->to($cust_info->email); 

				$this->email->subject($this->lang->line('sales_receipt'));
				$this->email->message($this->load->view("sales/receipt_email",$data, true));	
				$this->email->send();
			}
		}
		$this->load->view("sales/receipt",$data);
		$this->sale_lib->clear_all();
		$this->_remove_duplicate_cookies();
	}
	
	function receipt($sale_id)
	{
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$this->sale_lib->copy_entire_sale($sale_id);
		$data['cart']=$this->sale_lib->get_cart();
		$data['payments']=$this->sale_lib->get_payments();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title']= $this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a', strtotime($sale_info['sale_time']));
		$customer_id=$this->sale_lib->get_customer();
		$emp_info=$this->Employee->get_info($sale_info['employee_id']);
		$data['payment_type']=$sale_info['payment_type'];
		$data['amount_change']=to_currency($this->sale_lib->get_amount_due() * -1);
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}
		$data['sale_id']='POS '.$sale_id;
		$this->load->view("sales/receipt",$data);
		$this->sale_lib->clear_all();
		$this->_remove_duplicate_cookies();
	}
	
	function edit($sale_id)
	{
		$data = array();

		$data['customers'] = array('' => 'No Customer');
		foreach ($this->Customer->get_all()->result() as $customer)
		{
			$data['customers'][$customer->person_id] = $customer->first_name . ' '. $customer->last_name;
		}

		$data['employees'] = array();
		foreach ($this->Employee->get_all()->result() as $employee)
		{
			$data['employees'][$employee->person_id] = $employee->first_name . ' '. $employee->last_name;
		}

		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$person_name = $sale_info['first_name'] . " " . $sale_info['last_name'];
		$data['selected_customer'] = !empty($sale_info['customer_id']) ? $sale_info['customer_id'] . "|" . $person_name : "";
		$data['sale_info'] = $sale_info;
		
		$this->load->view('sales/form', $data);
	}
	
	function delete($sale_id = -1, $update_inventory=TRUE) {
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$sale_ids= $sale_id == -1 ? $this->input->post('ids') : array($sale_id);

		if($this->Sale->delete_list($sale_ids, $employee_id, $update_inventory))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('sales_delete_successful').' '.
			count($sale_ids).' '.$this->lang->line('sales_one_or_multiple'),'ids'=>$sale_ids));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('sales_delete_unsuccessful')));
		}
	}
	
	function save($sale_id)
	{
		$sale_data = array(
			'sale_time' => date('Y-m-d', strtotime($this->input->post('date'))),
			'customer_id' => $this->input->post('customer_id') ? $this->input->post('customer_id') : null,
			'employee_id' => $this->input->post('employee_id'),
			'comment' => $this->input->post('comment')
		);
		
		if ($this->Sale->update($sale_data, $sale_id))
		{
			echo json_encode(array(
				'success'=>true,
				'message'=>$this->lang->line('sales_successfully_updated'),
				'id'=>$sale_id)
			);
		}
		else
		{
			echo json_encode(array(
				'success'=>false,
				'message'=>$this->lang->line('sales_unsuccessfully_updated'),
				'id'=>$sale_id)
			);
		}
	}
	
	function _payments_cover_total()
	{
		$total_payments = 0;

		foreach($this->sale_lib->get_payments() as $payment)
		{
			$total_payments += $payment['payment_amount'];
		}

		/* Changed the conditional to account for floating point rounding */
		if ( ( $this->sale_lib->get_mode() == 'sale' ) && ( ( to_currency_no_money( $this->sale_lib->get_total() ) - $total_payments ) > 1e-6 ) )
		{
			return false;
		}
		
		return true;
	}
	
	function _reload($data=array())
	{
		$person_info = $this->Employee->get_logged_in_employee_info();
		$data['cart']=$this->sale_lib->get_cart();
		$data['modes']=array(
			'sale'=>$this->lang->line('sales_sale'),
			'return'=>$this->lang->line('sales_return')
		);
		$data['mode']=$this->sale_lib->get_mode();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['items_module_allowed'] = $this->Employee->has_permission('items', $person_info->person_id);
		$data['comment'] = $this->sale_lib->get_comment();
		$data['email_receipt'] = $this->sale_lib->get_email_receipt();
		$data['payments_total']=$this->sale_lib->get_payments_total();
		$data['amount_due']=$this->sale_lib->get_amount_due();
		$data['payments']=$this->sale_lib->get_payments();
		$data['payment_options']=array(
			$this->lang->line('sales_cash') => $this->lang->line('sales_cash'),
			$this->lang->line('sales_check') => $this->lang->line('sales_check'),
			$this->lang->line('sales_giftcard') => $this->lang->line('sales_giftcard'),
			$this->lang->line('sales_debit') => $this->lang->line('sales_debit'),
			$this->lang->line('sales_credit') => $this->lang->line('sales_credit')
		);
		$data['payment_document']=array(
			$this->lang->line('sales_bol') => $this->lang->line('sales_bol'),
			$this->lang->line('sales_fac') => $this->lang->line('sales_fac')
		);
		$customer_id=$this->sale_lib->get_customer();
		if($customer_id!=-1)
		{
			$info=$this->Customer->get_info($customer_id);
			$data['customer']=$info->first_name.' '.$info->last_name;
			$data['customer_email']=$info->email;
		}
		$data['payments_cover_total'] = $this->_payments_cover_total();
		$this->load->view("sales/register",$data);
		$this->_remove_duplicate_cookies();
	}

    function cancel_sale()
    {
    	$this->sale_lib->clear_all();
    	$this->_reload();

    }
	
	function suspend()
	{
		$data['cart']=$this->sale_lib->get_cart();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title']=$this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$customer_id=$this->sale_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->input->post('comment');
		$emp_info=$this->Employee->get_info($employee_id);
		$payment_type = $this->input->post('payment_type');
		$data['payment_type']=$this->input->post('payment_type');
		//Alain Multiple payments
		$data['payments']=$this->sale_lib->get_payments();
		$data['amount_change']=to_currency($this->sale_lib->get_amount_due() * -1);
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}

		$total_payments = 0;

		foreach($data['payments'] as $payment)
		{
			$total_payments += $payment['payment_amount'];
		}

		//SAVE sale to database
		$data['sale_id']='POS '.$this->Sale_suspended->save($data['cart'], $customer_id,$employee_id,$comment,$data['payments']);
		if ($data['sale_id'] == 'POS -1')
		{
			$data['error_message'] = $this->lang->line('sales_transaction_failed');
		}
		$this->sale_lib->clear_all();
		$this->_reload(array('success' => $this->lang->line('sales_successfully_suspended_sale')));
	}
	
	function suspended()
	{
		$data = array();
		$data['suspended_sales'] = $this->Sale_suspended->get_all()->result_array();
		$this->load->view('sales/suspended', $data);
	}
	
	function unsuspend()
	{
		$sale_id = $this->input->post('suspended_sale_id');
		$this->sale_lib->clear_all();
		$this->sale_lib->copy_entire_suspended_sale($sale_id);
		$this->Sale_suspended->delete($sale_id);
    	$this->_reload();
	}
}
?>

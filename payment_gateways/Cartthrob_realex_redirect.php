<?php 
class Cartthrob_realex_redirect extends Cartthrob_payment_gateway
{
	public $title = 'realex_redirect_title';
	public $overview = "realex_redirect_overview"; 
 	public $settings = array(
		array(
			'name' => 'realex_redirect_settings_merchant_id',
			'short_name' => 'your_merchant_id',
			'type' => 'text'
		),
		array(
			'name' => 'realex_redirect_settings_your_secret',
			'short_name' => 'your_secret',
			'type' => 'text'
		),
	 	array(
			'name'=>'realex_redirect_success_template',
			'short_name'=>'success_template',
			'type'=>'select',
			'note'	=> 'realex_backup_template_note',
			'attributes' => array(
				'class' 	=> 'templates',
				),
		),
		array(
			'name' => 'realex_redirect_failure_template',
			'short_name' => 'failure_template',
			'type'=>'select',
			'note'	=> 'realex_backup_template_note',
			'attributes' => array(
				'class' 	=> 'templates',
				),
		),
	);
	
	public $required_fields = array(
 
	);
	
	public $fields = array(
		'first_name'           ,
		'last_name'            ,
		'address'              ,
		'address2'             ,
		'city'                 ,
 		'zip'                  ,
		'country_code'         ,
		'shipping_first_name'  ,
		'shipping_last_name'   ,
		'shipping_address'     ,
		'shipping_address2'    ,
		'shipping_city'        ,
 		'shipping_zip'         ,
		'shipping_country_code',
		'phone'                ,
		'email_address'        ,
		);
	
	public function initialize()
	{
		$this->overview = $this->lang('realex_redirect_overview'). 
			"<pre>". $this->response_script(ucfirst(get_class($this)))."</pre>";
		
	}
	/**
	 * process_payment
	 *
 	 * @param string $credit_card_number 
	 * @return mixed | array | bool An array of error / success messages  is returned, or FALSE if all fails.
	 * @author Chris Newton
	 * @access public
	 * @since 1.0.0
	 */
	public function process_payment($credit_card_number)
	{
		$timestamp = strftime("%Y%m%d%H%M%S");
		mt_srand((double)microtime()*1000000);

		$rounded_total = round($this->order('total') * 100); 
		
		$currency_code = $this->order('currency_code') ? $this->order('currency_code') :"GBP" ; 
		
		$tmp = $timestamp.".". $this->plugin_settings('your_merchant_id').".".$this->order('order_id').".".$rounded_total.".".$currency_code;
		$md5hash = md5($tmp);
		
		$tmp = $md5hash.".".$this->plugin_settings('your_secret');
		
		$md5hash = md5($tmp);
		
		$post_array = array(
			'MERCHANT_ID'			=> $this->plugin_settings('your_merchant_id'),
			'ORDER_ID'				=> $this->order('order_id'),	
			'CURRENCY'				=> $currency_code,
			'AMOUNT'				=> $rounded_total,
			'TIMESTAMP'				=> $timestamp,	
			'MD5HASH'				=> $md5hash,	
			'AUTO_SETTLE_FLAG'		=> 1,
			'CUST_NUM'				=> $this->order('member_id'),
			'ct_order_id'			=> $this->order('order_id'),
		);
		
		$this->gateway_exit_offsite($post_array, 'https://epage.payandshop.com/epage.cgi'); 
		exit;
	}
	// END

	function extload($post = array())
	{
		$auth  = array(
			'authorized' 	=> FALSE,
			'error_message'	=> NULL,
			'failed'		=> TRUE,
			'processing' 	=> FALSE,
			'declined'		=> FALSE,
			'transaction_id'=> NULL 
			);

		$order_id = $this->xss_clean($this->arr($post, "ct_order_id")); 

 		$xss_clean = TRUE; 
		
		if (! $order_id )
		{
			die($this->lang('realex_order_id_not_specified')); 
		}

		$this->relaunch_cart(NULL, $order_id);
 
		if (!isset($post['TIMESTAMP']) || 
			!isset($post['ORDER_ID']) || 
			!isset($post['RESULT'])|| 
			!isset($post['MESSAGE']) || 
			!isset($post['PASREF']) || 
			!isset($post['AUTHCODE']))
		{
			$auth['authorized']	 	= FALSE; 
			$auth['declined'] 		= FALSE; 
			$auth['transaction_id']	= NULL;
			$auth['failed']			= TRUE; 
			$auth['error_message']	= $this->lang("realex_redirect_no_data_sent");
			
			$this->gateway_order_update($auth, $this->order('entry_id'), $return_url = NULL );
			echo $this->parse_template($this->fetch_template( $this->plugin_settings('failure_template') )); 
			exit; 
		}
		
 		$tmp = $post['TIMESTAMP']."."
				. $this->plugin_settings('your_merchant_id') ."."
				.$post['ORDER_ID']."."
				.$post['RESULT']."."
				.$post['MESSAGE']."."
				.$post['PASREF']."."
				.$post['AUTHCODE'];

		$md5hash = md5($tmp);
		$tmp = $md5hash.".". $this->plugin_settings('your_secret');
		$md5hash = md5($tmp);
		
		if ($md5hash != $post['MD5HASH']) 
		{
			$auth['authorized']	 	= FALSE; 
			$auth['declined'] 		= FALSE; 
			$auth['transaction_id']	= NULL;
			$auth['failed']			= TRUE; 
			$auth['error_message']	= $this->lang('realex_redirect_hashes_dont_match'); 
			
			
		}
		elseif ($post['RESULT'] == "00")
		{
			$auth['authorized']	 	= TRUE; 
			$auth['declined'] 		= FALSE; 
			$auth['transaction_id']	= $order_id; 
			$auth['failed']			= FALSE; 
			$auth['error_message']	= '';

			
		}
		else
		{
			$auth['authorized']	 	= FALSE; 
			$auth['declined'] 		= TRUE; 
			$auth['transaction_id']	= NULL;
			$auth['failed']			= FALSE; 
			$auth['error_message']	= $post['MESSAGE'];

			
		}
		
 		
		if ( ! $this->order('return'))
        {
            $this->update_order(array('return' => $this->plugin_settings('order_complete_template')));
        }

        $this->checkout_complete_offsite($auth, $order_id, 'template');

        exit;

    } // END
	
	function arr($array, $key)
	{
		if (isset($array[$key]))
		{
			return $array[$key]; 
		}
		else
		{
			return NULL; 
		}
	}
}
// END Class
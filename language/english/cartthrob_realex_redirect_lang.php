<?php   

$lang = array(
		'realex_redirect_title' => 'Realex Redirect Payment Gateway',

		'realex_redirect_overview' => '<p>This gateway makes use of a file called extload.php which is contained in the CartThrob themes folder. You will need to edit this file if your EE system folder is not named "system" or has been moved to a different directory than the default</p>
		
		<h3>Success & Failure Templates</h3>
		<p>Realex Redirect requires that there is no javascript or redirects in your success and failure templates. Only basic HTML should be included. The content of these templates will be shown on Realex\'s site based on the success or failure of the customer\'s payment. Because Realex does not return customers to your site directly, you should probably put an absolute link in these templates back to your site, or add other navigation to help your customers return. All images should use full URLs, all links should be absolute links. </p>
		
		<p>By default, the page you specify as the return parameter (return="template_group/template") in your checkout form will be shown as your success template at Realex\'s site when the customer\'s payment has been completed. Please only specify the template group and template  (return="group/template")  rather than a full URL or your template will not be rendered correctly. Make sure to use the <a href="http://cartthrob.com/docs/tags_detail/submitted_order_info/">submitted_order_info tag</a> if you want to show any order details to the customer.</p>
		
		<h3>Styling Realex\'s Payment Page</h3>
		<p>
		To stylize Realex\'s payment page a folder of files should be sent to support@realexpayments.com containing HTML, css, images. One file must be named template.htm, containing a template with no scripting of any kind. Must have e-page table tag. Example: </p>
		
		<pre>
		&lt;html&gt; &lt;head&gt; &lt;title&gt; Enter your credit card details. &lt;/title&gt;
		&lt;/head&gt; &lt;body&gt;
		more html...
		&lt;!--E-PAGE TABLE HERE--&gt; more html... &lt;/body&gt;
		&lt;/html&gt;
		</pre>
		
		<p>All files (images, css, etc) must be placed in a folder called "internet" inside the folder being sent. </p>
		
		<h3>Test Credit Cards</h3>
		
		<p>Only approved test credit cards should be used with Realex. Other credit card numbers will be ignored, or the transaction will fail</p>
		
		<p>CVV2/CVC - Any 3-digit number can be used for testing purposes.</p>

		<p>Expiry Date - Any date in the future can be used.</p>

		<p>Card Types & Currencies - Your test account may not be set up for all currency and card type combinations. If you require a specific currency or card type set up for testing please contact: support@realexpayments.com</p>

		<p>The currencies and card types available on your live account will be determined by your merchant services agreement with your bank.</p>

		<p>Visa: (CC number - Response Code - Message) <br />

		<br />4263971921001307 - 00 - Successful
		<br />4000126842489127 - 101 - DECLINED
		<br />4000136842489878 - 102 - REFERRAL B
		<br />4000166842489115 - 103 - REFERRAL A
		<br />4009837983422344 - 205 - Comms Error
		</p>

		Mastercard/MC:<br />

 		<br />5425232820001308 - 00 - Successful
		<br />5114617896541284 - 101 - DECLINED
		<br />5114634523652350 - 102 - REFERRAL B
		<br />5121229875643585 - 103 - REFERRAL A
		<br />5135024345352238 - 205 - Comms Error
</p>
<p>		Laser: <br />

		<br />6304939304310009610 - 00 - Successful
		<br />6304908620589523057 - 101 - DECLINED
		<br />6304936989767381455 - 102 - REFERRAL B
		<br />6304902235219564797 - 103 - REFERRAL A
		<br />6304902507676842597 - 200 - Error Connecting to Bank
</p>
<p>		Switch:<br />

 		<br />6759671431256542 - 00 - Authorised
		<br />6759675421985671 - 101 - Declined
</p>
<p>		AMEX:<br /> 

 		<br />374101012180018 - 00 - Successful
		<br />374101123456455  - 101 - DECLINED
		<br />375425435431347 - 102 - REFERRAL B
		<br />343452345245640 - 103 - REFERRAL A
		<br />372349658273959 - 205 - Comms Error
</p>
<p>		Delta:<br /> 

 		<br />4544321006384999 - 00 - Successful
</p>
<p>		Diners:<br />

 		<br />36256052780018 - 00 - Successful
		<br />36256052800014 - 101 - DECLINED
		<br />36256052790017 - 102 - REFERRAL B
		<br />38865030565503 - 103 - REFERRAL A
		<br />30450000000001 - 205 - COMMS ERROR
</p>
<p>		Solo:<br />

 		<br />6767000000000307  - 00 - Authorised
		<br />6767000000000315  - 101 - Declined
		<br />6767000000000323  - 102 - Referral B
		<br />6767000000000331 - 103 - Reported Lost or Stolen
		<br />6767000000000349  - 200 - Bank Error
		<br />6767000000000356 - 204 - Bank Error
		<br />6767000000000364 - 205 - Bank Error
</p>
 
		
		<h3>Payment Response Script:</h3>
		<p>Realex needs to know the full URL of your payment response script in order to POST transaction data back to your store to finalize the order on your CartThrob website. Send an email to <a href="mailto:support@realexpayments.com?subject=New Payment Response Script URL">support@realexpayments.com</a> with the following URL:	</p>',

		'realex_redirect_settings_merchant_id' => 'Your Merchant Id',
		'realex_redirect_settings_your_secret' => 'Your Secret',
		'realex_redirect_success_template' => 'Backup Return Template',
		'realex_backup_template_note'	=> 'If return parameter is not set in the checkout_form, this template will be used as a backup repsonse template. ',
		'realex_redirect_hashes_dont_match' => "Hash values do not match. Response by merchant failed.",
	);


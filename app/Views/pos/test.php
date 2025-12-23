 <?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="container">
<div class="row">
        
        <div class="col-md-12">
			<div class="row">
				<div class=" col-md-7  no-padding pr-12">
					<div class="box box-solid mb-12">
						<div class="box-body pb-0">
							<input id="location_id" data-receipt_printer_type="browser" data-default_payment_accounts="{&quot;cash&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;card&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;cheque&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;bank_transfer&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;other&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;custom_pay_1&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;custom_pay_2&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;custom_pay_3&quot;:{&quot;is_enabled&quot;:&quot;1&quot;,&quot;account&quot;:null},&quot;custom_pay_4&quot;:{&quot;account&quot;:null},&quot;custom_pay_5&quot;:{&quot;account&quot;:null},&quot;custom_pay_6&quot;:{&quot;account&quot;:null},&quot;custom_pay_7&quot;:{&quot;account&quot;:null}}" name="location_id" type="hidden" value="1">
							<!-- sub_type -->
							<input name="sub_type" type="hidden">
							<input type="hidden" id="item_addition_method" value="1">
								<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-user"></i>
				</span>
				<input type="hidden" id="default_customer_id" value="1">
				<input type="hidden" id="default_customer_name" value="Walk-In Customer">
				<input type="hidden" id="default_customer_balance" value="0.0000">
				<input type="hidden" id="default_customer_address" value="">
								<select class="form-control mousetrap select2-hidden-accessible valid" id="customer_id" required="" style="width: 100%;" name="contact_id" tabindex="-1" aria-hidden="true" aria-required="true"><option selected="selected" value="">Enter Customer name / phone</option><option value="1">Walk-In Customer</option></select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-customer_id-container"><span class="select2-selection__rendered" id="select2-customer_id-container" title="Walk-In Customer">Walk-In Customer</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
				<span class="input-group-btn">
					<button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
				</span>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default bg-white btn-flat" data-toggle="modal" data-target="#configure_search_modal" title="Configure product search"><i class="fa fa-barcode"></i></button>
				</div>
				<input class="form-control mousetrap ui-autocomplete-input" id="search_product" placeholder="Enter Product name / SKU / Scan bar code" autofocus="" name="search_product" type="text" autocomplete="off">
				<span class="input-group-btn">

					<!-- Show button for weighing scale modal -->
										

					<button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="https://pos.ultimatefosters.com/products/quick_add" data-container=".quick_add_product_modal"><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="row">
		<input type="hidden" name="pay_term_number" id="pay_term_number" value="">
	<input type="hidden" name="pay_term_type" id="pay_term_type" value="">
	
								<input id="price_group" name="price_group" type="hidden" value="0">
		
	
			<!-- Call restaurant module if defined -->
        
</div>
<!-- include module fields -->
                <div class="row">
	<div class="col-sm-12 pos_product_div" style="min-height: 185.85px; max-height: 185.85px;">
		<input type="hidden" name="sell_price_tax" id="sell_price_tax" value="includes">

		<!-- Keeps count of product rows -->
		<input type="hidden" id="product_row_count" value="2">
				<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
			<thead>
				<tr>
					<th class="tex-center  col-md-4 ">	
						Product <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Click <i>product name</i> to edit price, discount &amp; tax. <br/>Click <i>Comment Icon</i> to enter serial number / IMEI or additional note.<br/><br/>Click <i>Modifier Icon</i>(if enabled) for modifiers" data-html="true" data-trigger="hover"></i>					</th>
					<th class="text-center col-md-3">
						Quantity					</th>
										<th class="text-center col-md-2 ">
						Price inc. tax					</th>
					<th class="text-center col-md-2">
						Subtotal					</th>
					<th class="text-center"><i class="fas fa-times" aria-hidden="true"></i></th>
				</tr>
			</thead>
			<tbody><tr class="product_row" data-row_index="2">
	<td>
		
				<div title="Edit product Unit Price and Tax">
		<span class="text-link text-info cursor-pointer" data-toggle="modal" data-target="#row_edit_product_price_modal_2">
			Acer Aspire E 15 (Color:White)<br>AS0017-2 Acer
			&nbsp;<i class="fa fa-info-circle"></i>
		</span>
		</div>
				<input type="hidden" class="enable_sr_no" value="0">
		<input type="hidden" class="product_type" name="products[2][product_type]" value="variable">

		
		
		
				<div class="modal fade row_edit_product_price_model" id="row_edit_product_price_modal_2" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="myModalLabel">Acer Aspire E 15 (Color:White) - AS0017-2</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="form-group col-xs-12 ">
					<label>Unit Price</label>
						<input type="text" name="products[2][unit_price]" class="form-control pos_unit_price input_number mousetrap" value="437.50">
				</div>
								<div class="form-group col-xs-12 col-sm-6 ">
					<label>Discount Type</label>
						<select class="form-control row_discount_type" name="products[2][line_discount_type]"><option value="fixed" selected="selected">Fixed</option><option value="percentage">Percentage</option></select>
				</div>
				<div class="form-group col-xs-12 col-sm-6 ">
					<label>Discount Amount</label>
						<input class="form-control input_number row_discount_amount" name="products[2][line_discount_amount]" type="text" value="0.00">
				</div>
								<div class="form-group col-xs-12 ">
					<label>Tax</label>

					<input class="item_tax" name="products[2][item_tax]" type="hidden" value="0.00">
		
					<select class="form-control tax_id" name="products[2][tax_id]"><option selected="selected" value="">Select</option><option value="" selected="selected">None</option><option value="1" data-rate="10">VAT@10%</option><option value="2" data-rate="10">CGST@10%</option><option value="3" data-rate="8">SGST@8%</option><option value="4" data-rate="18">GST@18%</option></select>
				</div>
								<div class="form-group col-xs-12">
		      		<label>Description</label>
		      		<textarea class="form-control" name="products[2][sell_line_note]" rows="3"></textarea>
		      		<p class="help-block">Add product IMEI, Serial number or other informations here.</p>
		      	</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>		</div>
		
		<!-- Description modal end -->
		
		
				</td>

	<td>
		
		
		<input type="hidden" name="products[2][product_id]" class="form-control product_id" value="17">

		<input type="hidden" value="58" name="products[2][variation_id]" class="row_variation_id">

		<input type="hidden" value="1" name="products[2][enable_stock]">
		
		
				        	        		<div class="input-group input-number">
			<span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-down"><i class="fa fa-minus text-danger"></i></button></span>
		<input type="text" data-min="1" class="form-control pos_quantity input_number mousetrap input_quantity" value="1.00" name="products[2][quantity]" data-allow-overselling="false" data-decimal="0" data-rule-abs_digit="true" data-msg-abs_digit="Decimal value not allowed" data-rule-required="true" data-msg-required="This field is required" data-rule-max-value="50.0000" data-qty_available="50.0000" data-msg-max-value="Only 50.00 Pc(s) available" data-msg_max_default="Only 50.00 Pc(s) available">
		<span class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-up"><i class="fa fa-plus text-success"></i></button></span>
		</div>
		
		<input type="hidden" name="products[2][product_unit_id]" value="1">
					<br>
			<select name="products[2][sub_unit_id]" class="form-control input-sm sub_unit">
                                    <option value="1" data-multiplier="1" data-unit_name="Pieces" data-allow_decimal="0">
                        Pieces
                    </option>
                           </select>
		
		<input type="hidden" class="base_unit_multiplier" name="products[2][base_unit_multiplier]" value="1">

		<input type="hidden" class="hidden_base_unit_sell_price" value="437.5">
		
		
			</td>
			<td class="">
		<input type="text" name="products[2][unit_price_inc_tax]" class="form-control pos_unit_price_inc_tax input_number" value="437.50">
	</td>
	<td class="text-center">
				<input type="hidden" class="form-control pos_line_total " value="437.50">
		<span class="display_currency pos_line_total_text " data-currency_symbol="true">$ 437.50</span>
	</td>
	<td class="text-center v-center">
		<i class="fa fa-times text-danger pos_remove_row cursor-pointer" aria-hidden="true"></i>
	</td>
</tr></tbody>
		</table>
	</div>
</div>
								<div class="row">
	<div class="col-md-12">
		<table class="table table-condensed">
			<tbody><tr>
				<td><b>Items:</b>&nbsp;
					<span class="total_quantity">1.00</span></td>
				<td>
					<b>Total:</b> &nbsp;
					<span class="price_total">437.50</span>
				</td>
			</tr>
			<tr>
				<td>
					<b>
													Discount							<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Set 'Default Sale Discount' for all sales in Business Settings. Click on the edit icon below to add/update discount." data-html="true" data-trigger="hover"></i>																		(-):
						<i class="fas fa-edit cursor-pointer" id="pos-edit-discount" title="Edit Discount" aria-hidden="true" data-toggle="modal" data-target="#posEditDiscountModal"></i>
							<span id="total_discount">43.75</span>
							<input type="hidden" name="discount_type" id="discount_type" value="percentage" data-default="percentage">

							<input type="hidden" name="discount_amount" id="discount_amount" value="10.00" data-default="10.00">

							<input type="hidden" name="rp_redeemed" id="rp_redeemed" value="0">

							<input type="hidden" name="rp_redeemed_amount" id="rp_redeemed_amount" value="0">

							
					</b> 
				</td>
				<td class="">
					<span>
						<b>Order Tax(+): <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Set 'Default Sale Tax' for all sales in Business Settings. Click on the edit icon below to add/update Order Tax." data-html="true" data-trigger="hover"></i></b>
						<i class="fas fa-edit cursor-pointer" title="Edit Order Tax" aria-hidden="true" data-toggle="modal" data-target="#posEditOrderTaxModal" id="pos-edit-tax"></i> 
						<span id="order_tax">0.00</span>

						<input type="hidden" name="tax_rate_id" id="tax_rate_id" value="" data-default="">

						<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" value="0.00" data-default="">

					</span>
				</td>
				<td class="">
					<span>

						<b>Shipping(+): <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Set shipping details and shipping charges. Click on the edit icon below to add/update shipping details and charges." data-html="true" data-trigger="hover"></i></b> 
						<i class="fas fa-edit cursor-pointer" title="Shipping" aria-hidden="true" data-toggle="modal" data-target="#posShippingModal"></i>
						<span id="shipping_charges_amount">0.00</span>
						<input type="hidden" name="shipping_details" id="shipping_details" value="" data-default="">

						<input type="hidden" name="shipping_address" id="shipping_address" value="">

						<input type="hidden" name="shipping_status" id="shipping_status" value="">

						<input type="hidden" name="delivered_to" id="delivered_to" value="">

						<input type="hidden" name="shipping_charges" id="shipping_charges" value="0.00" data-default="0.00">
					</span>
				</td>
											</tr>
		</tbody></table>
	</div>
</div>
								<div class="modal fade" tabindex="-1" role="dialog" id="modal_payment" style="display: none;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Payment</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 mb-12">
						<strong>Advance Balance:</strong> <span id="advance_balance_text">$ 0.00</span>
						<input id="advance_balance" data-error-msg="Required advance balance not available" name="advance_balance" type="hidden" value="0.0000">
					</div>
					<div class="col-md-9">
						<div class="row">
							<div id="payment_rows_div">
																	
									
									<div class="col-md-12">
	<div class="box box-solid payment_row bg-lightgray">
		
        
		<div class="box-body">
			<div class="row">
	<input type="hidden" class="payment_row_index" value="0">
		<div class="col-md-4">
		<div class="form-group">
			<label for="amount_0">Amount:*</label>
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fas fa-money-bill-alt"></i>
				</span>
				<input class="form-control payment-amount input_number valid" required="" id="amount_0" placeholder="Amount" name="payment[0][amount]" type="text" value="0.00" aria-required="true" aria-invalid="false">
			</div>
		</div>
	</div>
		<div class="col-md-4">
		<div class="form-group">
			<label for="method_0">Payment Method:*</label>
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fas fa-money-bill-alt"></i>
				</span>
								<select class="form-control col-md-12 payment_types_dropdown valid" required="" id="method_0" style="width:100%;" name="payment[0][method]" aria-required="true"><option value="advance">Advance</option><option value="cash" selected="selected">Cash</option><option value="card">Card</option><option value="cheque">Cheque</option><option value="bank_transfer">Bank Transfer</option><option value="other">Other</option><option value="custom_pay_1">Custom Payment 1</option><option value="custom_pay_2">Custom Payment 2</option><option value="custom_pay_3">Custom Payment 3</option><option value="custom_pay_4" class="hide">Custom Payment 4</option><option value="custom_pay_5" class="hide">Custom Payment 5</option><option value="custom_pay_6" class="hide">Custom Payment 6</option><option value="custom_pay_7" class="hide">Custom Payment 7</option></select>

							</div>
		</div>
	</div>
			<div class="col-md-4">
			<div class="form-group">
				<label for="account_0">Payment Account:</label>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fas fa-money-bill-alt"></i>
					</span>
					<select class="form-control select2 account-dropdown select2-hidden-accessible" id="account_0" style="width:100%;" name="payment[0][account_id]" tabindex="-1" aria-hidden="true"><option value="" selected="selected">None</option></select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-account_0-container"><span class="select2-selection__rendered" id="select2-account_0-container" title="None">None</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="payment_details_div  hide " data-type="card">
	<div class="col-md-4">
		<div class="form-group">
			<label for="card_number_0">Card Number</label>
			<input class="form-control" placeholder="Card Number" id="card_number_0" name="payment[0][card_number]" type="text" value="">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="card_holder_name_0">Card holder name</label>
			<input class="form-control" placeholder="Card holder name" id="card_holder_name_0" name="payment[0][card_holder_name]" type="text" value="">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="card_transaction_number_0">Card Transaction No.</label>
			<input class="form-control" placeholder="Card Transaction No." id="card_transaction_number_0" name="payment[0][card_transaction_number]" type="text" value="">
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-3">
		<div class="form-group">
			<label for="card_type_0">Card Type</label>
			<select class="form-control" id="card_type_0" name="payment[0][card_type]"><option value="credit">Credit Card</option><option value="debit">Debit Card</option><option value="visa">Visa</option><option value="master">MasterCard</option></select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label for="card_month_0">Month</label>
			<input class="form-control" placeholder="Month" id="card_month_0" name="payment[0][card_month]" type="text" value="">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label for="card_year_0">Year</label>
			<input class="form-control" placeholder="Year" id="card_year_0" name="payment[0][card_year]" type="text" value="">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label for="card_security_0">Security Code</label>
			<input class="form-control" placeholder="Security Code" id="card_security_0" name="payment[0][card_security]" type="text" value="">
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="payment_details_div  hide " data-type="cheque">
	<div class="col-md-12">
		<div class="form-group">
			<label for="cheque_number_0">Cheque No.</label>
			<input class="form-control" placeholder="Cheque No." id="cheque_number_0" name="payment[0][cheque_number]" type="text" value="">
		</div>
	</div>
</div>
<div class="payment_details_div  hide " data-type="bank_transfer">
	<div class="col-md-12">
		<div class="form-group">
			<label for="bank_account_number_0">Bank Account No</label>
			<input class="form-control" placeholder="Bank Account No" id="bank_account_number_0" name="payment[0][bank_account_number]" type="text" value="">
		</div>
	</div>
</div>

<div class="payment_details_div  hide " data-type="custom_pay_1">
	<div class="col-md-12">
		<div class="form-group">
			<label for="transaction_no_1_0">Transaction No.</label>
			<input class="form-control" placeholder="Transaction No." id="transaction_no_1_0" name="payment[0][transaction_no_1]" type="text" value="">
		</div>
	</div>
</div>
<div class="payment_details_div  hide " data-type="custom_pay_2">
	<div class="col-md-12">
		<div class="form-group">
			<label for="transaction_no_2_0">Transaction No.</label>
			<input class="form-control" placeholder="Transaction No." id="transaction_no_2_0" name="payment[0][transaction_no_2]" type="text" value="">
		</div>
	</div>
</div>
<div class="payment_details_div  hide " data-type="custom_pay_3">
	<div class="col-md-12">
		<div class="form-group">
			<label for="transaction_no_3_0">Transaction No.</label>
			<input class="form-control" placeholder="Transaction No." id="transaction_no_3_0" name="payment[0][transaction_no_3]" type="text" value="">
		</div>
	</div>
</div>
<div class="payment_details_div  hide " data-type="custom_pay_4">
	<div class="col-md-12">
		<div class="form-group">
			<label for="transaction_no_4_0">Transaction No.</label>
			<input class="form-control" placeholder="Transaction No." id="transaction_no_4_0" name="payment[0][transaction_no_4]" type="text" value="">
		</div>
	</div>
</div>
<div class="payment_details_div  hide " data-type="custom_pay_5">
	<div class="col-md-12">
		<div class="form-group">
			<label for="transaction_no_5_0">Transaction No.</label>
			<input class="form-control" placeholder="Transaction No." id="transaction_no_5_0" name="payment[0][transaction_no_5]" type="text" value="">
		</div>
	</div>
</div>
<div class="payment_details_div  hide " data-type="custom_pay_6">
	<div class="col-md-12">
		<div class="form-group">
			<label for="transaction_no_6_0">Transaction No.</label>
			<input class="form-control" placeholder="Transaction No." id="transaction_no_6_0" name="payment[0][transaction_no_6]" type="text" value="">
		</div>
	</div>
</div>
<div class="payment_details_div  hide " data-type="custom_pay_7">
	<div class="col-md-12">
		<div class="form-group">
			<label for="transaction_no_7_0">Transaction No.</label>
			<input class="form-control" placeholder="Transaction No." id="transaction_no_7_0" name="payment[0][transaction_no_7]" type="text" value="">
		</div>
	</div>
</div>
	<div class="col-md-12">
		<div class="form-group">
			<label for="note_0">Payment note:</label>
			<textarea class="form-control" rows="3" id="note_0" name="payment[0][note]" cols="50"></textarea>
		</div>
	</div>
</div>		</div>
	</div>
</div>															</div>
							<input type="hidden" id="payment_row_index" value="1">
						</div>
						<div class="row">
							<div class="col-md-12">
								<button type="button" class="btn btn-primary btn-block" id="add-payment-row">Add Payment Row</button>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="sale_note">Sell note:</label>
									<textarea class="form-control" rows="3" placeholder="Sell note" name="sale_note" cols="50" id="sale_note"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="staff_note">Staff note:</label>
									<textarea class="form-control" rows="3" placeholder="Staff note" name="staff_note" cols="50" id="staff_note"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box box-solid bg-orange">
				            <div class="box-body">
				            	<div class="col-md-12">
				            		<strong>
				            			Total Items:
				            		</strong>
				            		<br>
				            		<span class="lead text-bold total_quantity">1.00</span>
				            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			Total Payable:
				            		</strong>
				            		<br>
				            		<span class="lead text-bold total_payable_span">$ 393.75</span>
				            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			Total Paying:
				            		</strong>
				            		<br>
				            		<span class="lead text-bold total_paying">$ 393.75</span>
				            		<input type="hidden" id="total_paying_input" value="393.75">
				            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			Change Return:
				            		</strong>
				            		<br>
				            		<span class="lead text-bold change_return_span">$ 0.00</span>
				            		<input class="form-control change_return input_number" required="" id="change_return" name="change_return" type="hidden" value="0.00" aria-required="true">
				            		<!-- <span class="lead text-bold total_quantity">0</span> -->
				            						            	</div>

				            	<div class="col-md-12">
				            		<hr>
				            		<strong>
				            			Balance:
				            		</strong>
				            		<br>
				            		<span class="lead text-bold balance_due">$ 0.00</span>
				            		<input type="hidden" id="in_balance_due" value="0.00">
				            	</div>


				            					              
				            </div>
				            <!-- /.box-body -->
				          </div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="pos-save" disabled="disabled">Finalize Payment</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Used for express checkout card transaction -->
<div class="modal fade" tabindex="-1" role="dialog" id="card_details_modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Card transaction details</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">

		<div class="col-md-4">
			<div class="form-group">
				<label for="card_number">Card Number</label>
				<input class="form-control" placeholder="Card Number" id="card_number" autofocus="" name="" type="text">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="card_holder_name">Card holder name</label>
				<input class="form-control" placeholder="Card holder name" id="card_holder_name" name="" type="text">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="card_transaction_number">Card Transaction No.</label>
				<input class="form-control" placeholder="Card Transaction No." id="card_transaction_number" name="" type="text">
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="card_type">Card Type</label>
				<select class="form-control select2 select2-hidden-accessible" id="card_type" name="" tabindex="-1" aria-hidden="true"><option value="visa" selected="selected">Visa</option><option value="master">MasterCard</option></select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-card_type-container"><span class="select2-selection__rendered" id="select2-card_type-container" title="Visa">Visa</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="card_month">Month</label>
				<input class="form-control" placeholder="Month" id="card_month" name="" type="text">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="card_year">Year</label>
				<input class="form-control" placeholder="Year" id="card_year" name="" type="text">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="card_security">Security Code</label>
				<input class="form-control" placeholder="Security Code" id="card_security" name="" type="text">
			</div>
		</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="pos-save-card">Finalize Payment</button>
			</div>

		</div>
	</div>
</div>
																	<div class="modal fade" tabindex="-1" role="dialog" id="confirmSuspendModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Suspend Sale</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
				        <div class="form-group">
				            <label for="additional_notes">Suspend Note:</label>
				            <textarea class="form-control" rows="4" name="additional_notes" cols="50" id="additional_notes"></textarea>
				            <input id="is_suspend" name="is_suspend" type="hidden" value="0">
				        </div>
				    </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="pos-suspend">Save</button>
			    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->								
																	<!-- Edit discount Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="recurringInvoiceModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Subscribe </h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
				        <div class="form-group">
				        	<label for="recur_interval">Subscription Interval:*</label>
				        	<div class="input-group">
				               <input class="form-control" required="" style="width: 50%;" name="recur_interval" type="number" id="recur_interval" aria-required="true">
				               
				                <select class="form-control" required="" style="width: 50%;" id="recur_interval_type" name="recur_interval_type" aria-required="true"><option value="days" selected="selected">Days</option><option value="months">Months</option><option value="years">Years</option></select>
				                
				            </div>
				        </div>
				    </div>

				    <div class="col-md-6">
				        <div class="form-group">
				        	<label for="recur_repetitions">No. of Repetitions:</label>
				        	<input class="form-control" name="recur_repetitions" type="number" id="recur_repetitions">
					        <p class="help-block">If blank invoice will be generated infinite times</p>
				        </div>
				    </div>
				    				    <div class="subscription_repeat_on_div col-md-6  hide ">
				        <div class="form-group">
				        	<label for="subscription_repeat_on">Repeat on:</label>
				        	<select class="form-control" id="subscription_repeat_on" name="subscription_repeat_on"><option selected="selected" value="">Please Select</option><option value="1">1st</option><option value="2">2nd</option><option value="3">3rd</option><option value="4">4th</option><option value="5">5th</option><option value="6">6th</option><option value="7">7th</option><option value="8">8th</option><option value="9">9th</option><option value="10">10th</option><option value="11">11th</option><option value="12">12th</option><option value="13">13th</option><option value="14">14th</option><option value="15">15th</option><option value="16">16th</option><option value="17">17th</option><option value="18">18th</option><option value="19">19th</option><option value="20">20th</option><option value="21">21st</option><option value="22">22nd</option><option value="23">23rd</option><option value="24">24th</option><option value="25">25th</option><option value="26">26th</option><option value="27">27th</option><option value="28">28th</option><option value="29">29th</option><option value="30">30th</option></select>
				        </div>
				    </div>

				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->															</div>
						</div>
					</div>
								<div class="col-md-5 no-padding">
					<div class="row" id="featured_products_box" style="display: none;">
</div>
<div class="row">
			<div class="col-md-4" id="product_category_div">
			<select class="select2 select2-hidden-accessible" id="product_category" style="width:100% !important" tabindex="-1" aria-hidden="true">

				<option value="all">All Categories</option>

									<option value="3">Accessories</option>
									<option value="18">Books</option>
									<option value="12">Electronics</option>
									<option value="21">Food &amp; Grocery</option>
									<option value="1">Men's</option>
									<option value="15">Sports</option>
									<option value="2">Women's</option>
				
															<optgroup label="Accessories">
															 <option value="6">Belts</option>
															 <option value="10">Sandal</option>
															 <option value="8">Shoes</option>
															 <option value="11">Wallets</option>
													</optgroup>
																				<optgroup label="Books">
															 <option value="19">Autobiography</option>
															 <option value="20">Children's books</option>
													</optgroup>
																				<optgroup label="Electronics">
															 <option value="13">Cell Phones</option>
															 <option value="14">Computers</option>
													</optgroup>
																													<optgroup label="Men's">
															 <option value="4">Jeans</option>
															 <option value="5">Shirts</option>
													</optgroup>
																				<optgroup label="Sports">
															 <option value="16">Athletic Clothing</option>
															 <option value="17">Exercise &amp; Fitness</option>
													</optgroup>
																					</select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-product_category-container"><span class="select2-selection__rendered" id="select2-product_category-container" title="All Categories">All Categories</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
		</div>
	
			<div class="col-sm-4" id="product_brand_div">
			<select id="product_brand" class="select2 select2-hidden-accessible" name="size" style="width:100% !important" tabindex="-1" aria-hidden="true"><option value="all">All Brands</option><option value="9">Acer</option><option value="6">Adidas</option><option value="8">Apple</option><option value="13">Barilla</option><option value="10">Bowflex</option><option value="2">Espirit</option><option value="1">Levis</option><option value="14">Lipton</option><option value="4">Nike</option><option value="11">Oreo</option><option value="5">Puma</option><option value="7">Samsung</option><option value="12">Sharewood</option><option value="3">U.S. Polo Assn.</option></select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-product_brand-container"><span class="select2-selection__rendered" id="select2-product_brand-container" title="All Brands">All Brands</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
		</div>
	
	<!-- used in repair : filter for service/product -->
	<div class="col-md-6 hide" id="product_service_div">
		<select id="is_enabled_stock" class="select2 select2-hidden-accessible" name="is_enabled_stock" style="width:100% !important" tabindex="-1" aria-hidden="true"><option value="" selected="selected">All</option><option value="product">Product</option><option value="service">Service</option></select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-is_enabled_stock-container"><span class="select2-selection__rendered" id="select2-is_enabled_stock-container" title="All">All</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
	</div>

	<div class="col-sm-4  hide " id="feature_product_div">
		<button type="button" class="btn btn-primary btn-flat" id="show_featured_products">Featured Products</button>
	</div>
</div>
<br>
<div class="row">
	<input type="hidden" id="suggestion_page" value="1">
	<div class="col-md-12">
		<div class="eq-height-row" id="product_list_body"><div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="57" title="Acer Aspire E 15 - Black  (AS0017-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727793_acerE15.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Acer Aspire E 15 
							- Black
						</small>

			<small class="text-muted">
				(AS0017-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="58" title="Acer Aspire E 15 - White  (AS0017-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727793_acerE15.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Acer Aspire E 15 
							- White
						</small>

			<small class="text-muted">
				(AS0017-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="107" title="Apple - Fuji  (AS0064) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528780234_apples.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple - Fuji 
						</small>

			<small class="text-muted">
				(AS0064)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="49" title="Apple iPhone 8 - White  (AS0015-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727817_iphone8.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple iPhone 8 
							- White
						</small>

			<small class="text-muted">
				(AS0015-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="50" title="Apple iPhone 8 - Gray  (AS0015-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727817_iphone8.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple iPhone 8 
							- Gray
						</small>

			<small class="text-muted">
				(AS0015-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="51" title="Apple iPhone 8 - Black  (AS0015-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727817_iphone8.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple iPhone 8 
							- Black
						</small>

			<small class="text-muted">
				(AS0015-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="52" title="Apple iPhone 8 - 32 GB  (AS0015-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727817_iphone8.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple iPhone 8 
							- 32 GB
						</small>

			<small class="text-muted">
				(AS0015-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="53" title="Apple iPhone 8 - 64 GB  (AS0015-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727817_iphone8.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple iPhone 8 
							- 64 GB
						</small>

			<small class="text-muted">
				(AS0015-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="59" title="Apple MacBook Air - 256 GB  (AS0018-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727849_macbookair.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple MacBook Air 
							- 256 GB
						</small>

			<small class="text-muted">
				(AS0018-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="60" title="Apple MacBook Air - 500 GB  (AS0018-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727849_macbookair.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Apple MacBook Air 
							- 500 GB
						</small>

			<small class="text-muted">
				(AS0018-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="61" title="Cushion Crew Socks  (AS0019) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727903_socks.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Cushion Crew Socks 
						</small>

			<small class="text-muted">
				(AS0019)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="65" title="Diary of a Wimpy Kid  (AS0022) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727917_diary_of_whimp_kid.jpeg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Diary of a Wimpy Kid 
						</small>

			<small class="text-muted">
				(AS0022)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="67" title="Etched in Sand Autobiography  (AS0024) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727933_etched_in_stone.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Etched in Sand Autobiography 
						</small>

			<small class="text-muted">
				(AS0024)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="68" title="Five Presidents  (AS0025) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727949_five_pesident.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Five Presidents 
						</small>

			<small class="text-muted">
				(AS0025)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="2" title="Levis Men's Slimmy Fit Jeans - 28  (AS0002-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727964_levis_jeans.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Levis Men's Slimmy Fit Jeans 
							- 28
						</small>

			<small class="text-muted">
				(AS0002-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="3" title="Levis Men's Slimmy Fit Jeans - 30  (AS0002-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727964_levis_jeans.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Levis Men's Slimmy Fit Jeans 
							- 30
						</small>

			<small class="text-muted">
				(AS0002-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="4" title="Levis Men's Slimmy Fit Jeans - 32  (AS0002-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727964_levis_jeans.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Levis Men's Slimmy Fit Jeans 
							- 32
						</small>

			<small class="text-muted">
				(AS0002-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="5" title="Levis Men's Slimmy Fit Jeans - 34  (AS0002-4) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727964_levis_jeans.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Levis Men's Slimmy Fit Jeans 
							- 34
						</small>

			<small class="text-muted">
				(AS0002-4)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="6" title="Levis Men's Slimmy Fit Jeans - 36  (AS0002-5) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727964_levis_jeans.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Levis Men's Slimmy Fit Jeans 
							- 36
						</small>

			<small class="text-muted">
				(AS0002-5)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="73" title="Lipton Black Tea Bags  (AS0030) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528727999_lipton_tea.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Lipton Black Tea Bags 
						</small>

			<small class="text-muted">
				(AS0030)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="204" title="Masoori  (321311) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/img/default.png
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Masoori 
						</small>

			<small class="text-muted">
				(321311)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="42" title="Men Full sleeve T Shirt - M  (AS0013-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728019_mens_tshirt.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men Full sleeve T Shirt 
							- M
						</small>

			<small class="text-muted">
				(AS0013-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="43" title="Men Full sleeve T Shirt - L  (AS0013-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728019_mens_tshirt.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men Full sleeve T Shirt 
							- L
						</small>

			<small class="text-muted">
				(AS0013-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="44" title="Men Full sleeve T Shirt - XL  (AS0013-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728019_mens_tshirt.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men Full sleeve T Shirt 
							- XL
						</small>

			<small class="text-muted">
				(AS0013-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="7" title="Men's Cozy Hoodie Sweater - S  (AS0003-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728035_cozy_sweater.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men's Cozy Hoodie Sweater 
							- S
						</small>

			<small class="text-muted">
				(AS0003-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="8" title="Men's Cozy Hoodie Sweater - M  (AS0003-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728035_cozy_sweater.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men's Cozy Hoodie Sweater 
							- M
						</small>

			<small class="text-muted">
				(AS0003-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="9" title="Men's Cozy Hoodie Sweater - L  (AS0003-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728035_cozy_sweater.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men's Cozy Hoodie Sweater 
							- L
						</small>

			<small class="text-muted">
				(AS0003-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="10" title="Men's Cozy Hoodie Sweater - XL  (AS0003-4) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728035_cozy_sweater.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men's Cozy Hoodie Sweater 
							- XL
						</small>

			<small class="text-muted">
				(AS0003-4)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="1" title="Men's Reverse Fleece Crew  (AS0001) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728059_fleece_crew.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Men's Reverse Fleece Crew 
						</small>

			<small class="text-muted">
				(AS0001)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="27" title="Nike Fashion Sneaker - 6  (AS0008-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728076_nike_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Nike Fashion Sneaker 
							- 6
						</small>

			<small class="text-muted">
				(AS0008-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="28" title="Nike Fashion Sneaker - 7  (AS0008-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728076_nike_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Nike Fashion Sneaker 
							- 7
						</small>

			<small class="text-muted">
				(AS0008-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="29" title="Nike Fashion Sneaker - 8  (AS0008-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728076_nike_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Nike Fashion Sneaker 
							- 8
						</small>

			<small class="text-muted">
				(AS0008-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="30" title="Nike Fashion Sneaker - 9  (AS0008-4) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728076_nike_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Nike Fashion Sneaker 
							- 9
						</small>

			<small class="text-muted">
				(AS0008-4)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="35" title="NIKE Men's Running Shoe - 5  (AS0010-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728095_nike_running_shoe.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">NIKE Men's Running Shoe 
							- 5
						</small>

			<small class="text-muted">
				(AS0010-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="36" title="NIKE Men's Running Shoe - 6  (AS0010-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728095_nike_running_shoe.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">NIKE Men's Running Shoe 
							- 6
						</small>

			<small class="text-muted">
				(AS0010-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="37" title="NIKE Men's Running Shoe - 7  (AS0010-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728095_nike_running_shoe.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">NIKE Men's Running Shoe 
							- 7
						</small>

			<small class="text-muted">
				(AS0010-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="38" title="NIKE Men's Running Shoe - 8  (AS0010-4) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728095_nike_running_shoe.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">NIKE Men's Running Shoe 
							- 8
						</small>

			<small class="text-muted">
				(AS0010-4)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="39" title="NIKE Men's Running Shoe - 9  (AS0010-5) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728095_nike_running_shoe.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">NIKE Men's Running Shoe 
							- 9
						</small>

			<small class="text-muted">
				(AS0010-5)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="69" title="Oreo Cookies  (AS0026) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728111_oreo.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Oreo Cookies 
						</small>

			<small class="text-muted">
				(AS0026)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="108" title="Organic Egg  (AS0065) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528780470_eggs.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Organic Egg 
						</small>

			<small class="text-muted">
				(AS0065)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="64" title="Pair Of Dumbbells  (AS0021) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728133_pair_of_dumbell.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Pair Of Dumbbells 
						</small>

			<small class="text-muted">
				(AS0021)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="105" title="Pinot Noir Red Wine  (AS0062) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528779737_wine2.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Pinot Noir Red Wine 
						</small>

			<small class="text-muted">
				(AS0062)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="11" title="Puma Brown Sneaker - 6  (AS0004-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728147_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Puma Brown Sneaker 
							- 6
						</small>

			<small class="text-muted">
				(AS0004-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="12" title="Puma Brown Sneaker - 7  (AS0004-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728147_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Puma Brown Sneaker 
							- 7
						</small>

			<small class="text-muted">
				(AS0004-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="13" title="Puma Brown Sneaker - 8  (AS0004-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728147_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Puma Brown Sneaker 
							- 8
						</small>

			<small class="text-muted">
				(AS0004-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="14" title="Puma Brown Sneaker - 9  (AS0004-4) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728147_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">Puma Brown Sneaker 
							- 9
						</small>

			<small class="text-muted">
				(AS0004-4)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="31" title="PUMA Men's Black Sneaker - 6  (AS0009-1) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728163_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">PUMA Men's Black Sneaker 
							- 6
						</small>

			<small class="text-muted">
				(AS0009-1)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="32" title="PUMA Men's Black Sneaker - 7  (AS0009-2) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728163_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">PUMA Men's Black Sneaker 
							- 7
						</small>

			<small class="text-muted">
				(AS0009-2)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="33" title="PUMA Men's Black Sneaker - 8  (AS0009-3) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728163_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">PUMA Men's Black Sneaker 
							- 8
						</small>

			<small class="text-muted">
				(AS0009-3)
			</small>
		</div>
			
		</div>
	</div>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="34" title="PUMA Men's Black Sneaker - 9  (AS0009-4) ">

		<div class="image-container" style="background-image: url(
											https://pos.ultimatefosters.com/uploads/img/1528728163_puma_brown_sneaker.jpg
									);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted">PUMA Men's Black Sneaker 
							- 9
						</small>

			<small class="text-muted">
				(AS0009-4)
			</small>
		</div>
			
		</div>
	</div>
</div>
	</div>
	<div class="col-md-12 text-center" id="suggestion_page_loader" style="display: none;">
		<i class="fa fa-spinner fa-spin fa-2x"></i>
	</div>
</div>				</div>
							</div>
		</div>




	<div class="pos-form-actions">
		<div class="col-md-12">
						<button type="button" class=" btn bg-info text-white btn-default btn-flat " id="pos-draft" disabled="disabled"><i class="fas fa-edit"></i> Draft</button>
			<button type="button" class="btn btn-default bg-yellow btn-flat " id="pos-quotation" disabled="disabled"><i class="fas fa-edit"></i> Quotation</button>

							<button type="button" class=" btn bg-red btn-default btn-flat no-print pos-express-finalize" data-pay_method="suspend" title="Suspend Sales (pause)" disabled="disabled">
				<i class="fas fa-pause" aria-hidden="true"></i>
				Suspend				</button>
			
							<input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
				<button type="button" class="btn bg-purple btn-default btn-flat no-print pos-express-finalize " data-pay_method="credit_sale" title="Checkout as credit sale" disabled="disabled">
					<i class="fas fa-check" aria-hidden="true"></i> Credit Sale				</button>
						<button type="button" class="btn bg-maroon btn-default btn-flat no-print  pos-express-finalize  " data-pay_method="card" title="Express checkout using card" disabled="disabled">
				<i class="fas fa-credit-card" aria-hidden="true"></i> Card			</button>

			<button type="button" class="btn bg-navy btn-default   btn-flat no-print  " id="pos-finalize" title="Checkout using multiple payment methods" disabled="disabled"><i class="fas fa-money-check-alt" aria-hidden="true"></i> Multiple Pay </button>

			<button type="button" class="btn btn-success   btn-flat no-print  pos-express-finalize " data-pay_method="cash" title="Mark complete paid &amp; checkout" disabled="disabled"> <i class="fas fa-money-bill-alt" aria-hidden="true"></i> Cash</button>
						&nbsp;&nbsp;
			<b>Total Payable:</b>
			<input type="hidden" name="final_total" id="final_total_input" value="393.75">
			<span id="total_payable" class="text-success lead text-bold">393.75</span>
			&nbsp;&nbsp;
										<button type="button" class="btn btn-danger btn-flat  btn-xs " id="pos-cancel" disabled="disabled"> <i class="fas fa-window-close"></i> Cancel</button>
			
						<button type="button" class="btn btn-primary btn-flat pull-right " data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions" disabled="disabled"> <i class="fas fa-clock"></i> Recent Transactions</button>
						
		</div>
	</div>
    </div>
<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<!-- Data table plugin-->
<script type='text/javascript' src="<?php echo base_url('assets/js/jquery.mycart.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>


<script type='text/javascript'>
	var productsList = <?php echo json_encode($product_show_for_sale, JSON_PRETTY_PRINT) ?>;
	$(document).ready(function() {

		var itemsInCart = [];
		var totalPrice = 0;

		$("#productSale").on("click", function() {

			var discount = $("#discount").val();
			var others_cost = $("#others_cost").val();

			var itemsInCartObject = Object.assign({}, itemsInCart);
			//console.log(itemsInCartObject);

			var sales_process_url = "http://localhost/codeigniter4/pos/sale";

			$.ajax({
				url: sales_process_url, // complete url from siteurl/constroller/function
				method: 'POST',
				data: {
					cart_data: itemsInCartObject,
					discount,
					others_cost
				},
				success: function(data) {
					//alert('success');
					$("#inVoiceAdd").modal('show');
					$("#invoiceData").html(data);
				},
				error: function() {
					alert('error');
				}
			});

		});

		$("#item").on('change', function() {
			var product_id = $(this).val();
			//alert(product_id);
			productAddToCart(product_id);
		});

		$(".extra-fields").on("input", function() {
			totalCalculation();
		});


		$('body').on("input", ".product_quantity_change", function() {

			var index = $(this).data("id");
			var newQuantity = Number.parseInt($(this).val());

			var current_stock = Number.parseInt($(this).data('current_stock'));
          if(newQuantity < current_stock) {
			if (newQuantity < 1) {
				itemsInCart.splice(index, 1);
			} else {
				itemsInCart[index].quantity = newQuantity;
			}
			drawTable();
            }
			else{
				itemsInCart[index].quantity = current_stock;
				$(this).val(current_stock);
				alert("Your Stock is Exceeded !");
			}
		});


		/* Product Delete Strat */
		$('body').on("click", ".btn_item_delete", function() {
			//if (confirm("Really Want to Delete ?")) {
			var index = $(this).data("index");
			itemsInCart.splice(index, 1);
			drawTable();
			//}
		});
		/* Product Delete End */

		/* Image e click kore product add kora strat */
		$('body').on("click", ".cart_item_image", function() {
			var product_id = $(this).data("id");
			productAddToCart(product_id);
		});
		/* Image e click kore product add kora End */
		/*
		Cart Initialize the cart
		*/
		function productAddToCart(product_id) {
			$.each(productsList, function(key, value) {
				if (value.product_id == product_id) {
					var response = itemExist(product_id);
					if (response.inCart) {
						itemsInCart[response.productIndex].quantity = itemsInCart[response.productIndex].quantity + 1;
					} else {
						value.quantity = 1;
						itemsInCart.push(value);
					}
					drawTable();
				}
			});
		}

		/*
		Draw / Redraw Table
		*/
		function drawTable() {
			$("#cartTableBody").empty();
			$("#totalPrice").html("0.00");
			totalPrice = 0;
			$.each(itemsInCart, function(key, item) {
				var totalBasePrice = parseInt(item.quantity) * parseFloat(item.selling_unit_price);
				var subTotalTax = parseFloat(totalBasePrice) * (parseFloat(item.tax_perchantage) / 100);
				var subtotalPrice = parseFloat(totalBasePrice) + subTotalTax;
				$("#cartTableBody").append('<tr>' +
					'<td>' + item.product_name + '</td>' +
					'<td>' + item.total_stock + '</td>' +
					'<td>' +
					'<input  data-current_stock="'+item.total_stock+'"  data-oldQuantity="' + item.quantity + '" data-id="' + key + '" class="product_quantity_change" type = "number"  size="4"' +
					'value="' + item.quantity + '" onkeypress="return accept_digit_only(event)" min="0"+ max="99999"/> ' +
					'</td>' +
					'<td>' + item.selling_unit_price + '</td>' +
					'<td> ' + item.tax_perchantage + '% = ' + subTotalTax.toFixed(2) +
					'</td>' +
					'<td class = "text-right" > ' + subtotalPrice.toFixed(2) +
					'<button  data-index="' + key + '" class="badge badge-danger badge-sm btn_item_delete">' +
					'<i class="fa fa-times"></i></button>' +
					'</td>' +
					'</tr>');
				totalPrice += subtotalPrice;
				//item.tax_perchantage.toFixed(2)
			});
			totalCalculation();
		}

		/*
		Calculate Table Total / SUbtotal 
		*/
		function totalCalculation() {
			var discount = $("#discount").val();
			if (discount != "") {
				discount = parseFloat((Number.isNaN(discount)) ? 0 : discount);
			} else {
				discount = 0;
			}
			var others_cost = $("#others_cost").val();
			if (others_cost != "") {
				others_cost = parseFloat((Number.isNaN(others_cost)) ? 0 : others_cost);
			} else {
				others_cost = 0;
			}
			var netTotalPrice = (totalPrice + others_cost) - discount;

			$("#totalPrice").html(totalPrice.toFixed(2));
			$("#netTotalPrice").html(netTotalPrice.toFixed(2));
		}


		/*
		Chek Is the selected Item Exist in List
		*/
		function itemExist(product_id) {
			var response = {
				inCart: false,
				productIndex: null
			};
			$.each(itemsInCart, function(key, item) {
				if (item.product_id == product_id) {
					if (!response.inCart) {
						response.inCart = true;
						response.productIndex = key;
					}
				}
			});
			return response;
		}


	});
</script>

</script>
<?php
echo $this->endSection();
?>
	
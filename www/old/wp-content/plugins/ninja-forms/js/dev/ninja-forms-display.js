jQuery(document).ready(function(jQuery) {
	// Initiate our response function list variable.
	window['ninja_forms_response_function_list'] = {};

	// Initiate our beforeSubmit function list variable.
	window['ninja_forms_before_submit_function_list'] = {};

	// Prevent the enter key from submitting the form.
	jQuery(".ninja-forms-form input").bind("keypress", function(e) {
		if (e.keyCode == 13) {
			var type = jQuery(this).attr("type");
			if( type != "textarea" ){
				return false;
			}
		}
	});

	/* * * Begin Mask JS * * */

	jQuery("div.label-inside input, div.label-inside textarea").focus(function(){
		var label = jQuery("#" + this.id + "_label_hidden").val();
		if( this.value == label ){
			this.value = '';
		}
	});

	jQuery("div.label-inside input, div.label-inside textarea").blur(function(){
		var label = jQuery("#" + this.id + "_label_hidden").val();
		if( this.value == '' ){
			this.value = label;
		}
	});

	if( jQuery.fn.mask ){
		jQuery(".ninja-forms-mask").each(function(){
			var mask = this.title;
			jQuery(this).mask(mask);
		});

		jQuery(".ninja-forms-date").mask('99/99/9999');
	}

	if( jQuery.fn.datepicker ){
		jQuery(".ninja-forms-datepicker").datepicker({
			dateFormat: ninja_forms_settings.date_format
		});
	}

	if( jQuery.fn.autoNumeric ){
		jQuery(".ninja-forms-currency").autoNumeric({aSign: ninja_forms_settings.currency_symbol});
	}

	/* * * End Mask JS * * */

	/* * * Begin Help Hover JS * * */

	if( jQuery.fn.qtip ){
		jQuery(".ninja-forms-help-text").qtip({
			style: {
				classes: 'qtip-shadow qtip-dark'
			}
		});
	}

	/* * * End Help Hover JS * * */


	/* * * Begin ajaxForms JS * * */

	/* 
	 * Attaching events to these elements can allow devs to mimic a priority system for event firing.
	 * Priority is handled by the element that the event handlers are attached to: 
	 * 1) Event handlers attached to the form itself will be fired first.
	 * 2) Event handlers attached to the 'body' element will be fired second.
	 * 3) Event handlers attached to the document element will be fired last.
	 * These lines give examples of the elements that can have events attached to them for beforeSubmit actions.

	jQuery("#ninja_forms_form_2").on('beforeSubmit.example', function(e, formData, jqForm, options){
		alert('hello world');
		return true;
	});

	jQuery(".ninja-forms-form").on('beforeSubmit.example', function(e, formData, jqForm, options){
		alert('hello world');
		return true;
	});

	jQuery('body').on('beforeSubmit.example', function(e, formData, jqForm, options ){
		alert('hello world');
		return true;
	});	

	jQuery(document).on('beforeSubmit.example', function(e, formData, jqForm, options ){
		alert('world');
		return true;
	});

	* If you want to remove an event handler, you can use the jQuery .off() method.

	jQuery(document).off('beforeSubmit.example');

	*/

	jQuery(".ninja-forms-form").each(function(){
		var form_id = this.id.replace("ninja_forms_form_", "");
		var settings = window['ninja_forms_form_' + form_id + '_settings'];
		ajax = settings.ajax
		if(ajax == 1){
			var options = {
			beforeSubmit:  ninja_forms_before_submit,
			success:       ninja_forms_response,
			dataType: 'json'
			};
			jQuery(this).ajaxForm(options);

			// Add our default response handler if "custom" hasn't been selected.
			jQuery(this).on('submitResponse.default', function(e, response){
				return ninja_forms_default_response( response );
			});

			// Add our default beforeSubmit handler.
			jQuery(this).on('beforeSubmit.default', function(e, formData, jqForm, options){
				return ninja_forms_default_before_submit( formData, jqForm, options );
			});
		} else {
			jQuery(this).submit( function(e){
				var formData = jQuery(this).serialize();
				var jqForm = this;
				var options = '';
				return ninja_forms_before_submit(formData, jqForm, options);
			});
		}
	});

	/* * * End ajaxForm JS * * */

	/* 
	 * Password Field JS
	 */

	jQuery('.pass1').val('').keyup( function(){
		var pass1 = this.value;
		var pass2 = this.id.replace( "pass1", "pass2" );
		pass2 = jQuery( "#" + pass2 ).val();
		check_pass_strength( pass1, pass2 );
	});
	jQuery('.pass2').val('').keyup( function(){
		var pass2 = this.value;
		var pass1 = this.id.replace( "pass2", "pass1" );
		pass1 = jQuery( "#" + pass1 ).val();
		check_pass_strength( pass1, pass2 );
	});

	/*
	 * Calculation Field JS
	 */

	var selects = jQuery(".ninja-forms-field-calc-listen");

	selects.each(function (i, element) {
		var select = jQuery(element);
		var previousValue = jQuery(this).val();
		if ( this.type !== 'checkbox' ) {
			jQuery(element).data("oldValue", previousValue);
		}
	});

	jQuery('body').on( 'focus', '.ninja-forms-field-list-options-span-calc-listen', function(e){
		var field_id = jQuery(this).attr("rel");
		jQuery(this).data("oldValue", jQuery("input[name='ninja_forms_field_" + field_id +"']:checked").val());
	});

	jQuery('body').on( 'mousedown', '.ninja-forms-field-list-options-span-calc-listen', function(e){
		var field_id = jQuery(this).attr("rel");
		jQuery(this).data("oldValue", jQuery("input[name='ninja_forms_field_" + field_id +"']:checked").val());
	});

	// Listen to the input elements for our auto-calculation fields and change the total.
	jQuery('body').on( 'change', '.ninja-forms-field-calc-listen', function(event){
		
		if ( this == event.target ) {

			// Get our calc settings.
			var form_id = ninja_forms_get_form_id( this );
			var field_id = jQuery(this).attr("rel");
			var calc_settings = window['ninja_forms_form_' + form_id + '_calc_settings'];
			// Get our auto total field or fields.

			for ( calc_id in calc_settings.calc_fields ) {
				if ( calc_id != field_id ) {
					var calc_method = calc_settings.calc_fields[calc_id]['method'];
					var calc_places = calc_settings.calc_fields[calc_id]['places'];
					// Find out which calc_method we're using.
					// If we're using the 'fields' method, bail if the current field isn't in our field list.
					if ( calc_method == 'fields' ) {
						var change = false;
						for (var i = calc_settings.calc_fields[calc_id]['fields'].length - 1; i >= 0; i--) {
							if ( calc_settings.calc_fields[calc_id]['fields'][i]['field'] == field_id ) {
								change = true;
								break;
							}
						};

					} else if ( calc_method == 'eq' ) { // If we're using the 'eq' method, make sure that our current field is in our equation
						var change = false;
						if ( typeof calc_settings.calc_fields[calc_id]['fields'] !== 'undefined' ) {
							for (var i = calc_settings.calc_fields[calc_id]['fields'].length - 1; i >= 0; i--) {
								if ( calc_settings.calc_fields[calc_id]['fields'][i] == field_id ) {
									change = true;
									break;
								}
							};					
						}
					}

					if ( ( ( calc_method == 'fields' || calc_method == 'eq' ) && change ) || calc_method == 'auto' ) {
						if ( calc_method == 'auto' || calc_method == 'fields' ) { // Method: auto or fields
							// Loop through our calc fields and check to see if they are set to auto. If they are, perform the auto totalling actions.
							var key = jQuery(this).val();
							var new_value = '';
							// Set our old_value to the previous one for this field.
							old_value = jQuery(this).data('oldValue');
								
							// Check to see if we are in a list field. If we are, we can grab the calc values.
							if ( jQuery('#ninja_forms_field_' + field_id + '_type' ).val() == 'list' ) {
								var key = jQuery(this).val();
								// See if we have any old values. If we do, compare them to our current selection for this field and see if we need to subtract anything.
								if ( jQuery('#ninja_forms_field_' + field_id + '_list_type').val() == 'checkbox' ) {
									if ( !this.checked ) {
										old_value = key;
										new_value = 0;
									}
								} else if ( jQuery('#ninja_forms_field_' + field_id + '_list_type').val() == 'radio' ) {
									// If this is a checkbox or a radio list, then we have to check the span parent for the oldValue.
									var span = jQuery(this).parent().parent().parent().parent();
									old_value = jQuery(span).data('oldValue');
								} else if ( jQuery('#ninja_forms_field_' + field_id + '_list_type').val() == 'multi' ) {
									// This is a multi-select list. The value is in an array, so we need to add all the values together.
									if ( jQuery.isArray( key ) ) {
										var tmp = 0;
										for (var i = key.length - 1; i >= 0; i--) {
											if ( typeof calc_settings.calc_value[field_id][key[i]] !== 'undefined' ) {
												tmp += parseFloat( calc_settings.calc_value[field_id][key[i]] );
											}
										};
										new_value = tmp;
									}
									
									if ( jQuery.isArray( old_value ) ) {
										var tmp = 0;
										for (var i = old_value.length - 1; i >= 0; i--) {
											if ( typeof calc_settings.calc_value[field_id][old_value[i]] !== 'undefined' ) {
												tmp += parseFloat( calc_settings.calc_value[field_id][old_value[i]] );
											}
										};
										old_value = tmp;
									}
								} else {
									// This is a select list, so we can just grab the oldValue from this field.
									var old_value = jQuery(this).data('oldValue');
								}
								// Check to see if we're in a checkbox field. If so, the key needs to be based on checked or unchecked, not value.
							} else if ( jQuery('#ninja_forms_field_' + field_id + '_type').val() == 'checkbox' ) {
								if ( this.checked ) {
									// This field is checked, so set key to 'checked.'
									var key = 'checked';
									// Checkboxes only have two states, so if we are changing, the previous value must have been the opposite of this one.
									var old_value = 'unchecked';
								} else {
									var key = 'unchecked';
									var old_value = 'checked';
								}
								
							}
							if ( this.type !== 'checkbox' ) {
								jQuery(this).data('oldValue', key);
							}
							
							if ( new_value === '' ) {
								if ( typeof calc_settings.calc_value[field_id] !== 'undefined' && typeof calc_settings.calc_value[field_id][key] !== 'undefined' ) {
									// Get our calc value for this field from our previously defined JS object.
									var new_value = calc_settings.calc_value[field_id][key];
								} else {
									// This field doesn't exist in the calc value object. It's either a textbox or similar element.
									if ( typeof this.type === 'undefined' ) {
										var new_value = this.innerHTML;
									} else {
										var new_value = this.value;
									}

									if ( typeof ninja_forms_settings.currency_symbol !== 'undefined' ) {
										new_value = new_value.replace( ninja_forms_settings.currency_symbol, "" );	
										new_value = new_value.replace( /,/g, "" );	
									}
									
									if ( isNaN( new_value ) ) {
										new_value = 0;
									}
								}
							}

							// Check to see if our old_value exists in the calc_value JS object.
							if ( typeof calc_settings.calc_value[field_id] !== 'undefined' && typeof calc_settings.calc_value[field_id][old_value] !== 'undefined' ) {
								// Grab our calc value form the calc_value JS object.
								old_value = calc_settings.calc_value[field_id][old_value];
							} else {
								// Our calc_value doesn't exist in the calc_value JS object.
								// Check to see if our old_value is an array. This would be the case if the field is a multi-select.
								
								if ( old_value == '' || typeof old_value === 'undefined' ) {
									// We aren't dealing with an old_value array and old_value isn't a number. Set it to 0.
									old_value = 0;
								} else { 
									if ( isNaN( old_value ) ) {
										if ( typeof ninja_forms_settings.currency_symbol !== 'undefined' ) {
											old_value = old_value.replace( ninja_forms_settings.currency_symbol, "" );	
											old_value = old_value.replace( /,/g, "" );	
										}
									}
								}
							}

							// Find out what kind of element our total field is - either span or textbox.
							// Set our current value.
							if(jQuery("#ninja_forms_field_" + calc_id).attr("type") == 'text' ){
								var current_value = jQuery("#ninja_forms_field_" + calc_id).val();
							}else{
								var current_value = jQuery("#ninja_forms_field_" + calc_id).html();
							}

							// Make sure that our current total is made up of numbers.
							if ( typeof ninja_forms_settings.currency_symbol !== 'undefined' ) {
								current_value = current_value.replace( ninja_forms_settings.currency_symbol, "" );	
								current_value = current_value.replace( /,/g, "" );	
							}
							if ( !isNaN( current_value ) ) {
								// Convert those string numbers into operable ones.
								current_value = parseFloat( current_value );
							} else {
								// Our current total isn't made up of numbers, so set the current total to 0.
								current_value = 0;
							}

							// Find out what calculation method our calc field is using and set our math operations appropriately.
							if ( calc_method == 'auto' ) { // Method: auto
								// If we are using the 'auto' method, then the calc is an auto-total field. We're always adding.
								var old_op = 'subtract';
								var new_op = 'add';
								if ( !jQuery(this).hasClass('ninja-forms-field-calc-auto') ) {
									old_value = '';
									new_value = '';
								}
							} else if( calc_method == 'fields' ) { // Method: fields
								// If we are using the 'fields' method, then figure out what the operators should be from the JS object.
								for (var i = calc_settings.calc_fields[calc_id]['fields'].length - 1; i >= 0; i--) {
									if ( calc_settings.calc_fields[calc_id]['fields'][i]['field'] == field_id ) {
										var old_op = ninja_forms_find_opposite_op( calc_settings.calc_fields[calc_id]['fields'][i]['op'] );
										var new_op = calc_settings.calc_fields[calc_id]['fields'][i]['op'];
									}
								};

							}

							// If our old value exists and isn't empty or 0, then carry out the old_op on it.
							
							if ( old_value && !isNaN( old_value ) && old_value != 0 && old_value != '' && !jQuery(this).hasClass('ninja-forms-field-calc-no-old-op') ) {
								old_value = parseFloat( old_value );
								tmp = new ninja_forms_var_operator(old_op);
								current_value = tmp.evaluate( current_value, old_value );
							}

							// If our new value exists and isn't empty or 0, then carry out the new_op on it.
							if ( new_value && !isNaN( new_value ) && new_value != 0 && new_value != '' && !jQuery(this).hasClass('ninja-forms-field-calc-no-new-op') ) {
								new_value = parseFloat( new_value );
								tmp = new ninja_forms_var_operator(new_op);
								var calc_value = tmp.evaluate( current_value, new_value );
								//console.log( current_value + ' ' + new_op + ' ' + new_value + ' = ' + calc_value );
							} else {
								// We don't have any calculations to do, so set calc_value to our current_value.
								var calc_value = current_value;
							}
						} else if ( calc_method == 'eq' ) { // Method: eq.
							var tmp_eq = calc_settings.calc_fields[calc_id]['eq'];

							// Loop through our fields getting their values and replacing their placeholders in the equation.
							for (var i = calc_settings.calc_fields[calc_id]['fields'].length - 1; i >= 0; i--) {

								// Make sure that the changed field is in the formula and that we should change the current value.
								var f_id = calc_settings.calc_fields[calc_id]['fields'][i];
								var key = jQuery("#ninja_forms_field_" + f_id).val();
								var f_value = '';
								if ( jQuery('#ninja_forms_field_' + f_id + '_type' ).val() == 'list' ) {
									if ( jQuery('#ninja_forms_field_' + f_id + '_list_type').val() == 'radio' ) {
										key = jQuery('.ninja-forms-field-' + f_id + '-options :checked').val();
									} else if ( jQuery('#ninja_forms_field_' + f_id + '_list_type').val() == 'multi' ) {
										// If we're working with a multi-select list, we need to add all of these values together before we continue our calculation.
										if ( jQuery.isArray( key ) ) {
											var tmp = 0;
											for (var x = key.length - 1; x >= 0; x--) {
												if ( typeof calc_settings.calc_value[f_id][key[x]] !== 'undefined' ) {
													tmp += parseFloat( calc_settings.calc_value[f_id][key[x]] );
												}
											};
											f_value = tmp;
										}
									} else if ( jQuery('#ninja_forms_field_' + f_id + '_list_type').val() == 'checkbox' ) {
										var tmp = 0;
										jQuery('.ninja-forms-field-' + f_id + '-options :checked').each(function(){
											if ( typeof calc_settings.calc_value[f_id][this.value] !== 'undefined' ) {
												tmp += parseFloat( calc_settings.calc_value[f_id][this.value] );
											}
										});
										f_value = tmp;
									}
								} else if ( jQuery('#ninja_forms_field_' + f_id + '_type').val() == 'checkbox' ) {
										if ( jQuery('#ninja_forms_field_' + f_id).attr('checked') ) {
											// This field is checked, so set key to 'checked.'
											var key = 'checked';
										} else {
											var key = 'unchecked';
										}
								}
								
								if ( f_value == '' ) {
									if ( typeof calc_settings.calc_value[f_id] !== 'undefined' && typeof calc_settings.calc_value[f_id][key] !== 'undefined' ) {
										f_value = calc_settings.calc_value[f_id][key]
									} else {
										f_value = key;
									}							
								}

								// Check for a percentage sign in our f_value. If we find one, then convert it to a decimal.
								if ( typeof f_value !== 'undefined' ) {
									if ( f_value.indexOf("%") >= 0 ) {
										f_value = f_value.replace( "%", "" );
										if ( !isNaN( f_value ) ) {
											f_value = parseFloat( f_value ) / 100;
										}
									}									
								}

								// This field doesn't exist in the calc value object. It's either a textbox or similar element.
								if ( typeof this.type === 'undefined' ) {
									f_value = this.innerHTML;
								} else {
									f_value = this.value;
								}

								if ( typeof ninja_forms_settings.currency_symbol !== 'undefined' ) {
									f_value = f_value.replace( ninja_forms_settings.currency_symbol, "" );	
									f_value = f_value.replace( /,/g, "" );	
								}

								if ( isNaN( f_value ) || f_value == '' || !f_value || typeof f_value === 'undefined' ) {
									f_value = 0;
								}

								var find = 'field_' + f_id;
								var re = new RegExp(find, 'g');
								tmp_eq = tmp_eq.replace(re, f_value);
							}
							var calc_value = eval(tmp_eq);
						}

						// Find out what kind of element our total field is - either span or textbox.
						// Set our current value.
						if(jQuery("#ninja_forms_field_" + calc_id).attr("type") == 'text' ){
							var current_value = jQuery("#ninja_forms_field_" + calc_id).val();
						}else{
							var current_value = jQuery("#ninja_forms_field_" + calc_id).html();
						}

						// Make sure that our current total is made up of numbers.
						if ( typeof ninja_forms_settings.currency_symbol !== 'undefined' ) {
							current_value = current_value.replace( ninja_forms_settings.currency_symbol, "" );	
						}
						if ( !isNaN( current_value ) ) {
							// Convert those string numbers into operable ones.
							current_value = parseFloat( current_value );
						} else {
							// Our current total isn't made up of numbers, so set the current total to 0.
							current_value = 0;
						}

						if ( current_value !== calc_value ) {
							jQuery(this).removeClass('ninja-forms-field-calc-no-old-op');
							calc_value = calc_value.toFixed(calc_places);
							// Set the value of our calculation field.							
							if(jQuery("#ninja_forms_field_" + calc_id).attr("type") == 'text' ){
								jQuery("#ninja_forms_field_" + calc_id).val(calc_value);
							}else{
								jQuery("#ninja_forms_field_" + calc_id).html(calc_value);
							}
							
							//if( typeof calc_settings.calc_fields[field_id] === 'undefined' ) {
								jQuery("#ninja_forms_field_" + calc_id).trigger('change');
							//}
						}
					}
				}
			}
		}
	});
}); //End document.ready

function ninja_forms_before_submit(formData, jqForm, options){
	var result = jQuery(jqForm).triggerHandler('beforeSubmit', [ formData, jqForm, options ]);
	if ( result !== false ) {
		result = jQuery('body').triggerHandler('beforeSubmit', [ formData, jqForm, options ]);
	}
	if( result !== false ) {
		result = jQuery(document).triggerHandler('beforeSubmit', [ formData, jqForm, options ]);
	}
	return result;
}

function ninja_forms_response(responseText, statusText, xhr, jQueryform){
	//console.log(responseText);
	if( ninja_forms_settings.ajax_msg_format == 'inline' ){
		var result = jQuery(jQueryform).triggerHandler('submitResponse', [ responseText ]);
		if ( result !== false ) {
			result = jQuery('body').triggerHandler('submitResponse', [ responseText ]);
		}
		if( result !== false ) {
			result = jQuery(document).triggerHandler('submitResponse', [ responseText ]);
		}
		return result;
	}
}

function ninja_forms_register_response_function(form_id, name){
	if( typeof window['ninja_forms_response_function_list'][form_id] == 'undefined' ){
		window['ninja_forms_response_function_list'][form_id] = {};
	}
	window['ninja_forms_response_function_list'][form_id][name] = name;
}

function ninja_forms_register_before_submit_function(form_id, name){
	if( typeof window['ninja_forms_before_submit_function_list'][form_id] == 'undefined' ){
		window['ninja_forms_before_submit_function_list'][form_id] = {};
	}
	window['ninja_forms_before_submit_function_list'][form_id][name] = name;
}

function ninja_forms_default_before_submit(formData, jqForm, options){
	var form_id = jQuery(jqForm).prop("id").replace("ninja_forms_form_", "" );

	// Show the ajax spinner and processing message.
	jQuery("#ninja_forms_form_" + form_id + "_process_msg").show();
	jQuery("#ninja_forms_form_" + form_id + "_response_msg").prop("innerHTML", "");
	jQuery("#ninja_forms_form_" + form_id + "_response_msg").removeClass("ninja-forms-error-msg");
	jQuery("#ninja_forms_form_" + form_id + "_response_msg").removeClass("ninja-forms-success-msg");
	jQuery(".ninja-forms-field-error").prop("innerHTML", "");
	jQuery(".ninja-forms-error").removeClass("ninja-forms-error");
	return true;
}

function ninja_forms_default_response(response){
	var form_id = response.form_id;

	jQuery("#ninja_forms_form_" + form_id + "_process_msg").hide();

	ninja_forms_update_error_msgs(response)
	ninja_forms_update_success_msg(response)
	return true;
}

function ninja_forms_update_success_msg(response){
	var innerHTML = '';
	var form_id = response.form_id;
	var success = response.success;
	//alert(success);
	var form_settings = response.form_settings;
	var hide_complete = form_settings.hide_complete;
	var clear_complete = form_settings.clear_complete;

	if(success != false){
		for( var propName in success ){
			innerHTML += '<p>' + success[propName] + '</p>';
		}
		if(innerHTML != ''){
			jQuery("#ninja_forms_form_" + form_id + "_response_msg").removeClass("ninja-forms-error-msg")
			jQuery("#ninja_forms_form_" + form_id + "_response_msg").addClass("ninja-forms-success-msg")
			jQuery("#ninja_forms_form_" + form_id + "_response_msg").prop("innerHTML", innerHTML);
		}
		if(hide_complete == 1 ){
			jQuery("#ninja_forms_form_" + form_id ).hide();
		}
		if(clear_complete == 1 ){
			jQuery("#ninja_forms_form_" + form_id ).resetForm();
		}
	}
}

function ninja_forms_update_error_msgs(response){
	var innerHTML = '';
	var form_id = response.form_id;
	var errors = response.errors;
	var form_id = response.form_id;
	if(errors != false){
		for( var propName in errors ){
			if(errors[propName]['location'] == 'general' ){
	    		innerHTML += '<p>' + errors[propName]['msg'] + '</p>';
	    	}else{
	    		var field_id = errors[propName]['location'];
	    		jQuery("#ninja_forms_field_" + field_id + "_error").show();
	    		jQuery("#ninja_forms_field_" + field_id + "_error").prop("innerHTML", errors[propName]['msg']);
	    		jQuery("#ninja_forms_field_" + field_id + "_div_wrap").addClass("ninja-forms-error");

	    	}
		}
		if(innerHTML != ''){
			jQuery("#ninja_forms_form_" + form_id + "_response_msg").removeClass("ninja-forms-success-msg")
			jQuery("#ninja_forms_form_" + form_id + "_response_msg").addClass("ninja-forms-error-msg")
			jQuery("#ninja_forms_form_" + form_id + "_response_msg").prop("innerHTML", innerHTML);
		}
	}
}

function ninja_forms_html_decode(value) {
	if (value) {
		var decoded = jQuery('<div />').html(value).text();
		decoded = jQuery('<div />').html(decoded).text();
		return decoded;
	} else {
		return '';
	}
}

function ninja_forms_toggle_login_register(form_type, form_id) {

	var el_id = 'ninja_forms_form_' + form_id + '_' + form_type + '_form';
	if(form_type == 'login'){
		var opp_id = 'ninja_forms_form_' + form_id + '_register_form';
	}else{
		var opp_id = 'ninja_forms_form_' + form_id + '_login_form';
	}
	var ele = document.getElementById(el_id);
	var opp_ele = document.getElementById(opp_id);
	if(ele.style.display == "block") {
		ele.style.display = "none";
  	}else{
		ele.style.display = "block";
		opp_ele.style.display = "none";
	}
}

function ninja_forms_get_form_id(element){
	var form_id = jQuery(element).closest('form').prop("id");
	form_id = form_id.replace("ninja_forms_form_", "");
	if(form_id == '' || form_id == 'ninja_forms_admin'){
		form_id = jQuery("#_form_id").val();
	}
	return form_id;
}

function check_pass_strength(pass1, pass2) {

	jQuery('#pass-strength-result').removeClass('short bad good strong');
	if ( ! pass1 ) {
		jQuery('#pass-strength-result').html( ninja_forms_password_strength.empty );
		return;
	}

	strength = passwordStrength(pass1, pass2);

	switch ( strength ) {
		case 2:
			jQuery('#pass-strength-result').addClass('bad').html( ninja_forms_password_strength['bad'] );
			break;
		case 3:
			jQuery('#pass-strength-result').addClass('good').html( ninja_forms_password_strength['good'] );
			break;
		case 4:
			jQuery('#pass-strength-result').addClass('strong').html( ninja_forms_password_strength['strong'] );
			break;
		case 5:
			jQuery('#pass-strength-result').addClass('short').html( ninja_forms_password_strength['mismatch'] );
			break;
		default:
			jQuery('#pass-strength-result').addClass('short').html( ninja_forms_password_strength['short'] );
	}
}

function passwordStrength(password1, password2) {
	var shortPass = 1, badPass = 2, goodPass = 3, strongPass = 4, mismatch = 5, symbolSize = 0, natLog, score;

	// password 1 != password 2
	if ( (password1 != password2) && password2.length > 0)
		return mismatch

	//password < 4
	if ( password1.length < 4 )
		return shortPass

	//password1 == username

	if ( password1.match(/[0-9]/) )
		symbolSize +=10;
	if ( password1.match(/[a-z]/) )
		symbolSize +=26;
	if ( password1.match(/[A-Z]/) )
		symbolSize +=26;
	if ( password1.match(/[^a-zA-Z0-9]/) )
		symbolSize +=31;

	natLog = Math.log( Math.pow(symbolSize, password1.length) );
	score = natLog / Math.LN2;

	if (score < 40 )
		return badPass

	if (score < 56 )
		return goodPass

    return strongPass;
}

function ninja_forms_find_opposite_op(op) {
	switch(op){
		case "add":
            return "subtract";
        case "subtract":
            return "add";
        case "multiply":
            return "divide";
        case "divide":
            return "multiply";
	}

}

function ninja_forms_var_operator(op) {
    this.operation = op;

    this.evaluate = function evaluate(param1, param2) {
    	switch(this.operation) {
            case "add":
                return param1 + param2;
            case "subtract":
                return param1 - param2;
            case "multiply":
                return param1 * param2;
            case "divide":
                return param1 / param2;
        }
    }
}
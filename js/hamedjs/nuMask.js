/**
 * 
 */

$(document).ready(
		function()
		{
			console.log('nuReady!');
			// $('#mobileNumber').inputmask('Regex', {regex:
			// '^[0-9]{1,6}(\\.\\d{1,2})?$'});
			$('.nuMask').keydown(
					function(e)
					{
						//alert(e.keyCode);
						if((e.keyCode != 8 && e.keyCode != 46))
						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57))
								&& (e.keyCode < 96 || e.keyCode > 105))
						{
							e.preventDefault();
						}
					});

		});
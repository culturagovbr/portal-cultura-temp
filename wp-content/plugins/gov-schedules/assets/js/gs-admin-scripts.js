(function ($) {
	$(document).ready(function () {
		gs.init();
		gs.customTaxFilter();
	});

	var gs = {
		init: function () {

			// Default configuration
			$.timepicker.regional['pt-BR'] = {
				timeOnlyTitle: 'Escolha o horário',
				timeText: 'Horário',
				hourText: 'Hora',
				minuteText: 'Minutos',
				secondText: 'Segundos',
				millisecText: 'Milissegundos',
				microsecText: 'Microssegundos',
				timezoneText: 'Fuso horário',
				currentText: 'Agora',
				closeText: 'Confirmar',
				timeFormat: 'HH:mm',
				timeSuffix: '',
				amNames: ['a.m.', 'AM', 'A'],
				pmNames: ['p.m.', 'PM', 'P'],
				isRTL: false
			};
			$.timepicker.setDefaults($.timepicker.regional['pt-BR']);

			var myControl = {
				create: function (tp_inst, obj, unit, val, min, max, step) {
					$('<input class="ui-timepicker-input" value="' + val + '">')
						.appendTo(obj)
						.spinner({
							min: min,
							max: max,
							step: step,
							change: function (e, ui) { // key events
								// don't call if api was used and not key press
								if (e.originalEvent !== undefined)
									tp_inst._onTimeChange();
								tp_inst._onSelectHandler();
							},
							spin: function (e, ui) { // spin events
								tp_inst.control.value(tp_inst, obj, unit, ui.value);
								tp_inst._onTimeChange();
								tp_inst._onSelectHandler();
							}
						});
					return obj;
				},
				options: function (tp_inst, obj, unit, opts, val) {
					if (typeof(opts) == 'string' && val !== undefined)
						return obj.find('.ui-timepicker-input').spinner(opts, val);
					return obj.find('.ui-timepicker-input').spinner(opts);
				},
				value: function (tp_inst, obj, unit, val) {
					if (val !== undefined)
						return obj.find('.ui-timepicker-input').spinner('value', val);
					return obj.find('.ui-timepicker-input').spinner('value');
				}
			};

			$('.datepicker').datetimepicker({
				controlType: myControl,
				dateFormat: 'dd/mm/yy'
			});

			if ($('#role_permission').length) {
				$('#role_permission').select2();
			}
		},

		customTaxFilter: function () {
			/*var checkExist;

			if (typeof gsData !== "undefined") {
				console.log(gsData);
				if (gsData.restricted_roles.length) {
					$('body').addClass('restricted-role')
				}
				if (gsData.taxonomies_excluded.length) {

					checkExist = setInterval(function () {
						console.log('Checking for element');
						if ($('.editor-post-taxonomies__hierarchical-terms-list > *').length) {
							clearInterval(checkExist);
							filterTax();
						}
					}, 100);

					function filterTax() {
						setTimeout(function () {
							$('.editor-post-taxonomies__hierarchical-terms-list input[type="checkbox"]').each(function () {
								if (gsData.taxonomies_excluded.indexOf(parseInt($(this).val())) !== -1) {
									$(this).next('label').remove();
									$(this).remove();
								}
								$('.editor-post-taxonomies__hierarchical-terms-list').addClass('loaded');
							});
						}, 100);
						console.log('Filtering');
					}
				}
			}*/
		}
	};
})(jQuery);
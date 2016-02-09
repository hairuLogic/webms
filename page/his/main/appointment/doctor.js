
		// $.jgrid.defaults.responsive = true;
		// $.jgrid.defaults.styleUI = 'Bootstrap';

		$(document).ready(function () {
			var calendar = $("#appt_calendar").calendar(
            {
                tmpl_path: "/webms/assets/plugins/bootstrap-calendar-master/tmpls/",
                events_source: function () { return []; }
            });
			
		});
		
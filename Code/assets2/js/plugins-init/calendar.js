"use strict"

function fullCalender(events) {


	/* initialize the external events
		-----------------------------------------------------------------*/


	/* initialize the calendar
	-----------------------------------------------------------------*/

	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {

		headerToolbar: {
			left: 'title,prev,next',
			right: '',
			center: 'dayGridMonth,timeGridWeek,timeGridDay'
		},

		selectable: true,
		selectMirror: true,

		editable: true,
		droppable: false,
		initialDate: new Date(),
		weekNumbers: false,
		navLinks: false,
		editable: false,
		selectable: false,
		nowIndicator: true,
		views: {
			settimana: {
				type: 'agendaWeek',
				duration: {
					days: 7
				},
				title: 'Apertura',
				columnFormat: 'dddd',
				hiddenDays: [0, 6]
			}
		},
		defaultView: 'settimana',
		events: events,
		eventClick: function (info) {
			$('#edit-event-modal').modal('show');
			$('#update_id').val(info.event.id);
			$('#title').val(info.event.title);
			var start = info.event.startStr;
			var end = info.event.endStr;
			var startingDate = moment(start, 'YYYY-MM-DD').format(date_format_js);
			var endingDate = moment(end, 'YYYY-MM-DD').subtract(1, 'day').format(date_format_js);
			$('#start').daterangepicker({
				locale: {
					format: date_format_js
				},
				singleDatePicker: true,
				startDate: startingDate,
			});
			$('#end').daterangepicker({
				locale: {
					format: date_format_js
				},
				singleDatePicker: true,
				startDate: endingDate,
				minDate:startingDate
			});
		}
	});
	calendar.render();
}

jQuery(window).on('load', function () {
	setTimeout(function () {
		$.ajax({
			url: base_url + 'events/get_events',
			type: 'GET',
			dataType: 'JSON',
			success: function (response) {
				console.log(response);
				fullCalender(response);
			},
			error: function (error) {
				console.error(error);
			}
		});
	}, 1000);


});



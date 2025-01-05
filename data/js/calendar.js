document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pl',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/getCalendarEvents', // Pobieranie wydarzeń z backendu
        eventTimeFormat: { // Format czasu
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },
        eventDidMount: function(info) { // Inicjalizacja popupu
            new bootstrap.Popover(info.el, {
                title: info.event.title,
                content: `
                    <p><strong>Godzina:</strong> ${info.event.start.toLocaleTimeString()}</p>
                    <p><strong>Opis:</strong> ${info.event.extendedProps.description || 'Brak szczegółów'}</p>
                `,
                html: true,
                trigger: 'hover',
                placement: 'top' // Umiejscowienie popupu
            });
        }
    });
    calendar.render();
});

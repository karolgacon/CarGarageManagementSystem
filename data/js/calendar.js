document.addEventListener('DOMContentLoaded', function () {
    initializeCalendar();
});

function initializeCalendar() {
    console.log('Uruchamianie kalendarza...');
    var calendarEl = document.getElementById('calendar');

    if (!calendarEl) {
        console.error('Nie znaleziono elementu #calendar');
        return;
    }

    console.log('Element #calendar znaleziony, renderowanie...');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pl',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function (fetchInfo, successCallback, failureCallback) {
            console.log('Pobieranie wydarzeń...');
            fetch('/getCalendarEvents')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error! Status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Wydarzenia:', data);
                    successCallback(data);
                })
                .catch(error => {
                    console.error('Błąd podczas ładowania wydarzeń:', error);
                    failureCallback(error);
                });
        },
        eventDidMount: function (info) {
            // Tworzenie popupa Bootstrap
            new bootstrap.Popover(info.el, {
                title: info.event.title,
                content: `
                    <p><strong>Data:</strong> ${info.event.start.toLocaleDateString()}</p>
                    <p><strong>Godzina:</strong> ${info.event.start.toLocaleTimeString()}</p>
                    <p><strong>Opis:</strong> ${info.event.extendedProps.description || 'Brak szczegółów'}</p>
                `,
                html: true,
                trigger: 'hover',
                placement: 'top'
            });
        }
    });

    calendar.render();
    console.log('Kalendarz został wyrenderowany.');
}

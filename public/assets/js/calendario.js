document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var tipoFiltro = 'todos';

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('eventos.php')
                .then(response => response.json())
                .then(events => {
                    if (tipoFiltro !== 'todos') {
                        events = events.filter(e => e.tipo === tipoFiltro);
                    }
                    successCallback(events);
                })
                .catch(error => failureCallback(error));
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();

            const modalTitle = document.getElementById('eventoTitulo');
            const modalBody = document.getElementById('eventoContenido');

            modalTitle.textContent = info.event.title;
            modalBody.innerHTML = `
                <p><strong>Inicio:</strong> ${info.event.start.toLocaleDateString()}</p>    
                <p><strong>Descripción:</strong> ${info.event.extendedProps.descripcion || 'Sin descripción'}</p>
            `;

            const myModal = new bootstrap.Modal(document.getElementById('eventoModal'));
            myModal.show();
        },
        dayMaxEventRows: true,
        views: {
            dayGridMonth: {
                dayMaxEventRows: 3
            }
        },
        eventDisplay: 'block',
        eventDidMount: function(info) {
            info.el.style.border = 'none';
            info.el.style.backgroundColor = info.event.extendedProps.tipo === 'examen' ? '#e63946' : '#457b9d';
            info.el.style.color = 'white';
            info.el.style.fontSize = '0.8rem';
            info.el.style.borderRadius = '8px';
            info.el.style.padding = '4px 8px';
            info.el.style.marginBottom = '4px';
        }
    });

    calendar.render();

    // Estilo general moderno para la tabla del calendario
    const style = document.createElement('style');
    style.innerHTML = `
        .fc {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1faee;
            border-radius: 12px;
            padding: 1rem;
        }
        .fc-toolbar-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1d3557;
        }
        .fc-daygrid-day-number {
            font-size: 0.85rem;
            padding: 4px;
            color: #1d3557;
        }
        .fc-col-header-cell {
            background-color: #a8dadc;
            color: #1d3557;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .fc-daygrid-day {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            transition: background 0.3s;
        }
        .fc-daygrid-day:hover {
            background-color: #f0f4f8;
        }
        .legend-container {
            text-align: center;
            margin-top: 1rem;
        }
        .legend-label {
            margin-right: 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #1d3557;
        }
        .legend-color {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 6px;
            border-radius: 3px;
        }
    `;
    document.head.appendChild(style);

    // Crear leyenda y filtros
    const legend = document.createElement('div');
    legend.className = 'legend-container';
    legend.innerHTML = `
        <span class="legend-label">
            <span class="legend-color" style="background-color: #e63946"></span> Examen
        </span>
        <span class="legend-label">
            <span class="legend-color" style="background-color: #457b9d"></span> Entrega
        </span>
        <select id="filtroTipo" class="form-select form-select-sm d-inline-block" style="width: auto; margin-left: 1rem;">
            <option value="todos">Todos</option>
            <option value="examen">Solo exámenes</option>
            <option value="entrega">Solo entregas</option>
        </select>
    `;
    calendarEl.parentNode.insertBefore(legend, calendarEl);

    document.getElementById('filtroTipo').addEventListener('change', function() {
        tipoFiltro = this.value;
        calendar.refetchEvents();
    });
});

window.addEventListener("load", async() => {
    /*const cal = Calendario('calendar');
    cal.m = 0; // Para setear un mes de inicio
    cal.viewDisponibilidad = true;
    cal.enabledCallBackMonth = true;
    cal.functionCallbackMonth = (arr) => {
        console.log('data', arr);
        const mockDataDisponible = [{
            time: '2021-10-04T22:00:00',
            asignados: 1,
            disponibles: 6
        },
            {
                time: '2021-10-15T22:00:00',
                asignados: 0,
                disponibles: 2
            },
            {
                time: '2021-10-19T22:00:00',
                asignados: 0,
                disponibles: 5
            }, {
                time: '2021-10-28T22:00:00',
                asignados: 0,
                disponibles: 0
            }
        ];
        return mockDataDisponible;
    };
    //cal.bindData(mockData);

    cal.onEventClick = (e) => { // para aplicar el evento y mostrar la data del evento clickeado
        StopEventPropagation(e);
        const el = e.path[1];
        console.log('data', el.dataset.time, el.dataset.type);
    };
    cal.bindData(mockDataDisponible);
    cal.render();*/
});

const StopEventPropagation = (e) => {
    if (!e) return;
    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();
};

const Calendario = (id) => ({
    id: id,
    data: [], // Arreglos de eventos
    viewDisponibilidad: false, // Habilita si quieres ver la disponibilidad de personal
    titleDisponibilidad: 'Personal', // Titulo que se mostrará para el personal disponible o asignado cuando esta habilitado la vista de disponibilidad
    codeEvBGDisponibilidad: ['bg-0disponible', 'bg-12disponible', 'bg-35disponible', 'bg-6disponible'],
    codeTDBGDisponibilidad: ['bg-with3event', 'bg-with2event', 'bg-with1event', 'bg-withoutevent'],
    enabledCallBackMonth: false, //Habilita la opción para hacer busqueda por mes y consultar solo el que estamos enviamos por parámetro visualizando.
    functionCallbackMonth: null, //Recibe un parámetro de tipo función para obtener los datos del mes que se esta consultando cuando esta habilitado la propiedad enabledCallBackMonth del calendar
    el: undefined, // Elemento
    y: undefined, // Año
    m: undefined, // Mes
    w: undefined, // Semana
    dt: undefined, // Dia
    dateDisabled: [0, 6], // Deshabilita dias de la semana por default esta el domingo y sábado
    date: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    month: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
    mode: 'month',
    onDateClick(e) {
        StopEventPropagation(e);
        const el = e.srcElement;
        const month = el.dataset.month;
        const date = el.dataset.date;
        const year = el.dataset.year;
        const time = el.dataset.time !== undefined ? el.dataset.time + ':00' : '';

        //alert('Fecha seleccionada: ' + date + '/' + month + '/' + year + ' ' + time);
    },
    onEventClick: null,
    bindData(events) {
        this.data = events.sort((a, b) => {
            if (a.time < b.time) return -1;
            if (a.time > b.time) return 1;
            return 0;
        });
    },
    haveEvents(date, month, year) {
        let haveEvent = 0;
        this.data.forEach((item) => {
            let fecha = moment(item.time);
            if (Number(fecha.format('D')) === Number(date) && Number(fecha.format('MM')) === Number(month) && Number(fecha.format('YYYY')) === Number(year)) {
                haveEvent += 1;
            }
        });

        return haveEvent;
    },
    callBackMonth(arr) {

        this.bindData(this.functionCallbackMonth(arr));

    },
    renderEvents() {
        if (!this.data || this.data.length <= 0) return;
        let tds;

        if (this.mode === 'month') {
            tds = document.querySelectorAll("#gridCalendar .calendar-day");
        }

        if (this.mode === 'week') {
            tds = document.querySelectorAll("#gridCalendar .horaWeek");
        }

        if (this.mode === 'day') {
            tds = document.querySelectorAll("#gridCalendar .horaDia");
        }

        let dataset = this.el.querySelector('.month-year').dataset;

        tds.forEach((td) => {
            let _td = td;
            let _class = _td.classList;
            let divDate = _td.querySelector('.date');
            let divEvents = _td.querySelector('.events');
            let dataset = divDate.dataset;

            if (_class[1] !== "outside" && !this.dateDisabled.includes(Number(dataset.day))) {
                _td.onclick = this.onDateClick;
            }

            if (!this.viewDisponibilidad) {
                //Se pinta sin eventos
                if (this.haveEvents(dataset.date, dataset.month, dataset.year) === 0 && !this.dateDisabled.includes(Number(dataset.day)) && _class[1] !== "outside") {
                    if (this.mode !== 'day') {
                        _td.classList += " bg-withoutevent";
                        let frgEvent = document.createRange().createContextualFragment(`
                        <div class="classwithOutEvent">Sin eventos</div>
                     `);
                        divEvents.appendChild(frgEvent);
                    }
                }

                //Se pinta cuando tiene un evento
                if (this.haveEvents(dataset.date, dataset.month, dataset.year) === 1 && !this.dateDisabled.includes(Number(dataset.day)) && _class[1] !== "outside") {
                    _td.classList += " bg-with1event";
                }

                //Se pinta cuando tiene 2 eventos
                if (this.haveEvents(dataset.date, dataset.month, dataset.year) === 2 && !this.dateDisabled.includes(Number(dataset.day)) && _class[1] !== "outside") {
                    _td.classList += " bg-with2event";
                }

                //Se pinta cuando tiene 3 eventos
                if (this.haveEvents(dataset.date, dataset.month, dataset.year) >= 3 && !this.dateDisabled.includes(Number(dataset.day)) && _class[1] !== "outside") {
                    _td.classList += " bg-with3event";
                }
            }

            if (!this.dateDisabled.includes(Number(dataset.day))) {
                this.data.forEach((ev) => {
                    let evTime = moment(ev.time);
                    let evTimeEnd = moment(ev.timeEnd);

                    if (this.mode === 'month' && _class[1] !== "outside") {

                        if (Number(evTime.year()) === Number(dataset.year) && (Number(evTime.month()) + 1) === Number(dataset.month) && Number(evTime.format('D')) === Number(dataset.date)) {
                            let classeBg = '';
                            let frgEvent = '';

                            if (this.viewDisponibilidad) { // Este caso es cuando esta activado la vista por disponibilidad

                                if (Number(ev.asignados.length) >= 1) {
                                    classeBg = 'bg-black';

                                    frgEvent = document.createRange().createContextualFragment(`
                        <div id="${ev.id + '_asignado' }" data-time="${ev.time}" data-type="asignado" data-asignados="`+JSON.stringify(ev.asignados)+`" class="event text-center ${classeBg} classBorder">${'<p>' + ev.asignados.length + ' ' + this.titleDisponibilidad + '</p><p> asignado(s)</p>'}</div>
                     `);
                                    divEvents.appendChild(frgEvent);
                                    let divEvent = divEvents.querySelector(`.event[id='${ev.id + '_asignado' }']`);
                                    divEvent.onclick = this.onEventClick;
                                }

                            } else { // Vista para mostrarse por evento
                                classeBg = ev.cls;

                                frgEvent = document.createRange().createContextualFragment(`
                        <div id="${ev.id}" time="${ev.time}" class="event ${classeBg} classBorder">${evTime.format('h:mma') + ' ' + ev.desc}</div>
                     `);
                                divEvents.appendChild(frgEvent);
                                let divEvent = divEvents.querySelector(`.event[id='${ev.id}']`);
                                divEvent.onclick = this.onEventClick;
                            }



                            if (this.viewDisponibilidad) {

                                //classeBg = 'bg-6disponible';
                                //_td.classList += " bg-withoutevent";

                                if (Number(ev.disponibles.length) === 0) {
                                    classeBg = this.codeEvBGDisponibilidad[0];
                                    _td.classList += " " + this.codeTDBGDisponibilidad[0];
                                }

                                if (Number(ev.disponibles.length) >= 1 && Number(ev.disponibles.length) <= 2) {
                                    classeBg = this.codeEvBGDisponibilidad[1];
                                    _td.classList += " " + this.codeTDBGDisponibilidad[1];
                                }

                                if (Number(ev.disponibles.length) >= 3 && Number(ev.disponibles.length) <= 5) {
                                    classeBg = this.codeEvBGDisponibilidad[2];
                                    _td.classList += " " + this.codeTDBGDisponibilidad[2];
                                }

                                if (Number(ev.disponibles.length) >= 6) {
                                    classeBg = this.codeEvBGDisponibilidad[3];
                                    _td.classList += " " + this.codeTDBGDisponibilidad[3];
                                }

                                frgEvent = document.createRange().createContextualFragment(`
                                    <div id="${ev.id + '_disponible'}" data-time="${ev.time}" data-type="disponible" data-disponibles='`+JSON.stringify(ev.disponibles)+`' class="event text-center ${classeBg} classBorder">${!this.viewDisponibilidad ? (evTime.format('h:mma') + ' ' + ev.desc) : ('<p>' + ev.disponibles.length + ' ' + this.titleDisponibilidad + '</p><p> disponible(s)</p>')}</div>
                                 `);
                                divEvents.appendChild(frgEvent);
                                let divEvent = divEvents.querySelector(`.event[id='${ev.id + '_disponible'}']`);
                                divEvent.onclick = this.onEventClick;
                            }
                        } else {
                            // if (this.viewDisponibilidad) {
                            //     _td.classList += " bg-withoutevent";
                            // }
                        }
                    }

                    if (this.mode === 'week') {
                        if (Number(evTime.year()) === Number(dataset.year) && (Number(evTime.month()) + 1) === Number(dataset.month) && Number(evTime.format('D')) === Number(dataset.date) && (Number(dataset.time) >= Number(evTime.format('HH')) && Number(dataset.time) < Number(evTimeEnd.format('HH')))) {

                            let classTime = '';
                            let desc = '';

                            if ((Number(evTimeEnd.format('HH')) - Number(evTime.format('HH'))) > 1) {
                                desc = '&nbsp;';
                                if (Number(evTime.format('HH')) === Number(dataset.time)) {
                                    classTime = 'classbegin';
                                    desc = evTime.format('h:mma') + ' ' + ev.desc;
                                } else {
                                    if ((Number(evTimeEnd.format('HH')) - Number(dataset.time)) === 1) {
                                        classTime = 'classend';
                                    } else {
                                        classTime = 'classhalf';
                                    }
                                }
                            } else {
                                desc = evTime.format('h:mma') + ' ' + ev.desc;
                            }

                            let frgEvent = document.createRange().createContextualFragment(`
                            <div id="${ev.id}" time="${ev.time}" class="event ${ev.cls} ${classTime}">${desc}</div>
                         `);
                            divEvents.appendChild(frgEvent);
                            let divEvent = divEvents.querySelector(`.event[id='${ev.id}']`);
                            divEvent.onclick = this.onEventClick;
                        }
                    }

                    if (this.mode === 'day') {
                        if (Number(evTime.year()) === Number(dataset.year) && (Number(evTime.month()) + 1) === Number(dataset.month) && Number(evTime.format('D')) === Number(dataset.date) && (Number(dataset.time) >= Number(evTime.format('HH')) && Number(dataset.time) < Number(evTimeEnd.format('HH')))) {

                            let classTime = '';
                            let desc = '';

                            if ((Number(evTimeEnd.format('HH')) - Number(evTime.format('HH'))) > 1) {
                                desc = '&nbsp;';
                                if (Number(evTime.format('HH')) === Number(dataset.time)) {
                                    classTime = 'classbegin';
                                    desc = evTime.format('h:mma') + ' ' + ev.desc;
                                } else {
                                    if ((Number(evTimeEnd.format('HH')) - Number(dataset.time)) === 1) {
                                        classTime = 'classend';
                                    } else {
                                        classTime = 'classhalf';
                                    }
                                }
                            } else {
                                desc = evTime.format('h:mma') + ' ' + ev.desc;
                            }

                            let frgEvent = document.createRange().createContextualFragment(`
                            <div id="${ev.id}" time="${ev.time}" class="event ${ev.cls} ${classTime}">${desc}</div>
                         `);
                            divEvents.appendChild(frgEvent);
                            let divEvent = divEvents.querySelector(`.event[id='${ev.id}']`);
                            divEvent.onclick = this.onEventClick;
                        }
                    }
                });
            }
        });
    },
    render(y, m, w, dt) {
        //-------------------------------------------------------------------------------------------
        //Renderizado del calendario de acuerdo a cada vista seleccionada
        if (isNaN(y) && isNaN(this.y)) {
            this.y = Number(moment().year());
        } else if ((!isNaN(y) && isNaN(this.y)) || (!isNaN(y) && !isNaN(this.y))) {
            this.y = y > 1600 ? y : Number(moment().year()); //calendar doesn't exist before 1600! :)
        }

        if (isNaN(m) && isNaN(this.m)) {
            this.m = Number(moment().month());
        } else if ((!isNaN(m) && isNaN(this.m)) || (!isNaN(m) && !isNaN(this.m))) {
            this.m = m >= 0 ? m : Number(moment().month()); //momentjs month starts from 0-11
        }

        if (isNaN(w) && isNaN(this.w)) {
            this.w = Number(moment().week());
        } else if ((!isNaN(w) && isNaN(this.w)) || (!isNaN(w) && !isNaN(this.w))) {
            this.w = w >= 0 ? w : Number(moment().week()); //momentjs week starts from 1-52
        }

        if (isNaN(dt) && isNaN(this.dt)) {
            this.dt = Number(moment().format('DDD'));
        } else if ((!isNaN(dt) && isNaN(this.dt)) || (!isNaN(dt) && !isNaN(this.dt))) {
            this.dt = dt >= 0 ? dt : Number(moment().format('DDD')); //momentjs day 1-356
        }
        //------------------------------------------------------------------------------------------

        let d; // Variable que se ocupa para definir las fechas segun el modo seleccionado
        const now = moment();

        let yearHead = '';
        let weekHead = '';
        let dayHead = '';
        let titleCalendar = '';

        //Arma esquelote para la vista por Año
        if (this.mode === 'year') {
            yearHead = '<thead></thead><tbody><tr></tr><tbody>';
        }

        //Arma esqueleto para Mes y Semana
        if (this.mode === 'month' || this.mode === 'week') {
            const isSameDate = (d1, d2) => d1.format('YYYY-MM-DD') == d2.format('YYYY-MM-DD');
            let frgWeek = '';



            if (this.mode === 'month') {
                //Programación Mensual

                weekHead = '<thead>' +
                    '<tr class="c-weeks">' +
                    '<th class="c-name"><h6 class="initials">Domingo</h6></th>' +
                    '<th class="c-name"><h6 class="initials">Lunes</h6></th>' +
                    '<th class="c-name"><h6 class="initials">Martes</h6></th>' +
                    '<th class="c-name"><h6 class="initials">Miércoles</h6></th>' +
                    '<th class="c-name"><h6 class="initials">Jueves</h6></th>' +
                    '<th class="c-name"><h6 class="initials">Viernes</h6></th>' +
                    '<th class="c-name"><h6 class="initials">Sábado</h6></th>' +
                    '</tr>' +
                    '</thead><tbody>';

                d = moment().year(this.y).month(this.m).date(1); //Posiciona al primer día del mes seleccionado
                titleCalendar = '<div data-month="' + Number(d.format('MM')) + '" data-year="' + this.y + '" class="month-year btn-title js-cal-option btn">' + (this.month[Number(d.format('MM')) - 1] + ' ' + this.y) + '</div>'

                d.day(-1); ///Posiciona al primer día de la semana seleccionada para mostrar en el calendario

                for (var i = 0; i < 5; i++) { //Bucle par pintar las semanas en grupo de 7 dias.
                    frgWeek += `
                    <tr class="days" week="${d.week()}">
                        <td class="calendar-day ${d.add(1, 'd'), this.m != d.month() ? 'outside' : 'inside'}${isSameDate(d, now) ? ' selected' : ''} js-cal-option"><div data-day="${d.day()}" data-date="${d.format('D')}" data-month="${d.format('MM')}" data-year="${d.format('YYYY')}" month="${d.month()}" class="date">${d.format('D')}</div><div class="events"></div></td>
                        <td class="calendar-day ${d.add(1, 'd'), this.m != d.month() ? 'outside' : 'inside'}${isSameDate(d, now) ? ' selected' : ''} js-cal-option"><div data-day="${d.day()}" data-date="${d.format('D')}" data-month="${d.format('MM')}" data-year="${d.format('YYYY')}" month="${d.month()}" class="date">${d.format('D')}</div><div class="events"></div></td>
                        <td class="calendar-day ${d.add(1, 'd'), this.m != d.month() ? 'outside' : 'inside'}${isSameDate(d, now) ? ' selected' : ''} js-cal-option"><div data-day="${d.day()}" data-date="${d.format('D')}" data-month="${d.format('MM')}" data-year="${d.format('YYYY')}" month="${d.month()}" class="date">${d.format('D')}</div><div class="events"></div></td>
                        <td class="calendar-day ${d.add(1, 'd'), this.m != d.month() ? 'outside' : 'inside'}${isSameDate(d, now) ? ' selected' : ''} js-cal-option"><div data-day="${d.day()}" data-date="${d.format('D')}" data-month="${d.format('MM')}" data-year="${d.format('YYYY')}" month="${d.month()}" class="date">${d.format('D')}</div><div class="events"></div></td>
                        <td class="calendar-day ${d.add(1, 'd'), this.m != d.month() ? 'outside' : 'inside'}${isSameDate(d, now) ? ' selected' : ''} js-cal-option"><div data-day="${d.day()}" data-date="${d.format('D')}" data-month="${d.format('MM')}" data-year="${d.format('YYYY')}" month="${d.month()}" class="date">${d.format('D')}</div><div class="events"></div></td>
                        <td class="calendar-day ${d.add(1, 'd'), this.m != d.month() ? 'outside' : 'inside'}${isSameDate(d, now) ? ' selected' : ''} js-cal-option"><div data-day="${d.day()}" data-date="${d.format('D')}" data-month="${d.format('MM')}" data-year="${d.format('YYYY')}" month="${d.month()}" class="date">${d.format('D')}</div><div class="events"></div></td>
                        <td class="calendar-day ${d.add(1, 'd'), this.m != d.month() ? 'outside' : 'inside'}${isSameDate(d, now) ? ' selected' : ''} js-cal-option"><div data-day="${d.day()}" data-date="${d.format('D')}" data-month="${d.format('MM')}" data-year="${d.format('YYYY')}" month="${d.month()}" class="date">${d.format('D')}</div><div class="events"></div></td>
                    </tr>
                    `;
                }

            } else {
                //Programación semanal

                if (this.mode === 'week') {
                    if (w === 1 && m !== 0) {
                        this.y = y + 1;
                    }
                }

                d = moment().year(this.y).week(w);
                let today = moment().format('D');
                let time = moment().format('HH');

                d.day(-1); //Posiciona al primer día de la semana seleccionada para mostrar en el calendario

                weekHead = `<thead>
                    <tr class="c-weeks">
                    <th class="weekHead"></th>
                    <th class="weekHead"></th>
                    <th class="c-name ${d.add(1, 'd')}"><h6 class="initials">Domingo ${d.format('D')}</h6></th>
                    <th class="c-name ${d.add(1, 'd')}"><h6 class="initials">Lunes ${d.format('D')}</h6></th>
                    <th class="c-name ${d.add(1, 'd')}"><h6 class="initials">Martes ${d.format('D')}</h6></th>
                    <th class="c-name ${d.add(1, 'd')}"><h6 class="initials">Miércoles ${d.format('D')}</h6></th>
                    <th class="c-name ${d.add(1, 'd')}"><h6 class="initials">Jueves ${d.format('D')}</h6></th>
                    <th class="c-name ${d.add(1, 'd')}"><h6 class="initials">Viernes ${d.format('D')}</h6></th>
                    <th class="c-name ${d.add(1, 'd')}"><h6 class="initials">Sábado ${d.format('D')}</h6></th>
                    </tr>
                    </thead><tbody>`;

                for (i = 1; i < 25; i++) {
                    d = moment().year(this.y).week(w);

                    d.day(-1); //Posiciona al primer día de la semana seleccionada para mostrar en el calendario

                    frgWeek += '<tr>' +
                        '<th class="horaLine">' + i + ':00</th>' +
                        '<td class="timetitle">&nbsp;</td>' +
                        '<td class="horaWeek ' + d.add(1, 'd') + ' time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-day="0" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td>' +
                        '<td class="horaWeek ' + d.add(1, 'd') + ' time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-day="1" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td>' +
                        '<td class="horaWeek ' + d.add(1, 'd') + ' time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-day="2" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td>' +
                        '<td class="horaWeek ' + d.add(1, 'd') + ' time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-day="3" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td>' +
                        '<td class="horaWeek ' + d.add(1, 'd') + ' time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-day="4" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td>' +
                        '<td class="horaWeek ' + d.add(1, 'd') + ' time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-day="5" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td>' +
                        '<td class="horaWeek ' + d.add(1, 'd') + ' time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-day="6" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td>' +
                        '</tr>';
                }

                let startDate = moment().year(this.y).week(w).startOf('week');
                let endDate = moment().year(this.y).week(w).endOf('week');

                if (Number(startDate.format('MM')) === Number(endDate.format('MM'))) {
                    titleCalendar = '<button data-month="' + Number(startDate.format('MM')) + '" data-year="' + this.y + '" class="month-year btn-title js-cal-option btn">' + (this.month[Number(startDate.format('MM')) - 1] + ' ' + startDate.format('D') + ' - ' + endDate.format('D') + ' ' + this.y) + '</button>';
                } else {
                    if (Number(endDate.format('MM')) === 1) {

                        titleCalendar = '<button data-month="' + (Number(startDate.format('MM')) - 1) + '" data-year="' + this.y + '" class="month-year btn-title js-cal-option btn">' + (this.month[Number(startDate.format('MM')) - 1] + ' ' + startDate.format('D') + ' ' + (this.y - 1) + ' - ' + this.month[Number(endDate.format('MM')) - 1] + ' ' + endDate.format('D') + ' ' + this.y) + '</button>';
                    } else {
                        titleCalendar = '<button data-month="' + (Number(startDate.format('MM')) - 1) + '" data-year="' + this.y + '" class="month-year btn-title js-cal-option btn">' + (this.month[Number(startDate.format('MM')) - 1] + ' ' + startDate.format('D') + ' - ' + this.month[Number(endDate.format('MM')) - 1] + ' ' + endDate.format('D') + ' ' + this.y) + '</button>';
                    }
                }
            }

            weekHead += frgWeek + '</tbody>';
        }

        //Arma esqueleto para día
        if (this.mode === 'day') {
            let dia = moment().year(this.y).month('0').date(0);
            let today = moment().format('D');
            let time = moment().format('HH');
            d = dia.add(this.dt, 'd');

            titleCalendar = '<button data-month="' + Number(d.format('MM')) + '" data-year="' + this.y + '" class="month-year btn-title js-cal-option btn">' + this.month[Number(d.format('MM')) - 1] + ' ' + d.format('D') + ' ' + this.y + '</button>';

            dayHead = '<tbody><tr><td colspan="7">';
            dayHead += '<table class="table table-condensed table-tight-vert"><thead><tr><th class="horaLine"></th><th></th><th class="c-days" style="text-align: center; width: 100%"><h6 class="initials">' + this.date[d.day()] + ' ' + d.format('D') + ' de ' + d.locale('es').format('MMMM') + ' del ' + this.y + '</h6></th></tr></thead>';
            dayHead += '<tbody>';

            for (i = 1; i < 25; i++) {
                dayHead += '<tr><th class="horaLine">' + i + ':00</th><td class="timetitle">&nbsp;</td><td class="horaDia time-' + i + '-0 ' + (Number(time) === i && d.format('D') === today ? 'selected' : '') + '" data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '"><div data-date="' + d.format('D') + '" data-month="' + d.format('MM') + '" data-year="' + d.format('YYYY') + '" data-time="' + i + '" class="date"></div><div class="events"></td></tr>';
            }
            dayHead += '</tbody>';
            dayHead += '</table>';
            dayHead += '</td></tr></tbody>';
        }

        const frgCal = document.createRange().createContextualFragment(`
        <div class="row">
        <div class="col-12">
        <table class="calendar-table table table-condensed table-tight" id="gridCalendar">
          <thead>
            <tr>
                <td colspan="${this.mode === 'week' ? '9' : '7'}" style="text-align: center">
                    <table style="white-space: nowrap; width: 100%">
                        <tr>
                            <td style="text-align:  ${!this.viewDisponibilidad ? 'right' : 'center'}">
                                <span class="btn-group btn-group-lg">
                                <button class="js-cal-prev prev-month btn btn-default"><</button>
                                    ${this.mode === 'day' ? titleCalendar :
            this.mode === 'month' ? titleCalendar :
                this.mode === 'week' ? titleCalendar : ''
        }
                                <button class="js-cal-next next-month btn btn-default">></button>
                                </span>
                            </td>
                            <td style="text-align: right">
                                <span class="btn-group">
                                ${!this.viewDisponibilidad ? '<button class="btn-view js-cal-option btn btn-default disabled" data-mode="month">Ver:</button>' : ''}
                                ${!this.viewDisponibilidad ? '<button class="btn-view js-cal-option mode-calendar-month btn btn-default ' + (this.mode === 'month' ? 'active' : '') + '" data-mode="month">Mes</button>' : ''}
                                ${!this.viewDisponibilidad ? '<button class="btn-view js-cal-option mode-calendar-week btn btn-default ' + (this.mode === 'week' ? 'active' : '') + '" data-mode="week">Semana</button>' : ''}
                                ${!this.viewDisponibilidad ? '<button class="btn-view js-cal-option mode-calendar-day btn btn-default ' + (this.mode === 'day' ? 'active' : '') + '" data-mode="day">Día</button>' : ''}
                                </span>
                            </td>
                        </tr>
                    </table>
                    <br />
                </td>
            </tr>
          </thead>
          ${yearHead}
          ${weekHead}
          ${dayHead}
        </table>
        </div>
        </div>
        <div class="row">
            <div class="col-12">
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-3 verificadores-di">
                <svg width="20" height="15">
                    <rect width="18" height="20" style="fill:#d7feed;stroke-width:1;stroke:#e4e4eb" />
                </svg> ${!this.viewDisponibilidad ? 'Sin eventos' : ('6 o más ' + this.titleDisponibilidad + ' disponbiles')}
            </div>
            <div class="col-3 verificadores-di">
                <svg width="20" height="15">
                    <rect width="18" height="20" style="fill:#fdf0b0;stroke-width:1;stroke:#e4e4eb" />
                </svg>${!this.viewDisponibilidad ? '1 evento' : ('3-5 ' + this.titleDisponibilidad + ' disponibles')}
            </div>
            <div class="col-3 verificadores-di">
                <svg width="20" height="15">
                    <rect width="18" height="20" style="fill:#ffc299;stroke-width:1;stroke:#e4e4eb" />
                </svg>${!this.viewDisponibilidad ? '2 eventos' : ('1-2 ' + this.titleDisponibilidad + ' disponibles')}
            </div>
            <div class="col-3 verificadores-di">
                <svg width="20" height="15">
                    <rect width="18" height="20" style="fill:#f29292;stroke-width:1;stroke:#e4e4eb" />
                </svg>${!this.viewDisponibilidad ? 'Más de 3 eventos' : ('0 ' + this.titleDisponibilidad + ' disponibles')}
            </div>
        </div>
    </div>
        `);

        frgCal.querySelector('.prev-month').onclick = () => {
            let dp;

            if (this.mode === 'month') {
                dp = moment().year(this.y).month(this.m).date(1).subtract(1, 'month');

                //Se hace llamado para traer solo el mes que se esta consultano sin traer todo el año
                //Si y solo si el enabledCallBackMonth esta en true
                if (this.enabledCallBackMonth) {
                    this.callBackMonth({ anio: Number(dp.year()), mes: Number(dp.month())+1 });
                }
            }

            if (this.mode === 'week') {
                dp = moment().year(this.y).week(this.w).subtract(1, 'week');
            }

            if (this.mode === 'day') {
                var dia = moment().year(this.y).month('0').date(0);
                dp = dia.add((this.dt - 1), 'd');
            }

            this.render(Number(dp.year()), Number(dp.month()), Number(dp.week()), Number(dp.format('DDD')));
        };

        frgCal.querySelector('.next-month').onclick = () => {
            let dn;

            if (this.mode === 'month') {
                dn = moment().year(this.y).month(this.m).date(1).add(1, 'month');

                //Se hace llamado para traer solo el mes que se esta consultano sin traer todo el año
                //Si y solo si el enabledCallBackMonth esta en true
                if (this.enabledCallBackMonth) {
                    this.callBackMonth({ anio: Number(dn.year()), mes: Number(dn.month())+1 });
                }
            }

            if (this.mode === 'week') {
                dn = moment().year(this.y).week(this.w).add(1, 'week');
            }

            if (this.mode === 'day') {
                var dia = moment().year(this.y).month('0').date(0);
                dn = dia.add((this.dt + 1), 'd');
            }

            this.render(Number(dn.year()), Number(dn.month()), Number(dn.week()), Number(dn.format('DDD')));
        };

        if (!this.viewDisponibilidad) {
            frgCal.querySelector('.mode-calendar-month').onclick = () => {
                this.mode = 'month';
                const dn = moment().year(this.y).month(this.m).date(1); //Primer día del mes
                this.render(Number(dn.year()), Number(dn.month()), Number(dn.week()), Number(dn.format('DDD')));
            };
        }

        if (!this.viewDisponibilidad) {
            frgCal.querySelector('.mode-calendar-week').onclick = () => {
                this.mode = 'week';
                const dn = moment().year(this.y).month(this.m); //Primer día del mes
                this.render(Number(dn.year()), Number(dn.month()), Number(dn.week()), Number(dn.format('DDD')));
            };
        }

        if (!this.viewDisponibilidad) {
            frgCal.querySelector('.mode-calendar-day').onclick = () => {
                this.mode = 'day';
                const dn = moment().year(this.y).month(this.m); //Primer día del mes
                this.render(Number(dn.year()), Number(dn.month()), Number(dn.week()), Number(dn.format('DDD')));
            };
        }


        this.el = document.getElementById(this.id);
        this.el.innerHTML = ''; //replacing
        this.el.appendChild(frgCal);
        this.renderEvents();
    }
});

const CambioMes = (id) => ({
    id: id,
    el: null,
    renderSpinner() {
        const frgSpinner = document.createRange().createContextualFragment(`
        <div class="spinner d-flex justify-content-center align-items-center">
            <div class="spinner-grow text-light" style="width: 4rem; height: 4rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        `);
        this.el = document.getElementById(this.id);
        this.el.innerHTML = ''; //replacing
        this.el.appendChild(frgSpinner);
        return this;
    },
    async delay(delay = 2000) {
        await new Promise(resolve => setTimeout(resolve, delay));
    }
});

const mockData = [{
    id: 1,
    time: '2021-08-06T22:00:00',
    timeEnd: '2021-08-06T23:00:00',
    cls: 'bg-green',
    desc: 'NAYARIT'
},
    {
        id: 2,
        time: '2021-08-10T19:00:00',
        cls: 'bg-purple',
        desc: 'CDMX'
    },
    {
        id: 3,
        time: '2021-08-20T22:00:00',
        timeEnd: '2021-08-20T23:00:00',
        cls: 'bg-orange',
        desc: 'NAYARIT'
    },
    {
        id: 4,
        time: '2021-09-01T21:00:00',
        timeEnd: '2021-09-01T22:00:00',
        cls: 'bg-orange',
        desc: 'OAXACA 1'
    },
    {
        id: 5,
        time: '2021-09-01T22:00:00',
        timeEnd: '2021-09-01T23:00:00',
        cls: 'bg-green',
        desc: 'NAYARIT'
    },
    {
        id: 6,
        time: '2021-09-01T19:00:00',
        timeEnd: '2021-09-01T20:00:00',
        cls: 'bg-purple',
        desc: 'CDMX'
    },
    {
        id: 7,
        time: '2021-09-05T21:00:00',
        timeEnd: '2021-09-05T22:00:00',
        cls: 'bg-orange',
        desc: 'OAXACA 1'
    },
    {
        time: '2021-09-05T22:00:00',
        timeEnd: '2021-09-05T23:00:00',
        cls: 'bg-green',
        desc: 'NAYARIT'
    },
    {
        id: 8,
        time: '2021-09-08T21:00:00',
        timeEnd: '2021-09-06T22:00:00',
        cls: 'bg-orange',
        desc: 'OAXACA 1'
    },
    {
        id: 9,
        time: '2021-09-10T19:00:00',
        timeEnd: '2021-09-10T23:00:00',
        cls: 'bg-purple',
        desc: 'CDMX'
    },
    {
        id: 10,
        time: '2021-09-10T19:00:00',
        timeEnd: '2021-09-10T19:00:00',
        cls: 'bg-green',
        desc: 'CDMX'
    },
    {
        id: 11,
        time: '2021-09-15T14:00:00',
        timeEnd: '2021-09-15T18:00:00',
        cls: 'bg-orange',
        desc: 'OAXACA 1'
    },
    {
        id: 12,
        time: '2021-09-17T22:00:00',
        timeEnd: '2021-09-15T23:00:00',
        cls: 'bg-green',
        desc: 'NAYARIT'
    },
    {
        id: 13,
        time: '2021-09-17T19:00:00',
        timeEnd: '2021-09-15T20:00:00',
        cls: 'bg-purple',
        desc: 'CDMX'
    },
    {
        id: 14,
        time: '2021-09-28T22:00:00',
        timeEnd: '2021-09-28T23:00:00',
        cls: 'bg-green',
        desc: 'NAYARIT'
    },
    {
        id: 15,
        time: '2021-09-30T19:00:00',
        timeEnd: '2021-09-30T22:00:00',
        cls: 'bg-purple',
        desc: 'CDMX'
    }
];

const mockDataDisponible = [{
    time: '2021-10-04T22:00:00',
    asignados: [1],
    disponibles: [2,3,4,5,6,7]
},
    {
        time: '2021-10-15T22:00:00',
        asignados: [],
        disponibles: [1,2]
    },
    {
        time: '2021-10-19T22:00:00',
        asignados: [],
        disponibles: [1,2,3,4,5]
    }, {
        time: '2021-10-28T22:00:00',
        asignados: [],
        disponibles: []
    }
];

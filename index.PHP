<<?php
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Calendario Digital Interactivo</title>
  <style>
    :root {
      --azul-claro: #3a7bd5;
      --azul-suave: #00d2ff;
      --fondo: #f5f9ff;
      --texto: #1e293b;
      --borde: #cbd5e1;
      --radius: 14px;
      font-family: 'Poppins', 'Segoe UI', sans-serif;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      background: var(--fondo);
      color: var(--texto);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      padding: 30px 10px;
    }

    h1 {
      font-size: 2rem;
      color: var(--azul-claro);
      margin-bottom: 20px;
    }

    /* --- Contenedor principal --- */
    .panel {
      background: #fff;
      border-radius: var(--radius);
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      width: 95%;
      max-width: 950px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    /* --- Pestañas --- */
    .tabs {
      display: flex;
      background: linear-gradient(to right, var(--azul-claro), var(--azul-suave));
    }

    .tab {
      flex: 1;
      text-align: center;
      padding: 14px 0;
      cursor: pointer;
      color: #fff;
      font-weight: 600;
      transition: background 0.3s;
    }

    .tab.active {
      background: rgba(255,255,255,0.2);
    }

    /* --- Contenido de cada pestaña --- */
    .tab-content {
      display: none;
      padding: 30px;
      animation: fadeIn 0.4s ease;
    }

    .tab-content.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* --- Sección HOY --- */
    .hoy {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .recordatorio {
      background: var(--fondo);
      border: 1px solid var(--borde);
      border-left: 5px solid var(--azul-claro);
      padding: 14px;
      border-radius: 10px;
      transition: 0.3s;
    }

    .recordatorio:hover {
      background: #e0f2ff;
    }

    /* --- Calendario --- */
    .calendar {
      background: #fff;
      border: 1px solid var(--borde);
      border-radius: 10px;
      padding: 20px;
    }

    .calendar-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
    }

    .calendar-header h2 {
      margin: 0;
      color: var(--azul-claro);
    }

    .controls button {
      background: var(--azul-claro);
      border: none;
      color: white;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .controls button:hover {
      background: var(--azul-suave);
    }

    .weekdays, .days {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      text-align: center;
      gap: 5px;
    }

    .weekdays div {
      font-weight: 600;
      color: var(--azul-claro);
    }

    .day {
      background: var(--fondo);
      padding: 10px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.2s;
    }

    .day:hover {
      background: #e0f2ff;
    }

    .day.today {
      border: 2px solid var(--azul-claro);
    }

    .day.other-month {
      opacity: 0.4;
    }

    /* --- Lista de eventos --- */
    .event-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .event-item {
      background: var(--fondo);
      border: 1px solid var(--borde);
      border-left: 5px solid var(--azul-suave);
      padding: 12px;
      border-radius: 10px;
    }

    .event-item h3 {
      margin: 0;
      color: var(--azul-claro);
      font-size: 1rem;
    }
  </style>
</head>
<body>
  <h1>Calendario Digital Interactivo</h1>

  <div class="panel">
    <div class="tabs">
      <div class="tab active" data-tab="hoy">Hoy</div>
      <div class="tab" data-tab="eventos">Eventos</div>
      <div class="tab" data-tab="calendario">Calendario</div>
    </div>

    <!-- Pestaña HOY -->
    <div class="tab-content active" id="hoy">
      <h2>🕓 Tu horario de hoy</h2>
      <div class="hoy" id="listaHoy">
        <div class="recordatorio">💻 Clase de programación - 9:00 AM</div>
        <div class="recordatorio">🍽️ Almuerzo con equipo - 12:30 PM</div>
        <div class="recordatorio">📚 Estudiar inglés - 4:00 PM</div>
      </div>
    </div>

    <!-- Pestaña EVENTOS -->
    <div class="tab-content" id="eventos">
      <h2>📅 Eventos importantes</h2>
      <div class="event-list">
        <div class="event-item">
          <h3>Examen final de Matemáticas</h3>
          <p>15 de noviembre - 8:00 AM</p>
        </div>
        <div class="event-item">
          <h3>Reunión de proyecto</h3>
          <p>17 de noviembre - 2:00 PM</p>
        </div>
      </div>
    </div>

    <!-- Pestaña CALENDARIO -->
    <div class="tab-content" id="calendario">
      <div class="calendar">
        <header class="calendar-header">
          <h2 id="monthYear">—</h2>
          <div class="controls">
            <button id="prevBtn">◀</button>
            <button id="todayBtn">Hoy</button>
            <button id="nextBtn">▶</button>
          </div>
        </header>
        <div class="weekdays" id="weekdays"></div>
        <div class="days" id="days"></div>
      </div>
    </div>
  </div>

  <script>
    // ---- Pestañas interactivas ----
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
      });
    });

    // ---- Renderizado de calendario ----
    const state = { current: new Date() };
    const weekdays = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];

    function renderWeekdays() {
      document.getElementById('weekdays').innerHTML = weekdays.map(d => `<div>${d}</div>`).join('');
    }

    function startOfMonth(d){ return new Date(d.getFullYear(), d.getMonth(), 1); }
    function endOfMonth(d){ return new Date(d.getFullYear(), d.getMonth() + 1, 0); }

    function renderCalendar() {
      const daysContainer = document.getElementById('days');
      const monthYear = document.getElementById('monthYear');
      const date = state.current;
      const start = startOfMonth(date);
      const end = endOfMonth(date);
      monthYear.textContent = date.toLocaleString('es-CO', { month: 'long', year: 'numeric' });

      const startWeekday = (start.getDay() + 6) % 7;
      const total = startWeekday + end.getDate();
      const rows = Math.ceil(total / 7);
      const cells = rows * 7;

      const firstDate = new Date(start);
      firstDate.setDate(start.getDate() - startWeekday);

      let html = '';
      for (let i = 0; i < cells; i++) {
        const d = new Date(firstDate);
        d.setDate(firstDate.getDate() + i);
        const isOther = d.getMonth() !== date.getMonth();
        const isToday = isSameDay(d, new Date());
        html += `<div class="day ${isOther ? 'other-month' : ''} ${isToday ? 'today' : ''}">
                   ${d.getDate()}
                 </div>`;
      }
      daysContainer.innerHTML = html;
    }

    function isSameDay(a,b){
      return a.getFullYear()===b.getFullYear() && a.getMonth()===b.getMonth() && a.getDate()===b.getDate();
    }

    document.getElementById('prevBtn').addEventListener('click', ()=>{
      state.current = new Date(state.current.getFullYear(), state.current.getMonth()-1,1);
      renderCalendar();
    });
    document.getElementById('nextBtn').addEventListener('click', ()=>{
      state.current = new Date(state.current.getFullYear(), state.current.getMonth()+1,1);
      renderCalendar();
    });
    document.getElementById('todayBtn').addEventListener('click', ()=>{
      state.current = new Date();
      renderCalendar();
    });

    renderWeekdays();
    renderCalendar();
  </script>
</body>
</html>

<?php
// --- Ejemplo de datos simulados de eventos (en un caso real vendrían de una base de datos)
$eventos = [
  ['fecha' => '2025-11-10', 'titulo' => 'Reunión del equipo'],
  ['fecha' => '2025-11-11', 'titulo' => 'Entrega de proyecto'],
  ['fecha' => '2025-11-13', 'titulo' => 'Clases extras'],
  ['fecha' => '2025-11-13', 'titulo' => 'Revisión de notas'],
  ['fecha' => '2025-11-14', 'titulo' => 'Taller de innovación'],
  ['fecha' => '2025-11-15', 'titulo' => 'Evaluación parcial'],
];

// Contar eventos por día de la semana (Lunes=1 ... Domingo=7)
$frecuencia = [0,0,0,0,0,0,0];
foreach ($eventos as $e) {
  $dia = date('N', strtotime($e['fecha']));
  $frecuencia[$dia-1]++;
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Calendario Digital Moderno</title>
<style>
  :root {
    --azul: #2b6cb0;
    --azul-claro: #e0f2ff;
    --blanco: #ffffff;
    --gris: #edf2f7;
    --texto: #1a202c;
    font-family: 'Poppins', system-ui, sans-serif;
  }

  body {
    margin: 0;
    background: var(--gris);
    color: var(--texto);
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
  }

  header {
    background: var(--azul);
    color: var(--blanco);
    width: 100%;
    text-align: center;
    padding: 20px;
    font-size: 1.5rem;
    font-weight: 600;
  }

  .tabs {
    display: flex;
    background: var(--blanco);
    border-radius: 12px;
    overflow: hidden;
    margin-top: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }

  .tab {
    flex: 1;
    text-align: center;
    padding: 12px;
    cursor: pointer;
    background: var(--azul-claro);
    color: var(--azul);
    font-weight: 500;
    transition: all 0.2s;
  }

  .tab.active {
    background: var(--azul);
    color: var(--blanco);
  }

  .content {
    max-width: 900px;
    background: var(--blanco);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-top: 20px;
    padding: 20px;
    width: 90%;
  }

  .tab-content { display: none; }
  .tab-content.active { display: block; }

  h2 { color: var(--azul); }

  canvas {
    width: 100%;
    max-width: 500px;
    margin-top: 20px;
  }

  ul { line-height: 1.6; }
</style>
</head>
<body>
  <header>📅 Calendario Digital Moderno</header>

  <div class="tabs">
    <div class="tab active" data-tab="hoy">Hoy</div>
    <div class="tab" data-tab="eventos">Eventos</div>
    <div class="tab" data-tab="calendario">Calendario</div>
    <div class="tab" data-tab="acerca">Acerca</div>
  </div>

  <div class="content">
    <!-- HOY -->
    <div class="tab-content active" id="hoy">
      <h2>🕒 Tu día de hoy</h2>
      <p>Bienvenido, hoy es <b><?php echo date("l, d \\d\\e F Y"); ?></b>.</p>
      <p>Estos son tus eventos programados para hoy:</p>
      <ul>
        <?php
        $hoy = date('Y-m-d');
        $tieneEventos = false;
        foreach ($eventos as $e) {
          if ($e['fecha'] === $hoy) {
            echo "<li>🔹 {$e['titulo']}</li>";
            $tieneEventos = true;
          }
        }
        if (!$tieneEventos) echo "<li>No tienes eventos programados hoy 🎉</li>";
        ?>
      </ul>
    </div>

    <!-- EVENTOS -->
    <div class="tab-content" id="eventos">
      <h2>📋 Próximos eventos</h2>
      <ul>
        <?php foreach ($eventos as $e): ?>
          <li><b><?php echo date('d/m/Y', strtotime($e['fecha'])); ?>:</b> <?php echo htmlspecialchars($e['titulo']); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- CALENDARIO -->
    <div class="tab-content" id="calendario">
      <h2>📆 Vista del Calendario</h2>
      <p>Haz clic en un día del calendario (en desarrollo).</p>
      <div style="height:200px;display:flex;align-items:center;justify-content:center;color:gray;">
        <em>🛠️ Aquí irá tu calendario interactivo...</em>
      </div>
    </div>

    <!-- ACERCA -->
    <div class="tab-content" id="acerca">
      <h2>ℹ️ Acerca de Calendario Digital</h2>
      <p>
        <strong>Calendario Digital</strong> es una plataforma creada para ayudarte a
        <b>organizar tu tiempo, planificar tus días y recordar tus eventos importantes</b>.
        Con un diseño moderno y limpio, puedes visualizar tus tareas, clases y actividades fácilmente.
      </p>

      <h3>🎯 ¿Cómo funciona?</h3>
      <ul>
        <li>📅 Muestra tu calendario y los eventos agregados.</li>
        <li>🔔 Te recuerda tus horarios y actividades diarias.</li>
        <li>📈 Analiza qué días tienes más eventos o actividades.</li>
        <li>🗂️ Te permite gestionar tus tareas con facilidad.</li>
      </ul>

      <h3>💬 ¿En qué te ayudamos?</h3>
      <p>
        Te apoyamos para que <b>mantengas el control de tus compromisos</b> sin estrés.
        Ya sea para tus clases, proyectos, reuniones o recordatorios personales, 
        esta herramienta te facilitará mantener todo en orden.
      </p>

      <h3>📊 Días con más eventos</h3>
      <p>Según tus registros actuales, así se distribuyen tus actividades:</p>
      <canvas id="graficoEventos"></canvas>

      <h3>🤝 Contáctanos</h3>
      <p>
        Si necesitas ayuda o tienes sugerencias, puedes escribirnos a:<br>
        <a href="mailto:soporte@calendariodigital.com">soporte@calendariodigital.com</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // ---- Gráfico de eventos (Chart.js) ----
    const ctx = document.getElementById('graficoEventos');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'],
        datasets: [{
          label: 'Cantidad de eventos',
          data: <?php echo json_encode($frecuencia); ?>,
          backgroundColor: 'rgba(43,108,176,0.5)',
          borderColor: '#2b6cb0',
          borderWidth: 1
        }]
      },
      options: {
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
        plugins: { legend: { display: false } }
      }
    });
  </script>
</body>
</html>

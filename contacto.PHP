<?PHP
// incluir laconexion
include("db/conexion.php");

// validar que el formulario fue enviado 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $_POST["nombre"];
    $correo   = $_POST["email"];
    $telefono = $_POST["telefono"];
    $asunto   = $_POST["asunto"];
    $mensaje  = $_POST["mensaje"];

    // preparar consulta (SQL injection seguro)
    $smtm = $conn->prepare("INSERT INTO formulario (nombre, correo, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)");
    $smtm->bind_param("sssss", $nombre, $correo, $telefono, $asunto, $mensaje);

    if ($stmt->execute()) {
      $msg = "✅ Tu mensaje se envió correctamente.";
      echo "<script>document.addEventListener('DOMContentLoaded', function(){ var m = " . json_encode($msg) . ";
      var d = document.createElement('div');
      d.textContent = m;
      Object.assign(d.style, {position:'fixed', left:'50%', top:'20px', transform:'translateX(-50%)', background:'#1f2937', color:'#fff', padding:'12px 18px', borderRadius:'6px', zIndex:9999, fontSize:'16px', boxShadow:'0 2px 10px rgba(0,0,0,0.2)'});
      document.body.appendChild(d);
      setTimeout(function(){
        try { window.close(); } catch(e) {}
        setTimeout(function(){
        if (!window.closed) { window.location = 'Inicio.php'; }
        }, 200);
      }, 3000);
      });</script>";
    } else {
      $err = "❌ Error: " . $stmt->error;
      echo "<script>document.addEventListener('DOMContentLoaded', function(){ var m = " . json_encode($err) . ";
      var d = document.createElement('div');
      d.textContent = m;
      Object.assign(d.style, {position:'fixed', left:'50%', top:'20px', transform:'translateX(-50%)', background:'#7f1d1d', color:'#fff', padding:'12px 18px', borderRadius:'6px', zIndex:9999, fontSize:'16px', boxShadow:'0 2px 10px rgba(0,0,0,0.2)'});
      document.body.appendChild(d);
      setTimeout(function(){
        try { window.close(); } catch(e) {}
        setTimeout(function(){
        if (!window.closed) { window.location = 'Inicio.php; }
        }, 200);
      }, 3000);
      });</script>";
      
    }

    $stmt->close();
    $conn->close();
  }
   
        ?>
</PHP>
<!DOCTYPE html>
<html lang="es">
<head>
<Meta charset="UTP-8">
<Meta name="viewport" content="width=device-width, initial-scale= 1.0">
<Title>pagina de pool</Title>
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* ====== Header ====== */
    header {
      background: #070808;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      font-size: 22px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    nav a:hover {
      color: #facc15;
    }

    /* ====== Contenido principal ====== */
    main {
      flex: 1;
      padding: 40px;
      background: #C8E8CE;
    }

    main h2 {
      margin-bottom: 15px;
    }

    /* ====== Footer ====== */
    footer {
      background: #070808;
      color: white;
      text-align: center;
      padding: 15px 0;
    }
  </style>
</head>

<body>
	<header>
		<h1>Mi web frontend</h1>
		<nav>
			<ul>
				<li><a href ="index.php">inicio</a></li>
				<li><a href ="acerca.php">acerca</a></li>
				<li><a href ="contacto.php">contacto</a></li>
			</ul>
		</nav>

	</header>

	<main>
    <div class="contact-container">
      <h2>contacto</h2>

      <!-- formulario: ajusta action y method según tu backend -->
      <form action="contacto.php"method="post" novalidate>
        <div class="form-group">
          <label for="nombre">nombre completo</label>
          <input id="nombre" name="nombre" type="text" placeholder="tu nombre" required>
        </div>

        <div class="form-group">
          <label for="email">correo electrónico</label>
          <input id="email" name="email" type="email" placeholder="tucorreo@ejemplo.com" required>

          <div class="form-group">
            <label for="telefono">teléfono (opcional)</label>
            <input id="telefono" name="telefono" type="text" placeholder="+34 600 000 000 ">
          </div>

          <div class="form-group">
            <label for="asunto">asunto</label>
            <input id="asunto" name="asunto" type="text"placeholder="breve resumen" required>
          </div>

          <div class="form-group">
            <label for="mensaje">mensaje</label>
            <textarea id="mensaje" name="mensaje" placeholder="escribe tu mensaje..." required></textarea>
              <div class="hint">máximo 2000 caracteres.</div>
            </div>

            <div class="actions">
              <button type="reset" class="btn btn-secondary">limpiar</button>
              <button type="submit"class="btn btn-primary">enviar mensaje</button>
            </div>
          </form>
        </div>
      </main>


	</main>

	<footer>
		<p>Realizado por Jean Pool</p>
 
  </footer>
  <script>
      (function(){
        var mensaje = document.getElementById('mensaje');
        var counter = document.getElementById('counter');
        var form = document.querySelector('.contact-form');
        var submit = document.getElementById('submitBtn');

        function updateCount(){
          var len = mensaje.value.length;
          counter.textContent = len + ' / ' + (mensaje.maxLength || 2000);
          if(len > (mensaje.maxLength - 20)){
            counter.style.color = '#b45309';
          } else {
            counter.style.color = '';
          }
        }
        mensaje.addEventListener('input', updateCount);
        updateCount();

        // simple client-side validation feedback
        form.addEventListener('submit', function(e){
          if(!form.checkValidity()){
            e.preventDefault();
            // focus first invalid
            var firstInvalid = form.querySelector(':invalid');
            if(firstInvalid) firstInvalid.focus();
            // visual hint
            submit.textContent = 'Corrige los campos';
            setTimeout(function(){ submit.textContent = 'Enviar mensaje'; }, 1800);
          } else {
            // prevent double submit UX: disable button briefly while submitting
            submit.disabled = true;
            submit.style.opacity = '.7';
            setTimeout(function(){ submit.disabled = false; submit.style.opacity = ''; }, 3000);
          }
        });

        // reset handler
        document.getElementById('resetBtn').addEventListener('click', function(){
          setTimeout(updateCount, 10);
        });
      })();
    </script>
<script>
</body>

</html> 
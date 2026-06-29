<!DOCTYPE html>
<html lang="es-MX">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto — Taquería El Compadre</title>
  <meta name="description" content="Ponte en contacto con Taquería El Compadre. Estamos en Av. Revolución 1234, Col. Centro, CDMX. Tel: +52 55 1234 5678.">
  <meta name="robots" content="index, follow">
  <meta property="og:title" content="Contacto — Taquería El Compadre">
  <meta property="og:description" content="Visítanos o escríbenos. Te esperamos.">
  <meta name="theme-color" content="#C62828">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&family=Dancing+Script:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌮</text></svg>">
</head>
<body>

<?php
// ============================================================
// CONTACT FORM HANDLER
// ============================================================
$success = false;
$error   = '';
$nombre  = '';
$email   = '';
$telefono = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $nombre  = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $email   = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING));
    $mensaje = trim(filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_STRING));

    // Validation
    $errors = [];

    if (empty($nombre) || strlen($nombre) < 2) {
        $errors[] = 'Por favor ingresa tu nombre.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Ingresa un correo electrónico válido.';
    }

    if (empty($mensaje) || strlen($mensaje) < 5) {
        $errors[] = 'Escribe un mensaje de al menos 5 caracteres.';
    }

    if (empty($errors)) {
        // --- EMAIL CONFIGURATION ---
        // Change these to your actual email settings:
        $to      = 'hola@taqueriaelcompadre.mx';
        $subject = 'Nuevo mensaje desde Taquería El Compadre — ' . $nombre;

        $body  = "Has recibido un nuevo mensaje desde el formulario de contacto:\n\n";
        $body .= "Nombre:    " . $nombre . "\n";
        $body .= "Correo:    " . $email . "\n";
        $body .= "Teléfono:  " . ($telefono ?: 'No proporcionado') . "\n";
        $body .= "Mensaje:\n" . $mensaje . "\n\n";
        $body .= "---\n";
        $body .= "Enviado desde taqueriaelcompadre.mx";

        $headers  = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $body, $headers)) {
            $success = true;
        } else {
            $error = 'Hubo un problema al enviar tu mensaje. Intenta de nuevo o escríbenos directamente a ' . $to;
        }
    } else {
        $error = implode(' ', $errors);
    }
}
?>

  <!-- ============================================================
       NAVBAR
       ============================================================ -->
  <nav class="navbar scrolled" role="navigation" aria-label="Navegación principal">
    <div class="container">
      <a href="index.html" class="navbar-brand" aria-label="Ir al inicio">
        <span class="brand-icon">🌮</span>
        El Compadre
      </a>
      <div class="hamburger" aria-label="Abrir menú" role="button" tabindex="0">
        <span></span><span></span><span></span>
      </div>
      <div class="navbar-links">
        <a href="index.html">Inicio</a>
        <a href="menu.html">Menú</a>
        <a href="index.html#gallery">Galería</a>
        <a href="contacto.php" class="active">Contacto</a>
        <a href="tel:+525512345678" class="navbar-cta"><i class="fas fa-phone-alt"></i> Llama Ahora</a>
      </div>
    </div>
  </nav>

  <!-- ============================================================
       PAGE HEADER
       ============================================================ -->
  <header class="page-header" style="background-image: none; background: linear-gradient(135deg, #1A1A1A, #2C2C2C);">
    <div class="page-header-bg" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1920&q=80');" aria-hidden="true"></div>
    <div class="page-header-overlay"></div>
    <div class="container">
      <div class="breadcrumb">
        <a href="index.html">Inicio</a>
        <span>/</span>
        <span>Contacto</span>
      </div>
      <h1 data-aos="fade-up">Contáctanos</h1>
      <p data-aos="fade-up" data-aos-delay="100">Estamos aquí para escucharte y atenderte.</p>
    </div>
  </header>

  <!-- ============================================================
       CONTACT SECTION
       ============================================================ -->
  <section class="section section--cream">
    <div class="container container--narrow">

      <?php if ($success): ?>
        <!-- SUCCESS MESSAGE -->
        <div class="form-success-page" data-aos="fade-up">
          <div class="success-icon"><i class="fas fa-check"></i></div>
          <h2 style="margin-bottom: 0.75rem;">¡Mensaje enviado!</h2>
          <p style="color: var(--color-text-light); font-size: 1.05rem; margin-bottom: 2rem;">
            Gracias, <strong><?php echo htmlspecialchars($nombre); ?></strong>. Hemos recibido tu mensaje y te responderemos a la brevedad. <br>¡Buen provecho!
          </p>
          <a href="index.html" class="btn btn--primary"><i class="fas fa-home"></i> Volver al inicio</a>
        </div>
      <?php else: ?>
        <!-- CONTACT GRID -->
        <div class="contact-grid">
          <div class="contact-info-list" data-aos="fade-right">
            <div class="contact-info-item">
              <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
              <div>
                <h4>Dirección</h4>
                <p>Av. Revolución 1234, Col. Centro<br>Ciudad de México, CDMX</p>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
              <div>
                <h4>Teléfono</h4>
                <p>+52 55 1234 5678</p>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
              <div>
                <h4>Correo</h4>
                <p>hola@taqueriaelcompadre.mx</p>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
              <div>
                <h4>Horario</h4>
                <p>Lun — Jue: 11am — 11pm<br>Vie — Sáb: 11am — 1am<br>Dom: 10am — 10pm</p>
              </div>
            </div>
            <div style="margin-top:1rem;">
              <a href="https://wa.me/525512345678" target="_blank" rel="noopener" class="btn btn--gold"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
          </div>

          <form class="contact-form" action="contacto.php" method="POST" data-aos="fade-left" novalidate>
            <?php if ($error): ?>
              <div class="form-alert form-alert--error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
              </div>
            <?php endif; ?>

            <div class="form-row">
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                       placeholder="Tu nombre" required
                       value="<?php echo htmlspecialchars($nombre); ?>">
              </div>
              <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="tu@correo.com" required
                       value="<?php echo htmlspecialchars($email); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono (opcional)</label>
              <input type="tel" class="form-control" id="telefono" name="telefono"
                     placeholder="+52 55 1234 5678"
                     value="<?php echo htmlspecialchars($telefono); ?>">
            </div>
            <div class="form-group">
              <label for="mensaje">Mensaje</label>
              <textarea class="form-control" id="mensaje" name="mensaje"
                        placeholder="Cuéntanos cómo podemos ayudarte..." required><?php echo htmlspecialchars($mensaje); ?></textarea>
            </div>
            <button type="submit" class="btn btn--primary" style="width:100%; justify-content:center;">
              <i class="fas fa-paper-plane"></i> Enviar Mensaje
            </button>
          </form>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- ============================================================
       LOCATION MAP (full width)
       ============================================================ -->
  <section class="section" style="padding-top:0;">
    <div class="container">
      <div style="border-radius: var(--card-radius); overflow: hidden; box-shadow: var(--shadow-md); height: 400px; position: relative;" data-aos="fade-up">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.5!2d-99.1332!3d19.4326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDI1JzU3LjQiTiA5OcKwMDgnMDAuMiJX!5e0!3m2!1ses!2smx!4v1"
          style="position:absolute;inset:0;width:100%;height:100%;border:0;"
          allowfullscreen=""
          loading="lazy"
          title="Mapa de ubicación de Taquería El Compadre"
        ></iframe>
      </div>
    </div>
  </section>

  <!-- ============================================================
       FOOTER
       ============================================================ -->
  <footer class="footer">
    <div class="footer-grid">
      <div>
        <a href="index.html" class="footer-brand">🌮 El Compadre</a>
        <p class="footer-about">
          Auténtica cocina mexicana desde 1998. Tradición, sabor y calidad en cada platillo. Te esperamos con los brazos abiertos.
        </p>
        <div class="footer-social">
          <a href="#" aria-label="Facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="TikTok" title="TikTok"><i class="fab fa-tiktok"></i></a>
          <a href="#" aria-label="YouTube" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <div>
        <h4>Enlaces</h4>
        <ul class="footer-links">
          <li><a href="index.html">Inicio</a></li>
          <li><a href="menu.html">Menú</a></li>
          <li><a href="contacto.php">Contacto</a></li>
        </ul>
      </div>
      <div>
        <h4>Horario</h4>
        <ul class="footer-links">
          <li><a href="#">Lun — Jue: 11am — 11pm</a></li>
          <li><a href="#">Vie — Sáb: 11am — 1am</a></li>
          <li><a href="#">Dom: 10am — 10pm</a></li>
        </ul>
      </div>
      <div>
        <h4>Contacto</h4>
        <ul class="footer-links">
          <li><a href="tel:+525512345678">+52 55 1234 5678</a></li>
          <li><a href="mailto:hola@taqueriaelcompadre.mx">hola@taqueriaelcompadre.mx</a></li>
          <li><a href="https://wa.me/525512345678" target="_blank" rel="noopener">WhatsApp</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; 2026 Taquería El Compadre. Todos los derechos reservados.</span>
      <span>Hecho con <i class="fas fa-heart" style="color: var(--color-primary);"></i> en México</span>
    </div>
  </footer>

  <!-- ============================================================
       WHATSAPP FLOAT
       ============================================================ -->
  <a href="https://wa.me/525512345678?text=¡Hola!%20Quiero%20más%20información" target="_blank" rel="noopener" class="whatsapp-float" aria-label="WhatsApp">
    <i class="fab fa-whatsapp"></i>
  </a>

  <script src="js/main.js"></script>
</body>
</html>

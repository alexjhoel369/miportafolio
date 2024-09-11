<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $mensaje = $_POST['mensaje'];

  $stmt = $pdo->prepare("INSERT INTO contactos (nombre, correo, mensaje) VALUES (?, ?, ?)");
  
  if ($stmt->execute([$nombre, $correo, $mensaje])) {
      $_SESSION['mensaje'] = "Mensaje enviado con éxito.";
  } else {
      $_SESSION['mensaje'] = "Error al enviar el mensaje.";
  }
  header("Location: index.php");
  exit(); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio Personal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

</head>
<body>
    <header>
        <h1>Mi Portafolio</h1>
    </header>

    <section id="proyectos">
        <h2>Proyectos</h2>
        <div class="grid">
            <?php
            // Mostrar proyectos
            $query = $pdo->query("SELECT * FROM proyectos");
            while ($proyecto = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='proyecto'>";
                echo "<h3>" . htmlspecialchars($proyecto['titulo']) . "</h3>";
                echo "<p>" . htmlspecialchars($proyecto['descripcion']) . "</p>";
                echo "<a href='" . htmlspecialchars($proyecto['link']) . "' target='_blank'>Ver Proyecto</a>";
                echo "</div>";
            }
            ?>
        </div>
    </section>

    <section id="habilidades">
        <h2>Habilidades</h2>
        <ul>
            <?php
            // Mostrar habilidades
            $query = $pdo->query("SELECT * FROM habilidades");
            while ($habilidad = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>" . htmlspecialchars($habilidad['nombre']) . " - Nivel: " . htmlspecialchars($habilidad['nivel']) . "</li>";
            }
            ?>
        </ul>
    </section>

    <section id="contacto">
        <h2>Contacto</h2>

        <!-- mensaje de éxito o error -->
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<p class='alert'>" . $_SESSION['mensaje'] . "</p>";
            unset($_SESSION['mensaje']); 
        }
        ?>

        <form action="index.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" required></textarea>

            <button type="submit">Enviar</button>
        </form>
    </section>
</body>
</html>

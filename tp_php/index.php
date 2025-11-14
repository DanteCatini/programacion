<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Gastos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/minty/bootstrap.min.css">
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
    
<?php
include_once('classes/Gasto.php');

// Ruta del archivo JSON
$archivo = 'data/gastos.json';

// Cargar datos existentes
$gastos = [];
if (file_exists($archivo)) {
    $contenido = file_get_contents($archivo);
    $gastos = json_decode($contenido, true) ?? [];
}

// Mensaje de validación
$mensaje = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $descripcion = trim($_POST['descripcion'] ?? '');
    $monto = trim($_POST['monto'] ?? '');

    if ($descripcion === '' || $monto === '' || !is_numeric($monto) || $monto <= 0) {
        $mensaje = "<div class='alert alert-danger'>Completá todos los campos correctamente.</div>";
    } else {
        $nuevoGasto = new Gasto($descripcion, floatval($monto));
        $gastos[] = $nuevoGasto->toArray();

        // Guardar en JSON
        file_put_contents($archivo, json_encode($gastos, JSON_PRETTY_PRINT));
        $mensaje = "<div class='alert alert-success'>Gasto agregado con éxito.</div>";
    }
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Calculadora de Gastos</h2>
    <?= $mensaje ?>

    <form method="POST">
        <div class="mb-3">
            <label>Descripción:</label>
            <input type="text" name="descripcion" class="form-control" placeholder="Ej: Comida, Transporte...">
        </div>
        <div class="mb-3">
            <label>Monto ($):</label>
            <input type="number" step="1" name="monto" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Agregar Gasto</button>
    </form>

    <hr>

    <h3>Historial de gastos</h3>
    <table class="table table-striped mt-3">
        <thead><tr><th>Descripción</th><th>Monto ($)</th></tr></thead>
        <tbody>
        <?php
        $total = 0;
        foreach ($gastos as $g) {
            echo "<tr><td>{$g['descripcion']}</td><td>$" . number_format($g['monto'], 2) . "</td></tr>";
            $total += $g['monto'];
        }
        ?>
        </tbody>
    </table>
    <h4 class="text-end">Total: $<?= number_format($total, 2) ?></h4>
</div>


</body>



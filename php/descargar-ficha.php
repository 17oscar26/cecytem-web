<?php
// Verifica si el formulario ha sido enviado mediante el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene el valor ingresado por el usuario, ya sea número de control o nombre
    $numeroControl = trim($_POST['numeroControl']);
    
    // Define el directorio donde se almacenan las fichas de pago
    $directorioFichas = '../fichas/';

    // Intenta localizar el archivo de la ficha utilizando el número de control proporcionado
    $archivoFicha = $directorioFichas . 'ficha_pago_' . $numeroControl . '.pdf';
    
    // Si el archivo no existe con el número de control, busca utilizando el nombre
    if (!file_exists($archivoFicha)) {
        // Normaliza el nombre ingresado, eliminando espacios, convirtiendo a minúsculas y sustituyendo por guiones bajos
        $nombreNormalizado = strtolower(str_replace(' ', '_', $numeroControl));
        $archivoFicha = $directorioFichas . 'ficha_pago_' . $nombreNormalizado . '.pdf';
    }

    // Verifica si el archivo existe después de realizar ambas búsquedas
    if (file_exists($archivoFicha)) {
        // Fuerza la descarga del archivo en formato PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($archivoFicha) . '"');
        header('Content-Length: ' . filesize($archivoFicha));
        readfile($archivoFicha);
        exit;
    } else {
        // Muestra un mensaje de error si el archivo no fue encontrado
        echo "<script>alert('No se encontró la ficha de pago para el número de control o nombre ingresado.'); window.history.back();</script>";
    }
} else {
    // Muestra un mensaje de error si el formulario no fue enviado correctamente
    echo "<script>alert('Error al procesar la solicitud. Intenta nuevamente.'); window.history.back();</script>";
}
?>
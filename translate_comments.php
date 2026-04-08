<?php

$dir = 'c:\\xampp\\htdocs\\Proyecto-KapoBarber\\wp-content\\themes\\kapo-barber';
$files = array_diff(scandir($dir), array('.', '..'));

$translations = [
    '<!--? slider Area Start-->' => '<!--? Inicio del Slider-->',
    '<!-- slider Area End-->' => '<!-- Fin del Slider-->',
    '<!-- Single Slider -->' => '<!-- Slider Único -->',
    '<!-- Arrow -->' => '<!-- Flecha -->',
    '<!--? About Area Start -->' => '<!--? Inicio Área Nosotros -->',
    '<!-- About Area End -->' => '<!-- Fin Área Nosotros -->',
    '<!-- about-img -->' => '<!-- img nosotros -->',
    '<!-- Section Tittle -->' => '<!-- Título de Sección -->',
    '<!-- About Shape -->' => '<!-- Forma de Nosotros -->',
    '<!--? Services Area Start -->' => '<!--? Inicio Área de Servicios -->',
    '<!-- Services Area End -->' => '<!-- Fin Área de Servicios -->',
    '<!-- Section caption -->' => '<!-- Texto de Sección -->',
    '<!--? Team Start -->' => '<!--? Inicio del Equipo -->',
    '<!-- Team End -->' => '<!-- Fin del Equipo -->',
    '<!-- single Tem -->' => '<!-- Miembro Único del Equipo -->',
    '<!-- Best Pricing Area Start -->' => '<!-- Inicio Área Mejores Precios -->',
    '<!-- Best Pricing Area End -->' => '<!-- Fin Área Mejores Precios -->',
    '<!-- Pricing  -->' => '<!-- Precios -->',
    '<!-- pricing img -->' => '<!-- img de precios -->',
    '<!--? Gallery Area Start -->' => '<!--? Inicio Área de Galería -->',
    '<!-- Gallery Area End -->' => '<!-- Fin Área de Galería -->',
    '<!-- Cut Details / Testimonials Start -->' => '<!-- Inicio Detalles de Corte / Testimonios -->',
    '<!-- Cut Details Start -->' => '<!-- Inicio Detalles de Corte -->',
    '<!-- Cut Details End -->' => '<!-- Fin Detalles de Corte -->',
    '<!--? Blog Area Start -->' => '<!--? Inicio Área del Blog -->',
    '<!-- Blog Area End -->' => '<!-- Fin Área del Blog -->',
    '<!-- Blog date -->' => '<!-- Fecha de Blog -->',
    '<!--? Hero Start -->' => '<!--? Inicio de Cabecera (Hero) -->',
    '<!-- Hero End -->' => '<!-- Fin de Cabecera (Hero) -->',
    '<!-- Header Start -->' => '<!-- Inicio de Encabezado -->',
    '<!-- Header End -->' => '<!-- Fin de Encabezado -->',
    '<!-- Footer Start-->' => '<!-- Inicio de Pie de Página -->',
    '<!-- Footer End-->' => '<!-- Fin de Pie de Página -->',
    '<!-- Logo -->' => '<!-- Logotipo -->',
    '<!-- Main-menu -->' => '<!-- Menú Principal -->',
    '<!-- Header Right -->' => '<!-- Derecha del Encabezado -->'
];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $filePath = $dir . DIRECTORY_SEPARATOR . $file;
        $content = file_get_contents($filePath);
        $original = $content;
        
        foreach ($translations as $eng => $esp) {
            $content = str_replace($eng, $esp, $content);
        }
        
        if ($content !== $original) {
            file_put_contents($filePath, $content);
            echo "Translated HTML comments in $file\n";
        }
    }
}
?>

<?php

if (!function_exists('formatNumber')) {
    function formatNumber($value) {
        // Asegúrate de que el valor sea un número flotante
        $formatted = number_format((float)$value, 4, '.', '');

        // Elimina ceros innecesarios pero siempre mantiene al menos 2 decimales
        $trimmed = rtrim(rtrim($formatted, '0'), '.');

        // Si tiene menos de 2 decimales después de eliminar ceros, agrega .00
        if (strpos($trimmed, '.') !== false) {
            $decimals = strlen(substr(strrchr($trimmed, '.'), 1)); // Número de decimales actuales
            if ($decimals < 2) {
                $trimmed = number_format((float)$value, 2, '.', '');
            }
        } else {
            // Si no tiene decimales, asegúrate de mostrar ".00"
            $trimmed .= '.00';
        }

        return $trimmed;
    }
}

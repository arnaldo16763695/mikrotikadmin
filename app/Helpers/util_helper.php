<?php


if (!function_exists('validateRut')) {

    function validateRut($rut)
    {
        // Limpiar el RUT (eliminar puntos, guiones y espacios)
        $rut = preg_replace('/[^0-9kK]/', '', trim($rut));

        // Validar que tenga al menos 2 caracteres (número + DV)
        if (strlen($rut) < 2) {
            return false;
        }

        // Separar número y dígito verificador
        $numero = substr($rut, 0, -1);
        $dv = strtoupper(substr($rut, -1));

        // Validar que el número sea numérico
        if (!ctype_digit($numero)) {
            return false;
        }

        // Cálculo del dígito verificador
        $suma = 0;
        $factor = 2;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += $numero[$i] * $factor;
            $factor = ($factor == 7) ? 2 : $factor + 1;
        }

        $resto = $suma % 11;
        $digitoCalculado = 11 - $resto;

        // Convertir a dígito verificador válido
        if ($digitoCalculado == 11) {
            $digitoCalculado = '0';
        } elseif ($digitoCalculado == 10) {
            $digitoCalculado = 'K';
        } else {
            $digitoCalculado = (string) $digitoCalculado;
        }

        // Comparar con el DV ingresado
        return $digitoCalculado === $dv;
    }
}

<?php

if (!function_exists('getEstadoNombre')) {
    function getEstadoNombre($estado) {
        switch ($estado) {
            case 1: return 'Pendiente';
            case 2: return 'En proceso';
            case 3: return 'Atendido';
            case 4: return 'No logrado';
            case 5: return 'Cancelado';
            default: return 'Cancelado';
        }
    }
}

if (!function_exists('getEstadoClase')) {
    function getEstadoClase($estado) {
        switch ($estado) {
            case 1: return 'badge-info-lighten';
            case 2: return 'badge-warning-lighten';
            case 3: return 'badge-success-lighten';
            case 4: return 'badge-secondary-lighten';
            case 5: return 'badge-danger-lighten';
            default: return 'badge-danger-lighten';
        }
    }
}

if (!function_exists('getEstadoIcono')) {
    function getEstadoIcono($estado) {
        switch ($estado) {
            case 1: return 'mdi mdi-file-document';
            case 2: return 'mdi mdi-progress-clock';
            case 3: return 'mdi mdi-check-circle-outline';
            case 4: return 'mdi mdi-close-circle-outline';
            case 5: return 'mdi mdi-cancel';
            default: return 'mdi mdi-alert-circle-outline';
        }
    }
}
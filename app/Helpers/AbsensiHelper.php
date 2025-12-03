<?php

use App\Http\Controllers\Admin\AbsensiHarianController;

/**
 * Mengambil array JENIS_KEGIATAN dari AbsensiHarianController
 * agar dapat digunakan secara global di View.
 *
 * @return array
 */
if (!function_exists('get_jenis_kegiatan')) {
    function get_jenis_kegiatan(): array
    {
        try {
            // Menggunakan Reflection Class untuk mengakses konstanta private
            $reflection = new \ReflectionClass(AbsensiHarianController::class);
            $constants = $reflection->getConstant('JENIS_KEGIATAN');
        } catch (\ReflectionException $e) {
            return [];
        }

        return $constants ?? [];
    }
}
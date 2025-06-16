<?php
session_start();

function usuario_autenticado() {
    return isset($_SESSION['user_id']);
}

function tipo_usuario() {
    return $_SESSION['user_tipo'] ?? null;
}

function redirigir_si_no_autenticado() {
    if (!usuario_autenticado()) {
        header("Location: adminlogin.php");
        exit;
    }
}

function solo_admin() {
    if (tipo_usuario() !== 'admin') {
        header("Location: dashboard.php");
        exit;
    }
}

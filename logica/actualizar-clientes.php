<?php
require 'conexionbdd.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('location:../login-sesion/login.php?error_message=Por favor inicie sesión');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre_empresa = $conn->real_escape_string($_POST['nombre_empresa']);
    $rif = $conn->real_escape_string($_POST['rif']);
    $telefono_empresa = $conn->real_escape_string($_POST['telefono_empresa']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $nombre_contacto = $conn->real_escape_string($_POST['nombre_contacto']);
    $cedula_encargado = $conn->real_escape_string($_POST['cedula_encargado']);
    $telefono_encargado = $conn->real_escape_string($_POST['telefono_encargado']);
    $correo_empresa = $conn->real_escape_string($_POST['correo_empresa']);
    $password = $conn->real_escape_string($_POST['password']);
    $intentos = isset($_POST['Usuario_bloqueado']) ? 3 : 0;

    $query = "UPDATE clientes SET 
                nombre_empresa = ?, 
                rif = ?, 
                telefono_empresa = ?, 
                direccion = ?, 
                nombre_encargado = ?, 
                cedula_encargado = ?, 
                telefono_encargado = ?, 
                correo = ?, 
                contrasena = ?, 
                intentos = ? 
              WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssi", $nombre_empresa, $rif, $telefono_empresa, $direccion, $nombre_contacto, $cedula_encargado, $telefono_encargado, $correo_empresa, $password, $intentos, $id);

    if ($stmt->execute()) {
        header('location:../panelAdmin/editar-cliente.php?id=' . $id . '&success_message=Cliente actualizado correctamente');
    } else {
        header('location:../panelAdmin/editar-cliente.php?id=' . $id . '&error_message=Error al actualizar el cliente');
    }
} else {
    header('location:../panelAdmin/editar-cliente.php?error_message=Método de solicitud no válido');
}
?>
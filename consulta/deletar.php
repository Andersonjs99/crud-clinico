<?php
include '../conexao.php';
$id_medico = $_GET['id_medico'];
$id_paciente = $_GET['id_paciente'];
$data_hora = $_GET['data_hora'];

$conn->query("DELETE FROM consulta 
              WHERE id_medico=$id_medico AND id_paciente=$id_paciente AND data_hora='$data_hora'");
header("Location: index.php");
?>

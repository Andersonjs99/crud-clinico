<?php
if (isset($_GET['id'])) {
    include '../conexao.php';

    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM paciente WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit();
?>

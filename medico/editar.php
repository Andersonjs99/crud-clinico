<?php
include '../conexao.php';

// Se tiver ID via GET, busca os dados
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM medico WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $medico = $resultado->fetch_assoc();
}

// Se enviar o formulário via POST, atualiza os dados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];

    $stmt = $conn->prepare("UPDATE medico SET nome = ?, especialidade = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nome, $especialidade, $id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Médico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Editar Médico</h2>

    <form method="post" class="bg-white p-4 rounded shadow-sm">
      <input type="hidden" name="id" value="<?= $medico['id'] ?>">

      <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $medico['nome'] ?>" required>
      </div>

      <div class="mb-3">
        <label for="especialidade" class="form-label">Especialidade:</label>
        <input type="text" name="especialidade" id="especialidade" class="form-control" value="<?= $medico['especialidade'] ?>" required>
      </div>

      <button type="submit" class="btn btn-primary">Atualizar</button>
      <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</html>

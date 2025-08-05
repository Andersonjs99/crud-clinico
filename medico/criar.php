<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../conexao.php';

    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];

    // Evita SQL Injection
    $stmt = $conn->prepare("INSERT INTO medico (nome, especialidade) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $especialidade);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Médico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Cadastrar Novo Médico</h2>

    <form method="post" class="bg-white p-4 rounded shadow-sm">
      <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" name="nome" id="nome" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="especialidade" class="form-label">Especialidade:</label>
        <input type="text" name="especialidade" id="especialidade" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">Salvar</button>
    </form>
    <br>
        <a href="../index.php" class="btn btn-primary btn-sm">Voltar ao Início</a>
</body>
</html>

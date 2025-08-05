<?php
include '../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Cadastrar Novo Paciente</h2>

    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo:</label>
            <input type="text" name="tipo_sanguineo" id="tipo_sanguineo" class="form-control" required>
        </div>

        <input type="submit" value="Salvar" class="btn btn-success">
    </form>
    <br>
   <a href="../index.php" class="btn btn-primary btn-sm">Voltar ao Início</a>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];

    $stmt = $conn->prepare("INSERT INTO paciente (nome, data_nascimento, tipo_sanguineo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $data_nascimento, $tipo_sanguineo);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='container mt-3'><div class='alert alert-danger'>Erro ao salvar paciente: " . htmlspecialchars($conn->error) . "</div></div>";
    }

    $stmt->close();
    $conn->close();
}
?>


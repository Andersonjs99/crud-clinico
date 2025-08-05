<?php
include '../conexao.php';

// Verifica se recebeu o ID via GET
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Busca os dados do paciente
$stmt = $conn->prepare("SELECT * FROM paciente WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$paciente = $result->fetch_assoc();

// Se não encontrou o paciente
if (!$paciente) {
    header("Location: index.php");
    exit;
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];

    // Atualiza os dados
    $stmt = $conn->prepare("UPDATE paciente SET nome = ?, data_nascimento = ?, tipo_sanguineo = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nome, $data_nascimento, $tipo_sanguineo, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $erro = "Erro ao atualizar paciente: " . htmlspecialchars($conn->error);
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Paciente</h2>

    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" required class="form-control"
                   value="<?= htmlspecialchars($paciente['nome']) ?>">
        </div>

        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" required class="form-control"
                   value="<?= $paciente['data_nascimento'] ?>">
        </div>

        <div class="mb-3">
            <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo:</label>
            <input type="text" name="tipo_sanguineo" id="tipo_sanguineo" required class="form-control"
                   value="<?= htmlspecialchars($paciente['tipo_sanguineo']) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
          <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>

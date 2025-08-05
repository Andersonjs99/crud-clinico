<?php
include '../conexao.php';

// Buscar médicos e pacientes do banco
$medicos = $conn->query("SELECT * FROM medico");
$pacientes = $conn->query("SELECT * FROM paciente");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Consulta</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Nova Consulta</h2>

    <form method="post" class="bg-white p-4 rounded shadow-sm">
        <label for="id_medico">Médico:</label><br>
        <select name="id_medico" id="id_medico" required>
            <option value="">Selecione o médico</option>

            <?php while ($m = $medicos->fetch_assoc()): ?>
                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="id_paciente">Paciente:</label><br>
        <select name="id_paciente" id="id_paciente" required>
            <option value="">Selecione o paciente</option>
            <?php while ($p = $pacientes->fetch_assoc()): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="data_hora">Data e Hora:</label><br>
        <input type="datetime-local" name="data_hora" id="data_hora" required><br><br>

        <label for="observacoes">Observações:</label><br>
        <textarea name="observacoes" id="observacoes" rows="4" cols="50"></textarea><br><br>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
       <a href="../index.php" class="btn btn-primary btn-sm">Voltar ao Início</a>
</div>
</body>
</html>

<?php
// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_medico = $_POST['id_medico'];
    $id_paciente = $_POST['id_paciente'];
    $data_hora = $_POST['data_hora'];
    $observacoes = $_POST['observacoes'];

    // Inserção com segurança
    $stmt = $conn->prepare("INSERT INTO consulta (id_medico, id_paciente, data_hora, observacoes) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_medico, $id_paciente, $data_hora, $observacoes);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='container'><p style='color:red;'>Erro ao salvar consulta.</p></div>";
    }
}
?>

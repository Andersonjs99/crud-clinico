<?php
include '../conexao.php';

if (!isset($_GET['id_medico'], $_GET['id_paciente'], $_GET['data_hora'])) {
    header("Location: index.php");
    exit;
}

$id_medico_original = $_GET['id_medico'];
$id_paciente_original = $_GET['id_paciente'];
$data_hora_original = $_GET['data_hora'];

// Buscar médicos e pacientes
$medicos = $conn->query("SELECT id, nome FROM medico");
$pacientes = $conn->query("SELECT id, nome FROM paciente");

// Buscar a consulta original
$stmt = $conn->prepare("SELECT * FROM consulta 
                        WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?");
$stmt->bind_param("iis", $id_medico_original, $id_paciente_original, $data_hora_original);
$stmt->execute();
$resultado = $stmt->get_result();
$consulta = $resultado->fetch_assoc();

if (!$consulta) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Consulta não encontrada.</div></div>";
    exit;
}

// Atualização
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novo_medico = $_POST['id_medico'];
    $novo_paciente = $_POST['id_paciente'];
    $nova_data_hora = $_POST['data_hora'];
    $observacoes = $_POST['observacoes'];

    $stmt = $conn->prepare("UPDATE consulta 
                            SET id_medico = ?, id_paciente = ?, data_hora = ?, observacoes = ?
                            WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?");
    $stmt->bind_param("iississ", 
        $novo_medico, $novo_paciente, $nova_data_hora, $observacoes, 
        $id_medico_original, $id_paciente_original, $data_hora_original
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $erro = "Erro ao atualizar a consulta.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Consulta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">Editar Consulta</h2>

  <?php if (!empty($erro)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <form method="post" class="bg-white p-4 rounded shadow-sm">

    <div class="mb-3">
      <label for="id_medico" class="form-label">Médico:</label>
      <select name="id_medico" id="id_medico" class="form-select" required>
        <?php while ($m = $medicos->fetch_assoc()): ?>
          <option value="<?= $m['id'] ?>" <?= $m['id'] == $consulta['id_medico'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($m['nome']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="id_paciente" class="form-label">Paciente:</label>
      <select name="id_paciente" id="id_paciente" class="form-select" required>
        <?php while ($p = $pacientes->fetch_assoc()): ?>
          <option value="<?= $p['id'] ?>" <?= $p['id'] == $consulta['id_paciente'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['nome']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="data_hora" class="form-label">Data e Hora:</label>
      <input type="datetime-local" name="data_hora" id="data_hora" class="form-control"
             value="<?= date('Y-m-d\TH:i', strtotime($consulta['data_hora'])) ?>" required>
    </div>

    <div class="mb-3">
      <label for="observacoes" class="form-label">Observações:</label>
      <textarea name="observacoes" id="observacoes" class="form-control" rows="4" required><?= htmlspecialchars($consulta['observacoes']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../conexao.php';

$sql = "SELECT c.*, m.nome AS medico, p.nome AS paciente 
        FROM consulta c
        JOIN medico m ON c.id_medico = m.id
        JOIN paciente p ON c.id_paciente = p.id
        ORDER BY c.data_hora DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Consultas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">
            <i class="fa-solid fa-calendar-check"></i> Lista de Consultas
        </h2>

        <div class="mb-3 text-end">
            <a href="criar.php" class="btn btn-success">
                <i class="fa-solid fa-plus"></i> Nova Consulta
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Médico</th>
                    <th>Paciente</th>
                    <th>Data e Hora</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['medico']) ?></td>
                            <td><?= htmlspecialchars($row['paciente']) ?></td>
                            <td><?= htmlspecialchars($row['data_hora']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['observacoes'])) ?></td>
                            <td>
                                <a href="editar.php?id_medico=<?= urlencode($row['id_medico']) ?>&id_paciente=<?= urlencode($row['id_paciente']) ?>&data_hora=<?= urlencode($row['data_hora']) ?>"
                                   class="btn btn-primary btn-sm" title="Editar">
                                   <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="deletar.php?id_medico=<?= urlencode($row['id_medico']) ?>&id_paciente=<?= urlencode($row['id_paciente']) ?>&data_hora=<?= urlencode($row['data_hora']) ?>"
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Tem certeza que deseja excluir esta consulta?')" title="Excluir">
                                   <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Nenhuma consulta encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="../menu.php" class="btn btn-primary btn-sm mt-3">Voltar ao Início</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>

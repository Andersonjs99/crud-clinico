<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../conexao.php';

$sql = "SELECT * FROM medico ORDER BY nome ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Lista de Médicos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">
      <i class="fa-solid fa-user-doctor"></i> Lista de Médicos
    </h2>

    <div class="mb-3 text-end">
      <a href="criar.php" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Novo Médico
      </a>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Especialidade</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($medico = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $medico['id'] ?></td>
              <td><?= htmlspecialchars($medico['nome']) ?></td>
              <td><?= htmlspecialchars($medico['especialidade']) ?></td>
              <td>
              <div class="btn-group" role="group">
                <a href="visualizar.php?id=<?= urlencode($medico['id']) ?>" 
                 class="btn btn-info btn-sm mx-1" title="Visualizar">
                 Visualizar
                </a>  
                <a href="editar.php?id=<?= urlencode($medico['id']) ?>" 
                class="btn btn-primary btn-sm mx-1" title="Editar">
                Editar
                </a>
                <a href="deletar.php?id=<?= urlencode($medico['id']) ?>" 
                class="btn btn-danger btn-sm mx-1" 
                onclick="return confirm('Tem certeza que deseja excluir este médico?')" 
                title="Excluir">
                Excluir
                </a>
</div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center">Nenhum médico cadastrado.</td>
          </tr>
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

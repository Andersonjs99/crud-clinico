<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bem-vindo - Sistema Clínico</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="text-center mb-4">
    <h1><i class="fa-solid fa-hospital-user"></i> Sistema Clínico</h1>
    <h4 class="mt-3"> Bem-vindo, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>!</h4>
    <p class="text-muted">Escolha uma das opções abaixo para gerenciar o sistema.</p>
  </div>

  <div class="row justify-content-center g-3">
    <div class="col-md-3">
      <a href="medico/index.php" class="btn btn-outline-primary w-100 p-3">
        <i class="fa-solid fa-user-doctor fa-2x"></i><br>
        Médicos
      </a>
    </div>
    <div class="col-md-3">
      <a href="paciente/index.php" class="btn btn-outline-success w-100 p-3">
        <i class="fa-solid fa-user-injured fa-2x"></i><br>
        Pacientes
      </a>
    </div>
    <div class="col-md-3">
      <a href="consulta/index.php" class="btn btn-outline-warning w-100 p-3">
        <i class="fa-solid fa-calendar-check fa-2x"></i><br>
        Consultas
      </a>
    </div>
    <div class="col-md-3">
      <a href="auth/logout.php" class="btn btn-outline-danger w-100 p-3">
        <i class="fa-solid fa-right-from-bracket fa-2x"></i><br>
        Sair
      </a>
    </div>
  </div>
</div>

<footer class="text-center mt-5 text-muted">
  <p>🩺 Cuidar da saúde é um ato de amor.</p>
</footer>

</body>
</html>

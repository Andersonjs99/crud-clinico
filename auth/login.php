<?php
session_start();
include '../conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Busca usuário
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: ../menu.php");
        exit();
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login - Sistema Clínico</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-5">
<div class="card shadow-sm">
<div class="card-header text-center">
    <h4><i class="fa-solid fa-right-to-bracket"></i> Login</h4>
</div>
<div class="card-body">

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required autofocus>
    </div>
    <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Entrar</button>
    <a href="cadastrar.php" class="btn btn-link w-100">Criar conta</a>
</form>

</div>
</div>
</div>
</div>
</div>

</body>
</html>

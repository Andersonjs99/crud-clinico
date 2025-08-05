<?php
session_start();
include '../conexao.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    // Validação
    if ($senha !== $confirma_senha) {
        $erro = "As senhas não coincidem!";
    } else {
        // Verifica se já existe email cadastrado
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = "Este e-mail já está cadastrado!";
        } else {
            // Criptografa a senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Insere usuário
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt->execute()) {
                $sucesso = "Cadastro realizado com sucesso! Agora faça login.";
            } else {
                $erro = "Erro ao cadastrar: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastrar - Sistema Clínico</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-header text-center">
    <h4><i class="fa-solid fa-user-plus"></i> Criar Conta</h4>
</div>
<div class="card-body">

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<?php if ($sucesso): ?>
    <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Confirmar Senha</label>
        <input type="password" name="confirma_senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    <a href="login.php" class="btn btn-link w-100">Já tenho conta</a>
</form>

</div>
</div>
</div>
</div>
</div>

</body>
</html>

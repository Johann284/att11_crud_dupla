<?php
include 'bd.php';

// Buscar todos os títulos de notas para exibir no <select>
$sql = "SELECT id_usuario, nome_usuario FROM usuario";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Adicionar novo usuário
if (isset($_POST["adicionar_usuario"])) {
    $novo_nome = trim($_POST["nome"]);
    $nova_senha = trim($_POST["senha"]);
    
    // Inserir o nome de usuário e a senha em texto simples
    $sql = "INSERT INTO usuario (nome_usuario, senha) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $novo_nome, $nova_senha);

    if ($stmt->execute()) {
        echo "<p>Usuário adicionado com sucesso!</p>";
        header("Location: usuarios.php");
        exit();
    } else {
        echo "<p>Erro ao adicionar usuário: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Exibir formulário para adicionar um novo usuário
if (isset($_POST["novo_usuario"])) {
    echo "<form method='POST' action=''>
        <label for='nome'>Nome do usuário: </label>
        <input type='text' name='nome' value='' required><br>
        <label for='senha'>Senha: </label>
        <input type='password' name='senha' value='' required><br>
        <input type='submit' name='adicionar_usuario' value='Salvar Usuário'>
        </form>";
}

// Lógica de login
if (isset($_POST["entrar"])) {
    $nome = trim($_POST["usuario"]);
    $senha = trim($_POST["senha"]);

    // Buscar a senha do banco de dados baseada no nome de usuário
    $sql = "SELECT senha FROM usuario WHERE nome_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $stmt->bind_result($senha_armazenada);
    $stmt->fetch();

    // Verificar se a senha inserida é igual à armazenada
    if ($senha === $senha_armazenada) {
        echo "<p>Login bem-sucedido!</p>";
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Nome de usuário ou senha incorretos!</p>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Bloco de Notas</title>
</head>
<body>

    <!-- Formulário para selecionar um usuário e fazer login -->
    <form method="POST" action="">
        <label for="usuario">Usuário</label>
        <select name="usuario" required>
            <?php while ($usuario = $result->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($usuario['nome_usuario']); ?>">
                    <?= htmlspecialchars($usuario['nome_usuario']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required class="digitar">
        <input type="submit" value="Entrar" name="entrar">
    </form>

    <!-- Formulário para criar um novo usuário -->
    <form method="POST" action="">
        <label for="novo_usuario">Criar usuário:</label>
        <input type="submit" name="novo_usuario" value="Novo Usuário" class="digitar">
    </form>

</body>
</html>

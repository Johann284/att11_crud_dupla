<?php
include 'bd.php';

if (isset($_POST["salvar"])) {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $sql = "INSERT INTO notas (titulo_nota, texto_nota) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $titulo, $conteudo);

    if ($stmt->execute()) {
        echo "Nota salva com sucesso!";
    } else {
        echo "Erro ao salvar nota.";
    }
}

// Buscar todos os títulos de notas para exibir no <select>
$sql = "SELECT id, titulo_nota FROM notas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se uma nota foi selecionada
$titulo_nota = '';
$conteudo_nota = '';
if (isset($_GET['nota_id'])) {
    $nota_id = $_GET['nota_id'];

    // Buscar o título e o conteúdo da nota com base no ID selecionado
    $sql = "SELECT titulo_nota, texto_nota FROM notas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nota_id);
    $stmt->execute();
    $result_nota = $stmt->get_result();

    // Verifica se algum resultado foi retornado
    if ($row_nota = $result_nota->fetch_assoc()) {
        $titulo_nota = $row_nota['titulo_nota'];
        $conteudo_nota = $row_nota['texto_nota'];
    } else {
        // Caso o ID não exista no banco de dados, definir valores padrão
        echo "Nota não encontrada!";
        $titulo_nota = '';
        $conteudo_nota = '';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bloco de Notas</title>
</head>
<body>

    <!-- Formulário para selecionar uma nota existente -->
    <form method="GET" action="">
        <label for="notas">Selecione uma nota:</label>
        <select name="nota_id" id="notas" onchange="this.form.submit()">
            <option value="">-- Escolha uma nota --</option>
            <?php while ($titulo = $result->fetch_assoc()): ?>
                <option value="<?= $titulo['id']; ?>" <?= isset($nota_id) && $nota_id == $titulo['id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($titulo['titulo_nota']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <section>
        <!-- Formulário para salvar nova nota -->
        <form method="POST" action="">

            <div class="container">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" class="texto" id="titulo" required value="<?= htmlspecialchars($titulo_nota); ?>">
            </div>

            <div class="container">
                <label for="conteudo">Texto:</label>
                <textarea name="conteudo" class="texto" id="conteudo" rows="20" required><?= htmlspecialchars($conteudo_nota); ?></textarea>
            </div>

            <input type="submit" name="salvar" value="Salvar" id="salvar">
        </form>
    </section>

</body>
</html>

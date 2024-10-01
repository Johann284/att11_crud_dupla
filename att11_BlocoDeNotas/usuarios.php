<?php
include 'bd.php';


// Buscar todos os títulos de notas para exibir no <select>
$sql = "SELECT id, nome_usuario FROM usuario";
$id = $_GET["id"];
$id = $_GET["nome_usuario"];
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();



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

    <!-- Formulário para selecionar uma nota existente -->
    <form method="GET" action="">
        <label for="notas">Selecione uma nota:</label>
        <select name="nota_id" id="notas" onchange="this.form.submit()">
            <option value="">Nova nota</option>
            <?php while ($titulo = $result->fetch_assoc()): ?>
                <option value="<?= $titulo['id']; ?>" <?= isset($nota_id) && $nota_id == $titulo['id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($titulo['titulo_nota']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <section>
        <!-- Formulário para salvar ou deletar uma nota -->
        <form method="POST" action="">
            <input type="hidden" name="nota_id" value="<?= $nota_id ?>">

            <div class="container">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" class="texto" id="titulo" required value="<?= htmlspecialchars($titulo_nota); ?>">
            </div>

            <div class="container">
                <label for="conteudo">Texto:</label>
                <textarea name="conteudo" class="texto" id="conteudo" rows="20" required><?= htmlspecialchars($conteudo_nota); ?></textarea>
            </div>
            <div>
                <input type="submit" name="deletar" value="Deletar" class="acoes">
                <input type="submit" name="salvar" value="Salvar" class="acoes">
            </div>
        </form>
    </section>

</body>
</html>

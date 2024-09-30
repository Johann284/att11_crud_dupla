<?php
include 'bd.php';


if (isset($_POST["salvar"])) {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $sql = "INSERT INTO notas (titulo_nota, texto_nota) VALUES ('$titulo', '$conteudo')";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        echo "Nota salva com sucesso!";
    } else {
        echo "Erro ao salvar nota.";
    }
}
// buscar notas já existentes
$sql = "SELECT titulo_nota FROM notas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();

$texto = "SELECT texto_nota FROM notas";

?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bloco de Notas</title>
</head>
<body>
    <select name="notas" id="notas">
        <?php while ($titulo = $result->fetch_assoc()): ?>
            <option value="<?= $titulo['titulo_nota']; ?>">
                <?= $titulo['titulo_nota']; ?>
            </option>
        <?php endwhile; ?>
    </select>
    <section>
        <form method="POST" action="">

            <div class="container">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" class="texto" id="titulo" required>
            </div>

            <div class="container">
                <label for="conteudo">Texto:</label>
                <textarea name="conteudo" class="texto" id="conteudo" rows="20" value="<?$texto ?>" required></textarea>
            </div>

            <input type="submit" name="salvar" value="Salvar" id="salvar">
        </form>
    </section>
</body>
</html>
<h2>Editar Documento - BrianBR13</h2>

<form action="index.php?action=actualizar" method="POST">
    
    <input type="hidden" name="id" value="<?= $documento['DOC_ID'] ?>">

    <label>Nombre del Documento:</label><br>
    <input type="text" name="nombre" value="<?= $documento['DOC_NOMBRE'] ?>" required><br><br>

    <label>Código:</label><br>
    <input type="text" value="<?= $documento['DOC_CODIGO'] ?>" disabled><br><br>

    <label>Contenido:</label><br>
    <textarea name="contenido" rows="5" cols="40" required><?= $documento['DOC_CONTENIDO'] ?></textarea><br><br>

    <button type="submit">Guardar Cambios</button>
    <a href="index.php?action=listar">Cancelar</a>
    
</form>
<h2>Registrar Nuevo Documento - BrianBR13</h2>

<form action="/KAWAK_CRUD/public/index.php?action=guardar" method="POST">
    
    <label>Nombre del Documento:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Tipo de Documento:</label><br>
    <select name="id_tipo" required>
        <?php foreach($tipos as $t): ?>
            <option value="<?= $t['TIP_ID'] ?>"><?= $t['TIP_NOMBRE'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Proceso:</label><br>
    <select name="id_proceso" required>
        <?php foreach($procesos as $p): ?>
            <option value="<?= $p['PRO_ID'] ?>"><?= $p['PRO_NOMBRE'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Contenido:</label><br>
    <textarea name="contenido" rows="5" cols="40" required></textarea><br><br>

    <button type="submit">Guardar y Generar Código</button>

</form>

<br>
<a href="/KAWAK_CRUD/public/index.php?action=listar">Volver al Listado</a>
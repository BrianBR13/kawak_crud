<h2>Listado de Documentos - BrianBR13</h2>

<a href="index.php?action=crear">Registrar Nuevo Documento</a> | 
<a href="index.php?action=logout" style="color: red;">Salir del sistema</a>

<br><br>

<form action="index.php" method="GET">
    <input type="hidden" name="action" value="listar">
    <input type="text" name="buscar" placeholder="Buscar aqui..." value="<?= $_GET['buscar'] ?? '' ?>">
    <button type="submit">Buscar</button>
    
    <?php if(isset($_GET['buscar'])): ?>
        <a href="index.php?action=listar">Ver todos</a>
    <?php endif; ?>
</form>

<br>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Contenido</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($documentos)): ?>
            <?php foreach($documentos as $doc): ?>
                <tr>
                    <td><?= $doc['DOC_CODIGO'] ?></td>
                    <td><?= $doc['DOC_NOMBRE'] ?></td>
                    <td>
                        <?= substr($doc['DOC_CONTENIDO'], 0, 50) ?>...
                    </td>
                    <td>
                        <a href="index.php?action=editar&id=<?= $doc['DOC_ID'] ?>">Editar</a> | 
                        <a href="index.php?action=eliminar&id=<?= $doc['DOC_ID'] ?>" 
                           onclick="return confirm('¿Seguro que quieres borrar este registro?');">
                           Borrar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" align="center">No hay datos en la tabla</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
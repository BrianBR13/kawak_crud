<h2>Registrar Nuevo Documento</h2>
<form action="/KAWAK_CRUD/public/index.php?action=guardar" method="POST">
    <label>Nombre del Documento:</label><br>
    <input type="text" name="nombre" required maxlength="60"><br><br>

    <label>Tipo de Documento:</label><br>
    <select name="id_tipo" required>
        <option value="1">Instructivo (INS)</option>
        <option value="2">Manual (MAN)</option>
        <option value="3">Procedimiento (PRO)</option>
        <option value="4">Guía (GUI)</option>
        <option value="5">Formato (FOR)</option>
    </select><br><br>

    <label>Proceso:</label><br>
    <select name="id_proceso" required>
        <option value="1">Ingeniería (ING)</option>
        <option value="2">Calidad (CAL)</option>
        <option value="3">Ventas (VEN)</option>
        <option value="4">Administración (ADM)</option>
        <option value="5">Soporte (SOP)</option>
    </select><br><br>

    <label>Contenido:</label><br>
    <textarea name="contenido" rows="4" cols="50" required maxlength="4000"></textarea><br><br>

    <button type="submit">Guardar y Generar Código</button>
</form>
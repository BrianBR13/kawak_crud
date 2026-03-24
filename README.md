# Prueba Técnica Kawak - Brian Villamil

Este proyecto es para la vacante de **Ingeniero de Soluciones**. Es un sistema para administrar documentos usando PHP y MySQL, organizado con el patrón MVC y Composer para el manejo de carpetas.

## Cómo hacerlo funcionar

1. **Base de datos:**
   - Ve a la carpeta `sql/` y busca el archivo `script.sql`.
   - Impórtalo en PHPMyAdmin o MySQL Workbench.
   - El script crea la base de datos `kawak_prueba` e incluye los **scripts DDL** (tablas) y **DML** (datos maestros).

2. **Configuración:**
   - Si tu usuario de MySQL no es `root` o tienes contraseña, cambia los datos en: `App/Config/Database.php`.

3. **Dependencias:**
   - Es necesario ejecutar el comando `composer dump-autoload` en la terminal para que el sistema reconozca todas las clases.

## Acceso al sistema (Login)
Usa estas credenciales para entrar:
- **Usuario:** admin
- **Contraseña:** 1234

## ¿Qué hace el sistema?
- **Crear documentos:** El código se genera solo (ejemplo: `INS-ING-1`).
- **Buscador:** Se puede buscar por nombre o código en la tabla principal.
- **Editar y Eliminar:** Permite actualizar o borrar registros.
- **Estructura:** Uso de **PSR-4** y **Separación de Responsabilidades** (MVC).
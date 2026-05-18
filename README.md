# Programa de Perfil y Cambio de Contraseña

## Descripción

El sistema web nos permite los registrar usuarios, dar iniciar sesión, ingresar a un perfil privado, actualizacion de datos personales, cambio contraseña por una segura y el cierre de sesión.

## Las Tecnologías que se uso

--PHP
-- MySQL
-- XAMPP
-- HTML
--Sesiones PHP

## Lo que realiza

- El registro de los usuario
- La alidación de si un correo se encuentra repetido
- Ingreso con correo y contraseña creada
- Trabajo con sesiones: $_SESSION
- Ingreso a perfil privado
- Se actualiza el nombre y correo
- Tiene Cambio de contraseña utilizando password_hash y password_verify
- Opcion de cierre de sesión

## Implentacion de segueridad

- Almacenamiento de contraseñas con password_hash
- Confirmacion de contraseñas con password_verify
- Confirmacion de campos faltantes de llenar
- Confirmacion de formato de correo elecronico
- Supervision de acceso mediante sesiones
- Utilizacion de consultas listas para evitar inyección SQL

## Your installation

1. Se copia la carpeta maya_go dentro de htdocs.
2. Se inicia Apache y MySQL desde XAMPP.
3. Se crea la base de datos maya_go_db en phpMyAdmin.
4. Se importa el archivo database.sql.
5. Se abrir el sistema en:

                            http://localhost/maya_go/

## Prueba de usuario

Se puede crear el usuario desde el formulario de registro que se realizo.
# 🎥✨ CineStream – Tu plataforma de cine en casa

<p align="center">
  <img src="https://i.postimg.cc/BZNwCGTt/Captura-de-pantalla-2025-04-10-212424.png" alt="CineStream Preview" width="100%" height="100%" />
</p>

--------------------------------------------------------------------------------------------------

# 📝 Descripcion

**🎥 CineStream es una plataforma web de streaming desarrollada con PHP, JavaScript y CSS, que te permite disfrutar de películas desde cualquier dispositivo como si estuvieras en el cine. Utiliza MySQL como base de datos para gestionar los contenidos de forma eficiente, permitiendo almacenar y organizar archivos multimedia, configuraciones y usuarios. Su diseño moderno, responsive y fácil de usar hace que sea ideal tanto para uso personal como para proyectos más grandes.**

--------------------------------------------------------------------------------------------------
**Tecnologías utilizadas en el proyecto:**  
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg" height="40px" width="40px"/>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg" height="40px" width="40px"/>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg" height="40px" width="40px"/>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original-wordmark.svg" height="40px" width="40px"/>
--------------------------------------------------------------------------------------------------


## 🚀 Instalación rápida

**Copia y pega este comando en tu terminal de VS Code para comenzar:**

```bash
git clone https://github.com/jeanchongdev/streaming.git
```
## 🚀 Instalación de dependencias
**Te creara una carpeta llamada vendor**

```bash
composer require vlucas/phpdotenv
```
--------------------------------------------------------------------------------------------------

## ⚠️ Nota importante

> ⚠️ **IMPORTANTE:** Si el proyecto no funciona correctamente, realiza los siguientes pasos para asegurarte de que la base de datos esté configurada correctamente, en la carpeta config/setup.php biene creado las tablas correctamentes y se implementaran automaticamene al momento de crear la base de datos tan solo debe de modificar los cambios a continuación:

1. **Crea la base de datos** `streaming_db` en MySQL si aún no existe.

2. **Agrega una nueva columna** `slug` a la tabla `peliculas`:

```sql
ALTER TABLE peliculas ADD slug VARCHAR(255);
```

3. **Modifica el tamaño** de la columna `video_url` para soportar URLs más largas (por ejemplo, hasta 1000 caracteres):

```sql
ALTER TABLE peliculas MODIFY COLUMN video_url VARCHAR(1000);
```

4. **Crea un archivo** `.env` en la raíz del proyecto con la siguiente estructura:

```bash
DB_HOST=localhost
DB_USER=tu_usuario
DB_PASS=tu_contraseña
DB_NAME=streaming_db
BASE_URL=/streaming/
```
**📝 Asegúrate de reemplazar los valores con los datos de tu entorno local. Este archivo es esencial para que la conexión a la base de datos y otras configuraciones funcionen correctamente.**

--------------------------------------------------------------------------------------------------

<h4><b>Y LISTO AHORA YA PUEDE DISFRUTAR /O MODIFICARLO A SU GUSTO 🖤</b></h4>

--------------------------------------------------------------------------------------------------

## 👨‍💻 Autor
**Desarrollado 🖤 por @jeanchongdev**

--------------------------------------------------------------------------------------------------

## 📄 Licencia

**Este proyecto está bajo la licencia MIT. Consulta el archivo [LICENSE](./LICENSE) para más detalles.**
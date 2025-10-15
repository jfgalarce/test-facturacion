# Instalación de PDO para PostgreSQL (php-pgsql)

Breve guía para instalar y verificar la extensión PDO para PostgreSQL (pdo_pgsql) y conectar desde PHP.


1) Instalar paquetes necesarios
```bash
sudo apt update
sudo apt install -y php php-pgsql apache2   # si usas Apache
# o si usas php-fpm (nginx):
# sudo apt install -y php php-pgsql php-fpm
```

2) Reiniciar el servidor web / servicio PHP
```bash
# Apache
sudo systemctl restart apache2

# PHP-FPM (si aplica)
sudo systemctl restart php8.2-fpm   # ajustar versión si es diferente
```

3) Verificar que las extensiones estén cargadas
```bash
php -m | grep -E 'pdo|pdo_pgsql|pgsql'
# o desde PHP en web: crear un phpinfo() y abrirlo en el navegador
```

4) Configurar la conexión en tu proyecto
- Edita `clases/Database.php` y ajusta host, puerto, dbname, usuario y contraseña:
```php
private $host = 'IP_O_HOST';
private $port = '5432';
private $dbname = 'tu_base';
private $user = 'tu_usuario';
private $pass = 'tu_password';
```
- Asegúrate de que la DSN use pgsql: `"pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}"`


6) Errores comunes
- "Class 'PDO' not found": PHP no tiene la extensión PDO habilitada. Instalar `php` y `php-pgsql`.
- Errores de autenticación/host: verificar credenciales y que PostgreSQL acepte conexiones desde la IP (pg_hba.conf).
- Si usas contenedor con red, asegúrate de que el host en Database.php sea accesible desde el contenedor.

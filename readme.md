Ejercicio práctico para E4CC.

para configurar el entorno de pruebas se debe instalar Composer.
Se trabaja asímismo con Apache y gestor de BD MySQL y git para clonar el proyecto.

Se debe crear una Base de Datos en MySQL con el nombre: pruebatecnica
Debido a la seguridad del framework trabajado (Laravel), este no permite que se compartan archivos de configuración
del proyecto como lo es el archivo base .env que se debe configurar cada vez que se haga una instalación del proyecto.

mysql, apache, git y composer

comandos:

-git clone https://github.com/usuario/nombre-proyecto
posicionarse en la carpeta del proyecto
-composer install (descarga los paquetes auxiliares del framework y del proyecto)
-crear el archivo .env (se puede copiar y editar el archivo .env.example )
   se colocan las contraseñas, usuarios, rutas entre otras cosas.
-php artisan key:generate
con esos pasos se crea un proyecto básico.
Este tiene migraciones para ejecutar, crean las tablas correspondientes en la base de datos

-php artisan migrate
-php artisan db:seed //valores de prueba

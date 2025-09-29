🎲 Prueba de Números Aleatorios (PHP + JS)

Este proyecto implementa dos pruebas estadísticas para verificar la uniformidad de números pseudoaleatorios en [0,1]:

Prueba de Promedios (Z):

Contrasta si la media muestral r̄ ≈ 0.5.

Usa distribución Normal estándar, dos colas.

Prueba de Frecuencias (χ²):

Divide el intervalo [0,1] en K subintervalos iguales.

Compara frecuencias observadas vs. esperadas.

Usa distribución Chi-cuadrado, cola derecha.

🚀 Estructura del proyecto

controller.php → lógica estadística y respuestas JSON.

index.js → control de formulario, envío AJAX y render de resultados.

index.html → interfaz gráfica (inputs, resultados, estilos).

README.md → documentación.

⚙️ Requisitos

PHP 7+ (se recomienda PHP 7.4 o superior).

Servidor local (XAMPP, Laragon, WAMP, etc.).

Navegador moderno con soporte fetch.

🖥️ Instalación y uso en Localhost
1. Descargar o clonar el proyecto
git clone https://github.com/tuusuario/prueba-numeros-aleatorios.git


O descarga el ZIP y descomprímelo en tu carpeta de proyectos.

2. Copiar en el directorio del servidor

Si usas XAMPP: mueve la carpeta al directorio htdocs/.

C:\xampp\htdocs\prueba-numeros-aleatorios


Si usas Laragon: muévela a C:\laragon\www\.

Si usas WAMP: muévela a C:\wamp64\www\.

3. Iniciar el servidor

Abre el Panel de Control de tu servidor (XAMPP, Laragon, etc.).

Activa Apache (y MySQL si lo necesitas, aunque aquí no se usa).

4. Acceder en el navegador

Entra a la siguiente URL:

http://localhost/prueba-numeros-aleatorios/index.html

5. Uso

Seleccionar la prueba (Promedios o Frecuencias).

Ingresar valores rᵢ en [0,1] con 2 decimales.

Presionar Calcular.

Visualizar el resultado y detalle paso a paso.

📖 Notas

Para frecuencias, se recomienda que la frecuencia esperada E = n/K ≥ 5.

La tabla crítica de χ² incluida soporta df ≤ 5 y α ∈ {0.10, 0.05, 0.01}.
Puede ampliarse fácilmente en controller.php.

📜 Licencia

MIT – Libre uso académico y educativo.

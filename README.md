# 🎲 Prueba de Números Aleatorios (PHP + JS)

Este proyecto implementa dos pruebas estadísticas para verificar la **uniformidad de números pseudoaleatorios en [0,1]**:

✨ **Prueba de Promedios (Z):**  
- Contrasta si la media muestral `r̄` ≈ 0.5.  
- Usa distribución **Normal estándar**, dos colas.

📊 **Prueba de Frecuencias (χ²):**  
- Divide el intervalo [0,1] en `K` subintervalos iguales.  
- Compara frecuencias observadas vs. esperadas.  
- Usa distribución **Chi-cuadrado**, cola derecha.

---

## 📂 Estructura del Proyecto

    📁 SIMULACION
    ├── 📁 app
    │ └── 📁 assets
    │ ├── 📁 css
    │ │ └── style.css
    │ └── 📁 js
    │ └── index.js
    │
    ├── 📁 controller
    │ └── controller.php
    │
    ├── index.php
    ├── README.md
    ├── 📊 Tabla Normal Estandar.xlsx
    └── 📊 tabla_chi_cuadrado.xlsx


---

## ⚙️ Requisitos

- 🐘 **PHP 7+** (recomendado PHP 7.4 o superior).  
- 🖥️ **Servidor local** (XAMPP, Laragon, WAMP, etc.).  
- 🌐 **Navegador moderno** con soporte `fetch`.

---

## 🚀 Instalación en Localhost

### 🔹 1. Descargar o Clonar el Proyecto

- git clone https://github.com/Gabotox/simulacion.git


O descarga el ZIP y descomprímelo en tu carpeta de proyectos.

---

### 🔹 2. Mover al Directorio del Servidor

- **XAMPP:**  

---  📁 htdocs


### 🔹 3. Iniciar el Servidor

1. Abre el **Panel de Control** (XAMPP / Laragon / WAMP).  
2. Activa **Apache** (MySQL no es necesario aquí).  

---

### 🔹 4. Abrir en el Navegador

👉 Ve a:  


- http://localhost/Simulacion/index.php




---

## 🧪 Ejemplo de Uso

1. Selecciona la prueba (**Promedios** o **Frecuencias**).  
2. Ingresa valores `rᵢ` en [0,1] con **2 decimales**.  
3. Presiona **Calcular**.  
4. Visualiza el resultado y un **detalle paso a paso**.  

💡 **Ejemplo de entrada:**  


- 0.15, 0.23, 0.47, 0.51, 0.78, 0.95


---

## 📖 Notas Importantes

- Puedes **ampliar la tabla** fácilmente en `controller.php`.  

---

## 📜 Licencia

📄 **MIT License** – Libre uso académico y educativo. 



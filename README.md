# 🎲 Prueba de Números Aleatorios (PHP + JS)

Este proyecto implementa dos pruebas estadísticas para verificar la uniformidad de números pseudoaleatorios en [0,1]:

1. **Prueba de Promedios (Z):**
   - Contrasta si la media muestral `r̄` ≈ 0.5.
   - Usa distribución Normal estándar, dos colas.

2. **Prueba de Frecuencias (χ²):**
   - Divide el intervalo [0,1] en `K` subintervalos iguales.
   - Compara frecuencias observadas vs. esperadas.
   - Usa distribución Chi-cuadrado, cola derecha.

---

## 🚀 Estructura del proyecto
- `controller.php` → lógica estadística y respuestas JSON.
- `index.js` → control de formulario, envío AJAX y render de resultados.
- `index.html` → interfaz gráfica (inputs, resultados, estilos).
- `README.md` → documentación.

---

## ⚙️ Requisitos
- PHP 7+ con servidor local (XAMPP, Laragon, etc.).
- Navegador moderno con soporte `fetch`.

---

## 🧪 Ejemplo de uso
1. Abrir `index.html` en el navegador.
2. Seleccionar prueba (**Promedios** o **Frecuencias**).
3. Ingresar valores `rᵢ` en [0,1] con 2 decimales.
4. Presionar **Calcular**.
5. Ver resultado y detalle paso a paso.

---

## 📖 Notas
- Para `frecuencias`, se recomienda que la frecuencia esperada `E = n/K ≥ 5`.
- La tabla crítica de χ² incluida soporta `df ≤ 5` y α ∈ {0.10, 0.05, 0.01}.  
  Puede ampliarse fácilmente en `controller.php`.

---

## 📜 Licencia
MIT – Libre uso académico y educativo.
# 🎲 Prueba de Números Aleatorios (PHP + JS)

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prueba de números aleatorios — Prototipo</title>
    <link rel="stylesheet" href="app/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>

    </style>
</head>

<body>
    <div class="wrap">
        <div class="title">Prototipo — Prueba de números aleatorios</div>
        <div class="subtitle">Elige la prueba, ingresa los datos (2 decimales) y obtén el dictamen.

            <div class="grid" style="margin-top:20px">
                <div class="card">
                    <div class="row" style="justify-content:space-between">
                        <div class="badge">Entrada</div>
                        <div class="row">
                            <label class="row" style="gap:8px"><input type="radio" name="tipo" value="promedios" checked> Promedios (Z)</label>
                            <label class="row" style="gap:8px"><input type="radio" name="tipo" value="frecuencias"> Frecuencias (χ²)</label>
                        </div>
                    </div>

                    <div style="margin-top:12px">
                        <label>Número de datos (n)</label>
                        <input id="n" type="number" min="2" step="1" placeholder="Ej. 20" value="20">
                    </div>

                    <div class="row">
                        <div style="flex:1">
                            <label>α (nivel de significancia)</label>
                            <select id="alpha">
                                <option value="0.10">10%</option>
                                <option value="0.05" selected>5%</option>
                                <option value="0.01">1%</option>
                            </select>
                        </div>
                        <div id="kWrap" style="flex:1; display:none">
                            <label>K (intervalos iguales)</label>
                            <input id="K" type="number" min="2" step="1" placeholder="Ej. 5">
                            <small>Recomendado: K ≤ ⌊n/5⌋ (E = n/K ≥ 5)</small>
                        </div>
                    </div>

                    <div style="margin-top:12px">
                        <div class="row" style="justify-content:space-between">
                            <label>Datos rᵢ en [0,1] con 2 decimales</label>
                            <button id="gen" class="btn btn-ghost">Generar casillas</button>
                        </div>
                        <textarea id="datos" rows="6" class="code" placeholder="Ingrese valores separados por coma, p. ej. 0.12,0.34,0.56,0.78,0.90,0.03,0.44,0.67,0.21,0.85,0.49,0.51,0.73,0.18,0.39,0.62,0.27,0.95,0.07,0.58"></textarea>
                        <small class="muted">Formato: exactamente 2 decimales. Puedes pegar números o usar “Generar casillas” y completar.</small>
                    </div>

                    <div class="row" style="margin-top:14px">
                        <button id="run" class="btn btn-primary">Calcular</button>
                        <button id="clear" class="btn btn-ghost">Limpiar</button>
                    </div>
                </div>

                <div class="card">
                    <div class="badge">Resultado</div>
                    <div id="out" class="muted" style="margin-top:8px">Aún sin calcular.</div>
                    <div style="margin-top:10px">
                        <div class="badge">Detalle</div>
                        <div id="detail" class="code" style="margin-top:8px; white-space:pre-wrap">—</div>
                    </div>
                    <div style="margin-top:10px">
                        <small>Regla de decisión: Promedios → 2 colas | Frecuencias → cola derecha.</small>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="app/assets/js/index.js"></script>
</body>

</html>
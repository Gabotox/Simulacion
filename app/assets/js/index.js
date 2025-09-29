
// ---------- Frontend JS (vanilla) ----------
const tipoRadios = document.querySelectorAll('input[name="tipo"]');
const kWrap = document.getElementById('kWrap');
const nEl = document.getElementById('n');
const alphaEl = document.getElementById('alpha');
const KEl = document.getElementById('K');
const datosEl = document.getElementById('datos');
const genBtn = document.getElementById('gen');
const runBtn = document.getElementById('run');
const clearBtn = document.getElementById('clear');
const outEl = document.getElementById('out');
const detEl = document.getElementById('detail');

function getTipo() {
    return [...tipoRadios].find(r => r.checked).value;
}

function toggleK() {
    kWrap.style.display = getTipo() === 'frecuencias' ? 'block' : 'none';
}

tipoRadios.forEach(r => r.addEventListener('change', toggleK));
toggleK();

genBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const n = Math.max(2, parseInt(nEl.value || '0', 10));
    const arr = Array.from({
        length: n
    }, (_, i) => (i < 5 ? (0.10 * (i + 1)).toFixed(2) : '').toString());
    datosEl.value = arr.filter(x => x !== '').join(','); // deja algunos como guía
});

clearBtn.addEventListener('click', (e) => {
    e.preventDefault();
    datosEl.value = '';
    outEl.textContent = 'Aún sin calcular.';
    detEl.textContent = '—';
    outEl.className = 'muted';
});

runBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    const testType = getTipo();
    const alpha = parseFloat(alphaEl.value);
    const K = testType === 'frecuencias' ? parseInt(KEl.value || '0', 10) : null;

    // Normaliza datos: quita espacios y valida dos decimales en frontend
    const raw = datosEl.value.split(',').map(s => s.trim()).filter(Boolean);
    const bad = raw.find(v => !/^(0(\.\d{2})?|1\.00)$/.test(v));
    if (raw.length < 2) {
        notify('Ingresa al menos 2 datos.');
        return;
    }
    if (bad) {
        notify('Cada rᵢ debe estar en [0,1] con exactamente 2 decimales.');
        return;
    }
    if (testType === 'frecuencias' && (!K || K < 2)) {
        notify('K debe ser un entero ≥ 2.');
        return;
    }

    const form = new FormData();
    form.append('action', 'compute');
    form.append('testType', testType);
    form.append('alpha', alpha.toString());
    if (K !== null) form.append('K', K.toString());
    form.append('data', raw.join(','));

    outEl.textContent = 'Calculando…';
    outEl.className = 'muted';

    const res = await fetch('/Simulacion/app/controller/controller.php', {
        method: 'POST',
        body: form
    });

    const data = await res.json();
    if (!data.ok) {
        outEl.textContent = 'Error';
        outEl.className = 'result bad';
        detEl.textContent = data.error || 'Error desconocido.';
        return;
    }

    if (data.test === 'promedios') {
        const accept = Math.abs(data.Z0) <= data.zcrit;
        outEl.textContent = accept ? 'Se ACEPTA H₀ (Promedios)' : 'Se RECHAZA H₀ (Promedios)';
        outEl.className = 'result ' + (accept ? 'ok' : 'bad');
        detEl.textContent =
            `n = ${data.n}
α = ${data.alpha}
α/2 = ${data.alpha2}
x̄ = ${data.rbar}
Z₀ = ${data.Z0}
z* = ${data.zcrit}
Tabla: ${data.tabla}

Decisión:
${data.decision}`;
    } else {
        const accept = data.chi2 <= data.chi2crit;
        outEl.textContent = accept ? 'No se rechaza H₀ (Frecuencias)' : 'Se RECHAZA H₀ (Frecuencias)';
        outEl.className = 'result ' + (accept ? 'ok' : 'bad');

        let detalle =
            `n = ${data.n}
α = ${data.alpha}
K = ${data.K}  |  df = ${data.df}
χ²₀ = ${data.chi2}
χ²* = ${data.chi2crit}
Tabla: ${data.tabla}

Detalle de términos:`;

        if (data.detalles && data.detalles.length > 0) {
            detalle += "\n" + data.detalles.join("\n");
        }

        detalle += `

Decisión:
${data.decision}`;

        if (data.warning) {
            detalle += `\n\n⚠️ ${data.warning}`;
        }

        detEl.textContent = detalle;
    }
});

function notify(msg) {
    outEl.textContent = 'Atención';
    outEl.className = 'result bad';
    detEl.textContent = msg;
}

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// ------------------- Helpers -------------------

function validate_numbers($arr)
{
    if (!is_array($arr) || count($arr) < 2) return "Debes ingresar al menos 2 números.";
    foreach ($arr as $x) {
        if (!is_numeric($x)) return "Todos los datos deben ser numéricos.";
        $v = floatval($x);
        if ($v < 0 || $v > 1) return "Cada rᵢ debe estar entre 0 y 1.";
        if (number_format($v, 2, '.', '') != sprintf('%.2f', $v)) {
            return "Cada rᵢ debe tener exactamente 2 decimales.";
        }
    }
    return null;
}

function mean($arr)
{
    return array_sum(array_map('floatval', $arr)) / count($arr);
}

function get_z_critical($alpha)
{
    $map = [
        "0.10" => 1.645,
        "0.05" => 1.960,
        "0.01" => 2.576
    ];
    $alphaStr = number_format($alpha, 2);
    return $map[$alphaStr] ?? 1.960;
}


function chi2_critical($alpha, $df)
{
    $table = [
        "0.10" => [1 => 2.706, 2 => 4.605, 3 => 6.251, 4 => 7.779, 5 => 9.236],
        "0.05" => [1 => 3.841, 2 => 5.991, 3 => 7.815, 4 => 9.488, 5 => 11.070],
        "0.01" => [1 => 6.635, 2 => 9.210, 3 => 11.345, 4 => 13.277, 5 => 15.086],
    ];

    $alphaStr = number_format($alpha, 2); // fuerza "0.10", "0.05", "0.01"
    return $table[$alphaStr][$df] ?? null;
}


function chi2_stat($arr, $K)
{
    $n = count($arr);
    $E = $n / $K;
    $counts = array_fill(0, $K, 0);

    foreach ($arr as $x) {
        $v = floatval($x);
        $idx = intval(floor($v * $K));
        if ($idx >= $K) $idx = $K - 1;
        $counts[$idx]++;
    }

    $chi2 = 0.0;
    $detalles = [];
    foreach ($counts as $j => $Oj) {
        $term = pow($Oj - $E, 2) / $E;
        $chi2 += $term;
        $detalles[] = "(FO" . ($j + 1) . "={$Oj} − FE={$E})² / {$E} = " . round($term, 4);
    }

    $warning = null;
    if ($E < 5) {
        $warning = "⚠️ Advertencia: E = {$E} < 5. Se recomienda K ≤ ⌊n/5⌋.";
    }

    return [$chi2, $detalles, $warning];
}

// ------------------- Endpoint -------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'compute') {
    header('Content-Type: application/json; charset=utf-8');

    $type = $_POST['testType'] ?? '';
    $alpha = floatval($_POST['alpha'] ?? 0.05);
    $K = isset($_POST['K']) ? intval($_POST['K']) : null;
    $data = explode(',', $_POST['data'] ?? '');

    $data = array_filter(array_map('trim', $data), fn($x) => $x !== '');
    $err = validate_numbers($data);
    if ($err) {
        echo json_encode(['ok' => false, 'error' => $err]);
        exit;
    }

    $n = count($data);

    // --- Promedios ---
    if ($type === 'promedios') {
        $rbar = mean($data);
        $sigma2 = 1.0 / 12.0;
        $Z0 = ($rbar - 0.5) / sqrt($sigma2 / $n);
        $zcrit = get_z_critical($alpha);
        $reject = (abs($Z0) > $zcrit);

        $decision = $reject
            ? "|Z₀| = " . round(abs($Z0), 4) . " > Z=α/2 ≡ {$zcrit}\nSE RECHAZA H₀ y SE ACEPTA H₁: rᵢ no son uniformes"
            : "|Z₀| = " . round(abs($Z0), 4) . " < Z=α/2 ≡ {$zcrit}\n\nSE ACEPTA H₀: rᵢ ~ U(0,1) Y SE RECHAZA H₁: rᵢ no son uniformes";

        echo json_encode([
            'ok' => true,
            'test' => 'promedios',
            'n' => $n,
            'alpha' => $alpha,
            'alpha2' => $alpha / 2,
            'rbar' => round($rbar, 4),
            'Z0' => round($Z0, 4),
            'zcrit' => $zcrit,
            'decision' => $decision,
            'tabla' => 'Normal estándar (Z críticos)'
        ]);
        exit;
    }
    // --- Promedios ---
    if ($type === 'promedios') {
        $rbar = mean($data);
        $sigma2 = 1.0 / 12.0;
        $Z0 = ($rbar - 0.5) / sqrt($sigma2 / $n);
        $zcrit = get_z_critical($alpha);
        $reject = (abs($Z0) > $zcrit);

        echo json_encode([
            'ok' => true,
            'test' => 'promedios',
            'n' => $n,
            'alpha' => $alpha,
            'alpha2' => $alpha / 2,
            'rbar' => round($rbar, 4),
            'Z0' => round($Z0, 4),
            'zcrit' => $zcrit,
            'decision' => $reject
                ? "Se RECHAZA H₀: rᵢ ~ U(0,1)"
                : "Se ACEPTA H₀: rᵢ ~ U(0,1)",
            'tabla' => 'Normal estándar (Z críticos)'
        ]);
        exit;
    }

    // --- Frecuencias ---
    if ($type === 'frecuencias') {
        [$chi2, $detalles, $warn] = chi2_stat($data, $K);
        $df = $K - 1;
        $chi2crit = chi2_critical($alpha, $df);

        $reject = ($chi2 > $chi2crit);

        // Construimos la frase como en el ejemplo del profesor
        $comparacion = round($chi2, 3) . " " . ($reject ? ">" : "<=") . " " . round($chi2crit, 3);

        $decision = $reject
            ? "$comparacion → Se RECHAZA H₀ y se ACEPTA H₁"
            : "$comparacion → Se ACEPTA H₀ y se RECHAZA H₁";

        echo json_encode([
            'ok' => true,
            'test' => 'frecuencias',
            'n' => $n,
            'alpha' => $alpha,
            'K' => $K,
            'df' => $df,
            'chi2' => round($chi2, 4),
            'chi2crit' => $chi2crit,
            'detalles' => $detalles,
            'decision' => $decision,
            'tabla' => 'Chi-cuadrado (valores críticos)',
            'warning' => $warn
        ]);
        exit;
    }
}

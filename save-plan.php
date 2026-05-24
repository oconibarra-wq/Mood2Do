<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("location: no-user-index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: new-plan.php");
    exit();
}

// ── Recoger respuestas ────────────────────────────────────────────
$mood         = $_POST['mood']          ?? '';
$need         = $_POST['need']          ?? '';
$bandwidth    = (int)($_POST['bandwidth']    ?? 50);
$energy       = (int)($_POST['energy']       ?? 3);
$body         = $_POST['body']          ?? '';
$poss         = $_POST['poss']          ?? '';
$weather      = $_POST['weather']       ?? '';
$stress_help  = $_POST['stress_help']   ?? '';
$appealing    = $_POST['appealing']     ?? '';
$social_bat   = (int)($_POST['social_battery'] ?? 3);
$rest_types   = $_POST['rest']          ?? [];   // checkbox array

// ── Sistema de puntuación (cada plan acumula puntos) ──────────────
// Planes disponibles:
//   1 = Reset Plan        → descanso, baja energía, necesita calma
//   2 = Deep Focus Plan   → alta concentración, alta energía
//   3 = Creative Spark    → creatividad, curiosidad, exploración
//   4 = Social Flow       → batería social alta, necesita conexión
//   5 = Momentum Builder  → motivación media, quiere avanzar poco a poco

$scores = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

// --- mood ---
switch ($mood) {
    case 'drained':
    case 'anxious':
        $scores[1] += 3; break;
    case 'energized':
        $scores[2] += 3; $scores[5] += 1; break;
    case 'curious':
        $scores[3] += 3; break;
    case 'unmotivated':
        $scores[1] += 2; $scores[5] += 2; break;
}

// --- need ---
switch ($need) {
    case 'calm':
    case 'comfort':
        $scores[1] += 2; break;
    case 'focus':
        $scores[2] += 2; break;
    case 'excitement':
        $scores[3] += 2; $scores[4] += 1; break;
    case 'meaning':
        $scores[3] += 1; $scores[5] += 2; break;
}

// --- bandwidth (1-100) ---
if ($bandwidth < 35) {
    $scores[1] += 3;
} elseif ($bandwidth < 65) {
    $scores[5] += 2; $scores[3] += 1;
} else {
    $scores[2] += 3;
}

// --- energy (1-5) ---
if ($energy <= 2) {
    $scores[1] += 2;
} elseif ($energy === 3) {
    $scores[5] += 2;
} else {
    $scores[2] += 2; $scores[3] += 1;
}

// --- body ---
switch ($body) {
    case 'tense':
        $scores[1] += 1; $scores[3] += 1; break;
    case 'heavy':
        $scores[1] += 2; break;
    case 'restless':
        $scores[3] += 2; $scores[4] += 1; break;
    case 'fine':
        $scores[2] += 1; $scores[5] += 1; break;
}

// --- what's possible ---
switch ($poss) {
    case 'bed':
        $scores[1] += 3; break;
    case 'small':
        $scores[5] += 2; break;
    case 'light':
        $scores[3] += 1; $scores[4] += 2; break;
}

// --- stress_help ---
switch ($stress_help) {
    case 'solitude':
        $scores[1] += 1; $scores[2] += 1; break;
    case 'movement':
        $scores[3] += 1; $scores[4] += 1; break;
    case 'creativity':
        $scores[3] += 2; break;
    case 'structure':
        $scores[2] += 2; $scores[5] += 1; break;
    case 'talking':
        $scores[4] += 2; break;
    case 'novelty':
        $scores[3] += 2; break;
}

// --- appealing ---
switch ($appealing) {
    case 'make':
        $scores[3] += 2; break;
    case 'learn':
        $scores[2] += 2; break;
    case 'explore':
        $scores[3] += 1; $scores[4] += 1; break;
    case 'care':
        $scores[1] += 2; break;
    case 'help':
        $scores[4] += 2; break;
    case 'play':
        $scores[3] += 1; $scores[4] += 1; break;
}

// --- social battery ---
if ($social_bat >= 4) {
    $scores[4] += 2;
} elseif ($social_bat <= 2) {
    $scores[1] += 1; $scores[2] += 1;
}

// --- rest types (checkboxes) ---
foreach ($rest_types as $r) {
    switch ($r) {
        case 'physical':
        case 'sensory':
        case 'emotional':
            $scores[1] += 1; break;
        case 'mental':
            $scores[1] += 1; $scores[5] += 1; break;
        case 'creative':
            $scores[3] += 1; break;
        case 'social':
            $scores[4] += 1; break;
    }
}

// ── Elegir el plan con mayor puntaje ─────────────────────────────
arsort($scores);
$selected_plan = array_key_first($scores);

// Guardar en sesión y redirigir
$_SESSION['plan_result']  = $selected_plan;
$_SESSION['plan_answers'] = [
    'mood'      => $mood,
    'need'      => $need,
    'bandwidth' => $bandwidth,
    'energy'    => $energy,
    'scores'    => $scores,
];

header("location: result.php");
exit();
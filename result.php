<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("location: no-user-index.php");
    exit();
}

if (!isset($_SESSION['plan_result'])) {
    header("location: new-plan.php");
    exit();
}

$plan_id = $_SESSION['plan_result'];
$answers = $_SESSION['plan_answers'] ?? [];
$scores  = $answers['scores'] ?? [];

// ── Definición de los 5 planes ────────────────────────────────────
$plans = [
    1 => [
        'name'        => 'Plan "Mood Reset"',
        'emoji'       => '😌',
        'tagline'     => "Cuando no tienes ganas pero igual necesitas avanzar, la clave es quitarle toda la presión al proceso. No se trata de rendir perfecto, sino simplemente de arrancar.",
        'color_main'  => '#f4845f',
        'mood_label'  => 'Reflectivo',
        'study_mode'  => 'Efoque suave',
        'activities'  => [
            'Estudio 15 a 25 minutos diarios',
            'Bebida Mood: Te caliente',
            'Caminata tranquila',
            'Realiza hobbies de bajo estimulo',
            'Autocuidado de 5 minutos',
            'Micro-tareas de reducción de estrés',
        ],
        'donut_segments' => [
            ['color' => '#f4845f', 'pct' => 35], /*Pct: Porcentajes*/
            ['color' => '#f9b99f', 'pct' => 25],
            ['color' => '#a78bfa', 'pct' => 20],
            ['color' => '#f472b6', 'pct' => 12],
            ['color' => '#93c5fd', 'pct' => 8],
        ],
    ],
    2 => [
        'name'        => 'Plan "Concentración Profunda"',
        'emoji'       => '🎯',
        'tagline'     => "Cuando tienes energía y ganas, el objetivo no es solo cubrir el temario sino entender de verdad. La idea es estudiar en bloques de 45 a 90 minutos con descansos activos entre medio, usando técnicas como lectura activa, mapas mentales y práctica constante.",
        'color_main'  => '#6366f1',
        'mood_label'  => 'Concentrado',
        'study_mode'  => 'Enfoque profundo',
        'activities'  => [
            'Bloques de estudio de 45 a 90 minutos',
            'Espacio de trabajo libre de distracciones',
            'Lista de prioridades en tareas',
            'Música lofi de fondo o silecio',
            'Duchas de agua fría',
            'Revisión y recompensa luego de sesiones de estudio',
        ],
        'donut_segments' => [
            ['color' => '#6366f1', 'pct' => 40],
            ['color' => '#a5b4fc', 'pct' => 25],
            ['color' => '#f4845f', 'pct' => 15],
            ['color' => '#34d399', 'pct' => 12],
            ['color' => '#fbbf24', 'pct' => 8],
        ],
    ],
    3 => [
        'name'        => 'Plan "Llama Creativa"',
        'emoji'       => '✨',
        'tagline'     => "La curiosidad es tu combustible hoy. Explora sin un plan rígido: deja que las ideas fluyan y se conecten de maneras inesperadas.",
        'color_main'  => '#f59e0b',
        'mood_label'  => 'Curiosx',
        'study_mode'  => 'Exploración libre',
        'activities'  => [
            'Mapas mentales o apoyo visual',
            'Explora más allá de los temas',
            'Organización creativa',
            'Explora nueva música',
            'Busca tu método de estudio visual favorito',
            'Establece tareas creativas',
        ],
        'donut_segments' => [
            ['color' => '#f59e0b', 'pct' => 35],
            ['color' => '#fde68a', 'pct' => 20],
            ['color' => '#f4845f', 'pct' => 22],
            ['color' => '#6ee7b7', 'pct' => 13],
            ['color' => '#c4b5fd', 'pct' => 10],
        ],
    ],
    4 => [
        'name'        => 'Plan "Social Mood"',
        'emoji'       => '🤝',
        'tagline'     => "Hoy te energiza la conexión. Apóyate en la colaboración, las conversaciones y el impulso compartido.",
        'color_main'  => '#10b981',
        'mood_label'  => 'Conectax',
        'study_mode'  => 'Collaborativo',
        'activities'  => [
            'Estudia con tu grupo o amigo',
            'Enséñale a alguien el tema a estudiar',
            'únete a una grupo de estudio',
            'Trabaja con alguien en un problema',
            'Comparte tus logros con tus amigos',
            'Celebra con otros',
        ],
        'donut_segments' => [
            ['color' => '#10b981', 'pct' => 38],
            ['color' => '#6ee7b7', 'pct' => 22],
            ['color' => '#93c5fd', 'pct' => 18],
            ['color' => '#f4845f', 'pct' => 12],
            ['color' => '#fbbf24', 'pct' => 10],
        ],
    ],
    5 => [
        'name'        => 'Plan "Arquitecto del momento"',
        'emoji'       => '🚀',
        'tagline'     => "No estás al 100%, pero quieres avanzar. Pasos pequeños y consistentes construirán el impulso que necesitas.",
        'color_main'  => '#3b82f6',
        'mood_label'  => 'Estable',
        'study_mode'  => 'Progreso gentil',
        'activities'  => [
            'Escoge una pequeña tarea a realizar',
            'Usa el método Pomodoro',
            'Organiza tu espacio antes de estudiar',
            'Ordena tus ideas en tu mente',
            'Celebra pequeños logros',
            'Planea tus tareas del día siguiente',
        ],
        'donut_segments' => [
            ['color' => '#3b82f6', 'pct' => 33],
            ['color' => '#93c5fd', 'pct' => 25],
            ['color' => '#f4845f', 'pct' => 20],
            ['color' => '#34d399', 'pct' => 14],
            ['color' => '#f472b6', 'pct' => 8],
        ],
    ],
];

$plan        = $plans[$plan_id];
$color_main  = $plan['color_main'];
$segs        = $plan['donut_segments'];

// ... (debajo de $plan = $plans[$plan_id];)

// Preparamos el array de actividades con un estado 'done' inicial en false
$activities_for_session = [];
foreach ($plan['activities'] as $text) {
    $activities_for_session[] = [
        'text' => $text,
        'done' => false
    ];
}

// Guardamos el plan completo en la sesión para que user-index.php lo vea
$_SESSION['active_plan'] = [
    'name'       => $plan['name'],
    'emoji'      => $plan['emoji'],
    'color_main' => $plan['color_main'],
    'mood_label' => $plan['mood_label'],
    'study_mode' => $plan['study_mode'],
    'activities' => $activities_for_session
];

// Calcular porcentaje relativo de cada plan para la barra de confianza
$max_score   = max($scores) ?: 1;
$confidence  = round(($scores[$plan_id] / $max_score) * 100);

// Construir path del SVG donut
function buildDonut(array $segs, $cx = 90, $cy = 90, $r = 70, $inner = 44): string {
    $total = array_sum(array_column($segs, 'pct'));
    $angle = -90; // start top
    $paths = '';
    $gap   = 3;   // gap in degrees between segments
    foreach ($segs as $seg) {
        $sweep = ($seg['pct'] / $total) * 360 - $gap;
        if ($sweep <= 0) continue;
        $a1 = deg2rad($angle);
        $a2 = deg2rad($angle + $sweep);
        $x1o = $cx + $r * cos($a1);  $y1o = $cy + $r * sin($a1);
        $x2o = $cx + $r * cos($a2);  $y2o = $cy + $r * sin($a2);
        $x1i = $cx + $inner * cos($a2); $y1i = $cy + $inner * sin($a2);
        $x2i = $cx + $inner * cos($a1); $y2i = $cy + $inner * sin($a1);
        $large = $sweep > 180 ? 1 : 0;
        $paths .= '<path d="M '.$x1o.' '.$y1o.' A '.$r.' '.$r.' 0 '.$large.' 1 '.$x2o.' '.$y2o.
                  ' L '.$x1i.' '.$y1i.' A '.$inner.' '.$inner.' 0 '.$large.' 0 '.$x2i.' '.$y2i.' Z"'.
                  ' fill="'.$seg['color'].'" opacity="0.92"/>';
        $angle += $sweep + $gap;
    }
    return $paths;
}

$donut_paths = buildDonut($segs);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($plan['name']) ?> — Mood2Do</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Fraunces:wght@700;800&display=swap" rel="stylesheet">
    <style>
        /* ── Reset ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --accent:   <?= $color_main ?>;
            --bg:       #fdf8f5;
            --card:     #ffffff;
            --text:     #1a1a1a;
            --muted:    #888;
            --radius:   28px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text);
        }

        /* ── Fondo degradado suave ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 60% 50% at 80% 10%, color-mix(in srgb, var(--accent) 18%, transparent), transparent),
                        radial-gradient(ellipse 50% 60% at 10% 90%, color-mix(in srgb, var(--accent) 10%, transparent), transparent);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Nav ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            background: rgba(253,248,245,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 100;
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        .back-btn {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: white;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
            color: #555;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .back-btn:hover { transform: translateX(-3px); box-shadow: 0 4px 16px rgba(0,0,0,0.1); }

        .nav-links { display: flex; gap: 28px; }
        .nav-links a {
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--muted);
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--text); }
        .nav-links a.active { color: var(--text); font-weight: 600; border-bottom: 2px solid var(--accent); padding-bottom: 2px; }

        /* ── User menu ── */
        .user-menu-container { position: relative; }
        .user-profile-button {
            background: transparent; border: none; padding: 0; cursor: pointer;
            width: 40px; height: 40px; border-radius: 50%;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .user-profile-button:hover { transform: scale(1.05); }
        .user-profile-button img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid white; }
        .user-dropdown {
            position: absolute; top: 52px; right: 0;
            background: white; border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            width: 160px; padding: 10px 0;
            display: flex; flex-direction: column; z-index: 200;
            opacity: 0; visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.25s ease;
        }
        .user-dropdown.show { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-user-name { font-weight: 600; color: #333; padding: 10px 20px; margin: 0; border-bottom: 1px solid #f0f0f0; font-size: 0.85rem; text-align: center; }
        .user-dropdown a { text-decoration: none; color: #555; padding: 11px 20px; font-size: 0.82rem; font-weight: 500; transition: background 0.2s, color 0.2s; }
        .user-dropdown a:hover { background: #f8f9fa; color: var(--accent); }
        .logout-link { color: #e53935 !important; }
        .logout-link:hover { background: #ffebee !important; }

        /* ── Main layout ── */
        main {
            position: relative;
            z-index: 1;
            padding-top: 100px;
            padding-bottom: 60px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .result-card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            padding: 48px;
            max-width: 820px;
            width: calc(100% - 40px);
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 48px;
            align-items: center;
            animation: cardIn 0.6s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Donut ── */
        .donut-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: spinIn 0.8s cubic-bezier(0.22,1,0.36,1) 0.2s both;
        }

        @keyframes spinIn {
            from { opacity: 0; transform: rotate(-15deg) scale(0.85); }
            to   { opacity: 1; transform: rotate(0deg) scale(1); }
        }

        .donut-wrap svg { overflow: visible; filter: drop-shadow(0 8px 20px rgba(0,0,0,0.12)); }

        /* ── Right side ── */
        .plan-info { display: flex; flex-direction: column; gap: 20px; }

        .plan-title-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .plan-title {
            font-family: 'Fraunces', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
        }

        .plan-info-icon {
            width: 22px; height: 22px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem;
            color: var(--muted);
            cursor: help;
            flex-shrink: 0;
        }

        .plan-tagline {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.6;
            max-width: 420px;
        }

        /* ── Confidence bar ── */
        .confidence-bar-wrap { display: flex; flex-direction: column; gap: 6px; }
        .confidence-label { font-size: 0.78rem; color: var(--muted); font-weight: 500; letter-spacing: 0.03em; text-transform: uppercase; }
        .confidence-track {
            height: 8px;
            background: #ebebeb;
            border-radius: 99px;
            overflow: hidden;
        }
        .confidence-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--accent), color-mix(in srgb, var(--accent) 60%, #fff));
            width: 0;
            transition: width 1.2s cubic-bezier(0.22,1,0.36,1) 0.5s;
        }

        /* ── Activities ── */
        .activities-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .activity-item {
            font-size: 0.88rem;
            color: #444;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.4;
            animation: fadeUp 0.5s ease both;
        }

        .activity-item::before {
            content: '✓';
            color: var(--accent);
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        <?php foreach(range(1,6) as $i): ?>
        .activity-item:nth-child(<?= $i ?>) { animation-delay: <?= 0.4 + $i * 0.08 ?>s; }
        <?php endforeach; ?>

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Start button ── */
        .start-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: color-mix(in srgb, var(--accent) 15%, transparent);
            color: var(--accent);
            border: 2px solid color-mix(in srgb, var(--accent) 40%, transparent);
            padding: 14px 36px;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
            align-self: flex-start;
            animation: fadeUp 0.5s ease 1s both;
        }

        .start-btn:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px color-mix(in srgb, var(--accent) 35%, transparent);
        }

        .start-btn svg { transition: transform 0.2s; }
        .start-btn:hover svg { transform: translateX(3px); }

        /* ── Weather / mood chips (debajo del card) ── */
        .meta-chips {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .chip {
            background: #f5f5f5;
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 0.8rem;
            color: #555;
            font-weight: 500;
        }

        .chip strong { color: var(--accent); }

        /* ── Divider line ── */
        .divider {
            width: 100%;
            height: 1px;
            background: #f0f0f0;
        }

        /* ── Responsive ── */
        @media (max-width: 620px) {
            .result-card {
                grid-template-columns: 1fr;
                padding: 28px 22px;
                gap: 28px;
            }
            .donut-wrap svg { width: 160px; height: 160px; }
            .activities-grid { grid-template-columns: 1fr; }
            .plan-title { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

<nav>
    <a href="user-index.php" class="back-btn" aria-label="Volver">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </a>

    <div class="nav-links">
        <a href="new-plan.php" class="active">Nuevo Plan</a>
    </div>

    <div class="user-menu-container">
        <button class="user-profile-button" id="userBtn" aria-label="Menú usuario">
            <img src="path/to/user-avatar.jpg" alt="Perfil"
                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['usuario'] ?? 'U') ?>&background=f4845f&color=fff'">
        </button>
        <div class="user-dropdown" id="userDropdown">
            <p class="dropdown-user-name"><?= htmlspecialchars($_SESSION['usuario'] ?? 'Usuario') ?></p>
            <a href="perfil.php">Mi Perfil</a>
            <a href="log-out.php" class="logout-link">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<main>
    <div class="result-card">

        <!-- Donut chart SVG -->
        <div class="donut-wrap">
            <svg width="200" height="200" viewBox="0 0 180 180" xmlns="http://www.w3.org/2000/svg">
                <!-- Sombra interior -->
                <circle cx="90" cy="90" r="44" fill="#faf9f8"/>
                <!-- Segmentos -->
                <?= $donut_paths ?>
                <!-- Emoji central -->
                <text x="90" y="90" text-anchor="middle" dominant-baseline="central"
                      font-size="30" style="user-select:none;"><?= $plan['emoji'] ?></text>
            </svg>
        </div>

        <!-- Información del plan -->
        <div class="plan-info">

            <div class="plan-title-row">
                <h1 class="plan-title"><?= htmlspecialchars($plan['name']) ?></h1>
                <div class="plan-info-icon" title="Plan generado según tus respuestas">ℹ</div>
            </div>

            <p class="plan-tagline"><?= htmlspecialchars($plan['tagline']) ?></p>

            <!-- Barra de confianza -->
            <div class="confidence-bar-wrap">
                <span class="confidence-label">Coincidencia</span>
                <div class="confidence-track">
                    <div class="confidence-fill" id="confBar"></div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Meta chips -->
            <div class="meta-chips">
                <span class="chip">Tendencia de tu Mood: <strong><?= htmlspecialchars($plan['mood_label']) ?></strong></span>
                <span class="chip">Método de estudio: <strong><?= htmlspecialchars($plan['study_mode']) ?></strong></span>
            </div>

            <!-- Actividades -->
            <div class="activities-grid">
                <?php foreach ($plan['activities'] as $act): ?>
                    <div class="activity-item"><?= htmlspecialchars($act) ?></div>
                <?php endforeach; ?>
            </div>

            <!-- Botón Start -->
            <a href="user-index.php" class="start-btn">
                Comenzar plan
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <polygon points="5 3 19 12 5 21 5 3"/>
                </svg>
            </a>

        </div>
    </div>
</main>

<script>
// ── Animar barra de confianza ─────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.getElementById('confBar').style.width = '<?= $confidence ?>%';
    }, 200);

    // ── Menú usuario ──────────────────────────────────────
    const btn = document.getElementById('userBtn');
    const dd  = document.getElementById('userDropdown');

    btn.addEventListener('click', e => {
        e.stopPropagation();
        dd.classList.toggle('show');
    });

    document.addEventListener('click', e => {
        if (!dd.contains(e.target) && e.target !== btn) {
            dd.classList.remove('show');
        }
    });
});
</script>

</body>
</html>
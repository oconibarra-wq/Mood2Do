<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("location: no-user-index.php");
    exit();
}

$active_plan = $_SESSION['active_plan'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood2Do - Home</title>
    <link rel="stylesheet" href="home-pages/user-style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/4.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>

    <?php if ($active_plan): ?>
    <style>:root { --plan-color: <?= htmlspecialchars($active_plan['color_main']) ?>; }</style>
    <?php endif; ?>
</head>
<body class="home-body">

<nav class="home-nav">
    <div class="nav-left">
        <a href="user-index.php" class="logo-link">
            <div class="user-avatar-small">
                <img src="img/logo_mood.png" alt="Mood2Do">
            </div>
        </a>
    </div>

    <div class="nav-right">
        <a href="new-plan.php" class="nav-link">Nuevo Plan</a>

    <div class="user-menu-container">
        <button class="user-profile-button" id="userBtn">
            <img src="path/to/user-avatar.jpg" alt="User Profile" 
                 onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario'] ?? 'User'); ?>&background=f4845f&color=fff'">
        </button>

        <div class="user-dropdown" id="userDropdown">
            <p class="dropdown-user-name"><?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Usuario'); ?></p>
            <a href="perfil.php">Mi Perfil</a>
            <a href="log-out.php" class="logout-link">Cerrar Sesión</a>
        </div>
    </div>
            </div>
        </div>
    </div>
</nav>

<main class="home-container">

<div class="welcome-header">
    <h1>Bienvenid@, <span><?= htmlspecialchars($_SESSION['usuario'] ?? 'Usuario') ?></span> <span>🙌</span></h1>
</div>

    <!-- ── Suggested Plans ── -->
    <section class="suggested-plans">
        <div class="title-group">
            <h2>¿Qué podrías hacer?</h2>
            <a href="#" class="show-more">Ver más</a>
        </div>
        <div class="plans-row">
            <div class="plan-card-mini">
                <h3>Plan "Mood Reset</h3>
                <p>Cuando no tienes ganas pero igual necesitas avanzar, la clave es...</p>
                <button class="use-plan-btn">Use plan</button>
            </div>
            <div class="plan-card-mini">
                <h3>Plan "Concentración Profunda</h3>
                <p>Cuando tienes energía y ganas, el objetivo no es solo cubrir el temario...</p>
                <button class="use-plan-btn">Use plan</button>
            </div>
            <div class="plan-card-mini">
                <h3>Plan "Llama Creativa</h3>
                <p>La curiosidad es tu combustible hoy. Explora sin un plan rígido...</p>
                <button class="use-plan-btn">Use plan</button>
            </div>
            <div class="plan-card-mini">
                <h3>Plan "Social Mood</h3>
                <p>Hoy te energiza la conexión. Apóyate en la colaboración, las conversaciones...</p>
                <button class="use-plan-btn">Use plan</button>
            </div>
            <div class="plan-card-mini">
                <h3>Plan "Arquitecto del momento</h3>
                <p>No estás al 100%, pero quieres avanzar. Pasos pequeños y consistentes construirán...</p>
                <button class="use-plan-btn">Use plan</button>
            </div>
        </div>
    </section>

    <!-- ── Dashboard Grid ── -->
    <div class="main-dashboard-grid">

        <!-- Plan in Use -->
        <section class="plans-in-use">
            <div class="section-title">
                <h2>Plan Actual</h2>
                <?php if ($active_plan): ?>
                <div class="plan-controls">
                    <a href="new-plan.php" title="Nuevo plan">＋</a>
                    <span title="Editar">📝</span>
                </div>
                <?php endif; ?>
            </div>

            <div class="task-list-container">

                <?php if ($active_plan): ?>

                    <!-- Header del plan activo -->
                    <div class="active-plan-header">
                        <span class="active-plan-emoji"><?= $active_plan['emoji'] ?></span>
                        <div>
                            <div class="active-plan-name"><?= htmlspecialchars($active_plan['name']) ?></div>
                            <div class="active-plan-meta">
                                <?= htmlspecialchars($active_plan['mood_label']) ?> · <?= htmlspecialchars($active_plan['study_mode']) ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    $total    = count($active_plan['activities']);
                    $done     = count(array_filter($active_plan['activities'], fn($a) => $a['done']));
                    $pct      = $total > 0 ? round(($done / $total) * 100) : 0;
                    ?>

                    <!-- Contador -->
                    <p class="task-count" id="taskCount">
                        <?= $done ?> de <?= $total ?> actividades completadas
                    </p>

                    <!-- Lista de actividades -->
                    <?php foreach ($active_plan['activities'] as $i => $act): ?>
                        <div class="task-item <?= $act['done'] ? 'completed' : '' ?>"
                             id="task-<?= $i ?>"
                             onclick="toggleTask(<?= $i ?>)">
                            <div class="task-check">✓</div>
                            <span class="task-text"><?= htmlspecialchars($act['text']) ?></span>
                        </div>
                    <?php endforeach; ?>

                    <!-- Barra de progreso -->
                    <div class="plan-progress-wrap">
                        <div class="plan-progress-label">
                            <span>Progreso</span>
                            <span id="progressPct"><?= $pct ?>%</span>
                        </div>
                        <div class="plan-progress-track">
                            <div class="plan-progress-fill" id="progressFill"
                                 style="width: <?= $pct ?>%"></div>
                        </div>
                    </div>

                <?php else: ?>

                    <!-- Sin plan activo -->
                    <div class="no-plan-state">
                        <span style="font-size:2.5rem;">🗒️</span>
                        <p>Aún no tienes un plan activo.<br>¡Genera uno según tu estado de ánimo!</p>
                        <a href="new-plan.php" class="no-plan-btn">Crear mi plan ✨</a>
                    </div>

                <?php endif; ?>

            </div>
        </section>

        <!-- Sidebar -->
        <aside class="status-sidebar">
            <div class="weather-widget">
                <div class="temp-row">
                    <span class="temp">24°</span>
                    <span class="weather-icon">☁️</span>
                </div>
                <?php if ($active_plan): ?>
                    <p class="mood-tendency">Mood tendency: <strong><?= htmlspecialchars($active_plan['mood_label']) ?></strong></p>
                    <p class="study-mode">Best study mode: <strong><?= htmlspecialchars($active_plan['study_mode']) ?></strong></p>
                <?php else: ?>
                    <p class="mood-tendency">Mood tendency: <strong>—</strong></p>
                    <p class="study-mode">Best study mode: <strong>—</strong></p>
                <?php endif; ?>
            </div>

            <?php if ($active_plan): ?>
            <div class="today-try">
                <h4>Today try:</h4>
                <ul>
                    <?php foreach (array_slice($active_plan['activities'], 0, 3) as $act): ?>
                        <li>✓ <?= htmlspecialchars($act['text']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </aside>

    </div>
</main>

<script>

    const slider = document.querySelector('.plans-row');
let isDown = false;
let startX;
let scrollLeft;

if (slider) {
    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2; // Velocidad del scroll
        slider.scrollLeft = scrollLeft - walk;
    });
}
document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.getElementById('userBtn');
    const userDropdown = document.getElementById('userDropdown');

    if (userBtn && userDropdown) {
        // Alternar la clase 'show' cuando se hace clic en el botón de perfil
        userBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Evita que el clic cierre el menú inmediatamente
            userDropdown.classList.toggle('show');
        });

        // Cerrar el menú automáticamente si el usuario hace clic en cualquier otro lugar de la pantalla
        document.addEventListener('click', (event) => {
            if (!userDropdown.contains(event.target) && event.target !== userBtn) {
                userDropdown.classList.remove('show');
            }
        });
    }
});

// ── Toggle actividad (AJAX) ───────────────────────────────────────
function toggleTask(index) {
    fetch('toggle-activity.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'index=' + index
    })
    .then(r => r.json())
    .then(data => {
        const item  = document.getElementById('task-' + index);
        const check = item.querySelector('.task-check');

        if (data.done) {
            item.classList.add('completed');
        } else {
            item.classList.remove('completed');
        }

        updateProgress();
    })
    .catch(err => console.error('Toggle error:', err));
}

// Actualiza el contador y barra de progreso en tiempo real
function updateProgress() {
    const items = document.querySelectorAll('.task-item');
    const total = items.length;
    const done  = document.querySelectorAll('.task-item.completed').length;
    const pct   = total > 0 ? Math.round((done / total) * 100) : 0;

    const countEl = document.getElementById('taskCount');
    const pctEl   = document.getElementById('progressPct');
    const fillEl  = document.getElementById('progressFill');

    if (countEl) countEl.textContent = done + ' de ' + total + ' actividades completadas';
    if (pctEl)   pctEl.textContent   = pct + '%';
    if (fillEl)  fillEl.style.width  = pct + '%';
}
</script>

</body>
</html>
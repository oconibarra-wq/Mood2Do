<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Plan - Mood2Do</title>
    <style>
.user-menu-container {
    position: relative;
}

/* --- Botón del Perfil --- */
.user-profile-button {
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    outline: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.user-profile-button:hover {
    transform: scale(1.05);
}

.user-profile-button img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
}

/* --- Estilos del Menú Desplegable --- */
.user-dropdown {
    position: absolute;
    top: 55px; /* Lo separa un poco de la foto */
    right: 0;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    width: 160px;
    padding: 10px 0;
    display: flex;
    flex-direction: column;
    z-index: 1001;
    
    /* Animación de oculto/visible */
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

/* Esta clase se agrega con JS para mostrar el menú */
.user-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* --- Elementos dentro del Menú --- */
.dropdown-user-name {
    font-weight: 600;
    color: #333;
    padding: 10px 20px;
    margin: 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.9rem;
    text-align: center;
}

.user-dropdown a {
    text-decoration: none;
    color: #555;
    padding: 12px 20px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
}

.user-dropdown a:hover {
    background: #f8f9fa;
    color: #f4845f; /* Tu naranja característico */
}

.logout-link {
    color: #e53935 !important; /* Rojo para cerrar sesión */
}

.logout-link:hover {
    background: #ffebee !important;
}
.quiz-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
}

.back-btn {
    text-decoration: none;
    color: #555;
    font-size: 1.5rem;
    background: white;
    width: 45px;
    height: 45px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.back-btn:hover {
    transform: translateX(-3px);
    background: #f0f0f0;
}

.user-profile {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    cursor: pointer;
}

.user-profile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Ajuste para que el card no quede pegado al header en móviles */
body {
    padding-top: 80px;
}
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 50%, #e8eaf6 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .quiz-card {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 40px 30px 30px;
            border-radius: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
        }

        .date-label {
            color: #aaa;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        h2 {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 24px;
            color: #1a1a1a;
        }

        h2 span { color: #f4845f; }

        /* ── KEY FIX: Group visibility ── */
        .quiz-group { display: none; }
        .quiz-group.active { display: block; }

        .question-block {
            background: #f5f5f5;
            padding: 18px 16px;
            border-radius: 22px;
            margin-bottom: 16px;
            text-align: left;
        }

        .question-block p {
            color: #666;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 14px;
            text-align: center;
        }

        /* Mood faces */
        .mood-options { display: flex; justify-content: space-around; }
        .mood-item input { display: none; }
        .mood-face {
            font-size: 2rem;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            opacity: 0.45;
            filter: grayscale(1);
            transition: 0.25s;
        }
        .mood-face span { font-size: 0.7rem; color: #999; font-style: normal; }
        .mood-item input:checked + .mood-face {
            opacity: 1;
            filter: grayscale(0);
            transform: scale(1.15);
        }
        .mood-item input:checked + .mood-face span { color: #555; }

        /* Need icons */
        .need-options { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 8px; }
        .need-item input { display: none; }
        .need-face {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 10px 8px;
            border-radius: 16px;
            cursor: pointer;
            transition: 0.25s;
            opacity: 0.5;
        }
        .need-face i { font-size: 1.6rem; }
        .need-face span { font-size: 0.7rem; color: #888; }
        .need-item input:checked + .need-face {
            opacity: 1;
            background: rgba(0,0,0,0.06);
        }
        .need-item input:checked + .need-face span { color: #444; }

        /* Slider */
        .bandwidth-slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 12px;
            background: #e0e0e0;
            border-radius: 50px;
            outline: none;
            margin: 12px 0 6px;
        }
        .bandwidth-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 26px; height: 26px;
            background: #f4845f;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .bandwidth-slider::-moz-range-thumb {
            width: 26px; height: 26px;
            background: #f4845f;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
        .slider-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #aaa;
        }

        /* Option pills */
        .options-grid { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
        .option-pill input { display: none; }
        .option-pill span {
            display: inline-block;
            padding: 10px 18px;
            background: #fff;
            border-radius: 50px;
            color: #555;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
            border: 1.5px solid #e8e8e8;
        }
        .option-pill input:checked + span {
            background: #555;
            color: #fff;
            border-color: #555;
        }

        /* Slider scale numbers/ends */
        .slider-scale {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #aaa;
            margin-top: 4px;
        }
        .slider-scale-ends {
            display: flex;
            justify-content: space-between;
            font-size: 0.72rem;
            color: #999;
            margin-top: 6px;
            font-style: italic;
        }

        /* Button */
        .btn-main {
            width: 100%;
            margin-top: 24px;
            padding: 16px;
            border: none;
            border-radius: 50px;
            background: #e8e8e8;
            color: #555;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-main:hover { background: #ddd; }

        /* Progress dots */
        .dots-container { display: flex; justify-content: center; gap: 8px; margin-top: 20px; }
        .dot {
            width: 32px; height: 6px;
            background: #e8e8e8;
            border-radius: 10px;
            transition: background 0.3s;
        }
        .dot.active { background: #bbb; }
    </style>
</head>
<body>
    <header class="quiz-header">
    <a href="user-index.php" class="back-btn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </a>

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
</header>
<div class="quiz-card">
    <form id="moodQuiz" action="save-plan.php" method="POST">

        <!-- GROUP 1 -->
        <div class="quiz-group active" id="group1">
            <div id="fecha" class="date-label"></div>
            <h2>¿Cómo te sientes para estudiar <span>hoy?</span></h2>

            <div class="question-block">
                <p>¿Con qué Mood te relacionas?</p>
                <div class="mood-options">
                    <label class="mood-item">
                        <input type="radio" name="mood" value="energized">
                        <span class="mood-face">😤<span>Con energía</span></span>
                    </label>
                    <label class="mood-item">
                        <input type="radio" name="mood" value="anxious">
                        <span class="mood-face">😟<span>Ansiosx</span></span>
                    </label>
                    <label class="mood-item">
                        <input type="radio" name="mood" value="unmotivated">
                        <span class="mood-face">😑<span>Sin motivación</span></span>
                    </label>
                    <label class="mood-item">
                        <input type="radio" name="mood" value="drained">
                        <span class="mood-face">😶<span>Drenadx</span></span>
                    </label>
                    <label class="mood-item">
                        <input type="radio" name="mood" value="curious">
                        <span class="mood-face">🤔<span>Curiosx</span></span>
                    </label>
                </div>
            </div>

            <div class="question-block">
                <p>¿Qué necesitas hoy?</p>
                <div class="need-options">
                    <label class="need-item">
                        <input type="radio" name="need" value="calm">
                        <span class="need-face"><i>🌸</i><span>Calma</span></span>
                    </label>
                    <label class="need-item">
                        <input type="radio" name="need" value="comfort">
                        <span class="need-face"><i>☁️</i><span>Comodidad</span></span>
                    </label>
                    <label class="need-item">
                        <input type="radio" name="need" value="excitement">
                        <span class="need-face"><i>🎉</i><span>Entusiasmo</span></span>
                    </label>
                    <label class="need-item">
                        <input type="radio" name="need" value="focus">
                        <span class="need-face"><i>🔍</i><span>Concentración</span></span>
                    </label>
                    <label class="need-item">
                        <input type="radio" name="need" value="meaning">
                        <span class="need-face"><i>💡</i><span>Claridad</span></span>
                    </label>
                </div>
            </div>

            <div class="question-block">
                <p>¿Qué tan capaz, mentalmente, te sientes?</p>
                <input type="range" name="bandwidth" min="1" max="100" value="40" class="bandwidth-slider">
                <div class="slider-labels"><span>Poco capaz</span><span>Muy capaz</span></div>
            </div>
        </div>

        <!-- GROUP 2 -->
        <div class="quiz-group" id="group2">
            <h2>¿Cómo se siente tu<span>cuerpo?</span></h2>

            <div class="question-block">
                <p>¿Cuál es tu nivel de energía?</p>
                <input type="range" name="energy" min="1" max="5" step="1" value="3" class="bandwidth-slider">
                <div class="slider-labels"><span>Agotadx</span><span>Energizadx</span></div>
            </div>

            <div class="question-block">
                <p>¿Cómo se siente tu cuerpo?</p>
                <div class="options-grid">
                    <label class="option-pill"><input type="radio" name="body" value="tense"><span>Tenso</span></label>
                    <label class="option-pill"><input type="radio" name="body" value="heavy"><span>Pesado</span></label>
                    <label class="option-pill"><input type="radio" name="body" value="restless"><span>Inquieto</span></label>
                    <label class="option-pill"><input type="radio" name="body" value="fine"><span>Bien</span></label>
                </div>
            </div>

            <div class="question-block">
                <p>¿Qué te gustaría más?</p>
                <div class="options-grid">
                    <label class="option-pill"><input type="radio" name="poss" value="bed"><span>Quedarme en cama</span></label>
                    <label class="option-pill"><input type="radio" name="poss" value="small"><span>Tareas pequeñas</span></label>
                    <label class="option-pill"><input type="radio" name="poss" value="light"><span>Salida tranquila</span></label>
                </div>
            </div>
        </div>

        <!-- GROUP 3 -->
        <div class="quiz-group" id="group3">
            <h2>Tu mundo a tu <span>alrededor</span></h2>

            <div class="question-block">
                <p>¿Qué tal se ve el clima?</p>
                <div class="options-grid">
                    <label class="option-pill"><input type="radio" name="weather" value="rainy"><span>🌧️ Lluvioso</span></label>
                    <label class="option-pill"><input type="radio" name="weather" value="hot"><span>🌞 Caliente</span></label>
                    <label class="option-pill"><input type="radio" name="weather" value="cool"><span>🍃 Fresco </span></label>
                    <label class="option-pill"><input type="radio" name="weather" value="sunny"><span>☀️ Soleado</span></label>
                    <label class="option-pill"><input type="radio" name="weather" value="stormy"><span>⛈️ Tormetoso</span></label>
                </div>
            </div>

            <div class="question-block">
                <p>Cuando te sientes estresadx, ¿qué necesitas?</p>
                <div class="options-grid">
                    <label class="option-pill"><input type="radio" name="stress_help" value="solitude"><span>🤫 Soledad</span></label>
                    <label class="option-pill"><input type="radio" name="stress_help" value="movement"><span>🏃 Movimiento</span></label>
                    <label class="option-pill"><input type="radio" name="stress_help" value="creativity"><span>🎨 Creatividad</span></label>
                    <label class="option-pill"><input type="radio" name="stress_help" value="structure"><span>📋 Estrucutras</span></label>
                    <label class="option-pill"><input type="radio" name="stress_help" value="talking"><span>💬 Charla</span></label>
                    <label class="option-pill"><input type="radio" name="stress_help" value="novelty"><span>✨ Novedades</span></label>
                </div>
            </div>

            <div class="question-block">
                <p>¿Qué suena más apetecible?</p>
                <div class="options-grid">
                    <label class="option-pill"><input type="radio" name="appealing" value="make"><span>🛠️ Hacer algo</span></label>
                    <label class="option-pill"><input type="radio" name="appealing" value="learn"><span>📖 Leer algo</span></label>
                    <label class="option-pill"><input type="radio" name="appealing" value="explore"><span>🗺️ Salir a explorar</span></label>
                    <label class="option-pill"><input type="radio" name="appealing" value="care"><span>🛁 Cuidar de mi mismx</span></label>
                    <label class="option-pill"><input type="radio" name="appealing" value="help"><span>🤝 Ayudar a alguien</span></label>
                    <label class="option-pill"><input type="radio" name="appealing" value="play"><span>🎮 Jugar</span></label>
                </div>
            </div>
        </div>

        <!-- GROUP 4 -->
        <div class="quiz-group" id="group4">
            <h2>¡Casi listo! <span>Finalmente...</span></h2>

            <div class="question-block">
                <p>¿Cómo se encuentra tu batería social?</p>
                <input type="range" name="social_battery" min="1" max="5" step="1" value="3" class="bandwidth-slider">
                <div class="slider-scale">
                    <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                </div>
                <div class="slider-scale-ends">
                    <span>No quiero ver a nadie</span><span>Necesito compañía</span>
                </div>
            </div>

            <div class="question-block">
                <p>¿Qué tipo de descanso necesitas? <em style="font-size:0.8rem;color:#aaa;">(pueden haber varias respuestas)</em></p>
                <div class="options-grid">
                    <label class="option-pill"><input type="checkbox" name="rest" value="physical"><span>🛌 Físico</span></label>
                    <label class="option-pill"><input type="checkbox" name="rest" value="mental"><span>🧠 Mental</span></label>
                    <label class="option-pill"><input type="checkbox" name="rest" value="sensory"><span>🔇 Sensorial</span></label>
                    <label class="option-pill"><input type="checkbox" name="rest" value="creative"><span>🎨 Creativo</span></label>
                    <label class="option-pill"><input type="checkbox" name="rest" value="emotional"><span>💙 Emocional</span></label>
                    <label class="option-pill"><input type="checkbox" name="rest" value="social"><span>👭 Social</span></label>
                </div>
            </div>
        </div>

        <button type="button" id="mainBtn" class="btn-main" onclick="handleNavigation()">Continuar</button>

        <div class="dots-container">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </form>
</div>

<script>
    let currentGroup = 1;
    const totalGroups = 4;

    function handleNavigation() {
        if (currentGroup < totalGroups) {
            document.getElementById('group' + currentGroup).classList.remove('active');
            currentGroup++;
            document.getElementById('group' + currentGroup).classList.add('active');
            updateDots();
            if (currentGroup === totalGroups) {
                document.getElementById('mainBtn').innerText = "Generar plan";
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            document.getElementById('moodQuiz').submit();
        }
    }

    function updateDots() {
        document.querySelectorAll('.dot').forEach((dot, i) => {
            dot.classList.toggle('active', i < currentGroup);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.getElementById('userBtn');
    const userDropdown = document.getElementById('userDropdown');

    // Alternar el menú cuando se hace clic en la imagen
    userBtn.addEventListener('click', (event) => {
        event.stopPropagation(); // Evita que el clic se propague al documento
        userDropdown.classList.toggle('show');
    });

    // Cerrar el menú si se hace clic fuera de él
    document.addEventListener('click', (event) => {
        if (!userDropdown.contains(event.target) && event.target !== userBtn) {
            userDropdown.classList.remove('show');
        }
    });
});

        function mostrarFechaActual() {
            const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const fecha = new Date().toLocaleDateString('es-ES', opciones);
            document.getElementById('fecha').textContent = fecha;
        }

        // Llamar a la función al cargar la página
        mostrarFechaActual();
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RF Marketing — Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('recursos/styles/paginas/login.css') ?>">
</head>
<body>

<!-- Fondo animado con orbes y partículas -->
<div class="bg">
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>
    <div class="particles" id="particles"></div>
</div>

<div class="login-card">

    <!-- Panel izquierdo - marca y descripción del sistema -->
    <div class="side-left">
        <div class="deco-circle dc1"></div>
        <div class="deco-circle dc2"></div>
        <div class="deco-circle dc3"></div>

        <div class="left-top">
            <div class="left-badge">
                <div class="badge-pulse"></div>
                <span class="badge-label">Sistema en línea</span>
            </div>
            <div class="left-logo">RF</div>
            <div class="left-agency">Agencia de Marketing S.A.C.</div>
        </div>

        <div class="left-middle">
            <div class="left-system">
                <div class="ls-title">Sistema de<br>Gestión de<br>Pedidos</div>
                <div class="ls-sep"></div>
                <div class="ls-desc">Centraliza, automatiza y escala<br>las operaciones de tu agencia.</div>
            </div>
        </div>

        <div class="left-bottom">
            <div class="left-bottom-text">RF MARKETING © <?= date('Y') ?> — ICA, PERÚ</div>
        </div>
    </div>

    <!-- Panel derecho - formulario de acceso -->
    <div class="side-right">
        <div class="form-container">

            <div class="form-eyebrow">
                <div class="eyebrow-line"></div>
                <span class="eyebrow-text">Acceso al sistema</span>
            </div>

            <div class="form-title">INICIA<br><span>SESIÓN</span></div>
            <div class="form-subtitle">Ingresa tus credenciales para<br>acceder a tu panel de trabajo.</div>

            <!-- Mensaje de error si las credenciales son incorrectas -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-err show">
                    ⚠ &nbsp; <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="fgroup">
                    <label class="flabel">Usuario</label>
                    <div class="input-box">
                        <input type="text" id="usr" name="usuario"
                            class="finput" placeholder="Tu nombre de usuario"
                            autocomplete="off" required>
                        <span class="input-ico">👤</span>
                    </div>
                </div>

                <div class="fgroup">
                    <label class="flabel">Contraseña</label>
                    <div class="input-box">
                        <input type="password" id="pwd" name="clave"
                            class="finput" placeholder="••••••••" required>
                        <span class="input-ico">🔒</span>
                    </div>
                </div>

                <button type="submit" class="btn" id="btnMain">
                    Ingresar al sistema
                    <span class="btn-ico">→</span>
                </button>

            </form>

            <div class="ftr">
                <span class="ftr-left">RF Marketing</span>
                <div class="ftr-right">
                    <div class="ftr-dot"></div>
                    <span class="ftr-ver">v1.0.0</span>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Genera partículas flotantes en el fondo -->
<script>
(function(){
    const wrap = document.getElementById('particles');
    for(let i=0;i<25;i++){
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = Math.random()*100+'vw';
        p.style.width = p.style.height = (Math.random()*2+1)+'px';
        p.style.animationDuration = (Math.random()*15+10)+'s';
        p.style.animationDelay = (Math.random()*15)+'s';
        wrap.appendChild(p);
    }
})();
</script>

</body>
</html>
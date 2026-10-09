<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acessibilidade</title>
</head>
<body>
    <!-- =====================================================
     PAINEL DE ACESSIBILIDADE - MATHPLAY
====================================================== -->

<div id="acessibilidadeContainer">

    <!-- Botão para abrir ou fechar o painel -->
    <button
        type="button"
        id="abrirAcessibilidade"
        aria-expanded="false"
        aria-controls="painelAcessibilidade"
        aria-label="Abrir opções de acessibilidade">

        ♿ Acessibilidade
    </button>

    <!-- Painel de configurações -->
    <section
        id="painelAcessibilidade"
        aria-label="Opções de acessibilidade"
        hidden>

        <h2>Acessibilidade</h2>

        <p>Personalize sua experiência no MathPlay!</p>

        <div class="grupoAcessibilidade">

            <button type="button" id="aumentarFonte">
                Aumentar texto A+
            </button>

            <button type="button" id="diminuirFonte">
                Diminuir texto A-
            </button>

        </div>

        <div class="grupoAcessibilidade">

            <button
                type="button"
                id="contraste"
                aria-pressed="false">

                Alto contraste
            </button>

            <button
                type="button"
                id="animacoes"
                aria-pressed="false">

                Reduzir animações
            </button>

        </div>

        <button type="button" id="restaurar">
            Restaurar padrão
        </button>

        <button type="button" id="fecharAcessibilidade">
            Fechar painel
        </button>

        <p
            id="mensagemAcessibilidade"
            role="status"
            aria-live="polite">
        </p>

    </section>

</div>

<style>
/* =====================================================
   PAINEL DE ACESSIBILIDADE
====================================================== */

#acessibilidadeContainer {
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 99999;
    font-family: Arial, Helvetica, sans-serif;
}

/* Botão principal */

#abrirAcessibilidade {
    background: #5265d8;
    color: #ffffff;
    border: 2px solid #ffffff;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

#abrirAcessibilidade:hover {
    background: #3548b5;
}

/* Painel */

#painelAcessibilidade {
    position: absolute;
    right: 0;
    bottom: 65px;
    width: 300px;
    max-width: calc(100vw - 40px);
    max-height: 75vh;
    overflow-y: auto;
    padding: 18px;
    box-sizing: border-box;
    background: #ffffff;
    color: #202020;
    border: 2px solid #5265d8;
    border-radius: 14px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.2);
}

/* Garante que o atributo hidden realmente esconda o painel */

#painelAcessibilidade[hidden] {
    display: none !important;
}

#painelAcessibilidade h2 {
    margin-top: 0;
    font-size: 22px;
}

#painelAcessibilidade p {
    line-height: 1.5;
}

/* Organização dos botões */

.grupoAcessibilidade {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 10px;
}

#painelAcessibilidade button {
    display: block;
    width: 100%;
    min-height: 44px;
    margin-top: 8px;
    padding: 11px;
    background: #f1f3ff;
    color: #202020;
    border: 1px solid #5265d8;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
}

#painelAcessibilidade button:hover {
    background: #dfe4ff;
}

/* Foco visível para navegação pelo teclado */

#acessibilidadeContainer button:focus-visible {
    outline: 3px solid #ffbf47;
    outline-offset: 3px;
}

/* =====================================================
   MODO DE ALTO CONTRASTE
====================================================== */

body.alto-contraste {
    background: #000000 !important;
    color: #ffffff !important;
}

body.alto-contraste header,
body.alto-contraste main,
body.alto-contraste footer,
body.alto-contraste nav,
body.alto-contraste article,
body.alto-contraste section,
body.alto-contraste aside,
body.alto-contraste .card,
body.alto-contraste .question-card,
body.alto-contraste .question-container,
body.alto-contraste .alternativa {
    background-color: #000000 !important;
    color: #ffffff !important;
    border-color: #ffff00 !important;
}

body.alto-contraste h1,
body.alto-contraste h2,
body.alto-contraste h3,
body.alto-contraste p,
body.alto-contraste label,
body.alto-contraste span {
    color: #ffffff !important;
}

body.alto-contraste a {
    color: #ffff00 !important;
}

body.alto-contraste button,
body.alto-contraste input,
body.alto-contraste select,
body.alto-contraste textarea {
    background: #000000 !important;
    color: #ffff00 !important;
    border: 2px solid #ffff00 !important;
}

body.alto-contraste #painelAcessibilidade {
    background: #000000 !important;
    color: #ffffff !important;
    border-color: #ffff00 !important;
}

body.alto-contraste #painelAcessibilidade h2,
body.alto-contraste #painelAcessibilidade p {
    color: #ffffff !important;
}

/* =====================================================
   REDUÇÃO DE ANIMAÇÕES
====================================================== */

body.sem-animacoes *,
body.sem-animacoes *::before,
body.sem-animacoes *::after {
    animation: none !important;
    transition: none !important;
    scroll-behavior: auto !important;
}

/* =====================================================
   AJUSTES PARA CELULARES
====================================================== */

@media (max-width: 480px) {

    #acessibilidadeContainer {
        right: 12px;
        bottom: 12px;
    }

    #painelAcessibilidade {
        width: 280px;
        max-width: calc(100vw - 24px);
    }

}
</style>

<script>
(function () {

    "use strict";

    // =================================================
    // LOCALIZAR OS ELEMENTOS
    // =================================================

    const abrir = document.getElementById("abrirAcessibilidade");
    const painel = document.getElementById("painelAcessibilidade");
    const fechar = document.getElementById("fecharAcessibilidade");

    const aumentar = document.getElementById("aumentarFonte");
    const diminuir = document.getElementById("diminuirFonte");
    const contraste = document.getElementById("contraste");
    const animacoes = document.getElementById("animacoes");
    const restaurar = document.getElementById("restaurar");

    const mensagem = document.getElementById("mensagemAcessibilidade");

    // Evita erros caso o código seja colocado em uma página
    // sem o painel de acessibilidade.
    if (
        !abrir || !painel || !fechar ||
        !aumentar || !diminuir || !contraste ||
        !animacoes || !restaurar || !mensagem
    ) {
        return;
    }

    // =================================================
    // CONFIGURAÇÕES INICIAIS
    // =================================================

    const chavePreferencias = "mathplay_acessibilidade";

    let tamanhoFonte = 100;
    let altoContraste = false;
    let semAnimacoes = false;

    // =================================================
    // MOSTRAR MENSAGENS
    // =================================================

    function informar(texto) {
        mensagem.textContent = texto;
    }

    // =================================================
    // ABRIR E FECHAR O PAINEL
    // =================================================

    function abrirPainel() {
        painel.hidden = false;
        abrir.setAttribute("aria-expanded", "true");

        document.getElementById("aumentarFonte").focus();
    }

    function fecharPainel(devolverFoco = true) {
        painel.hidden = true;
        abrir.setAttribute("aria-expanded", "false");

        if (devolverFoco) {
            abrir.focus();
        }
    }

    abrir.addEventListener("click", function () {

        if (painel.hidden) {
            abrirPainel();
        } else {
            fecharPainel(false);
        }

    });

    fechar.addEventListener("click", function () {
        fecharPainel(true);
    });

    // Fecha o painel com a tecla Escape.
    document.addEventListener("keydown", function (evento) {

        if (evento.key === "Escape" && !painel.hidden) {
            fecharPainel(true);
        }

    });

    // =================================================
    // APLICAR O TAMANHO DA FONTE
    // =================================================

    function aplicarFonte() {

        document.documentElement.style.fontSize =
            tamanhoFonte + "%";

    }

    // Aumenta a fonte até 150%.
    aumentar.addEventListener("click", function () {

        tamanhoFonte = Math.min(tamanhoFonte + 10, 150);

        aplicarFonte();

        informar("Tamanho do texto: " + tamanhoFonte + "%.");

        salvarPreferencias();

    });

    // Diminui a fonte até 80%.
    diminuir.addEventListener("click", function () {

        tamanhoFonte = Math.max(tamanhoFonte - 10, 80);

        aplicarFonte();

        informar("Tamanho do texto: " + tamanhoFonte + "%.");

        salvarPreferencias();

    });

    // =================================================
    // ALTO CONTRASTE
    // =================================================

    function aplicarContraste() {

        document.body.classList.toggle(
            "alto-contraste",
            altoContraste
        );

        contraste.setAttribute(
            "aria-pressed",
            String(altoContraste)
        );

        contraste.textContent = altoContraste
            ? "Desativar alto contraste"
            : "Ativar alto contraste";

    }

    contraste.addEventListener("click", function () {

        altoContraste = !altoContraste;

        aplicarContraste();

        informar(
            altoContraste
                ? "Alto contraste ativado."
                : "Alto contraste desativado."
        );

        salvarPreferencias();

    });

    // =================================================
    // REDUZIR ANIMAÇÕES
    // =================================================

    function aplicarAnimacoes() {

        document.body.classList.toggle(
            "sem-animacoes",
            semAnimacoes
        );

        animacoes.setAttribute(
            "aria-pressed",
            String(semAnimacoes)
        );

        animacoes.textContent = semAnimacoes
            ? "Ativar animações"
            : "Reduzir animações";

    }

    animacoes.addEventListener("click", function () {

        semAnimacoes = !semAnimacoes;

        aplicarAnimacoes();

        informar(
            semAnimacoes
                ? "Animações reduzidas."
                : "Animações restauradas."
        );

        salvarPreferencias();

    });

    // =================================================
    // SALVAR AS PREFERÊNCIAS NO NAVEGADOR
    // =================================================

    function salvarPreferencias() {

        try {

            localStorage.setItem(
                chavePreferencias,
                JSON.stringify({
                    tamanhoFonte: tamanhoFonte,
                    altoContraste: altoContraste,
                    semAnimacoes: semAnimacoes
                })
            );

        } catch (erro) {

            // O painel continua funcionando mesmo se
            // o navegador bloquear o armazenamento.

        }

    }

    // =================================================
    // CARREGAR AS PREFERÊNCIAS SALVAS
    // =================================================

    function carregarPreferencias() {

        try {

            const salvas = localStorage.getItem(chavePreferencias);

            if (!salvas) {
                return;
            }

            const preferencias = JSON.parse(salvas);

            if (
                Number.isFinite(preferencias.tamanhoFonte) &&
                preferencias.tamanhoFonte >= 80 &&
                preferencias.tamanhoFonte <= 150
            ) {
                tamanhoFonte = preferencias.tamanhoFonte;
            }

            altoContraste = preferencias.altoContraste === true;
            semAnimacoes = preferencias.semAnimacoes === true;

        } catch (erro) {

            // Se os dados estiverem inválidos, utiliza
            // as configurações padrão.

            tamanhoFonte = 100;
            altoContraste = false;
            semAnimacoes = false;

        }

        aplicarFonte();
        aplicarContraste();
        aplicarAnimacoes();

    }

    // =================================================
    // RESTAURAR CONFIGURAÇÕES PADRÃO
    // =================================================

    restaurar.addEventListener("click", function () {

        tamanhoFonte = 100;
        altoContraste = false;
        semAnimacoes = false;

        aplicarFonte();
        aplicarContraste();
        aplicarAnimacoes();

        try {
            localStorage.removeItem(chavePreferencias);
        } catch (erro) {
            // Continua funcionando sem armazenamento.
        }

        informar("Configurações de acessibilidade restauradas.");

    });

    // Aplica as preferências quando a página é carregada.
    carregarPreferencias();

})();
</script>
</body>
</html>
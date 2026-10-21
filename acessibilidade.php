
<?php
// ==========================================================
// ESTUDAÊ - PAINEL DE ACESSIBILIDADE
// Fonte, alto contraste, redução de animações e restauração.
// ==========================================================
?>

<div id="acessibilidadeContainer">

    <button
        type="button"
        id="abrirAcessibilidade"
        aria-controls="painelAcessibilidade"
        aria-expanded="false"
    >
        ♿ Acessibilidade
    </button>

    <section
        id="painelAcessibilidade"
        aria-labelledby="tituloAcessibilidade"
        hidden
    >
        <h2 id="tituloAcessibilidade">Acessibilidade</h2>

        <p class="descricaoAcessibilidade">
            Personalize sua experiência no Estudaê!
        </p>

        <div class="botoesAcessibilidade">

            <button type="button" id="aumentarFonte">
                Aumentar texto A+
            </button>

            <button type="button" id="diminuirFonte">
                Diminuir texto A-
            </button>

            <button
                type="button"
                id="contraste"
                aria-pressed="false"
            >
                Ativar alto contraste
            </button>

            <button
                type="button"
                id="animacoes"
                aria-pressed="false"
            >
                Reduzir animações
            </button>

            <button type="button" id="restaurar">
                Restaurar padrão
            </button>

            <button type="button" id="fecharAcessibilidade">
                Fechar painel
            </button>

        </div>

        <p
            id="mensagemAcessibilidade"
            role="status"
            aria-live="polite"
        ></p>
    </section>

</div>

<style>
/* ==========================================================
   1. CONTAINER DO PAINEL
========================================================== */

#acessibilidadeContainer {
    position: fixed !important;
    top: auto !important;
    left: auto !important;
    right: 20px !important;
    bottom: 20px !important;

    z-index: 99999 !important;

    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;

    width: 340px;
    max-width: calc(100vw - 30px);

    font-family: Arial, Helvetica, sans-serif;
    box-sizing: border-box;
}

#acessibilidadeContainer * {
    box-sizing: border-box;
}

/* ==========================================================
   2. BOTÃO ABRIR ACESSIBILIDADE
========================================================== */

#abrirAcessibilidade {
    position: static !important;
    transform: none !important;

    display: block;
    flex: 0 0 auto;

    width: auto;
    max-width: 100%;
    min-height: 46px;

    margin: 0 !important;
    padding: 11px 17px;

    background: #ffffff;
    color: #202b50;

    border: 2px solid #444444;
    border-radius: 10px;

    font-size: 16px;
    font-weight: 700;

    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
}

/* ==========================================================
   3. PAINEL
========================================================== */

#painelAcessibilidade {
    position: static !important;
    inset: auto !important;
    transform: none !important;

    width: 100%;
    max-width: 100%;
    max-height: 72vh;

    overflow-y: auto;
    overscroll-behavior: contain;

    margin: 0 !important;
    padding: 20px !important;

    border: 2px solid #444444;
    border-radius: 16px;

    background: #ffffff;
    color: #222222;

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);

    flex-direction: column;
    gap: 12px;
}

#painelAcessibilidade[hidden] {
    display: none !important;
}

/* Título */
#tituloAcessibilidade {
    margin: 0 !important;
    color: #202b50;

    font-size: 26px;
    line-height: 1.3;
    font-weight: 700;
}

/* Descrição */
#painelAcessibilidade .descricaoAcessibilidade {
    margin: 0 !important;
    color: #292929;

    font-size: 17px;
    line-height: 1.5;
}

/* ==========================================================
   4. BOTÕES SEPARADOS
========================================================== */

#painelAcessibilidade .botoesAcessibilidade {
    display: flex !important;
    flex-direction: column !important;
    align-items: stretch;

    width: 100%;
    gap: 12px !important;

    margin: 0;
    padding: 0;
}

#painelAcessibilidade .botoesAcessibilidade button {
    position: static !important;
    inset: auto !important;
    transform: none !important;

    display: flex !important;
    flex: 0 0 auto;

    align-items: center;
    justify-content: center;

    width: 100% !important;
    min-width: 0;
    min-height: 50px;
    height: auto !important;

    margin: 0 !important;
    padding: 13px 12px !important;

    border: 2px solid #5044e8;
    border-radius: 10px;

    background: #5044e8;
    color: #ffffff;

    font-family: Arial, Helvetica, sans-serif;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.4;
    text-align: center;

    white-space: normal;
    overflow-wrap: anywhere;

    cursor: pointer;
}

#painelAcessibilidade #restaurar {
    margin-top: 5px !important;
    background: #343a58;
    border-color: #343a58;
}

#painelAcessibilidade #fecharAcessibilidade {
    margin-top: 2px !important;
    background: #292929;
    border-color: #292929;
}

#painelAcessibilidade button:hover {
    filter: brightness(0.88);
}

/* Foco de teclado */
#abrirAcessibilidade:focus-visible,
#painelAcessibilidade button:focus-visible {
    outline: 3px solid #ffbf47 !important;
    outline-offset: 3px;
}

/* Mensagem de retorno */
#mensagemAcessibilidade {
    margin: 0 !important;
    padding: 0;

    color: #202b50;
    font-size: 14px;
    line-height: 1.5;
}

/* ==========================================================
   5. ALTO CONTRASTE - CORREÇÃO PRINCIPAL
   Fundo preto e textos claros em toda a página.
========================================================== */

html body.alto-contraste {
    background: #000000 !important;
    background-image: none !important;
    color: #ffffff !important;
}

/* Remove fundos claros que poderiam esconder as letras.
   Não altera o conteúdo de imagens e vídeos. */
html body.alto-contraste *:not(img):not(video):not(iframe) {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;

    background-color: #000000 !important;
    background-image: none !important;

    border-color: #ffff00 !important;
    box-shadow: none !important;
    text-shadow: none !important;
}

/* Links amarelos para ficarem fáceis de identificar */
html body.alto-contraste a,
html body.alto-contraste a *,
html body.alto-contraste a:visited {
    color: #ffff00 !important;
    -webkit-text-fill-color: #ffff00 !important;
    text-decoration: underline !important;
}

/* Botões do site */
html body.alto-contraste button,
html body.alto-contraste input[type="button"],
html body.alto-contraste input[type="submit"],
html body.alto-contraste input[type="reset"],
html body.alto-contraste .btn,
html body.alto-contraste .botao {
    background: #000000 !important;
    color: #ffff00 !important;
    -webkit-text-fill-color: #ffff00 !important;

    border: 2px solid #ffff00 !important;
}

/* Garante a cor dos textos internos dos botões */
html body.alto-contraste button *,
html body.alto-contraste .btn *,
html body.alto-contraste .botao * {
    color: #ffff00 !important;
    -webkit-text-fill-color: #ffff00 !important;
}

/* Campos de texto, login, cadastro e respostas */
html body.alto-contraste input:not([type="checkbox"]):not([type="radio"]),
html body.alto-contraste textarea,
html body.alto-contraste select {
    background: #000000 !important;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;

    border: 2px solid #ffff00 !important;
    caret-color: #ffff00 !important;
}

/* Texto de orientação nos campos */
html body.alto-contraste input::placeholder,
html body.alto-contraste textarea::placeholder {
    color: #dddddd !important;
    -webkit-text-fill-color: #dddddd !important;
    opacity: 1 !important;
}

/* Caixas de seleção */
html body.alto-contraste input[type="checkbox"],
html body.alto-contraste input[type="radio"] {
    accent-color: #ffff00;
}

/* Foco bem visível para teclado */
html body.alto-contraste a:focus-visible,
html body.alto-contraste button:focus-visible,
html body.alto-contraste input:focus-visible,
html body.alto-contraste select:focus-visible,
html body.alto-contraste textarea:focus-visible {
    outline: 3px solid #00ffff !important;
    outline-offset: 3px !important;
}

/* Painel de acessibilidade */
html body.alto-contraste #painelAcessibilidade {
    background: #000000 !important;
    color: #ffffff !important;
    border: 3px solid #ffff00 !important;
}

html body.alto-contraste #tituloAcessibilidade,
html body.alto-contraste #painelAcessibilidade .descricaoAcessibilidade,
html body.alto-contraste #mensagemAcessibilidade {
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
}

/* Botão de abrir */
html body.alto-contraste #abrirAcessibilidade {
    background: #000000 !important;
    color: #ffff00 !important;
    -webkit-text-fill-color: #ffff00 !important;
    border: 2px solid #ffff00 !important;
}

/* Botões do painel */
html body.alto-contraste #painelAcessibilidade .botoesAcessibilidade button {
    background: #000000 !important;
    color: #ffff00 !important;
    -webkit-text-fill-color: #ffff00 !important;
    border: 2px solid #ffff00 !important;
}

/* Ícones SVG */
html body.alto-contraste svg {
    color: #ffff00 !important;
}

/* ==========================================================
   6. REDUZIR ANIMAÇÕES
========================================================== */

html.reduzir-animacoes *,
html.reduzir-animacoes *::before,
html.reduzir-animacoes *::after {
    animation: none !important;
    transition: none !important;
    scroll-behavior: auto !important;
}

/* ==========================================================
   7. RESPONSIVIDADE
========================================================== */

@media (max-width: 480px) {
    #acessibilidadeContainer {
        right: 12px !important;
        bottom: 12px !important;

        width: 310px;
        max-width: calc(100vw - 24px);
        gap: 10px;
    }

    #painelAcessibilidade {
        padding: 16px !important;
        max-height: 68vh;
    }

    #tituloAcessibilidade {
        font-size: 23px;
    }

    #painelAcessibilidade .descricaoAcessibilidade {
        font-size: 16px;
    }

    #painelAcessibilidade .botoesAcessibilidade {
        gap: 12px !important;
    }

    #painelAcessibilidade .botoesAcessibilidade button {
        min-height: 48px;
        padding: 12px 10px !important;
        font-size: 14px;
    }
}
</style>

<script>
(function () {
    "use strict";

    const container = document.getElementById(
        "acessibilidadeContainer"
    );

    if (!container || container.dataset.inicializado === "true") {
        return;
    }

    container.dataset.inicializado = "true";

    const botaoAbrir = container.querySelector(
        "#abrirAcessibilidade"
    );

    const painel = container.querySelector(
        "#painelAcessibilidade"
    );

    const aumentar = container.querySelector("#aumentarFonte");
    const diminuir = container.querySelector("#diminuirFonte");
    const contraste = container.querySelector("#contraste");
    const animacoes = container.querySelector("#animacoes");
    const restaurar = container.querySelector("#restaurar");

    const fechar = container.querySelector(
        "#fecharAcessibilidade"
    );

    const mensagem = container.querySelector(
        "#mensagemAcessibilidade"
    );

    if (
        !botaoAbrir || !painel || !aumentar || !diminuir ||
        !contraste || !animacoes || !restaurar || !fechar
    ) {
        return;
    }

    let tamanhoFonte = 100;

    const tamanhoMinimo = 80;
    const tamanhoMaximo = 150;
    const passoFonte = 10;

    function anunciar(texto) {
        if (mensagem) {
            mensagem.textContent = texto;
        }
    }

    function abrirPainel() {
        painel.hidden = false;

        botaoAbrir.setAttribute(
            "aria-expanded",
            "true"
        );
    }

    function fecharPainel() {
        painel.hidden = true;

        botaoAbrir.setAttribute(
            "aria-expanded",
            "false"
        );

        botaoAbrir.focus();
    }

    // ABRIR E FECHAR
    botaoAbrir.addEventListener("click", function () {
        if (painel.hidden) {
            abrirPainel();
        } else {
            fecharPainel();
        }
    });

    fechar.addEventListener("click", fecharPainel);

    // AUMENTAR TEXTO
    aumentar.addEventListener("click", function () {
        if (tamanhoFonte >= tamanhoMaximo) {
            anunciar("O texto já está no tamanho máximo.");
            return;
        }

        tamanhoFonte = Math.min(
            tamanhoFonte + passoFonte,
            tamanhoMaximo
        );

        document.documentElement.style.fontSize =
            tamanhoFonte + "%";

        anunciar("Tamanho do texto: " + tamanhoFonte + "%.");
    });

    // DIMINUIR TEXTO
    diminuir.addEventListener("click", function () {
        if (tamanhoFonte <= tamanhoMinimo) {
            anunciar("O texto já está no tamanho mínimo.");
            return;
        }

        tamanhoFonte = Math.max(
            tamanhoFonte - passoFonte,
            tamanhoMinimo
        );

        document.documentElement.style.fontSize =
            tamanhoFonte + "%";

        anunciar("Tamanho do texto: " + tamanhoFonte + "%.");
    });

    // ATIVAR E DESATIVAR ALTO CONTRASTE
    contraste.addEventListener("click", function () {
        const ativo = document.body.classList.toggle(
            "alto-contraste"
        );

        contraste.setAttribute(
            "aria-pressed",
            String(ativo)
        );

        contraste.textContent = ativo
            ? "Desativar alto contraste"
            : "Ativar alto contraste";

        anunciar(
            ativo
                ? "Alto contraste ativado."
                : "Alto contraste desativado."
        );
    });

    // REDUZIR ANIMAÇÕES
    animacoes.addEventListener("click", function () {
        const ativo = document.documentElement.classList.toggle(
            "reduzir-animacoes"
        );

        animacoes.setAttribute(
            "aria-pressed",
            String(ativo)
        );

        animacoes.textContent = ativo
            ? "Ativar animações"
            : "Reduzir animações";

        anunciar(
            ativo
                ? "Redução de animações ativada."
                : "Redução de animações desativada."
        );
    });

    // RESTAURAR CONFIGURAÇÕES
    restaurar.addEventListener("click", function () {
        tamanhoFonte = 100;

        document.documentElement.style.fontSize = "";

        document.body.classList.remove(
            "alto-contraste"
        );

        document.documentElement.classList.remove(
            "reduzir-animacoes"
        );

        contraste.setAttribute("aria-pressed", "false");
        contraste.textContent = "Ativar alto contraste";

        animacoes.setAttribute("aria-pressed", "false");
        animacoes.textContent = "Reduzir animações";

        anunciar(
            "Configurações de acessibilidade restauradas."
        );
    });

    // FECHAR COM ESC
    document.addEventListener("keydown", function (evento) {
        if (
            evento.key === "Escape" &&
            !painel.hidden
        ) {
            fecharPainel();
        }
    });
})();
</script>
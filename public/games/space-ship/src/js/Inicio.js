/*
Classe Inicio
    - Essa é reponsável por criar, animar, controlar e apagar os elementos da tela inicial do jogo
    - Essa classe é chamada por 'Main_.js'

Índice
    1. Atributos
        1.1 elementos_jquery → string de elementos a serem criados
        1.2 elemento_html_* → seleção dos elementos da página
    2. Métodos
        2.1 criar() → Cria elementos do inicio
        2.2 selecionar() → Seleciona os elementos que serão manipulados
        2.3 animar() → Anima os elementos da esquerda para o centro
        2.4 controlar() → Adiciona som no botão, e função no click do botão
        2.5 apagar() → Apaga os elementos do inicio para começar o jogo

*/
class Inicio {
    static elementos_jquery = `
    <div class="inicio" style="display: none">
        <div class="conteudo-inicio">
            <img src="/games/space-ship/src/img/logo.png" alt="">
            <br>
            <button>Iniciar</button>
        </div>
    </div>`;
    static elemento_html_inicio;
    static elemento_html_conteudoInicio;
    static elemento_html_botao;

    static criar() {
        $(".janela").append(this.elementos_jquery);
    }

    static selecionar() {
        this.elemento_html_inicio = document.querySelector(".inicio");
        this.elemento_html_conteudoInicio = document.querySelector(".conteudo-inicio");
        this.elemento_html_botao = document.querySelector(".conteudo-inicio").children[2];
    }

    static animar(tipo) {
        Inicio.selecionar();
        if (tipo == 1) {
            this.elemento_html_inicio.style = ""
            // Margem atual do elemento fora da tela (valor inicial)
            var margin = -415;
            // Loop com intervalo que diminui a margem até que os elementos estejam no centro
            var intervalo = setInterval(() => {
                // Incrementa margin
                margin++
                // Aplica estilização
                this.elemento_html_conteudoInicio.style = `margin: auto ${margin}px`
                // Quando o valor da margem atingir 130...
                if (margin == 130) {
                    // Para o loop
                    clearInterval(intervalo)
                    // Chama controlar()
                    this.controlar();
                }
            }, 1);
        }
    }

    static controlar() {
        var button_hover;
        var button_click;
        var button_out;

        // Adiciona som quando o usuário passa o mouse por cima do botão "iniciar"
        //  - Quando o usuário tira o mouse e coloca novamente, o som reinicia.
        this.elemento_html_botao.addEventListener("mouseover", () => {
            if (button_hover) {
                button_hover.pause()
            }
            button_hover = new Audio("src/sound/button-hover.mp3");
            button_hover.play()
        })

        // Adiciona som quando o usuário tira o mouse de cima do botão "iniciar"
        //  - Quando o usuário tira o ponteiro do mouse multiplas vezes, o som reinicia a cada vez.
        this.elemento_html_botao.addEventListener("mouseout", () => {
            if (button_out) {
                button_out.pause()
            }
            button_out = new Audio("/games/space-ship/src/sound/button-out.mp3");
            button_out.play()
        })

        // Adiciona função no click do botão iniciar.
        //  - Em resumo, adiciona som ao click do botão, apaga os elementos do menu inicial,
        //    e troca a direção que o fundo se move
        function handleClick() {
            console.log(`[Inicio] Iniciar`)
            Inicio.elemento_html_botao.removeEventListener("click", handleClick)
            button_click = new Audio("/games/space-ship/src/sound/button-click.mp3");
            button_click.play()

            window.pause = 1;
            setTimeout(() => {
                Janela.animar(2, "l")
            }, 13);

            Inicio.apagar();
        }
        this.elemento_html_botao.addEventListener("click", handleClick)
    }


    // Quando esse método é chamado, apaga os elementos do menu inicial e chama Jogo.criar(), iniciando o jogo.
    static apagar() {

        Inicio.elemento_html_inicio.addEventListener("animationend", () => {
            Inicio.elemento_html_inicio.remove()
        })

        Inicio.elemento_html_inicio.classList.add("some");
        Jogo.criar()
    }
}

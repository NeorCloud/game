/*
classe Analise
    - Essa classe é responsável por criar, controlar e apagar os elementos da analise dos planetas.
    - Fim estético
Índice
    1. Métodos
        1.1 Criar(tipo) → Cria elementos da classe analise
            1.1.1 Tipo 1 → Cria div.analisar>"aperte espaço para continuar"
            1.1.2 Tipo 2 → Cria div.barra-analise
        1.2 controlar(tipo) → Adiciona função e anima elementos.
            1.2.1 Tipo 1 → Apaga div.analisar>"#", toca audio do scan e chama criar(2)
            1.2.2 Tipo 2 → Adiciona animação de ↓↑ para barra-analise depois apaga elementos
        1.3 apagar() → Apaga elementos da analise quando não são mais necessários
 */

class Analise {
    static criar(tipo) {
        switch (tipo) {
            case 1:
                var botaoAnalise = `
                <div class="analisar">
                            <p>Aperte</p>
                            <img src="/games-files/space-ship/src/img/espaco_verde.png" alt="">
                            <p>para analisar <br> o planeta.</p>
                        </div>
                `
                $(".planetarea").prepend(botaoAnalise)
                Analise.controlar(1)
                break;
            case 2:
                var barraAnalise = $("<div></div>", { class: "barra-analise" })
                $(".jogo").prepend(barraAnalise)
                Analise.controlar(2)
                break;
        }
    }

    static controlar(tipo) {
        switch (tipo) {
            case 1:
                function keyHandle(e) {
                    // Quando o usuário apertar [Espaço]
                    if (e.keyCode == 32) {
                        // Remove o tutorial de analise
                        $(".analisar")[0].remove()
                        var audio = new Audio('src/sound/scan.mp3')
                        // Cria a barra de analise
                        Analise.criar(2)
                        // Toca um audio
                        audio.volume = 0.5;
                        audio.play()
                        // Remove listener
                        document.querySelector("body").removeEventListener("keydown", keyHandle)
                    }
                }
                document.querySelector("body").addEventListener("keydown", keyHandle)
                break;
            case 2:
                console.log(`[#${Jogo.faseAtual}] Analise iniciada`)
                function animationHandle() {
                    // Quando a animação da barra de analise terminar
                    // Cria a caixa de informações do planeta da fase atual
                    Planeta.criar(Jogo.faseAtual, 2)
                    // Remove listener
                    document.querySelector(".barra-analise").removeEventListener("animationend", animationHandle)
                    // Remove barra de analise
                    $(".barra-analise")[0].remove()
                    // Aguarda meio segundo e...
                    setTimeout(() => {
                        // Adiciona função no click do botão da caixa de análise
                        Planeta.controlar()
                    }, 500);

                }
                document.querySelector(".barra-analise").addEventListener("animationend", animationHandle)
                break;
        }
    }

    static apagar() {
        // Seleciona e apaga elementos de analise.
        var barra = document.querySelector(".barra-analise");
        barra.addEventListener("animationend", () => {
            barra.remove()
        })
    }
}

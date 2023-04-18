/*
Classe NaveInimiga
    - Essa classe é responsável por criar, controlar, animar e apagar os elementos que constituem as naves inimigas

Índice
    1. Atributos
        1.1 Elemento_jquery_enemyarea → String dos elementos a serem criados '.enemyArea'
        1.2 elemento_jquery_nave → String dos elementos a serem criados '.ship.enemy'
        1.3 audioExplosao → Audio da explosão da nave
        1.4 elementos_html_* → Atributos que selecionam os elementos criados anteriormente
        1.5 estado → Essa variável determina se a nave está ativa/viva. 0/1 - desligado/ligado
    2. Métodos
        2.1 criar() →
            2.1.1 function single() →
            2.1.2 function multiple() →
        2.2 selecionar() →
        2.3 explodir() →
*/
class NaveInimiga {
    static ship_placeholder;
    static elemento_jquery_enemyArea = `
    <div class="enemyArea">
        <div class="shipBay __1"></div>
        <div class="shipBay __2"></div>
        <div class="shipBay __3"></div>
        <div class="shipBay __4"></div>
        <div class="shipBay __5"></div>
        <div class="shipBay __6"></div>
        <div class="shipBay __7"></div>
        <div class="shipBay __8"></div>
        <div class="shipBay __9"></div>
    </div>
    `;
    static elemento_jquery_nave = `
    <div class="ship enemy">
        <img src="/games-files/space-ship/src/img/ship-enemy.png" value="1">
    </div>`
    static audio = new Audio('/games/space-ship/src/sound/boom.wav')
    static audioGun = new Audio('/games/space-ship/src/sound/shootEnemy.mp3')
    static elemento_html_enemyArea;
    static elemento_html_enemyShipbay;
    static estado = 1;

    static criar(arg) {
        // Cria elementos do Campo inimigo.
        $(".jogo").append(NaveInimiga.elemento_jquery_enemyArea);
        // Verifica se existe mais de 1 inimigo em campo
        arg.toString().split('') > 1 ? single() : multiple();

        // Cria elementos da(s) nave(s) inimiga(s).
        function single() {
            $(`.__${arg}`).append(NaveInimiga.elemento_jquery_nave)
        }
        function multiple() {
            NaveInimiga.selecionar()
            for (let inimigo = 0; inimigo <= arg.length - 1; inimigo++) {
                $(`.__${arg[inimigo]}`).append(NaveInimiga.elemento_jquery_nave)
            }
        }
    }

    static selecionar() {
        this.elemento_html_enemyArea = $(".enemyArea")
        this.elemento_html_enemyShipbay = document.querySelectorAll(".shipBay")
    }

    static ativar() {
        this.selecionar();

        // Gera os intervalos para os tiros.
        // Resumindo, existe um intervalo pai para fazer simular recarga de munição e
        //            um intervalo filho que faz cada par de naves atirar.
        //            A cada execução, o par interno mais próximo do par da execução
        //            anterior atira. Quando resta o quadrante número 5, somente ele é ativado.

        disparar()
        // Esse intervalo verifica se ainda existem inimigos em campo, caso sim, executa um loop para atirar
        var intervalo = setInterval(() => {
            // Começa com 9 inimigos, por conta das 9 casas
            var inimigos = 9
            for (let i = 0; i <= 8; i++) {
                // Executa 9 vezes buscando por inimigos, sempre que não encontra, desconta 1 do valor 9
                if (NaveInimiga.elemento_html_enemyArea[0].children[i].children.length == 0)
                    inimigos--
            }
            // Se ainda existirem inimigos depois da verificação
            if (inimigos > 0) {
                // Dispara
                disparar()
            } else {
                // Do contrario, para o intervalo p/ prosseguir de fase.
                clearInterval(intervalo)
            }
        }, 400 * 5 * 1.5);

        // Essa função controla a ordem de disparo [| 1-9 | 2-8 | 3-7 | 4-6 | 5 |]
        function disparar() {
            NaveInimiga.audioGun.volume = 0.05
            var a = 1
            var b = 9
            var intervalo = setInterval(() => {
                if (a != b) {
                    if (NaveInimiga.elemento_html_enemyShipbay[a - 1].children.length > 0) {
                        // console.log("Nave casa " + a + " disparou.")
                        var tiro = new TiroInimigo(a - 1)
                    } else {
                    }
                    if (NaveInimiga.elemento_html_enemyShipbay[b - 1].children.length > 0) {
                        // console.log("Nave casa " + b + " disparou.")
                        var tiro = new TiroInimigo(b - 1)
                    } else {
                    }
                    if (NaveInimiga.elemento_html_enemyShipbay[b - 1].children.length > 0 ||
                        NaveInimiga.elemento_html_enemyShipbay[a - 1].children.length > 0) {
                            if (NaveInimiga.audioGun.paused == false){
                                NaveInimiga.audioGun.currentTime = 0
                            }else{
                                NaveInimiga.audioGun.play()
                            }
                        // console.log("---------------------------")
                    }
                } else {
                    if (NaveInimiga.elemento_html_enemyShipbay[b - 1].children.length > 0) {
                        if (NaveInimiga.audioGun.paused == false){
                            NaveInimiga.audioGun.currentTime = 0
                        }else{
                            NaveInimiga.audioGun.play()
                        }
                        // console.log("Nave casa " + a + " disparou.")
                        var tiro = new TiroInimigo(a - 1)
                        // console.log("---------------------------")
                    }
                    clearInterval(intervalo)
                }
                a <= 5 ? a++ : a = 5;
                b >= 5 ? b-- : b = 5;
            }, 400);

        }
    }

    static explodir(nave) {
        // Elemento correspondente a nave inimiga a ser destruida
        var atual = $(".shipBay")[nave].children[0];
        // Emite som de explosão apenas uma vez se for atingida
        if (atual.value != 0) {
            this.audio.volume = 0.1
            this.audio.play()
            atual.value = 0
        }

        console.log(`[#${Jogo.faseAtual}] Nave no quadrante ${nave + 1} atingida.`)

        // Troca de imagem fazendo uma animação de explosão
        var img = 0;
        // Em resumo, faz um loop com intervalo que da a impressão de animação
        var intervalo = setInterval(() => {
            if (atual) {
                img++
                atual.children[0].src = `/games/space-ship/src/img/boom_${img}.png`
                // quando terminar a animação, apaga o elemento e para o intervalo.
                if (img == 8) {
                    atual.remove();

                    if (NaveInimiga.estado != 1) {
                    } else {
                        NaveInimiga.estado = 0
                        Jogo.verificaInimigos()
                    }
                    setTimeout(() => {
                        NaveInimiga.estado = 1
                    }, 602);
                    clearInterval(intervalo)
                }
            }
        }, 100);
    }
}

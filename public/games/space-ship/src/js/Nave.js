/*
classe Nave
    - Essa classe é responsável por criar, mover, animar e destruir a nave ALIADA
Índice
    1. Atributos
        1.1 elemento_jquery → String com elementos da nave a ser criada
        1.2/3 elementos_html → Elementos html atribuidos as variaveis do tipo '_html'
        1.4 statusX → Estado de movimento no eixo X (0 → desligado | 1 → ligado)
        1.5 statusY → Estado de movimento no eixo Y (0 → desligado | 1 → ligado)
        1.6 x → Posição atual do eixo X
        1.7 y → Posição atual do eixo Y
        1.8 shootCooldown → Recarga do tiro (0 → Não está em recarga | 1 → Está em recarga)
        1.9 shootState → Nave está atirando (0 → false | 1 → true)
    2. Métodos
        2.1 criar() → Cria elementos da classe nave
        2.2 selecionar() → Seleciona e atribui elementos
        2.3 controlar() → Inicia o jogo a primeira vez que a nave for criada
        2.4 mover_X() → Move a nave no eixo X
        2.5 mover_y() → Move a nave no eixo Y
        2.6 atirar() → Faz a nave atirar
        2.7 destruir() → Destroi e chama reposição da nave
*/
class Nave {
    static elemento_jquery = `
    <div class = "ship ally"><img src="/games/space-ship/src/img/ship-ally.png" alt=""></div>
    `;

    // Elementos visuais
    static elemento_html_playArea;
    static elemento_html_nave;
    // Elementos lógicos
    static statusX = 0;
    static statusY = 0;
    static x = 209;
    static y = 0;
    static shootCooldown = 0;
    static shootState = 0
    static vulneravel = true
    static audio = new Audio('/games/space-ship/src/sound/boom.wav');
    static criar() {
        if (Jogo.faseAtual <= 0){
            $(".playarea").append(this.elemento_jquery);
        }else{
            $(".playarea").prepend(this.elemento_jquery);
        }
        this.selecionar();
    }

    static selecionar() {
        this.elemento_html_nave = document.querySelector(".ally");
        this.controlar();
    }

    static controlar() {
        this.elemento_html_nave.addEventListener("animationend", () => {
            if (Jogo.faseAtual == 0){
                Jogo.iniciar()
            }else{
                // TODO: Ativar movimentação da nave e adicionar classe de blink
                Jogo.enableMove = 1
                setTimeout(() => {
                    console.log("VULNERAVEL NOVAMENTE")
                    Nave.vulneravel = true;
                }, 3000);
            }
        });
    }

    static mover_x(direcao) {
        // Direções: 0 - Parado | 1 - Direita | 2 - Esquerda

        // Parar eixo x
        if (direcao == 0) {
            Nave.statusX = 0;

        }
        // Mover eixo x
        else if (direcao > 0) {
            Nave.statusX = 1;
            anima(direcao)

        }

        // Inicia animação
        function anima() {
            var intervalo = setInterval(() => {
                // Para animação se statusX = 0
                if (Nave.statusX == 0) {
                    clearInterval(intervalo)
                } else {
                    // Se for 1, move para a direita;
                    if (direcao == 1) {
                        // Limita o tanto que pode se mover pra direita
                        if (Nave.x < 210) {
                            Nave.x++
                            Nave.elemento_html_nave.style.left = `${Nave.x}px`
                        }
                    }
                    // Se for 2, move para a esquerda;
                    else if (direcao == 2) {
                        if (Nave.x > 0) {
                            Nave.x--
                            Nave.elemento_html_nave.style.left = `${Nave.x}px`
                        }
                    }
                }
            }, 1);
        }
    }

    static mover_y(direcao) {

        // Direções: 0 - Parado | 1 - Cima | 2 - Baixo

        // Parar eixo Y
        if (direcao == 0) {
            Nave.statusY = 0;
        }
        // Mover eixo Y
        else if (direcao > 0) {
            Nave.statusY = 1;
            anima(direcao)

        }

        // Inicia animação
        function anima() {
            var intervalo = setInterval(() => {
                // Para a animação se statusY = 0
                if (Nave.statusY == 0) {
                    clearInterval(intervalo)
                } else {
                    // Se a direção for 1, move para cima
                    if (direcao == 1) {
                        if (Nave.y > -215) {
                            Nave.y--
                            Nave.elemento_html_nave.style.top = `${Nave.y}px`
                        }
                    }
                    // Se a direção for 2, move para baixo
                    else if (direcao == 2) {
                        if (Nave.y < 215) {
                            Nave.y++
                            Nave.elemento_html_nave.style.top = `${Nave.y}px`
                        }
                    }
                }
            }, 1);
        }

    }

    static atirar(e) {
        var intervalo = setInterval(() => {
            // Se a nave estiver com shootState = 1
            if (Nave.shootState == 1) {
                // E o tiro não estiver em recarga
                if (Nave.shootCooldown == 0) {
                    // Cria instância de tiro
                    var tiro = new Tiro(`${Nave.x - 25} ,${Nave.y}`, 1)
                    // Coloca recarga = 1
                    Nave.shootCooldown = 1
                    // E com um temporizador de .6s
                    setTimeout(() => {
                        // tira a recarga
                        Nave.shootCooldown = 0
                    }, 600);
                }
            } else {
                // Se shootState = 0, para de atirar.
                clearInterval(intervalo)
            }
        }, 1);
    }

    static explodir(){
        Nave.vulneravel = false;
        Jogo.enableMove = 0
        this.audio.play()
        var img = 0;
        var intervalo = setInterval(() => {
            img++;
            Nave.elemento_html_nave.children[0].src = `/games/space-ship/src/img/boom_${img}.png`
            if (img == 8){
                Nave.elemento_html_nave.remove()
                Nave.x = 210;
                Nave.y = 0;
                clearInterval(intervalo)
                setTimeout(() => {
                    Nave.criar()
                }, 100);
            }
        }, 100);
    }
}

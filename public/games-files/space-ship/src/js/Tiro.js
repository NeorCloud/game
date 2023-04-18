/*
classe Tiro
    - Uma instância dessa classe é criada a cada tiro que a nave aliada executa.
    - Cada uma dessas instâncias fica relacionada com seu respectivo elemento html.
Índice
    1. Atributos
        1.1 static elemento_jquery_tiro → Div.tiro a ser criada
        1.2 static id → ID global, salvo independente da instância atual
        1.3 static audio → Audio do tiro
        1.4 id → ID da instância
        1.5 posicao → Posição que o tiro é criado
        1.6 x → Posição no eixo X do tiro
        1.7 y →  Posição no eixo Y do tiro
        1.8 elemento_html → Elemento html referente a instância atual de tiro
    2. Métodos
        2.1 criar() → Cria elemento de tiro baseado na posição atual da Nave aliada
            2.1.1 function verificaTiro() → Verica se o Y do tiro criado agora é compatível com a posição de uma
                                            nave inimiga, assim, quando o X do tiro for igual a posição x da nave
                                            inimiga, ela irá explodir.
        2.2 selecionar() → Método utilizado para atribuir o elemento criado por essa classe a uma variavel, fazendo um link
                           entre a instância e um elemento no documento.
*/
class Tiro {
    static elemento_jquery_tiro = $('<div>', { class: "tiro" })
    static id = 0;
    static audio = new Audio("/games/space-ship/src/sound/shoot.mp3");
    id;
    posicao;
    tipo;
    x;
    y;
    elemento_html;

    constructor(posicao, tipo) {
        this.posicao = posicao;
        this.tipo = tipo;
        Tiro.id++
        this.id = Tiro.id;
        this.criar()
    }

    criar() {
        // Cria elementos
        $(".gun")[0] == null ? $("<div>", { class: "gun" }).appendTo(".playarea") : null;
        $("<div>", { class: "tiro", id: this.id }).appendTo(".gun");
        if (Tiro.audio.paused) {
            // Emite som de tiro
            Tiro.audio.volume = 0.08
            Tiro.audio.play()
        } else {
            // Caso já haja um som sendo emitido, recomeça ele se houver outra execução.
            Tiro.audio.currentTime = 0
        }
        // Define posição que deverá ser criado a partir da posição atual do player
        this.x = parseInt(this.posicao.toString().split(',')[0])
        this.y = parseInt(this.posicao.toString().split(',')[1])
        // Seleciona elemento html equivalente a essa instância
        var atual = this.selecionar();
        //
        // Define a posição da nave.
        atual.style.top = this.y + "px"
        atual.style.left = this.x + "px"
        // Mostra o tiro
        atual.style.opacity != "100%" ? atual.style.opacity = "100%" : 0;

        var intervalo = setInterval(() => {
            // Enquanto o tiro for visivel na tela...
            if (this.x < 680) {
                // Move o tiro para a direita
                this.x++
                atual.style.left = this.x + "px"
                // Quando o tiro chega em campo inimigo
                if (atual.style.left == "582px") {
                    // Verifica se atingiu algum inimigo
                    verificarTiro()
                }
            }
            // Quando o tiro sai de enquadramento
            else {
                // Remove e limpa intervalo
                atual.remove()
                clearInterval(intervalo)
            }
        }, 1);

        var y = this.y
        // Verifica se essa instância de Tiro acertou um alvo
        function verificarTiro() {
            var campo = document.querySelector(".enemyArea")
            var nave = document.querySelectorAll(".shipBay")
            // Valores do primeiro quadrante de inimigos:
            var teto = -223
            var chao = -176
            // Verifica todos os quadrantes inimigos a busca de naves.
            for (let i = 0; i <= campo.children.length - 1; i++) {
                // Quando acha um quadrante que tem nave...
                if (nave[i].children.length > 0) {
                    //    Verifica se essa instância de tiro tem Y dentro do quadrante inimigo
                    // que possui a nave.
                    if (y >= `${teto + (i * 50)}` &&
                        y <= `${chao + (i * 50)}`) {
                        // Tiro acertou um inimigo.
                        // Remove o tiro da tela
                        atual.remove()
                        // Explode a nave atingida
                        NaveInimiga.explodir(i)
                    } else {
                        // Tiro não acertou um inimigo.
                    }
                }
            }
        }
    }

    // Método utilizado para atribuir essa instância de Tiro a um elemento .tiro no html.
    // Utiliza o ID da nave criada no html.
    selecionar() {
        this.elemento_html = document.querySelectorAll(".tiro")
        for (let i = 0; i <= this.elemento_html.length - 1; i++) {
            if (this.elemento_html[i].id == this.id) {
                return this.elemento_html[i];
            }
        }
    }
}

/* 
Classe Janela
    - Essa classe é responsável por criar e animar a janela principal.
    - Essa classe é invocada através do arquivo "Main_.js".

Índice
   1 Atributos
       1.1 elemento_jquery → string 'sect.janela'
       1.2 elemento_html → Elemento .janela no html
   2 Métodos
       2.1 criar() → Utilizando jquery, cria o elemento armazenado como string no this.elemento_jquery
       2.2 selecionar() → Seleciona o .janela no html e armazena em this.elemento_html
       2.3 animar() → Anima a abertura da janela, depois chama 
           2.3.1 tipo 1 → Anima a abertura da janela
           2.3.2 tipo 2 → Anima o background
       */
class Janela {
    static elemento_jquery = `
        <section class="janela" style="margin-top:350px">
        </section>`;
    static elemento_html_janela;
    static posicaoBkg = 0;
    
    static criar() {
        $("main").append(this.elemento_jquery);
        Janela.selecionar();

    }

    static selecionar() {
        this.elemento_html_janela = document.querySelector(".janela");
        setTimeout(() => {
            Janela.animar(1);
        }, 250);
    }

    static animar(tipo, arg) {
        // Tipos: 1 - Abrir janela; 2 - Animar background;

        // Abrir janela
        if (tipo == 1) {
            // Valores Iniciais da janela
            var altura = 0;
            var largura = 0;
            var margin = 350;

            // Loop com intervalo
            var intervalo = setInterval(() => {

                // Aumento dos valores a cada execução do loop
                altura += 2;
                largura += 3.111
                margin -= 1;
                // Atualiza os valores no elemento a cada execução do loop
                this.elemento_html_janela.style = `height: ${altura}px; width: ${largura}px;margin-top: ${margin}px;`;

                // Finaliza o loop quando o valor desejado for atingido, no caso 450.
                if (altura == 450) {
                    // Limpa
                    clearInterval(intervalo);
                    // Formatação final, adiciona classe 'aberta' e limpa a estilização da animação.
                    this.elemento_html_janela.classList.add("aberta")
                    this.elemento_html_janela.style = "";
                    // Chama Inicio.anima(), para mostrar o conteudo do 'inicio'
                    Inicio.animar(1);
                    // Anima o background sentido R
                    Janela.animar(2, 'r')
                    // Cria elemento nav-header, controladores.
                    Navegacao.criar(1)
                }
            }, 2);
        }

        // Animar background;
        window.pause = 0 // Essa variavel serve para pausar o background

        if (tipo == 2) {
            // Loop com intervalo()
            var intervalo = setInterval(() => {
                // Argumento R: Faz o background mover-se para a direita
                if (arg == "r") {
                    Janela.posicaoBkg++;
                    // Argumento L: Faz o background mover-se para a esquerda
                } else if (arg == "l") {
                    Janela.posicaoBkg--;
                }
                // Altera a posição do background a cada execução
                this.elemento_html_janela.style = `background-position-x: ${Janela.posicaoBkg}px;`

                // Função que faz o background parar
                if (window.pause == 1) {
                    clearInterval(intervalo)
                }
            }, 1);
        }
    }
}

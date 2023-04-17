class TiroInimigo {
    static elemento_jquery = ``
    static id = 0;
    elemento_html;
    id;
    x;
    nave;

    constructor(nave) {
        TiroInimigo.id++
        this.id = TiroInimigo.id
        this.nave = nave
        this.criar()
    }

    criar() {
        var campo = document.querySelectorAll(".shipBay")
        $("<div>", { class: "tiroInimigo", id: this.id }).appendTo(campo[this.nave].children[0]);
        this.controlar();
    }

    controlar() {
        var atual = this.selecionar()
        var nave = this.nave
        animar()

        var x = 10;
        function animar() {
            var intervalo = setInterval(() => {
                if (x < 645) {
                    atual.style = `left: ${x}px`
                    if (x >= 395 && Nave.vulneravel == true){
                        verificaTiro()
                    }
                } else {
                    atual.remove();
                    clearInterval(intervalo)
                }
                x++;
            }, 1);
        }

        function verificaTiro() {
            var nave = document.querySelector(".ally").getBoundingClientRect();
            var tiro = atual.getBoundingClientRect();

            if (nave.bottom >= tiro.bottom &&
                nave.top <= tiro.top) {
                if (Math.floor(nave.right) == Math.floor(tiro.left)) {        
                    Nave.explodir()
                    atual.remove()
                    console.log("Nave aliada atingida.  ")
                }
            }
        }
    }

    selecionar() {
        this.elemento_html = document.querySelectorAll(".tiroInimigo")
        for (let i = 0; i <= this.elemento_html.length - 1; i++) {
            if (this.elemento_html[i].id == this.id) {
                return this.elemento_html[i];
            }
        }
    }
}
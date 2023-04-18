/*
Classe Tutorial
    - Essa classe é responsável por criar, selecionar e apagar os elementos do Tutorial.
*/
class Tutorial {
    static tipo = 0;
    static elemento_tutorial_jquery;
    static elemento_tutorial_html;

    static criar(tipo) {
        this.selecionar(tipo)
        $(".jogo").prepend(this.elemento_tutorial_jquery)
    }
    
    static selecionar(tipo) {
        this.tipo = tipo;
        this.elemento_tutorial_jquery = `
            <div class="tutorial _${this.tipo}"></div>
        `
        this.elemento_tutorial_html = $(".tutorial")
    }

    static apagar() {
        this.selecionar()
        this.elemento_tutorial_html.remove()
    }
}
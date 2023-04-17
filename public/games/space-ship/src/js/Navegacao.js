/*
Classe Navegacao
    - Essa classe é responsável por criar, controlar e apagar os elementos de Navegação.
    - Essa classe é chamada pelos arquivos "Janela.js" e "Incio.js".

Índice
    1 Atributos
        1.1 elemento_jquery_head → string elemento '.nav-header'
        1.2 elemento_html_head_home → elemento html .home
        1.3 elemento_html_head_volumeContainer → elemento html .volume-container
        1.4 elemento_html_head_barraVolume → elemento html input[type=range]
    2 Métodos
        2.1 criar(tipo) → Cria elementos da classe
        2.2 selecionar() → Atribui o campo html aos atributos _html
        2.3 controlar() → Adiciona função aos itens da navegação.
   */
class Navegacao {
    static elemento_jquery_head = `
    <section class="nav-header">
        <div class="left">
            <a href="" class="nav-header-item home">
                <img src="/games/space-ship/src/img/home.png">
            </a>
            <div class="volume-container">
                <a class="nav-header-item volume">
                    <img src="/games/space-ship/src/img/volume_1.png" alt="">
                </a>
                <input type="range" min="0" max="100" value="5">
            </div>
        </div>
        <div class="right">
            <a href="https://github.com/FabioV37ga/Sistema-Solar" class="nav-header-item git"><img src="/games/space-ship/src/img/git.svg" alt=""></a>
        </div>
    </section>
    `;

    static elemento_html_head_home;
    static elemento_html_head_volumeContainer;
    static elemento_html_head_barraVolume;


    static criar() {
        $(this.elemento_jquery_head).insertBefore(".janela");
        this.selecionar();
    }

    static selecionar() {
        this.elemento_html_head_home = document.querySelector(".home")
        this.elemento_html_head_volumeContainer = document.querySelector(".volume-container")
        this.elemento_html_head_barraVolume = document.querySelector(".volume-container").children[1]

        this.controlar();
    }

    static controlar() {

        // ICONE VOLUME
        var barraDeslizante = this.elemento_html_head_barraVolume;
        var volumeContainer = this.elemento_html_head_volumeContainer;
        //     → Mostra o range de volume quando mouseover
        volumeContainer.addEventListener("mouseover", () => {
            barraDeslizante.style = "display: initial;"
        })
        //     → Esconde o range de volume quando mouseover
        volumeContainer.addEventListener("mouseout", () => {
            barraDeslizante.style = "display: none;"
        })
        //     → Coloca função no click do volume
        volumeContainer.children[0].addEventListener("click", () => {
            //          → Alterna entre MUTE e VOL=5, trocando para as imagens respectivas.
            if (window.audioStatus == 1) {
                barraDeslizante.value = 0
                window.audio.volume = 0;
                window.audioStatus = 0;
                volumeContainer.children[0].children[0].src = "/games/space-ship/src/img/volume_0.png"
                window.localStorage.setItem('soundtrack_volume', 0)
                window.localStorage.setItem('soundtrack_volume_pic', "/games/space-ship/src/img/volume_0.png")
            } else {
                barraDeslizante.value = 5
                window.audio.volume = 0.05
                window.audioStatus = 1;
                volumeContainer.children[0].children[0].src = "/games/space-ship/src/img/volume_1.png"
            }
        })

        // LOCALSTORAGE: Define os valores de volume & aparencia do ultimo uso da página, caso existam.
        var volumeAnterior = window.localStorage.getItem("soundtrack_volume")
        volumeAnterior != null ? barraDeslizante.value = volumeAnterior * 100 : '';
        var volumeFotoAnterior = window.localStorage.getItem("soundtrack_volume_pic")
        volumeFotoAnterior != null ? volumeContainer.children[0].children[0].src = volumeFotoAnterior : '';

        //     → Coloca função no range de volume
        barraDeslizante.addEventListener("input", () => {
            //          → Sempre que o usuário mover o range, faz volume = range.value
            window.audio.volume = barraDeslizante.value / 100
            window.localStorage.setItem('soundtrack_volume', window.audio.volume)
            //          → Sessão responsável por trocar as imagens do icone de volume dependendo no volume:
            //          VOL = 0
            if (barraDeslizante.value == 0) {
                volumeContainer.children[0].children[0].src = "/games/space-ship/src/img/volume_0.png"
                window.localStorage.setItem('soundtrack_volume_pic', "/games/space-ship/src/img/volume_0.png")
                window.audioStatus = 0;
            } else {
                window.audioStatus = 1;
            }

            //          VOL = 1-35
            if (barraDeslizante.value <= 35
                && barraDeslizante.value > 0) {
                volumeContainer.children[0].children[0].src = "/games/space-ship/src/img/volume_1.png"
                window.localStorage.setItem('soundtrack_volume_pic', "/games/space-ship/src/img/volume_1.png")
                //          VOL = 36-75
            } else if (barraDeslizante.value > 35
                && barraDeslizante.value <= 75) {
                volumeContainer.children[0].children[0].src = "/games/space-ship/src/img/volume_2.png"
                window.localStorage.setItem('soundtrack_volume_pic', "/games/space-ship/src/img/volume_2.png")
                //          VOL = 76-100
            } else if (barraDeslizante.value > 75
                && barraDeslizante.value <= 100) {
                volumeContainer.children[0].children[0].src = "/games/space-ship/src/img/volume_3.png"
                window.localStorage.setItem('soundtrack_volume_pic', "/games/space-ship/src/img/volume_3.png")
            }
        })
    }
}

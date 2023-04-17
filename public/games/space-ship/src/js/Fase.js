/*
classe Fase
    - Essa classe é responsável por controlar as funcionalidades da fase, como adicionar e ativar inimigos, tempo de viajem, etc.
Índice
    1. Atributos
        1.1 Progressao → Esse atributo determina se a progressão da fase está ativada [0 - 1]
        1.2 numero → Número dessa instância da fase
        1.3 inimigos → String dos inimigos dessa instância da fase
        1.4 duracao → Duração dos tempos de viagem dessa instância da fase
        1.5 planeta → Armazenado como número, refere ao planeta atual dessa instância da fase
        1.6 estado → Determina o estado da fase. [0 → Confronto | 1 → Planeta]
    2. Métodos
        2.1 iniciar() → Liga a progressão, chama Jogo.viajar() para animar fundo e Fase.viajar() para iniciar temporizador
        2.2 viajar(tipo) → Adiciona um temporizador que chama uma parte da fase
            2.2.1 Tipo 1 → Adiciona um temporizador para ir ao confronto
            2.2.2 Tipo 2 → Adiciona um temporizador para ir ao planeta
*/
class Fase {
    static progressao = 0;
    numero;
    inimigos;
    duracao;
    planeta;
    estado;

    constructor(numero, inimigos, duracao) {
        this.numero = numero;
        this.inimigos = inimigos.split('').length > 1 ? inimigos.split(",") : inimigos
        this.duracao = duracao.split('').length > 1 ? duracao.split(",") : duracao
        this.planeta = numero;
        this.estado = 0
        this.iniciar()
    }

    iniciar() {
        // LOGS
        console.log(`[#${Jogo.faseAtual}] Fase iniciada. \n`)
        console.log(`[#${Jogo.faseAtual}] Viagem inciada: Planeta anterior → Confronto atual \n`)
        // Liga a progressão
        Fase.progressao = 1
        // Adiciona temporizar para chegar na proxima etapa da fase
        this.viajar(1)
        // Anima, enquanto o temporizador durar, o background na direção da progressão
        Jogo.viajar()
    }

    viajar(arg) {
        switch (arg) {
            case 1:
                this.estado = 0
                setTimeout(() => {
                    // LOGS
                    console.log(`[#${Jogo.faseAtual}] Viagem Finalizada: Planeta anterior → Confronto atual \n`)
                    console.log(`[#${Jogo.faseAtual}] Confronto iniciado\n`)

                    // Cria naves inimigas
                    NaveInimiga.criar(this.inimigos)

                    // Quando a animação da nave inimiga terminar...
                    document.querySelector(".enemyArea").addEventListener("animationend", () => {
                        // Toma decisão com base na fase atual.
                        // Fase 1: Mostra o tutorial de combate
                        if (this.numero == 1) {
                            Jogo.tutorial(2)
                        }
                        // Fase 2: Mostra o tutorial de inimigos
                        else if (Jogo.faseAtual == 2) {
                            // TODO: Tutorial de tiro inimigo
                            // fim do tutorial: NaveInimiga.ativar()
                            Jogo.tutorial(3)
                        }
                        // Fase 3+: Apenas ativa nave inimiga
                        else {
                            NaveInimiga.ativar()
                        }
                    })
                }, parseInt(this.duracao[0]) * 1000);
                break;
            case 2:
                // Permite apenas uma execução dessa função
                if (this.estado == 0) {
                    this.estado = 1
                    // LOGS
                    console.log(`[#${Jogo.faseAtual}] Confronto: Todos os inimigos foram eliminados.`)
                    console.log(`[#${Jogo.faseAtual}] Viagem Iniciada: Confronto atual → Planeta atual \n`)
                    console.log(`[#${Jogo.faseAtual}] Planeta: planeta criado. \n`)
                    // Cria o planeta da fase atual
                    Planeta.criar(Jogo.faseAtual, 1)
                    // Utiliza temporizador para executar:
                    //      1. Animação de entrada do planeta
                    setTimeout(() => {
                        console.log(`[#${Jogo.faseAtual}] Planeta: Planeta movendo\n`)
                        Planeta.mostrar()
                    }, parseInt((this.duracao[1]) * 1000) - 2000);
                    //      2. Planeta é centralizado, progressão desligada 
                    setTimeout(() => {
                        console.log(`[#${Jogo.faseAtual}] Planeta: Planeta centralizado\n`)
                        console.log(`[#${Jogo.faseAtual}] Viagem Finalizada: Confronto atual → Planeta atual \n`)
                        Fase.progressao = 0
                    }, parseInt(this.duracao[1]) * 1000);
                }
                break;
        }
    }

}
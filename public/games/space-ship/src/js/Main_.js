// Inicio da página
// Carrega soundtrack
window.audio = new Audio('/games/space-ship/src/sound/soundtrack.mp3');
var documento = document

// Função que força usuário a interagir com a página, dessa maneira permitindo o .play()
//  - Em resumo, espera que o usuário aperte ESPAÇO ou ENTER, para assim criar os elementos da janela.
//  - Além disso, chama o método para criar o menu inicial e cria a trilha sonora.
function handleKeydown(e) {
  // Espaço ou Enter
  if (e.keyCode == 32 || e.keyCode == 13) {
    document.querySelector("#comecar").remove()

    Janela.criar()
    Inicio.criar()
    window.audio.play();

    /*
        Essa parte define o volume da triha sonora baseada no último valor colocado pelo usuário, caso
      o usuário já tenha acessado anteriormente.
    */
    if (window.localStorage.getItem("soundtrack_volume") === null) {
      window.audio.volume = 0.05
    } else {
      window.audio.volume = window.localStorage.getItem("soundtrack_volume")
    }
    window.audioStatus = 1

    // Faz a trilha sonora ficar em loop
    audio.addEventListener('ended', function () {
      this.currentTime = 0;
      this.play();
    });

    documento.removeEventListener('keydown', handleKeydown);
  }
}
documento.addEventListener("keydown", handleKeydown);

class AudioController {
  constructor() {
    this.bgMusic = new Audio(
      "https://github.com/jasonrouss/Christmas-Kids-Game/blob/master/audio/backgroundMusic.m4a?raw=true"
    );
    this.flipSound = new Audio(
      "https://raw.githubusercontent.com/WebDevSimplified/Mix-Or-Match/master/Assets/Audio/flip.wav"
    );
    this.matchSound = new Audio(
      "https://github.com/jasonrouss/Christmas-Kids-Game/blob/master/audio/cheeringAudio.mp3?raw=true"
    );
    this.victorySound = new Audio(
      "https://raw.githubusercontent.com/WebDevSimplified/Mix-Or-Match/master/Assets/Audio/victory.wav"
    );
    this.gameOverSound = new Audio("Assets/Audio/gameOver.wav");
    this.bgMusic.volume = 0.5;
    this.bgMusic.loop = true;
  }
  startMusic() {
    this.bgMusic.play();
  }
  stopMusic() {
    this.bgMusic.pause();
    this.bgMusic.currentTime = 0;
  }
  flip() {
    this.flipSound.play();
  }
  match() {
    this.matchSound.play();
  }
  victory() {
    this.stopMusic();
    this.victorySound.play();
  }
  gameOver() {
    this.stopMusic();
    this.gameOverSound.play();
  }
}

class MixOrMatch {
  constructor(totalTime, cards) {
    this.cardsArray = cards;
    this.totalTime = totalTime;
    this.timeRemaining = totalTime;
    this.timer = document.getElementById("time-remaining");
    this.ticker = document.getElementById("flips");
    this.audioController = new AudioController();
  }

  startGame() {
    this.totalClicks = 0;
    this.timeRemaining = this.totalTime;
    this.cardToCheck = null;
    this.matchedCards = [];
    this.busy = true;
    this.audioController.startMusic();
    setTimeout(() => {
      this.shuffleCards(this.cardsArray);
      this.countdown = this.startCountdown();
      this.busy = false;
    }, 500);
    this.hideCards();
    this.timer.innerText = this.timeRemaining;
    this.ticker.innerText = this.totalClicks;
  }
  startCountdown() {
    return setInterval(() => {
      this.timeRemaining--;
      this.timer.innerText = this.timeRemaining;
      if (this.timeRemaining === 0) this.gameOver();
    }, 1000);
  }
  gameOver() {
    clearInterval(this.countdown);

    document.getElementById("game-over-text").classList.add("visible");
  }
  victory() {
    clearInterval(this.countdown);
    this.audioController.victory();
    document.getElementById("victory-text").classList.add("visible");
  }
  hideCards() {
    this.cardsArray.forEach((card) => {
      card.classList.remove("visible");
      card.classList.remove("matched");
    });
  }
  flipCard(card) {
    if (this.canFlipCard(card)) {
      this.audioController.flip();
      this.totalClicks++;
      this.ticker.innerText = this.totalClicks;
      card.classList.add("visible");

      if (this.cardToCheck) {
        this.checkForCardMatch(card);
      } else {
        this.cardToCheck = card;
      }
    }
  }
  checkForCardMatch(card) {
    if (this.getCardType(card) === this.getCardType(this.cardToCheck))
      this.cardMatch(card, this.cardToCheck);
    else this.cardMismatch(card, this.cardToCheck);

    this.cardToCheck = null;
  }
  cardMatch(card1, card2) {
    this.matchedCards.push(card1);
    this.matchedCards.push(card2);
    card1.classList.add("matched");
    card2.classList.add("matched");
    this.audioController.match();
    if (this.matchedCards.length === this.cardsArray.length) this.victory();
  }
  cardMismatch(card1, card2) {
    this.busy = true;
    setTimeout(() => {
      card1.classList.remove("visible");
      card2.classList.remove("visible");
      this.busy = false;
    }, 1000);
  }
  shuffleCards(cardsArray) {
    for (let i = cardsArray.length - 1; i > 0; i--) {
      const randIndex = Math.floor(Math.random() * (i + 1));
      [cardsArray[i], cardsArray[randIndex]] = [
        cardsArray[randIndex],
        cardsArray[i],
      ];
    }
    cardsArray = cardsArray.map((card, index) => {
      card.style.order = index;
    });
  }
  getCardType(card) {
    return card.getElementsByClassName("card-value")[0].src;
  }
  canFlipCard(card) {
    return (
      !this.busy &&
      !this.matchedCards.includes(card) &&
      card !== this.cardToCheck
    );
  }
}

if (document.readyState == "loading") {
  document.addEventListener("DOMContentLoaded", ready);
} else {
  ready();
}

function ready() {
  let overlays = Array.from(document.getElementsByClassName("overlay-text"));
  let cards = Array.from(document.getElementsByClassName("card"));
  let game = new MixOrMatch(100, cards);

  overlays.forEach((overlay) => {
    overlay.addEventListener("click", () => {
      overlay.classList.remove("visible");
      game.startGame();
    });
  });

  cards.forEach((card) => {
    card.addEventListener("click", () => {
      game.flipCard(card);
    });
  });
}
function playAudioBot() {
  var bottes = document.getElementById("bottes");
  bottes.play();
}
function playAudioBot1() {
  var bottes1 = document.getElementById("bottes1");
  bottes1.play();
}

function playAudioBou() {
  var boule = document.getElementById("boule");
  boule.play();
}
function playAudioBou1() {
  var boule1 = document.getElementById("boule1");
  boule1.play();
}

function playAudioCad() {
  var cadeau = document.getElementById("cadeau");
  cadeau.play();
}
function playAudioCad1() {
  var cadeau1 = document.getElementById("cadeau1");
  cadeau1.play();
}

function playAudioEto() {
  var etoile = document.getElementById("etoile");
  etoile.play();
}
function playAudioEto1() {
  var etoile1 = document.getElementById("etoile1");
  etoile1.play();
}

function playAudioLut() {
  var lutin = document.getElementById("lutin");
  lutin.play();
}

function playAudioLut1() {
  var lutin1 = document.getElementById("lutin1");
  lutin1.play();
}

function playAudioRei() {
  var reinne = document.getElementById("reinne");
  reinne.play();
}
function playAudioRei1() {
  var reinne1 = document.getElementById("reinne1");
  reinne1.play();
}

function playAudioSap() {
  var sapin = document.getElementById("sapin");
  sapin.play();
}
function playAudioSap1() {
  var sapin1 = document.getElementById("sapin1");
  sapin1.play();
}
function playAudioTra() {
  var trainneau = document.getElementById("trainneau");
  trainneau.play();
}
function playAudioTra1() {
  var trainneau1 = document.getElementById("trainneau1");
  trainneau.play();
}

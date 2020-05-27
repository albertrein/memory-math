/* Engine do jogo */
let quantidadeCartasAtivas = 0;
        let startGame = () => {
            startTimer();
            registrarPontuacao(0);
            cartas.forEach((obj) => {
                makeElement(obj.value, obj.key);
            });
            quantidadeCartasAtivas = cartas.length / 2;
        }    
        let timer = document.querySelector('#timerCounter');
        let timerCounter = regras.timer * 1000;
        let tempoPerguntaAleatoria = Math.floor(Math.random() * (regras.timer - 10) + 10);
        let primeiraJogada = null;
        let timerIntervalValue = null;
        let startTimer = () => {
            timerIntervalValue = setInterval(() => {
                if((tempoPerguntaAleatoria * 1000) == timerCounter){
                    clearInterval(timerIntervalValue);
                    document.getElementById('dialog-rounded').showModal();
                }
                timer.textContent = timerCounter/1000;
                timerCounter -= 1000;

                if(timerCounter < 0){
                    clearInterval(timerIntervalValue);
                    endGame();
                    return;
                }
            },1000)
        }

        let endGame = async () => {
            await savePoints(usuario, parseInt(localStorage.getItem("pontuacaoAtual")));
            alert("Fim de jogo!");
            window.location.href = "index.html";
        }

        let registrarPontuacao = (pontos) => {
            let pontuacaoAtual = parseInt(localStorage.getItem("pontuacaoAtual")) + pontos;
            localStorage.setItem("pontuacaoAtual", pontuacaoAtual);
            //document.querySelector('#pontuacaoAtual').textContent = pontuacaoAtual; 
        }

        let verificaFimDaEtapa = () => {            
            if(quantidadeCartasAtivas <= 0){
                //registrarPontuacao(regras.pontuacaoPorEtapa);
                alert("Fim da etapa");
                window.location.reload();
            }
        }

        let verificaSeCartasSaoIguais = (card1, card2, callback) => new Promise((resolve, reject) => {
            if(card1.getAttribute("key") == card2.getAttribute("key")){
                registrarPontuacao(10);
                quantidadeCartasAtivas--;
                resolve();
            }else{
                card1.className = "card";
                card2.className = "card";
                resolve();
            }
        });

        let makeMove = (card) => {
            card.className += " show"
            
            if(!primeiraJogada){
                primeiraJogada = card;
                return;
            }
            setTimeout(async () => {
                await verificaSeCartasSaoIguais(primeiraJogada, card);                    
                verificaFimDaEtapa();                
                primeiraJogada = null;
                card = null;
            },350)
            
        }

        let makeElement = (text, key) => {
            let newCard = document.createElement('div');
            newCard.classList = "card";
            newCard.textContent = text;
            newCard.setAttribute('key', key);
            newCard.addEventListener('click',(el) => {
                makeMove(el.target)
            });
            containerElement.appendChild(newCard);
        }

        let containerElement = document.querySelector('.nes-container');

        let respondePerguntaAleatoria = () => {
            let resposta = document.querySelector('#inputPergunta').value;
            if(resposta === respotaParaPerguntaAleatoria){
                let arrayCartasNaoSelecionadas = Array.from(document.querySelectorAll(".card")).filter(item => !item.classList[1]);
                if(arrayCartasNaoSelecionadas.length <= 2){
                    startTimer();
                    return;
                }                
                arrayCartasNaoSelecionadas[0].className += " show";
                let atributoKeyPrimeiraCarta = arrayCartasNaoSelecionadas[0].getAttribute("key");
                for(i = 1; i < arrayCartasNaoSelecionadas.length; i++){
                    if(atributoKeyPrimeiraCarta == arrayCartasNaoSelecionadas[i].getAttribute("key")){
                        arrayCartasNaoSelecionadas[i].className += " show";
                        registrarPontuacao(10);
                        quantidadeCartasAtivas--;
                        verificaFimDaEtapa();
                    }
                }
            }
            startTimer();
        }

        let pularPergunta = () => {
            document.getElementById('dialog-rounded').close();
            startTimer();
        } 

        let savePoints = (nome, pontos) => new Promise(async (resolve, reject) => {
            let params = {
                method: 'POST',
                body: JSON.stringify({"nome": nome, "pontos": pontos})
            };
            await fetch("./backend/atualizarpontos.php",params);
            resolve();
        }) 
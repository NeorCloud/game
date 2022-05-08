<!DOCTYPE html>
<html>
<head>
    <title>Basic Snake HTML Game</title>
    <meta charset="UTF-8">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            background: black;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        canvas {
            border: 1px solid white;
        }

        table, th, td {
            border: 1px solid white;
            color: white;
        }

        span {
            color: white;
        }
    </style>
</head>
<body>
<div id="div">
    <span>Enter Your Nickname:</span>
    <input type="text" id="name" autofocus>
    <button type="button" id="button">start</button>
</div>
<div id="game" style="display: none; margin-left: 100px;">
    <canvas width="400" height="400" id="canvas" style="display: inline-block;"></canvas>
    <div style="width: 400px; height: 400px; display: inline-block; margin-left: 100px;">
        <table width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>game_id</th>
                <th>nickname</th>
                <th>score</th>
                <th>duration</th>
                <th>date</th>
            </tr>
            </thead>
            <tbody id="tbody"></tbody>

        </table>
    </div>
</div>
<script>
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');

    var grid = 16;
    var count = 0;

    // statistic variables
    var eaten = 0;
    var nickname = '';
    var duration = 0;
    var start = 0;
    var end = 0;

    // api variables
    var gameID = '';

    var snake = {
        x: 160,
        y: 160,

        // snake velocity. moves one grid length every frame in either the x or y direction
        dx: grid,
        dy: 0,

        // keep track of all grids the snake body occupies
        cells: [],

        // length of the snake. grows when eating an apple
        maxCells: 4
    };
    var apple = {
        x: 320,
        y: 320
    };

    // get random whole numbers in a specific range
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }

    // game loop
    function loop() {
        requestAnimationFrame(loop);

        // slow game loop to 15 fps instead of 60 (60/15 = 4)
        // also we can calibrate it as the speed of snake
        if (++count < 10) {
            return;
        }

        count = 0;
        context.clearRect(0, 0, canvas.width, canvas.height);

        // move snake by its velocity
        snake.x += snake.dx;
        snake.y += snake.dy;

        // wrap snake position horizontally on edge of screen
        if (snake.x < 0) {
            snake.x = canvas.width - grid;
        } else if (snake.x >= canvas.width) {
            snake.x = 0;
        }

        // wrap snake position vertically on edge of screen
        if (snake.y < 0) {
            snake.y = canvas.height - grid;
        } else if (snake.y >= canvas.height) {
            snake.y = 0;
        }

        // keep track of where snake has been. front of the array is always the head
        snake.cells.unshift({x: snake.x, y: snake.y});

        // remove cells as we move away from them
        if (snake.cells.length > snake.maxCells) {
            snake.cells.pop();
        }

        // draw apple
        context.fillStyle = 'red';
        context.fillRect(apple.x, apple.y, grid - 1, grid - 1);

        // draw snake one cell at a time
        context.fillStyle = 'green';
        snake.cells.forEach(function (cell, index) {

            // drawing 1 px smaller than the grid creates a grid effect in the snake body so you can see how long it is
            context.fillRect(cell.x, cell.y, grid - 1, grid - 1);

            // snake ate apple
            if (cell.x === apple.x && cell.y === apple.y) {
                snake.maxCells++;

                // canvas is 400x400 which is 25x25 grids
                apple.x = getRandomInt(0, 25) * grid;
                apple.y = getRandomInt(0, 25) * grid;
                eaten++;
                sendData(eaten);
            }

            // check collision with all cells after this one (modified bubble sort)
            for (var i = index + 1; i < snake.cells.length; i++) {

                // snake occupies same space as a body part. reset game
                if (cell.x === snake.cells[i].x && cell.y === snake.cells[i].y) {
                    alert('Tnx for playing... Your score was:' + eaten);
                    sendData(eaten);
                    snake.x = 160;
                    snake.y = 160;
                    snake.cells = [];
                    snake.maxCells = 4;
                    snake.dx = grid;
                    snake.dy = 0;
                    eaten = 0;
                    duration = 0;
                    gameID = '';
                    createGame();

                    apple.x = getRandomInt(0, 25) * grid;
                    apple.y = getRandomInt(0, 25) * grid;
                }
            }
        });
    }

    // listen to keyboard events to move the snake
    document.addEventListener('keydown', function (e) {
        // prevent snake from backtracking on itself by checking that it's
        // not already moving on the same axis (pressing left while moving
        // left won't do anything, and pressing right while moving left
        // shouldn't let you collide with your own body)

        // left arrow key
        if (e.which === 37 && snake.dx === 0) {
            snake.dx = -grid;
            snake.dy = 0;
        }
        // up arrow key
        else if (e.which === 38 && snake.dy === 0) {
            snake.dy = -grid;
            snake.dx = 0;
        }
        // right arrow key
        else if (e.which === 39 && snake.dx === 0) {
            snake.dx = grid;
            snake.dy = 0;
        }
        // down arrow key
        else if (e.which === 40 && snake.dy === 0) {
            snake.dy = grid;
            snake.dx = 0;
        }
    });

    // start the game
    document.getElementById("button").addEventListener("click", function () {
        if (document.getElementById("name").value != '') {
            nickname = document.getElementById("name").value;
            document.getElementById("div").style.display = 'none';
            document.getElementById("game").style.display = 'block';
            createGame();
            setInterval(getTableData, 2000);
            requestAnimationFrame(loop);
        } else {
            alert('Enter Your Correct Nickname!Please!');
        }
    });

    function sendData(snake_eaten_number) {
        end = new Date().getTime();
        duration = (end - start) / 1000;
        fetch('/api/gameLogs/' + gameID, {
            method: 'post',
            body: JSON.stringify({
                'score': snake_eaten_number,
                'duration': duration,
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function (response) {

        }).catch(function (exception) {
            console.log(exception);
        });
    }

    function createGame() {
        fetch('/api/games/1', {
            method: 'POST',
            body: JSON.stringify({
                'nickname': nickname,
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
            .then(function (data) {
                gameID = data.id;
                start = new Date().getTime();
            })
            .catch(function (exception) {
                console.log('err')
                console.log(exception);
            });
    }

    function getTableData() {
        fetch('/api/games/1/leaderboard', {
            method: 'GET',
        }).then(response => response.json())
            .then(function (data) {
                var table = document.getElementById("tbody");
                while (table.hasChildNodes()) {
                    table.removeChild(table.firstChild);
                }
                var flag = false;
                data.forEach(function (row) {
                    if(row.id == gameID){
                        flag = true;
                    }
                });
                if(flag) {
                    var i = 1;
                    data.forEach(function (row) {
                        createRow(table, row, i, gameID);
                        i++;
                    });
                } else {
                    var i = 1;
                    data.forEach(function (row) {
                        if(i < 6){
                            createRow(table, row, i, gameID);
                            i++;
                        }
                    });
                    for (var i = 0; i < 3; i++) {
                        var tr1 = document.createElement('tr');
                        var dot = document.createElement('span');
                        dot.innerHTML = '.';
                        tr1.appendChild(dot);
                        table.appendChild(tr1);
                    }
                    var row = {
                        'id': gameID,
                        'nickname': nickname,
                        'score': eaten,
                        'duration': duration,
                    }
                    createRow(table, row, '#', gameID);
                }
            })
            .catch(function (exception) {
                console.log('err in leaderboard')
                console.log(exception);
            });

    }

    function createRow(table, row, ranking, game_id = null) {
        var tr = document.createElement('tr');
        var rank = document.createElement('td');
        rank.innerHTML = ranking;
        if (row.id == game_id) {
            tr.style.backgroundColor = '#ffc107';
            tr.style.color = 'black';
        }
        var id = document.createElement('td');
        id.innerHTML = row.id;
        var nickname = document.createElement('td');
        nickname.innerHTML = row.nickname;
        var score = document.createElement('td');
        score.innerHTML = row.score;
        var duration = document.createElement('td');
        duration.innerHTML = row.duration;
        var created_at = document.createElement('td');
        created_at.innerHTML = row.created_at;
        tr.appendChild(rank);
        tr.appendChild(id);
        tr.appendChild(nickname);
        tr.appendChild(score);
        tr.appendChild(duration);
        tr.appendChild(created_at);
        table.appendChild(tr);
    }
</script>
</body>
</html>

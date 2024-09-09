let cell1 = document.getElementById("1");
let cell2 = document.getElementById("2");
let cell3 = document.getElementById("3");
let cell4 = document.getElementById("4");
let cell5 = document.getElementById("5");
let cell6 = document.getElementById("6");
let cell7 = document.getElementById("7");
let cell8 = document.getElementById("8");
let cell9 = document.getElementById("9");

let player1 = "";
let player2 = "";
let currentPlayer = "player1";
let selectedSquares = [];
let gameActive = true;

const Player = (player) => {
    return player;
};

const checkWin = () => {
    const winConditions = [
        [cell1, cell2, cell3],
        [cell4, cell5, cell6],
        [cell7, cell8, cell9],
        [cell1, cell4, cell7],
        [cell2, cell5, cell8],
        [cell3, cell6, cell9],
        [cell1, cell5, cell9],
        [cell3, cell5, cell7]
    ];

    for (let condition of winConditions) {
        if (condition[0].innerHTML && condition[0].innerHTML === condition[1].innerHTML && condition[0].innerHTML === condition[2].innerHTML) {
            return condition[0].innerHTML;
        }
    }
    return false;
};

const handleCellClick = (cell) => {
    if (cell.innerHTML === "" && gameActive) {
        cell.innerHTML = currentPlayer === "player1" ? "X" : "O";
        selectedSquares.push(cell.id);
        const winner = checkWin();
        if (winner) {
            document.querySelector(".PlayerStatus").innerHTML = `${winner} wins!`;
            gameActive = false;
        } else if (selectedSquares.length === 9) {
            document.querySelector(".PlayerStatus").innerHTML = "It's a draw!";
        }
        currentPlayer = currentPlayer === "player1" ? "player2" : "player1";
    }
};

const resetGame = () => {
    selectedSquares = [];
    gameActive = true;
    document.querySelector(".PlayerStatus").innerHTML = "";
    [cell1, cell2, cell3, cell4, cell5, cell6, cell7, cell8, cell9].forEach(cell => {
        cell.innerHTML = "";
    });
};

const changeName = () => {
    const player1 = document.getElementsByClassName("player1").value
    const player2 = document.getElementsByClassName("player2").value

    document.querySelector(".PlayerStatus").innerHTML = `${player1} vs ${player2}`;

    resetGame();
}

cell1.addEventListener("click", () => handleCellClick(cell1));
cell2.addEventListener("click", () => handleCellClick(cell2));
cell3.addEventListener("click", () => handleCellClick(cell3));
cell4.addEventListener("click", () => handleCellClick(cell4));
cell5.addEventListener("click", () => handleCellClick(cell5));
cell6.addEventListener("click", () => handleCellClick(cell6));
cell7.addEventListener("click", () => handleCellClick(cell7));
cell8.addEventListener("click", () => handleCellClick(cell8));
cell9.addEventListener("click", () => handleCellClick(cell9));

document.querySelector(".resetBtn").addEventListener("click", resetGame);

document.querySelector(".PlayerStatus").innerHTML = `${player1} vs ${player2}`;

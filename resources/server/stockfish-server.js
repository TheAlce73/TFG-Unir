const express = require('express');
const bodyParser = require('body-parser');
const { spawn } = require('child_process');
const path = require('path');

const app = express();
const PORT = 3000;

// Reemplaza con la ruta al ejecutable de Stockfish en tu sistema
const STOCKFISH_PATH = path.resolve('A:\\DAW\\xampp\\xampp\\htdocs\\TFG - UNIR\\ProyectoDaw\\resources\\server\\stockfish');  // En Windows
// const STOCKFISH_PATH = '/usr/local/bin/stockfish';  // En macOS o Linux

app.use(bodyParser.json());

app.post('/move', (req, res) => {
    const fen = req.body.fen;
    const stockfish = spawn(STOCKFISH_PATH);

    stockfish.stdin.write(`position fen ${fen}\n`);
    stockfish.stdin.write('go movetime 2000\n');

    stockfish.stdout.on('data', (data) => {
        const output = data.toString();
        const bestMove = output.split('\n').find(line => line.startsWith('bestmove'));
        if (bestMove) {
            const move = bestMove.split(' ')[1];
            res.json({ bestMove: move });
            stockfish.kill();
        }
    });

    stockfish.stderr.on('data', (data) => {
        console.error(`stderr: ${data}`);
    });

    stockfish.on('error', (error) => {
        console.error(`error: ${error.message}`);
        res.status(500).send(error.message);
    });

    stockfish.on('close', (code) => {
        console.log(`child process exited with code ${code}`);
    });
});

app.listen(PORT, () => {
    console.log(`Stockfish server listening at http://localhost:${PORT}`);
});

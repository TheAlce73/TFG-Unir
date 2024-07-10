const express = require('express');
const cors = require('cors');
const { spawn } = require('child_process');
const bodyParser = require('body-parser');

const app = express();
const enginePath = 'A:\\DAW\\xampp\\xampp\\htdocs\\TFG - UNIR\\ProyectoDaw\\node_modules\\stockfish\\src\\stockfish-nnue-16'; // Ajusta esta ruta según la ubicación real
const engine = spawn(enginePath);

app.use(cors({
  origin: 'http://192.168.1.153' // Cambia esto según tu configuración
}));

app.use(bodyParser.json());

app.post('/move', (req, res) => {
  const { moves } = req.body;

  engine.stdin.write('uci\n');
  engine.stdin.write('ucinewgame\n');
  engine.stdin.write('isready\n');
  engine.stdin.write(`position startpos moves ${moves.join(' ')}\n`);
  engine.stdin.write('go movetime 1000\n');

  engine.stdout.on('data', (data) => {
    const output = data.toString();
    if (output.includes('bestmove')) {
      const bestMove = output.split(' ')[1];
      res.json({ move: bestMove });
    }
  });
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Stockfish server listening at http://localhost:${PORT}`);
});

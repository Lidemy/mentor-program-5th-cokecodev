/*
好多星星
輸入為一個數字 N，請按照規律輸出正確圖形
*/

const readline = require('readline')

const lines = []
const rl = readline.createInterface({
  input: process.stdin
})

rl.on('line', (line) => {
  lines.push(line)
})

rl.on('close', () => {
  solve(lines)
})

// 拿到資料
function solve(lines) {
  const n = lines[0].split(' ')
  let result = ''
  for (let i = 0; i < n; i++) {
    result += '*'
    console.log(result)
  }
}

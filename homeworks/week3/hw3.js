/* 判斷質數
針對每一筆輸入，如果 P 是質數，輸出：Prime，否之則輸出 Composite
（附註：Composite 是合數的意思，不過有一點要注意的是 1 不是質數也不是合數，但在這一題裡面一樣要輸出Composite）
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
  for (let j = 1; j < lines.length; j++) {
    const input = Number(lines[j])
    console.log((isprime(input)) ? 'Prime' : 'Composite')
  }
}
/*
質數 = 整除自己的除了1和自己以外沒有別人
找出可以整除的數，同時判斷是不是自己
不是的話就是質數
*/
function isprime(n) {
  if (n === 1) return false
  for (let i = 2; i < n; i++) {
    if (n % i === 0) return false
  }
  return true
}

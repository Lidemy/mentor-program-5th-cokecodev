/* eslint-enable */
/* 水仙花數

水仙花數（Narcissistic number）又被稱為自戀數或者是阿姆斯壯數，太數學的定義我們就不講了，詳情可以查維基百科。
比較白話的定義為：「一個 n 位數的數字，每一個數字的 n 次方加總等於自身」
例如說 153 是三位數，而 1^3 + 5^3 + 3^3 = 1531
而 1634 是四位數，而 1^4 + 6^4 + 3^4 + 4^4 = 16341
而數字 0~9 也都是水仙花數，因為一位數 n 的 1 次方一定會等於自己
現在給你一個範圍 n 到 m，請你求出這範圍之中的水仙花數有哪些
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
/* eslint-enable */

// 拿到資料
function solve(lines) {
  const temp = lines[0].split(' ')
  const n = Number(temp[0])
  const m = Number(temp[1])
  for (let i = n; i <= m; i++) {
    if (isNarci(i)) {
      console.log(i)
    }
  }
}
function isNarci(n) {
  const str = n.toString()
  const digits = str.length
  let sum = 0
  for (let i = 0; i < str.length; i++) {
    sum += Number(str[i]) ** digits
  }
  return n === sum
}

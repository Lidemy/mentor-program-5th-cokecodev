/*  聯誼順序比大小
Input
輸入第一行會是一個數字 M，1 <= M <= 50，代表一共有幾組比賽的結果

接著每一行會有三個用空白分隔的數字 A, B, K

A 代表 A 選擇的數字，B 代表 B 選擇的數字，兩者皆保證為正整數
要特別注意的是 A 與 B 可能是很大的數字，但保證長度為 512 個位數以內

K 只會有兩種情況：1 或是 -1，若是 1 代表數字大的獲勝，K 若是 -1 代表數字小的獲勝

Output
針對每一筆輸入，請輸出贏家是誰。
若是 A 贏請輸出 A，B 贏請輸出 B，平手則輸出 DRAW

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
    const temp = lines[j].split(' ')
    const a = (temp[0])
    const b = (temp[1])
    const k = Number(temp[2])
    console.log(whoWins(a, b, k))
  }
}

function whoWins(a, b, k) {
  if (a === b) return 'DRAW'
  if (k === -1) {
    const holdonnum = a
    a = b
    b = holdonnum
  }
  const A = a.length
  const B = b.length
  if (A !== B) {
    return A > B ? 'A' : 'B'
  }
  return a > b ? 'A' : 'B'
}

/* 問題釐清嚕
測試之後發現思考的漏洞應該是在我一整個誤會比字典序的意思
(想說字典序位數少的也在前面，應該直接比就行了吧)

但實際上字串比大小會直接從第一個數字開始比，
而不是會比整個字串長度，
------------------------------------------------------------
所以位數比較多，但第一個位數的數值比較小，就會被判別成比較小的數字
比方說 console.log('52345'>'6215'?'true':'false')
會是FALSE
------------------------------------------------------------
所以如果是同樣長度的字串就可以達到我要的效果了。

--> 一開始的錯誤寫法
function whoWins(a,b,k) {
if ( a === b ) return'DRAW'
if (k === 1) {
  return (a > b ? 'A':'B')
}
if (k === -1) {
  return (a < b ? 'A':'B')
}
}
*/

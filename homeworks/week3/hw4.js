/*  判斷迴文

Description
迴文的定義很簡單，就是你把一個字串倒過來以後還是長的跟原字串一樣
舉例來說，aba 倒過來還是 aba，我們就稱 aba 為迴文
abab 倒過來變成 baba，跟原本的字串不一樣，就不是迴文
現在給你一個字串 S，請輸出 S 是否為迴文
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
  const imfor = lines[0]
  console.log((Palindrome(imfor) === imfor) ? 'True' : 'False')
}

function Palindrome(str) {
  let ans = ''
  for (let i = str.length - 1; i >= 0; i--) {
    ans += str[i]
  }
  return ans
}

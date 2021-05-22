
function reverse(str) {
 let ans = ''
 for (let i = str.length- 1; i >= 0; i--) {
     ans += str[i]
 }
 console.log(ans)
}
reverse('1abc2');





/*
## hw3：反轉字串
給定一個字串，請「印出」反轉之後的樣子（不能使用內建的 `reverse` 函式）

```
reverse('yoyoyo')
正確輸出：oyoyoy

reverse('1abc2')
正確輸出：2cba1

*/
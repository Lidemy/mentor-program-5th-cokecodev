```
// 題目

for(var i=0; i<5; i++) {
  console.log('i: ' + i)
  setTimeout(() => {
    console.log(i)
  }, i * 1000)
}

```
step 1：初始化 建立 globalEC。建立 scopeChain 跟 globalEC AO{} 。

step 2: 在 globalEC AO{} 裡面記錄下: " 有個變數 i，值是 undefined "

step 3：跳進去迴圈。開始跑第一圈 ( 注意：這時候 i 被賦值，從undefined 變成 0 了 ) ，然後往下執行到 `console.log('i: ' + i)` ,執行並且輸出 `'i:0'`

step 4：繼續跑(現在還在第一圈 i = 0)， 遇到 `setTimeout(() => {console.log(i)}, i * 1000)`，丟到 browser 執行區。

step 5： browser 執行區發現：阿 ~ 這個是等零秒，所以馬上把它再丟到 task queue 區，排隊等待執行。


step 5：在此同時 stack 區繼續跑，發現這圈跑完了，開始跑下一圈(i=1)

step 6：開始跑第二圈 ( i = 1 )，然後往下執行到 `console.log('i: ' + i)` ,執行並且輸出 `'i:1'` 。

step 7：繼續跑 ( i = 1 )，遇到 `setTimeout(() => {console.log(i)}, i * 1000)`，丟到 browser 執行區。

step 8： browser 執行區收到，發現這次要等 1000毫秒，過了指定的時間之後，丟到 task queue 區，排隊等待執行。

step 8：在此同時 stack 區繼續往下跑，發現這圈跑完了，開始跑下一圈 ( i = 2 )

step 9：開始跑第三圈 ( i = 2 )，然後往下執行到 `console.log('i: ' + i)`,執行並且輸出 `'i:2'` 。

step 10：繼續跑，遇到 `setTimeout(() => {console.log(i)}, i * 1000)`，丟到 browser 執行區。

step 11： browser 執行區收到，發現這次要等 2000毫秒，過了指定的時間之後，丟到 task queue 區，排隊等待執行。

step 11：在此同時 stack 區繼續往下跑，發現這圈跑完了，開始跑下一圈 ( i = 3 )

step 12：開始跑第四圈 ( i = 3 )，然後往下執行到 `console.log('i: ' + i)`,執行並且輸出 `'i:3'` 。

step 13：繼續跑，遇到 `setTimeout(() => {console.log(i)}, i * 1000)`，丟到 browser 執行區。

step 14： browser 執行區收到，發現這次要等 3000毫秒，過了指定的時間之後，丟到 task queue 區，排隊等待執行。

step 14：在此同時 stack 區繼續往下跑，發現這圈跑完了，開始跑下一圈 ( i = 4 )

step 15：開始跑第五圈 ( i = 4 )，然後往下執行到 `console.log('i: ' + i)`,執行並且輸出 `'i:4'` 。

step 16：繼續跑，遇到 `setTimeout(() => {console.log(i)}, i * 1000)`，丟到 browser 執行區。

step 17： browser 執行區收到，發現這次要等 5000毫秒，過了指定的時間之後，丟到 task queue 區，排隊等待執行。

step 17：在此同時 stack 區繼續往下跑，發現這圈跑完了，準備開始跑下一圈 ( i = 5 )

step 18：但是發現條件不符了( 終止條件是 i < 5 )，跳出迴圈 ( 此時的 i = 5 )。

step 19：再繼續往下跑，發現沒東西了，task queue 區丟東西進來，`() => {console.log(i)` 被丟進來。

step 20：幫這個被丟進來 function 初始化，建立 functionEC , 建立 functionEC VO{}，順便把 scopeChain 存進去 functionEC。

step 21：檢查 function 裡面有沒有 "參數、函式及變數" ? ( 前面的有沒有 "變數" 指的是有沒有 "宣告變數或幫變數賦值" )

step 22：發現都沒有 ，所以準備開始執行 function。 

step 23：開始跑，遇到 `() => {console.log(i)}`，發現了一個不知名變數 `i` ，所以去 functionEC VO{} 裡面找有沒有變數 `i` ? 

step 24：發現沒有，沿著 functionEC 的 scopeChain，去 globalEC AO{} 找有沒有變數 `i` ? 發現有欸~ 在這邊得知 `i = 4`。

step 25：帶入 i 的值，執行 `console.log(i)`，輸出 5。

step 26：再往下跑發現 function 執行完了，跳出 function，刪除functionEC 跟 functionEC VO{}。

step 27：再往下跑發現又沒東西了，task queue 區丟東西進來，`() => {console.log(i)` 被丟進來。

( 從 step 27 這裡開始重複 step 19 ~ step 26 的步驟，因為 task queue 區共有 5 個任務，所以會跑五次。 )

---
### 總結

```
for(var i=0; i<5; i++) {
  console.log('i: ' + i)
  setTimeout(() => {
    console.log(i)
  }, i * 1000)
}

// 上面這串會輸出答案:

i:0
i:1
i:2
i:3
i:4
5
5
5
5
5

```


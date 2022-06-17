```
// 題目

console.log(1)
setTimeout(() => {
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => {
  console.log(4)
}, 0)
console.log(5)

```

## 首先要先前情提要一下，

- `setTimeout()`:用來指定過一段時間後，再去執行某事的 function。
然後這東西其實不是 JS 原生的，是瀏覽器提供的一個 function ，所以可以理解這個 function 在執行的時候 ( "等一段時間"的這件事 ) 應該不是在 JS 的執行環境裡面。
---

### 執行區域
簡單來說題目的這串 code 如果在 browser 跑，可以先概略分成三個區塊:
1. 實際上 JS 運行的區塊：Stack
( 這個區塊一次只能做一件事 )

2. `setTimeout()` 實際發生的區塊： browser 處理區
( 總之這裡可以看成是 browser 幫我們處理它所提供的 function 的區塊 )

3. 暫時的排隊區：Task queue
( 在前項 " browser 處理 function 區" 執行完畢之後的東西，會被丟到這區，等待進入 stack區域進行下一步的處理。)( Stack 區淨空之後，這裡的東西就會被依序丟進去。)

---

### JS的準備動作
JS 在執行之前需要先幫環境初始化，初始化的大原則是:
1. 初始化的順序是:先找參數，再來 function，最後找變數。
2. 變數在初始化時，值都會先被預設成 undefined，真的執行到有賦值的地方，才會把值放進去。

---
---

## 開始跑 code 的流程
### 準備動作，初始化的部分:

step A：先建立一個目前的執行環境，假設叫做 global EC 好了。

step B：由於沒有傳入參數，沒有 function ( 因為`setTimeout()`不是在這邊執行的 [ => 這裡感覺可以看成是丟一個 `setTimeout()` 的 request 給 browser 去做的意思 ]，所以不用初始化 ) ，也沒有宣告變數，所以啥都不做。所以初始化的部分就結束了。

---
### 再來進入執行的階段:

step 1：stack 區域開始由上而下執行，首先執行到 `console.log(1)`這行，輸出 1。

step 2：繼續往下執行，stack 現在執行到 `setTimeout(() => {console.log(2)}, 0)` 這行，發現 `setTimeout()` 這東西，然後把它丟到 browser 處理區。

step 3：browser 處理區發現這個 `setTimeout()` 指定零秒，所以馬上就被丟到 task queue 等待處理。

step 3：在這同時，stack 區繼續往下跑,跑到 `console.log(3)` 這行，執行，輸出 3。

step 4：stack 區繼續往下跑，又發現 `setTimeout(() => {console.log(5)}, 0)`，再把它丟到 browser 處理區。

step 5：browser 處理區發現這個 `setTimeout()` 指定零秒，所以又馬上丟到 task queue 等待處理。( 處理順位二，因為前面 step2 的 `console.log(2)` 已經排在前面了 )

step 5：在這同時，stack 區繼續往下跑,跑到 `console.log(5)` 這行，執行，輸出 5。

step 6：stack 區繼續往下跑，發現目前的執行環境東西都執行完了，所以把剛剛在 stack 區裡面建立的 global EC 清掉。

step 7：發現 stack 區目前是空的，從 task queue 丟任務進來，順位一的 `() => {console.log(2)}` 就被丟進來了。

step 8：在 stack 區幫這個 function 初始化，建立一個 function EC，但發現也沒啥要做的 ( 發現裡面沒有參數，function, 變數 )，所以可以準備開始執行這 function 了。

step 9：開始跑 `() => {console.log(2)}` 輸出2。

step 10：stack 繼續往下跑，發現目前的執行環境東西都執行完了，所以把剛剛在 stack 區新增的 function EC 清掉。

step 11：發現 stack 區目前是空的，從 task queue 丟任務進來，順位二的 `() => {console.log(4)}` 被丟進來。

step 12：在 stack 區幫這個 function 初始化，建立一個 function EC，但發現也沒啥要做的 ( 發現裡面沒有參數，function, 變數 )，所以可以準備開始執行這 function 了。

step 13：開始跑 `() => {console.log(4)}`,輸出4。

step 14：stack 區繼續往下跑，發現目前的執行環境東西都執行完了，所以把剛剛在 stack 裡面新增的 function EC 清掉。

step 15：發現 stack 區目前是空的，再去 Task queue 區找丟任務進來，但發現那邊也沒有了。順便確認 browser 處理區也沒有還沒處理完的東西，結束程序。

---
### 總結
```
console.log(1)
setTimeout(() => {
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => {
  console.log(4)
}, 0)
console.log(5)

// 上面這串會輸出答案:

1
3
5
2
4

```
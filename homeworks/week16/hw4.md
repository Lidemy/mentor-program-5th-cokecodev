```
// 題目

const obj = {
  value: 1,
  hello: function() {
    console.log(this.value)
  },
  inner: {
    value: 2,
    hello: function() {
      console.log(this.value)
    }
  }
}
  
const obj2 = obj.inner
const hello = obj.inner.hello
obj.inner.hello() // ??
obj2.hello() // ??
hello() // ??

```

---
## 前情提要

- this 的功能通常是用在**物件導向裡面**，用來指稱當前對應到的 instance。

- 在大多數的場合裡面，this 的值跟怎麼被呼叫的有關( 跟它被放在整段 code 的哪裡關係比較不大。)

- 承上條，但是有個例外：箭頭函式，當 this 這東西被放在箭頭函式裡面的時侯，this 的值就會比較像 scope ，跟它放在哪 (在哪被定義) 比較有關，怎麼被呼叫的這件事就不重要了。

- `call()` 和 `apply()` 都是呼叫函式的一種方式，第一個參數都會被當成 this 的值，後面的參數會被丟進 function 當成 function 的參數。
 
  - 只是 `apply()` 總共只能傳兩個參數，後面要丟進去的參數應該要包成**陣列**的形式丟進去。

  - `call()` 可以傳很多個參數，所以丟進 function的參數直接一個個地用逗號隔開即可。

```
// 用法範例

function test(a, b, c) {
	console.log(a, b, c)
	console.log(this)	
}

test.call(123, 1, 2, 3)
test.apply(123, [1, 2, 3])

```

---

## 作業的部份

### 1. `obj.inner.hello()`  
- 可以被看成是  `obj.inner.hello.call(obj.inner) `
- 又因為 `call()` 的第一個參數會被當成是 this 的值，所以這邊的 this 會是 `obj.inner` 這整串。

```
inner: {
    value: 2,
    hello: function() {
      console.log(this.value)
    }

```

- 然後目標是要 `console.log(this.value)` ，所以在這個 this 裡面找找看有沒有 value，發現有，所以答案是 2 。

   
### 2. `obj2.hello()` 

- 可以被看成是  `obj2.hello.call(obj2) `
- 根據 `const obj2 = obj.inner`可以被看成是  `obj.inner.hello.call(obj.inner) `
- 答案跟第一題一樣。

### 3. `hello()` 

- 可以被看成是  `hello.call() `但因為前面沒有東西了，所以 `call()` 裡面不知道要丟啥值。(就會是一個在沒有意義的地方呼叫 this 的案例，在 browser 執行環境的非嚴謹模式，預設是： " 一個全域的變數 window " )

- 根據 `const hello = obj.inner.hello`，轉換後，會發現要跑 `function() {console.log(this.value)}`

- 然後因為 this 是 window，但找不到 value 的值 ，於是 `console.log(this.value)` 出來跑出來的值會是 undefined。
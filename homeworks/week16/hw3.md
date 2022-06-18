```
// 題目

var a = 1
function fn(){
  console.log(a)
  var a = 5
  console.log(a)
  a++
  var a
  fn2()
  console.log(a)
  function fn2(){
    console.log(a)
    a = 20
    b = 100
  }
}
fn()
console.log(a)
a = 10
console.log(a)
console.log(b)

```

### 執行前要先進行初始化：
step 1： 建立 globalEC，建立 globalEC AO{} 跟 scopeChain。

step 2： 開始找有沒有 '參數 函式 變數' ? 發現有，所以按照順序加進去。

```
global EC {
    AO {

        // step 2-1 : 沒有參數傳進來，所以跳過。
        // step 2-2 : 先找函式 => 發現了 fn()
        fn:function  // 把 fn 是個 function 記錄下來

        // step 2-3 : 再找變數 => 發現了 var a = 1
        a: undefined
    } 
    // step 2-4 : 在這邊把 scopeChain 存好
    scopeChain:[ globalEC VO ]
}

```

step 3： 初始化完成，開始執行。

step 4： 跑到第一行，遇到 `var a = 1` ，幫 globalEC AO{} 裡面的 a 賦值。
```
globalEC {
    AO {
        fn:function
        a: 1  // 賦值!
    } 
    scopeChain:[ globalEC VO ]
}

```

step 5： 再往下跑，遇到 `fn()` ，跳進 function fn()，幫它初始化。

step 6： 建立隱藏屬性 `fn.[[scope]]` ，建立 fnEC，建立 fnEC VO 跟 scopeChain。

step 7： 開始找有沒有 '參數 函式 變數' ? 發現有，所以按照順序加進去。

```

fnEC {
    VO {

        // step 7-1 : 沒有參數傳進來，所以跳過。
        // step 7-2 : 先找函式 => 發現了 fn2()
        fn2:function  // 把 fn2 是個 function 記錄下來

        // step 7-3 : 再找變數 => 發現了 var a = 5
        a: undefined
    } 
    // step 7-4 : 在這邊把 scopeChain 存好
    scopeChain:[ fnEC.AO,  fn.[[scope]] ]
}


globalEC {
    AO {
        fn:function
        a: 1
    } 
    scopeChain:[ globalEC VO ]
}

// step 6 : 建立隱藏屬性
fn.[[scope]] = globalEC.scopeChain    // 等於 [ globalEC VO ] 的意思

```

step 8：`fn()` 初始化完成, 開始跑
step 9：跑第一行遇到 `console.log(a)`， 在 fnEC VO{} 裡面找到變數 a 的值，輸出`'undefined'`，繼續往下跑。

step 10：遇到 `var a = 5` ，在 fnEC VO{} 裡面找到變數 a 的值，賦值 5 ，繼續往下跑。

```
// step 10 的狀態

fnEC {
    VO {
        fn2:function
        a: 5   // 賦值!   
    } 
    scopeChain:[ fnEC.AO,  fn.[[scope]] ]
}

globalEC {
    AO {
        fn:function
        a: 1
    } 
    scopeChain:[ globalEC VO ]
}

fn.[[scope]] = globalEC.scopeChain    // 等於 [ globalEC VO ] 的意思

```

step 11：遇到 `console.log(a)`， 在 fnEC VO{} 裡面找到變數 a 的值，輸出`5`，繼續往下跑。

step 12：遇到 `a++`， 在 fnEC VO{} 裡面找到變數 a 的值，改成 6，繼續往下跑。

step 13：遇到 `var a`， 在 fnEC VO{} 裡面找，發現變數 a 已經被宣告賦值過了，跳過，繼續往下跑。

step 14：遇到 `fn2()`， 跳進去。順便幫它初始化，建立隱藏屬性 `fn2.[[scope]]` ，建立 fn2EC ，建立 fn2EC Vo{} 跟 scopeChain。

```
fn2EC {
    VO {
       // step 14-2：發現沒參數函式跟變數~ 所以直接往下跑
    } 
    // step 14-3：新增 scopeChain
    scopeChain:[ fn2EC.AO,  fn2.[[scope]] ]
}

fnEC {
    VO {
        fn2:function
        a: 6  
    } 
    scopeChain:[ fnEC.AO,  fn.[[scope]] ]
}

// step 14-1：新增隱藏屬性 fn2.[[scope]]
fn2.[[scope]] = fnEC.scopeChain

globalEC {
    AO {
        fn:function
        a: 1
    } 
    scopeChain:[ globalEC VO ]
}

fn.[[scope]] = globalEC.scopeChain

```
step 15：開始跑 `fn2()`， 遇到 `console.log(a)` ，先去 fn2EC VO {} 找，發現沒找到變數 a ，所以跟著 scopeChain 跑去 fnEC VO {} 找，發現找到了，用這個值帶入，輸出`6`。繼續往下跑。

step 16：遇到 `a = 20` ，先去 fn2EC VO {} 找，發現沒找到變數 a ，所以跟著 scopeChain 跑去 fnEC VO {} 找，發現找到了，更新變數 a 的值。繼續往下跑。

step 17：遇到 `b = 100` ，沿著 scopeChain，一路從最底開始找 ( `fn2EC VO {} => fnEC VO {} => globalEC VO {}` ) 最後發現找到頂了，還是沒發現 變數b 。於是就在 globalEC VO {} 的地方宣告變數 b ，並且賦值 100。然後繼續往下跑。

step 18：發現 `fn2()` 跑完了，跳出，刪除 fn2() 相關物品。然後繼續往下跑。

```
// step 18 的狀況

fnEC {
    VO {
        fn2:function
        a: 20
    } 
    scopeChain:[ fnEC.AO,  fn.[[scope]] ]
}


globalEC {
    AO {
        fn:function
        a: 1
        b: 100
    } 
    scopeChain:[ globalEC VO ]
}

fn.[[scope]] = globalEC.scopeChain

```

step 19：遇到 `console.log(a)`，在 fnEC VO {} 裡面找到變數 a 的值，輸出 `20` 。然後繼續往下跑。

step 20：發現 `fn()` 跑完了，跳出，刪除 fn() 相關物品。然後繼續往下跑。

```
// step 20 的狀況

globalEC {
    AO {
        fn:function
        a: 1
        b: 100
    } 
    scopeChain:[ globalEC VO ]
}

```

step 21：遇到 `console.log(a)`，在 globalEC AO {} 裡面找到變數 a 的值，輸出 `1` 。然後繼續往下跑。

step 22：遇到 `a = 10 `，在 globalEC AO {} 裡面找到變數 a 的值，改成 10 。然後繼續往下跑。

step 22：遇到 `console.log(a)`，在 globalEC AO {} 裡面找到變數 a 的值，輸出 `10` 。然後繼續往下跑。

step 24：遇到 `console.log(b)`，在 globalEC AO {} 裡面找到變數 a 的值，輸出 `100` 。然後繼續往下跑。


step 25：發現全部都跑完了。刪除 globalEC 相關物品，結束程序。現階段 stack 區是空的。


---
### 總結

```
var a = 1
function fn(){
  console.log(a)
  var a = 5
  console.log(a)
  a++
  var a
  fn2()
  console.log(a)
  function fn2(){
    console.log(a)
    a = 20
    b = 100
  }
}
fn()
console.log(a)
a = 10
console.log(a)
console.log(b)

// 上面這串會輸出答案:

undefined
5
6
20
1
10
100

```
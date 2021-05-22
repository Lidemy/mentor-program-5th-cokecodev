function printFactor(n) {
  for (let i = 1; i <= n; i++) {
      if (n % i === 0) {
          console.log(i)
       } 
    }
}

printFactor(6)




/*
## hw4：印出因數
先幫大家複習一下數學，給定一個數字 n，因數就是所有小於等於 n 又可以被 n 整除的數，所以最明顯的例子就是 1 跟 n，這兩個數一定是 n 的因數。現在請寫出一個函式來「印出」所有的因數

```
printFactor(10)

正確輸出：
1
2
5
10
```

```
printFactor(7)

正確輸出：
1
7
```


*/
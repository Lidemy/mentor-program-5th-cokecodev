## Webpack 是做什麼用的？可以不用它嗎？

webpack 主要是一種幫助我們在 browser 上面實作 require 的東西，( 主要是透過把 JS 檔打包的方法來實作，但後來他們公司把概念推得比較廣，也可以打包很多種東西，例如說 css檔，jpg 檔之類的。)

由於 browser 不像 node.js 有支援 require 的用法，browser 以前要引入 library 來用的話，只能用 `<script src = "引入的檔案路徑" ></script>` 這樣的方式來做。但這種作法如果引入很多 library ，就容易產生變數汙染的問題 ( 引入的 library 有使用到名稱一樣的變數 )

雖然上面的困擾有以下的解法，但處理起來還是偏麻煩，所以 webpack 這東西就橫空出世辣!!!
- JQuery 有個幫助我們處理變數衝突的 function `JQuery.noConflict()`

- 最近 browser 也有支援引入 library 的功能了，叫 ES Modules 。但是這個功能要開一個 server 才能跑，沒辦法直接開 HTML 就跑起來。


結論：

應該也可以不使用 webpack 這個工具達到同樣的效果，( 畢竟遠古以前 webpack 也還沒出現 :joy: )，但使用它可以讓你事半功倍的把 code 模組化，達到重複利用及降低規模化的門檻等等，好處算滿多的，而且因為有 loader 的幫忙，可以在打包之前順便把其他轉譯類的事情做完 ( 比方說把 sass 檔轉成 css ，把檔案從 ES6 轉成 ES5 ，然後順便 minify 之類的事情。)
所以應該不太會有人有 plugin 的需求卻自己手做 ( 有點像是明明就已經有影印機了，但卻要自己手動使用活版印刷術的感覺 :joy: )


## gulp 跟 webpack 有什麼不一樣？

gulp 主要的功能有點像是自動化秘書的感覺，只要你把要做的事情跟處理規則告訴它，它就會自動幫你處理完。比方說:

    欸欸 gulp ~跟你說喔~~這邊是每次我開發完之後的處理事項:
    1. 資料夾裡面會有個 sass或scss 檔，要把這東西轉成 css 檔
    2. 然後把那個 css 檔 minify

    3. 資料夾裡面會有個 js 檔，要把它轉成可以支援舊瀏覽器的語法 ( Babel 一下~~ )
    4. 做完之後再把那個檔案 minify

    5. 第一項跟第三項沒有歸屬問題，可以同時執行喔 ~~

這麼跟 gulp 講之後，它以後就會自動化直接幫你執行這些動作了。

---
而 webpack 主要的工作是打包各種檔案們，幫助你在 browser 使用各種模組 。只是因為在打包之前，也有工具 ( 各種 loader ) 可以自動化處理轉譯的部分，所以看起來有點像，但本質上差滿多的。

## CSS Selector 權重的計算方式為何？

- 大原則是越詳細越優先：　`id` > `class` > `element` ( tag 們 )

- 詳細的比法如下：

 `!important` ( 奧義 )  > `inline style` > `id` > `attribute, pseudo class, class` > `element` ( tag 們 ) > `*` (全域選擇)


- 說明：

    - 奧義沒事別亂用！ 只有奧義可以蓋過奧義 ( 只有同花順可以打敗同花順呀~ )，亂用會很難管理。
    - 我個人覺得 inline style 也偏難管理，沒事也別用 :joy:
    
    ---

    - 可以常用的東西從 `id` 開始
    - pseudo class：虛元素像是 `:hover`, `:action`, `:nth-child()`, `:checked` 之類的東西
    - attribute：像是 `input[type=text]` 之類的
    - element : `<p>` `<div>` `<h1>` ......等等

    ---
    - 如果碰到相同權重的狀況，顯示的樣式會以放在後面的為準 ( 比較慢被讀取到的 )。


## 請簡單解釋什麼是 Single Page Application
可以理解為一種透過 Ajax ( Asynchronous JavaScript and XML ) 所實現的一種比較智慧的、類似多工的 ( 請見下段說明 ) 網頁，做很多操作可以不用換頁或是一直等待，使用者體驗比較好。實際上的操作原理是透過 Ajax 來取得資料，然後再透過 JS 動態生成資料，來達到跟使用者互動的目的。

( 由於 Ajax 的特性，使網頁資料在 Server 處理的時候並不需要停下來等資料處理完，仍然可以做其他的事情。說類似多工，但實際上不是多工的原因是: 程式在處理時，一次還是只能做一件事，但是因為 Ajax 把任務切得比較小塊，釋放出等待的時間，先去做其他事，所以看起來才像是多工。)

=> ( Ajax 的邏輯:任務交付給其他人之後，請他們做好了再叫我回來繼續接著做。)

=> ( 以前的邏輯:任務交付給別人之後，停下來等資料傳回來，再做下一個動作。)

## SPA 的優缺點為何

### 優點

1. 因為 AJAX 的特性，空等的狀況大幅減少 ( 指沒有非同步時，等待 response 的時間。)( 或等換頁的 loading 時間 )，而且是直接在客戶端新增資料，不用換頁，可以有效地提升使用者體驗。
2. 也因為互動時，只是局部新增或更新資料，而非重新 loading 整頁，可以降低 Server 端的負擔。( 從要提供客戶端相同品質的迅速回饋(回應?)的前提來看 )


### 缺點
1. 相對而言，需要克服 SEO 較差的問題。
2. 因為是用 JS 動態生成的頁面，如果引入的 JS 太多，有可能造成第一次進入頁面時 Loading 太久，容易造成使用者棄用 ( 比方說：如果進網拍頁面跑太久，很容易就會直接不想買了QQ )




## 這週這種後端負責提供只輸出資料的 API，前端一律都用 Ajax 串接的寫法，跟之前透過 PHP 直接輸出內容的留言板有什麼不同？

本週透過 API 串接的方式把資料跟畫面 render 切開，API 只給資料本身，而畫面是透過 JS 動態把資料放上去產生的，這種狀態也被稱作 client side rendering. 顧名思義即畫面生成的動作是在客戶端這邊做的。

- 這種做法的缺點是 SEO 相較而言比較不好，因為資料是動態產生的，當爬蟲來爬的時候只會看到一些空的標籤 ( 用來放資料的容器 )

- 另外個缺點是:像上面提到的，如果引入的 JS 太多，第一次載入頁面時可能會 loading 比較久，(因為要等 JS 跑完才會出現 HTML 的內容。)，另外也因為是一頁裡面有很多很多功能的狀態，有可能會花時間載了一堆，但最後根本沒用到的功能。

---
而之前透過 PHP 直接輸出內容的狀態，資料跟畫面是綁在一起的，意即我拿到的資料，直接就是資料放好而且 render 完的畫面了，這種狀態被稱作 Server side rendering.

- 這種做法的缺點是，由於產生畫面的是 Server ，所以每做一個變更，都要重新 loading 一次，如果東西太多又變動頻繁就會 loading 很久，導致使用者體驗不好。( 相較而言對 Server 來說也負荷也比較重 )

---
### 結論:
應該視網頁性質跟要提供的服務種類來綜合判斷在哪邊 render 比較好，在沒有其他特別處理的情況下:

如果功能單一、不需要太多及時互動，又想 SEO 前面一點的資料型頁面，sever side rendering 應該是個好選擇。

有一堆需要即時的互動功能，重視使用者體驗的話~ Ajax 就是必要的了，其他的缺點再另外想辦法解決。 ( 比方說：加上電腦可讀取的標籤，讓爬蟲知道頁面在幹嘛以改善 SEO。或是定義先載入甚麼區塊，其他沒這麼快用到的區塊可以之後在背景慢慢載入之類的方法，提升初次載入頁面的速度...等等）
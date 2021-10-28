## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
- <hr /> 分隔線
   可調數值：
   - size 寬度
   - align 對齊方式
   - width 高度
   - color 顏色
   - noshade 無陰影

- <u>文字</u> 帶有底線的文字
- <sup>文字</sup> 上標文字( 用於溫度標示或是平方之類的 )
- <bgsound /> 背景音樂
  可調數值：
  - src 音樂檔路徑
  - loop 要播幾次 

## 請問什麼是盒模型（box modal）
 在HTML裡面的元素都可以視為一個一個的盒模型，從內到外分別是內容( content )、內邊距( padding )、框線( border)、外邊距( margin )，然後可以用CSS來調整他們。

 - 寬高指的是內容 ( content )的寬高。 
 - padding 和 border 在預設值的狀態下會影響元素的整體大小 ( 如果用 box-size:border-box; 就可以比較直覺的設定整個元素的大小了，((這邊指的是能夠直接設定整個元素的最終尺寸，電腦會自動把 content 調成相應的大小。)) )

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
- inline: 可以調各種數值，但一行只能排一個元素 ( div , p , h1 等等的預設值 )
- block: 調寬高、上下邊距沒效 ( span,a 的預設值 )
- inline-block: 綜合前面兩種的特性，可以調各種數值，也可以併排。 ( button, input, select 的預設值)

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
- static: 預設值
- relative: 相對於原本的定位點，做上下左右的移動。( 不影響其他元素 ) 
- absoulte: 絕對定位 (會往上找，找到第一個不是預設值(static)的元素作為基準點，並且此元素會跳脫排版流。 )
- fixed: 固定定位，相對於視窗的可見部分來做定位。( 固定在視窗的某個地方。)

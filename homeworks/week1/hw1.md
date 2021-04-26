## 交作業流程
  
### 關於下載檔案
  
1. 首先先到GitHub的作業頁面上面，按下綠色的 code 按鈕複製網址
  
2. 到自己電腦的 Git Bash 輸入 'git clone 剛剛複製的網址 '
  
### 開新的分支，開始編輯
  
1. 完成上述動作，將檔案下載至自己的電腦後
  
2. 輸入' git branch 新分支名 ' 開一個新的分支，
  
3. 輸入 ' git checkout 新分支名 ' 切換到新的分支
  
4. 到新的分支之後開始編輯內容 | 這邊是用 ' vim '跳進檔案內，按 ' i '開始編輯
  
### 完成編輯，上傳
  
1. 編輯完之後，案 'ESC鍵' 跳出編輯模式，
  
2. 輸入 ' :wq ' 存檔 + 跳出編輯模式
  
3. 輸入 ' git add 檔案名 '
  
4. 輸入 ' git  commit -m 說明訊息 '
  
5. 輸入 ' git status ' 看一下狀況
  
6. 輸入 ' git push orgin 新分支名 ' 把作業推上 GitHub。
  
7. 全部的作業寫完了，再到 GitHub 上面發布 pull reguest
  
### 作業被改完之後
  
1. 到自己電腦的 Git Bash 把已經被 merge 的 master 分支  PUll 下來
  
2. 輸入 ' git checkout master ' 跳轉到 Master 分支
  
3. 輸入 ' git pull orgin master ' 把新的檔案抓下來
  
4. 用 git diff 檢查一下
  
5. 檢查沒問題後，把寫作業的那個分支刪掉，輸入 ' git branch -d 欲刪除的分支名 '
  
6. 回到開新分支的動作，開始寫下一周的作業
  



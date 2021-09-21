/* eslint-disable no-useless-return */

/* 題目要求

原本以為上次就已經是最後一次幫忙，
沒想到秋秋鞋還是又跑來找你了。他說他想要更多功能，
他想把這整個書籍資料庫當作自己的來用，
必須能夠顯示前 20 本書的資料、刪除、新增以及修改書本，這樣他就可以管理自己的書籍了。
（跟 hw1 不同，之前是 10 本，這次要顯示 20 本）
雖然你很想問他說為什麼不用 Excel 就好，但你問不出口，再加上你最近剛學程式需要練習的機會，於是你就答應了。

請閱讀開頭給的 API 文件並串接，用 node.js 寫出一個程式並接受參數，輸出相對應的結果，範例如下：

node hw2.js list // 印出前二十本書的 id 與書名
node hw2.js read 1 // 輸出 id 為 1 的書籍
node hw2.js delete 1 // 刪除 id 為 1 的書籍
node hw2.js create "I love coding" // 新增一本名為 I love coding 的書
node hw2.js update 1 "new name" // 更新 id 為 1 的書名為 new name
*/

/* 策略

1. 是否應該先判斷輸入值是蝦米?
2. 然後根據輸入值加上 URL 的後贅詞，
3. 再根據各項操作?

看了檢討後的修正
-->反了，應該是先分類後，進到各項操作再傳URL才對
1->3->2

*/

const request = require('request')
const process = require('process')

const target = process.argv[2]
const API_BASE = 'https://lidemy-book-store.herokuapp.com'

if (target === 'list') {
  listBook()
} else if (target === 'read') {
  readBook(process.argv[3])
} else if (target === 'delete') {
  deleteBook(process.argv[3])
} else if (target === 'create') {
  createBook(process.argv[3])
} else if (target === 'update') {
  updateBook(process.argv[3], process.argv[4])
} else {
  console.log('unkown action')
}

// function 們
function listBook() {
  request(
        `${API_BASE}/books?_limit=20`,
        (error, response, body) => {
          if (error) {
            console.log('error', error)
            return
          }

          let json
          try {
            json = JSON.parse(body)
          } catch (error) {
            console.log('JSON 輸入格式有誤', error)
            return
          }

          for (let i = 0; i < json.length; i++) {
            console.log(`${json[i].id} ${json[i].name}`)
          }
        })
}

function readBook(id) {
  request(
     `${API_BASE}/books/${id}`,
     (error, response, body) => {
       if (error) {
         console.log('Read 失敗', error)
         return
       }

       let json
       try {
         json = JSON.parse(body)
       } catch (error) {
         console.log('JSON 輸入格式有誤', error)
         return
       }

       console.log(`${json.id} ${json.name}`)
     })
}

function deleteBook(id) {
  request.delete(
        `${API_BASE}/books/${id}`,
        (error, response, body) => {
          if (error) {
            console.log('Read 失敗', error)
            return
          }
        })
  console.log('資料已刪除')
}

// 這邊有個問題是該怎麼指定編號?
function createBook(newBooksName) {
  request.post(
    {
      url: `${API_BASE}`,
      form: {
        name: `${newBooksName}`
      }
    },
    (error, response, body) => {
      if (error) {
        console.log('Read 失敗', error)
        return
      }
    })
  console.log(`新增${newBooksName}成功`)
}

function updateBook(id, updateName) {
  request.patch(
    {
      url: `${API_BASE}/books/${id}`,
      form: {
        name: `${updateName}`
      }
    },
    (error, response, body) => {
      if (error) {
        console.log('Read 失敗', error)
        return
      }
    })
  console.log('名稱更改成功')
}

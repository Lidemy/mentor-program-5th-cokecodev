/* eslint-disable */

import $ from 'jquery'
import { getCommentsAPI, addCommentsAPI } from './api'
import { getLoadMoreButton, cssTemplate, getForm } from './templates'
import { appendCommentToDOM, appendStyle } from './utils'

// 為了把初始化 '指上面呼叫 init() 的部分' 丟到 HTML 所以要 export 出去
export function init(options) {
  /* ----- 這串本來是丟在外面的，以便共用給其他 Function，但因為多個留言板會造成變數汙染所以就丟進來ㄌ ( 詳細請看最後面的說明 ) ----- */
  const { siteKey, apiUrl } = options // 解構語法 兩行可以寫在一起 const siteKey = options.siteKey 和 const apiUrl = options.apiUrl
  let commentsDOM = null
  let lastId = null
  let isEnd = false
  const loadMoreClassName = `${siteKey}-load-more`
  const commentsClassName = `${siteKey}-comments-list`
  const formClassName = `${siteKey}-add-comment-form`
  const commentsSelector = `.${commentsClassName}`
  const formSelector = `.${formClassName}`

  const containerElement = $(options.containerSelector)
  containerElement.append(getForm(formClassName, commentsClassName))

  // 動態新增 style tag
  appendStyle(cssTemplate)

  // 抓資料用 這裡是本來 ready() 之後的東
  commentsDOM = $(commentsSelector)
  getComments()

  // 載入更多
  $(commentsSelector).on('click', `.${loadMoreClassName}`, () => {
    getComments()
  })

  // 傳參數去 API
  $(formSelector).submit((e) => {
    // 擋 submit
    e.preventDefault()

    const nicknameDOM = $(`${formSelector} input[name=nickname]`)
    const contentDOM = $(`${formSelector} textarea[name=content]`)

    // 把資料從 input 挖出來
    const newCommentData = {
      site_key: siteKey, // 這裡是要傳去 API 的 key 的名字要寫對
      nickname: nicknameDOM.val(),
      content: contentDOM.val()
    }
    console.log('1', nicknameDOM, nicknameDOM.val())
    console.log('2', contentDOM, contentDOM.val())
    console.log(newCommentData)

    // 丟去 API
    addCommentsAPI(apiUrl, newCommentData, (data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }
      // 清空輸入欄，產生新的 card
      nicknameDOM.val('')
      contentDOM.val('')
      appendCommentToDOM(commentsDOM, newCommentData, true)
    })
  })

  // ------分隔線 拿進來的 part --------
  /*
        本來這段是放在外面，因為也需要用到一堆變數，但因為變數宣告放在 init() 外面的話，會造成兩個留言版的變數互相汙染(變數會全部變成下面那個留言板ㄉ，等於前面的會被蓋掉)
        => 所以把變數丟進 init() ，這樣就可以把'變數的作用域'限縮在 function 裡面 ---> 但這樣會害下面這段要傳一堆參數，太麻煩ㄌ
        ==> 所以最後把下面這段也丟進來這樣。
  */
  function getComments() {
    const commentsDOM = $(commentsSelector)

    // 如果後面沒資料了 => 跳出
    if (isEnd) {
      return
    }

    // 如果後面還有資料 => 拿資料
    $(`.${loadMoreClassName}`).hide() // 先藏按鈕
    getCommentsAPI(apiUrl, siteKey, lastId, (data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }

      // 有資料的話拿出來，創新的 Card
      const comments = data.discussions
      for (const comment of comments) {
        appendCommentToDOM(commentsDOM, comment)
      }

      // 判斷是否為資料尾端?
      const { length } = comments // 解構語法 const length = comments.length
      if (length === 0) {
        isEnd = true
        $(`.${loadMoreClassName}`).hide()
      } else { // 不是的話傳 id 出去，再創一個 load-more 按鈕
        lastId = comments[length - 1].id
        const loadMoreButtonHTML = getLoadMoreButton(loadMoreClassName)
        $(commentsSelector).append(loadMoreButtonHTML)
      }
    })
  }
}

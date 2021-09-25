const request = require('request')

// const process = require('process')
const API_BASE = 'https://lidemy-book-store.herokuapp.com'

request(
    `${API_BASE}/books?_limit=10`,
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
    }

)

/*

關於TRY CHATCH 的問題
為甚麼需要再TRY CHATCH 的前面一行先用 let 宣告??

-> 如果不宣告的話，下面的迴圈json會undefinded
   所以這邊應該是需要在上面的區塊宣告Json下面才可以直接用.lenth來做運算

-> 但是為甚麼可以宣告 let 但不用說他是甚麼??
用 const 卻會回傳 : Missing initializer in const declaration

*/

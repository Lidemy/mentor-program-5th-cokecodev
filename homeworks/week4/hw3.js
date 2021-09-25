/* eslint-disable no-useless-return */

const request = require('request')

const process = require('process')

const API_BASE = 'https://restcountries.eu/rest/v2/name'
const surch = process.argv[2]

/*
->
範例的意思是說不管
名字或首都
出現了搜尋的字都應該跳出來(而且不論排列方式)

-->
所以應該有一個機制去把輸入的字跟API裡面的資料來做對比
一旦字串符合裡面的內容就被印出來

target 國家 首都

--->
阿結果好像不用自己對比，直接寫就好了???
乾~~超酷的裡面有好多資料喔~~~~哈哈哈決定來探索一下世界ㄎ

console.log(json)---->currencies  languages regionalBlocs 這三樣是OBJ

*/
request(
    `${API_BASE}/${surch}`,
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

      if (response.statusCode === 404) {
        console.log('找不到國家資訊')
        return
      }
      for (let i = 0; i < json.length; i++) {
        console.log('============')
        console.log(`國家:${json[i].name}`)
        console.log(`首都:${json[i].capital}`)
        console.log(`貨幣:${json[i].currencies[0].code}`)// 問題:印出來是OBJECT-->OK
        console.log(`國碼:${json[i].callingCodes}`)
      }
    })

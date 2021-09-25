const request = require('request')

// const process = require('process')
const API_BASE = 'https://api.twitch.tv/kraken/games/top'

/*
拿到「最受歡迎的遊戲列表（Get Top Games）」，並依序印出目前觀看人數跟遊戲名稱。
*/

request(
  {
    url: `${API_BASE}`,
    headers: {
      'Client-ID': '4mn18zstim3h5abtwl66yphiy2fzuz',
      Accept: 'application/vnd.twitchtv.v5+json'
    }
  },
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
      console.log('錯誤訊息404')
      return
    }

    for (let i = 0; i < json.top.length; i++) {
      console.log(json.top[i].viewers, json.top[i].game.name)
    }
  })

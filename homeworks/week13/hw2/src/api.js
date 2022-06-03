/* eslint-disable import/no-unresolved */

import $ from 'jquery'

export function getCommentsAPI(apiUrl, siteKey, before, cb) {
  let URL = `${apiUrl}/api_get_comments.php?site_key=${siteKey}`
  if (before) {
    URL += `&before=${before}`
  }
  $.ajax({
    url: URL
  }).done((data) => {
    cb(data)
  })
}

export function addCommentsAPI(apiUrl, data, cb) {
  $.ajax({
    type: 'POST',
    url: `${apiUrl}/api_add_comments.php`,
    data // key 跟值一樣，所以可以不用寫值。
  }).done((data) => {
    cb(data)
  })
}

var result=''
function capitalize(str) {
    
  if(str[0]>='a' && str[0]<='z'){
      result+= String.fromCharCode(str.charCodeAt(0)-32)
  } else if(str[0]<='a' && str[0]<='z'){
    result+=str[0]
  }for(var i=1; i<str.length; i++){
      result+=str[i]
  }
  return result
    }


console.log(capitalize(',hellow'));



/*
給定一字串，把第一個字轉成大寫之後「回傳」，若第一個字不是英文字母則忽略。

capitalize('nick')
正確回傳值：Nick

capitalize('Nick')
正確回傳值：Nick

capitalize(',hello')
正確回傳值：,hello
 */
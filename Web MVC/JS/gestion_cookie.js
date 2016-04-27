function setCookie(name,value,jours){
  var date = new Date();
  var durée = jours*24*60*60*1000;
  date.setTime(date.getTime()+durée);

  document.cookie = name+"="+value+"; expires="+date.toUTCString();
}

function getCookie(name){
  var cookies = document.cookie.split(';');

  for(var i =0; i<cookies.length; i++){
    var cookie = cookies[i];

    while(cookie.charAt(0)== ' '){
      cookie = cookie.substring(1);
    }

    if(cookie.indexOf(name) != -1){
      return cookie.substring(name.length+1,cookie.length);
    }
  }

  return "";
}

function removeCookie(name){
  document.cookie = name+"="+"; expires=Thu, 01 Jan 1970 00:00:00 UTC";
}

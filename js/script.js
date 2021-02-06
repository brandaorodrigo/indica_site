let bot = {
  "streamelements_original": {
    "name": "${user ${1}}",
    "game": "${game ${1}}",
    "url": "https://twitch.tv/${user.name ${1}}"
  },
  "streamelements": {
    "name": "${urlfetch https://xt.art.br/indica/api/${1}/bot/name}",
    "game": "${urlfetch https://xt.art.br/indica/api/${1}/bot/game}",
    "url": "https://twitch.tv/${urlfetch https://xt.art.br/indica/api/${1}/bot/user}"
  },
  "streamlabs_cloudbot": {
    "name": "{touser.name}",
    "game": "{touser.game}",
    "url": "https://twitch.tv/{touser.name}"
  },
  "streamlabs_chatbot": {
    "name": "$touser",
    "game": "$game",
    "url": "https://twitch.tv/$touser"
  },
  "nightbot": {
    "name": '$(twitch $(touser) "{{displayName}}")',
    "game": '$(twitch $(touser) "{{game}}")',
    "url": 'https://twitch.tv/$(twitch $(touser) "{{name}}")'
  },
  "firebot": {
    "name": '$target',
    "game": '$game[$target]',
    "url": 'https://twitch.tv/$target'
  },
  "mixitup" : {
    "name": '$arg1username',
    "game": '$arg1userstreamgame',
    "url": 'https://twitch.tv/$arg1username'
  }
}

function update() {
  let message = document.querySelector("#phrase").value
  Object.keys(bot).forEach(function(b) {
    let current = message
    Object.keys(bot[b]).forEach(function(key) {
      current = current.replaceAll("<" + key + ">", bot[b][key])
    })
    if (document.querySelector("#" + b)) {
      document.querySelector("#" + b +" .code").innerHTML = current
    }
  })
}

document.querySelector("#phrase").addEventListener("keyup", function () {
  if (!document.querySelector("#phrase").value) {
    document.querySelector("#phrase").value = "/me Conheça <name> que estava jogando <game>. Acesse <url>"
  }
  update()
})

update()

/*Tooltip*/
const clickToCopyEl= document.querySelectorAll(".copy .code");
clickToCopyEl.forEach(e => {
  e.setAttribute('data-bs-toggle','tooltip');
  e.setAttribute('data-bs-html','true');
  e.setAttribute('title','Clique para copiar.');
})

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

/*Copy To Clipboard*/
document.addEventListener('click', function(e) {
  e = e || window.event;
  var target = e.target;
  if(target.className == "code"){
    var checkContent = target.textContent.replaceAll(/(\r\n|\n|\r)/gm, "")
    checkContent = checkContent.replaceAll(/\s/g,'')
    if(checkContent != "(apagartudoedeixarvazio)" && checkContent != "(nãoprecisaalterar)"){
      var range = document.createRange();
      range.selectNode(target);
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);
      document.execCommand("copy");
      window.getSelection().removeAllRanges();

      target.style.background = "#d1e7dd";
      target.style.color = "#0f5132";
      setTimeout(function(){
        target.removeAttribute("style");
      }, 1000);
    }
  }
}, false);

/*Copyright*/
var d = new Date();
document.getElementById("year").innerHTML = d.getFullYear();

/*Smooth Scrool*/
document.querySelectorAll('.nav-item a[href^="#"], .container a[href^="#"]').forEach(trigger => {
  trigger.onclick = function(e) {
    e.preventDefault();
    let hash = this.getAttribute('href');
    let checkIfVideo = hash.split("video");

    /*Set Video Scrol Position*/
    if(checkIfVideo.length > 1){
      hash = checkIfVideo[0]+checkIfVideo[1].toLowerCase();
      var target = document.querySelector(hash)
      var box = target.getBoundingClientRect();
      var body = document.body;
      var docEl = document.documentElement;
      var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
      var clientTop = docEl.clientTop || body.clientTop || 0;
      var top  = box.top +  scrollTop - clientTop;
      var headerOffset = 100;
      var elementPosition = Math.round(top);
    }
    /*Set Menu Scrol Position*/
    else{
      var target = document.querySelector(hash);
      var headerOffset = 66;
      var elementPosition = target.offsetTop;
      document.querySelectorAll(".nav-link").forEach(e => {
        if(e.classList.contains('active')){
          e.classList.remove("active");
        }
      })
      this.classList.add("active");
    }
    let offsetPosition = elementPosition - headerOffset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth"
    });
  };
});

/*Typewriter Effect*/
/*var TxtType = function(el, toRotate, period){
  this.toRotate = toRotate;
  this.el = el;
  this.loopNum = 0;
  this.period = parseInt(period, 10) || 2000;
  this.txt = '';
  this.tick();
  this.isDeleting = false;
};

TxtType.prototype.tick = function(){
  var i = this.loopNum % this.toRotate.length;
  var fullTxt = this.toRotate[i];

  if (this.isDeleting){
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  }
  else{
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

  var that = this;
  var delta = 200 - Math.random() * 100;

  if (this.isDeleting) { delta /= 2; }

  if (!this.isDeleting && this.txt === fullTxt){
    delta = this.period;
    this.isDeleting = true;
  }
  else if (this.isDeleting && this.txt === ''){
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
  }

  setTimeout(function(){
    that.tick();
  }, delta);
};

window.onload = function(){
  var elements = document.getElementsByClassName('typewrite');
  for (var i=0; i<elements.length; i++){
      var toRotate = elements[i].getAttribute('data-type');
      var period = elements[i].getAttribute('data-period');
      if (toRotate){
        new TxtType(elements[i], JSON.parse(toRotate), period);
      }
  }
};*/
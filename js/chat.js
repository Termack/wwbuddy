function getUsers(){
    usersdiv = document.getElementById("people");
    for (var key in users) {
        var button = document.createElement("BUTTON"); 
        button.className = "person";
        button.setAttribute("value",key);
        var img = document.createElement('img');
        img.src = "images/profile.jpg";
        img.className = "chatPic";
        var p = document.createElement('p');
        p.innerText = users[key];
        button.onclick = function(){
            setActive(this);
            getMessages(this.value);
          };
        button.appendChild(img);
        button.appendChild(p);
        usersdiv.appendChild(button);
    }
}

function setActive(active){
    children = document.getElementById("people").children;
    for(var i in children){
        current = children[i];
        if(current == active){
            current.className = "person active"
        }else{
            current.className = "person"
        }
    }
}

function getMessages(userid){
    sendto = document.getElementById("sendto");
    sendto.value = userid;
    fetch("/api/messages/?uid=" + userid)
        .then(response => {
            return response.json();
        })
        .then(messages => {
            putMessages(messages);
        })
}

function putMessages(messages){
    messagelist = document.getElementById("messages");
    messagelist.innerHTML = "";
    for(var i in messages){
        message = messages[i];
        var li = document.createElement("LI");
        li.classList.add("message");
        if(message["sender"] == uid){
            li.classList.add("send");
        }else{
            li.classList.add("receive");
        }
        li.innerText = message["content"];
        messagelist.appendChild(li);
    }
    scrollChat();
}

function scrollChat(){
    chatWindow = document.getElementById('scroll'); 
    var xH = chatWindow.scrollHeight; 
    chatWindow.scrollTo(0, xH);
}

function sendMessage(form){
    children = form.children;
    sendto = children[0].value;
    message = children[1].value;
    data = "sendto="  + sendto + "&message=" + message;
    postData("/api/messages/",data)
        .then(() => {
            children[1].value = "";
            getMessages(sendto)
        });
}

async function postData(url = '', data) {
    // Default options are marked with *
    const response = await fetch(url, {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, *cors, same-origin
      cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow', // manual, *follow, error
      referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: data // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
  }

function setupPage(){
    getUsers();
    scrollChat();
    form = document.getElementById("sender");
    sendbtn = document.getElementById("btnSend");
    sendbtn.onclick = function(){
        sendMessage(form);
      };
}

setupPage();
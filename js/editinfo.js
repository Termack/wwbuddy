function hidePage(){
    var elem = document.getElementById("editPage");
    var pos = 0;
    var body = document.getElementsByTagName("BODY")[0];
    var id = setInterval(frame, 5);
    function frame() {
        if (pos >= 100) {
            clearInterval(id);
            elem.style.display = "none";
            body.style.overflowY = "scroll";
        } else {
            pos += 3;
            elem.style.top = pos + '%';
        }
    }
}

function showPage(){
    var elem = document.getElementById("editPage");
    var pos = 100;
    var body = document.getElementsByTagName("BODY")[0];
    body.style.overflowY = "hidden";
    elem.style.display = "block";
    var id = setInterval(frame, 5);
    function frame() {
        if (pos <= 0) {
            elem.style.top = 0;
            clearInterval(id);
        } else {
            pos -= 3;
            elem.style.top = pos + '%';
        }
    }
}
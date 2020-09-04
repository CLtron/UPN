var usr_value;
var server = new XMLHttpRequest();

function Initialize() {
  console.log("Javascript enabled!");
}

function getValue() {
  usr_value = document.getElementById("username").value;
  console.log(usr_value);
}

function send_msg() {

server.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
       // Typical action to be performed when the document is ready:
       document.getElementById("chat").innerHTML = server.responseText;
    }
};

server.open("GET", "chat.txt",);
server.send();
};

function put() {
  var aX = new ActiveXObject("Scripting.FileSystemObject");
  //aX.CreateTextFile("chat.txt");
  var file = aX.GetFile("chat.txt");
  var writefile = file.OpenAsTextStrem(2);
  writefile.Write(document.getElementById("msg").innerHTML.value);
}

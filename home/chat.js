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

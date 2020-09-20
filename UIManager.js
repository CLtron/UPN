//wait to load the page
var reloadAllowed = true;   // a variable that has to be true before this code can reload the page. (to avoid reload loops)
var refreshInterval = 1000;
var request = new XMLHttpRequest();

$("#alert").hide();

function sendToSignup() {
    window.location.href = "/overview.php?action=signup";
}

function sendToLogin() {
    window.location.href = "/overview.php?action=login";
}

function sendToLogout() {
    window.location.href = "/authentication/logout.service.php";
}

function deleteFromContact(contact) {
    if(contact != null) {
        request.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                alert(contact + " wurde aus deinen Kontakten entfernt.");
                if(reloadAllowed) {
                    location.reload();
                    reloadAllowed = false;
                }
            }
        }

        request.open("GET", "ContactManager.php?action=delete&contact=" + contact);
        request.send(); // "execute" request
    }
}

$(document).ready(function() {
    var refresh;
    var oldResponse = null;

    //load personal contact UI -> MAIN UI --------------------------------------------------------------------------
    $("#box").show();                               //all elements are defined, jquery controls there behavior 
    $(".master").hide();
    $("#btn-contact").addClass("underline");
    $("#btn-explore").removeClass("underline");
    $("#btn-explore").show();

    clearInterval(refresh); // use global interval variable to refresh current content

    if(document.getElementById("box") != null) {    //display a load animation till the server response to the first request
        document.getElementById("box").innerHTML = '<div id="loaderLow"></div>';
    }
    
    refresh = setInterval(function() { // fist interval update every 2000 milliseconds (2 sec.) the main UI (-> personal contact list)

        request.onreadystatechange = function() { // first request to load the main UI
            if(this.readyState == 4 && this.status == 200) { // wait for headers

                if(this.responseText != oldResponse) {
                    oldResponse = this.responseText;

                    reloadAllowed = true; //enable page reload again

                    if(this.responseText == null || this.responseText == "") { // dispaly "empty" message if the response is null
                        document.getElementById("box").innerHTML = '<div id="info">Keine Kontakte!</div>';
                    }
                    else if(document.getElementById("box") != null) {
                        document.getElementById("box").innerHTML = this.responseText;
                    }
    
                    // initialize contact selector function 
                    var name; 
                    $(".latest h3").click(function(e) { //select user from perosnal contact list
                        clearInterval(refresh); // delete previous interval 
                        //specify target
                        e.preventDefault();
                        name = jQuery(this).text(); // get the selected contact name
                        setCookie("contact", name);
    
                        //load chat
                        if(name != "") {
                            $("#box").hide();               //reform the UI
                            $(".master").show();
                            $("#btn-explore").hide();
                            $("#btn-contact").removeClass("underline");
                            $("#btn-explore").removeClass("underline");
                            
                            oldResponse = null;
                            var response;
                            document.getElementById("msg").innerHTML = '<div id="loaderCenter"></div>'; // display new loading animation while waiting for responses
                            refresh = setInterval(function() {
                                request.onreadystatechange = function() {
                                    if(this.readyState == 4 && this.status == 200) {
                                        //build chat   
                                        if(this.responseText == null) {alert("Error: Internetverbindung verloren!")}
                                        response = this.responseText; // chat content
                                                
                                        $("#btn-contact").click(function(e) { // reload click listener for main MARKER
                                            if(reloadAllowed) {
                                                location.reload();
                                                reloadAllowed = false; //disable page reload to avoid a reload loop
                                            }
                                        });
                                    }
                                };
                                request.open("GET", "DataManager.php?with=" + name);
                                request.send(); // "execute" request
    
                                if(response != oldResponse && response != null) {
                                    document.getElementById("msg").innerHTML = response;
                                    document.getElementById("msg").lastChild.scrollIntoView(true);    
                                    oldResponse = response;
                                }
    
    
                            }, refreshInterval);
                            
                        }
    
                    });
    
                    //btn-explore sub1 ---------------------------------------------------------------------
                    $("#btn-explore").click(function(e) { // add contact function
                        clearInterval(refresh);
    
                        $("#box").show();       //reform UI
                        $(".master").hide();
                        $("#btn-contact").removeClass("underline");
                        $("#btn-explore").addClass("underline");
    
    
                        //load explore UI
                        request.onreadystatechange = function() {
                            if(this.readyState == 4 && this.status == 200) { // wait for response
                                
                                if(this.responseText == null || this.responseText == "") {
                                    document.getElementById("box").innerHTML = '<div id="info">Keiner da!</div>';
                                }
                                else {
                                    document.getElementById("box").innerHTML = this.responseText; // available contacts
                                }
    
                                $(".latest h3").click(function(e) { //reload click listener for open contact list
                                    //specify target
                                    e.preventDefault();
                                    name = jQuery(this).text();
                    
                                    if(name != "") {            
                                        request.onreadystatechange = function() {
                                            if(this.readyState == 4 && this.status == 200) {  
                                                alert(name + " wurde zu deinen Kontakten hinzugefügt.");
                                                if(reloadAllowed) {
                                                    location.reload();
                                                    reloadAllowed = false;
                                                }
                                            }
                                        };
                                        request.open("GET", "ContactManager.php?action=add&contact=" + name + "&msg=latest") //add header
                                        request.send();
                                        
                                    }               
                                });
    
                                $("#btn-contact").click(function(e) { //reload click listener for main menu
                                    if(reloadAllowed) {
                                        location.reload();
                                        reloadAllowed = false;
                                    }
                                    
                                });
                    
                            }
                        }
    
                        request.open("GET", "ContactManager.php?action=list");
                        request.send();
                        
                    });
                    // btn-explore sub1 ---------------------------------------------------------------------
                }
            }
        }

        request.open("GET", "ContactManager.php?action=contactlist");
        request.send();

    }, refreshInterval);
    
    // MAIN UI --------------------------------------------------------------------------


    //send message listener
    $("#msg-send").click(function() {
        var msg = $("#msg-input").val();
       
        if(msg != null && msg != "") {
            //send msg
            request.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    //build chat   
                    if(this.responseText == null) {alert("response is null")}
                    // document.getElementById("msg").innerHTML = this.responseText; Don't write this to the form
                    $("#msg-input").val("");
                }
            };
            
            request.open("GET", "DataManager.php?with=" + getCookie("contact") + "&msg=" + msg);
            request.send();

        }
    });


});

//define function set Cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//define function get Cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
}



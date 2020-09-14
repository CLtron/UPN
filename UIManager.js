function sendToSignup() {
    window.location.href = "/overview.php?action=signup";
}

function sendToLogin() {
    window.location.href = "/overview.php?action=login";
}

function sendToLogout() {
    window.location.href = "/authentication/logout.service.php";
}

//wait to load the page
var reloadAllowed = true;
$(document).ready(function() {
    var refresh;
    var request;
    var oldResponse = null;

    //load personal contact UI -> MAIN UI --------------------------------------------------------------------------
    $("#box").show();
    $(".master").hide();
    $("#btn-contact").addClass("underline");
    $("#btn-explore").removeClass("underline");
    $("#btn-explore").show();

    clearInterval(refresh);
   
    request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            reloadAllowed = true; //enable page reload again

            document.getElementById("box").innerHTML = this.responseText;
            //contact selector
            var name;
            $(".latest h3").click(function(e) { //select user from perosnal contact list
                //specify target
                e.preventDefault();
                name = jQuery(this).text();
                setCookie("contact", name);

                //load chat
                if(name != "") {
                    $("#box").hide();
                    $(".master").show();
                    $("#btn-explore").hide();
                    $("#btn-contact").removeClass("underline");
                    $("#btn-explore").removeClass("underline");
                    
                    oldResponse = null;
                    document.getElementById("msg").innerHTML = '<div id="loader"></div>';
                    refresh = setInterval(function() {
                        request = new XMLHttpRequest();
                        request.onreadystatechange = function() {
                            if(this.readyState == 4 && this.status == 200) {
                                //build chat   
                                if(this.responseText == null) {alert("Error: Internetverbindung verloren!")}
                                var response = this.responseText;
                                
                                if(response != oldResponse) {
                                    document.getElementById("msg").innerHTML = response;
                                    document.getElementById("msg").lastChild.scrollIntoView(true);    
                                    oldResponse = response;
                                }
        
                                $("#btn-contact").click(function(e) { // reload click listener for main MARKER
                                    if(reloadAllowed) {
                                        location.reload();
                                        reloadAllowed = false; //disable page reload to avoid a reload loop
                                    }
                                });
                            }
                        };
                        request.open("GET", "DataManager.php?with=" + name)
                        request.send();



                    }, 500);
                    
                }   

             });

            //btn-explore sub1 ---------------------------------------------------------------------
            $("#btn-explore").click(function(e) {
                $("#box").show();
                $(".master").hide();
                $("#btn-contact").removeClass("underline");
                $("#btn-explore").addClass("underline");


                //load explore UI
                request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if(this.readyState == 4 && this.status == 200) {
                        document.getElementById("box").innerHTML = this.responseText;

                        $(".latest h3").click(function(e) { //reload click listener for open contact list
                            //specify target
                            e.preventDefault();
                            name = jQuery(this).text();
            
                            if(name != "") {            
                                request = new XMLHttpRequest();
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

    request.open("GET", "ContactManager.php?action=contactlist");
    request.send();
    
    // MAIN UI --------------------------------------------------------------------------




    //send message listener
    $("#msg-send").click(function() {
        var msg = $("#msg-input").val();
       
        if(msg != null && msg != "") {
            //send msg
            request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    //build chat   
                    if(this.responseText == null) {alert("response is null")}
                    document.getElementById("msg").innerHTML = this.responseText;
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



function rememberMe() {
    var email = document.forms["loginForm"]["idemail"].value;
    var password = document.forms["loginForm"]["idpassword"].value;
    var rememberMe = document.forms["loginForm"]["idremember"].checked;
    console.log("Form data:" + rememberMe + "," + email + "," + password);
    if (!rememberMe) {
        setCookies("cemail", "", 0);
        setCookies("cpassword", "", 0);
        setCookies("crememberMe", false, 0);
        document.forms["loginForm"]["idemail"].value = "";
        document.forms["loginForm"]["idpassword"].value = "";
        document.forms["loginForm"]["idremember"].checked = false;
        alert("Credentials removed");
    } else {
        if (email == "" || password == ""){
            document.forms["loginForm"]["idremember"].checked = false;
            alert("Please enter your credentials");
            return false;
        } else{
            setCookies("cemail", email, 30);
            setCookies("cpassword", password, 30);
            setCookies("crememberMe", rememberMe, 30);
            alert("Credentials Stored Success");
        }
    }
}

function setCookies(cookiename, cookiedata, exdays){
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cookiename + "=" + cookiedata + ";" + expires + ";path=/";
}

function loadCookies() {
    var email = getCookies("cemail");
    var password = getCookies("cpassword");
    var rememberMe = getCookies("crememberMe");
    console.log("COOKIES:" + email, password, rememberMe);
    document.forms["loginForm"]["idemail"].value = email;
    document.forms["loginForm"]["idpassword"].value = password;
    if (rememberMe){
        document.forms["loginForm"]["idremember"].checked = true;
    }else{
        document.forms["loginForm"]["idremember"].checked = false;
    }
}

function getCookies(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i=0; i < ca.length; i++){
        var c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0){
            return c.substring(name.length, c.length);
        }
    }
    return ""; 
}

function deleteCookie(cname){
    const d = new Date();
    d.setTime(d.getTime() + (24*60*60*1000));
    let expires = "expires=" + d.toUTCString();
    document.coo
    kie = cname + "=;" + expires + ";path+/";
}

function acceptCookieConsent(){
    deleteCookie('user_cookie_consent');
    setCookies('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}
/* 

I built this login form to block the front end of most of my freelance wordpress projects during the development stage. 

This is just the HTML / CSS of it but it uses wordpress's login system. 

Nice and Simple

*/


function showLogin() {

    $("#login-div").removeAttr("hidden");
    $("#logbtn").attr("hidden", "hidden");

}

function showRegistration() {

    $("#reg-div").removeAttr("hidden");
    $("#logbtn").attr("hidden", "hidden");
}

/**
 * Created by Salifu on 9/5/2015.
 */
$(function() {

    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

});

function sendRequest(u){
    // Send request to server
    //u a url as a string
    //async is type of request
    var obj=$.ajax({url:u,async:false});
    //Convert the JSON string to object
    var result=$.parseJSON(obj.responseText);
    return result;	//return object

}

$(function () {
  $('#login-form').submit(function(e) {
    e.preventDefault();
    signIn();
  });
});

function signIn(){
    var username = $("#username").val();
    var password = $("#password").val();
    var user_type = $("#user_type").val();

    if(user_type == 0){
        alert("You must choose a user type");
        return;
    }
    if(username.length <= 1){
        alert("Enter correct username");
        return;
    }

    if(password.length < 6){
        alert("Password must be at least 6 characters!");
        return;
    }

    var strUrl = "controller/controller.php?cmd=1&username="+username+"&password="+password+"&user_type="+user_type;
    var objResult = sendRequest(strUrl);
    if(objResult.result == 0){
        alert(objResult.message);
        return;
    }
    window.location.href = "home.html";
    print(" Welcome " + getUsername());
    }

function getUserDetails(){
    var strUrl = "controller/controller.php?cmd=2";
    var objResult = sendRequest(strUrl);

    if(objResult.result == 0){
        alert("nothing");
        alert(objResult.message);
        window.location.href = "index.html";
        return;
    }
    alert(objResult.username+"  "+objResult.user_type);
    return;
}

function getBooks(){
    var strUrl = "controller/controller.php?cmd=3";
    var objResult = sendRequest(strUrl);

    if(objResult.result == 0){
        alert("no books");
        return;
    }
    var books = objResult.books;
    var thebooks = "";
    for(i = 0; i < books.length; i++){
        thebooks += "<br>"+books[i]['title'];
    }
    document.getElementById("books").innerHTML = thebooks;
}


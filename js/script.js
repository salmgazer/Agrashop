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

$(function () {
  $('#searchInput').keyup(function(e) {
    e.preventDefault();
    getBooks();
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
    var searchEntry = $("#searchInput").val();
    var strUrl = "controller/controller.php?cmd=3&searchEntry="+searchEntry;
    var objResult = sendRequest(strUrl);

    if(objResult.result == 0){
        alert("no books");
        return;
    }
    var books = objResult.books;
    document.getElementById("books").innerHTML = "";
    for(i = 0; i < books.length; i++){
        var singleBook = document.createElement("div");

        singleBook.innerHTML = '<div class="col-sm-2" style="margin-bottom: 50px;"><div class="book-content"><img src=img/'+books[i]['photo']+' class="book_cover"/><h5 class="book-title">'+books[i]['title']+'</h5><h6 class="author"><span class="author-icon"> </span> Author: <span>'+books[i]['author']+'</span></h6><h6 class="publisher">Publisher: <span>'+books[i]['publisher']+'</span></h6><h6 class="book-subject">Subject: <span>'+books[i]['subject']+'</span></h6><h5 class="quantity">Quantity: <span>'+books[i]['quantity']+'</span></h5><h6>Retail: <span class="retail_price"> GH¢'+books[i]['retail_price']+'</span></h6><h6>Wholesale: <span class="wholesale_price"> GH¢'+books[i]['wholesale_price']+'</span></h6><div><a href="" class="btn btn-default update-book"> Update Book</a><a href="" class="btn btn-default sell-book">Sell Book</a></div></div></div>';

        document.getElementById("books").appendChild(singleBook);
    }
}

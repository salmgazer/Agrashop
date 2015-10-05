/**
 * Created by Salifu on 9/5/2015.
 */

//stores id of selected book
var current_book_id = -10;
//stores details of a selected book
var current_book = [];
//stores details of a sale
var sale = [];

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
        document.getElementById("searchReport").innerHTML = '<div class="row"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>No books with key words '+searchEntry+' found.</strong></div></div>';
        return;
    }
    var books = objResult.books;
    document.getElementById("books").innerHTML = "";
    for(i = 0; i < books.length; i++){
        var singleBook = document.createElement("div");

        singleBook.innerHTML = '<div class="col-sm-3" style="margin-bottom: 50px;"><div class="book-content"><img src=img/'+books[i]['photo']+' class="book_cover"/><h5 class="book-title">'+books[i]['title']+'</h5><h6 class="author"><span class="author-icon"> </span> Author: <span>'+books[i]['author']+'</span></h6><h6 class="publisher">Publisher: <span>'+books[i]['publisher']+'</span></h6><h6 class="book-subject">Subject: <span>'+books[i]['subject']+'</span></h6><h5 class="quantity">Quantity: <span>'+books[i]['quantity']+'</span></h5><h6>Retail: <span class="retail_price"> GH¢'+books[i]['retail_price']+'</span></h6><h6>Wholesale: <span class="wholesale_price"> GH¢'+books[i]['wholesale_price']+'</span></h6><div><button class="btn btn-default sell-book" onclick="sellBook('+books[i]['id']+')">Sell Book</button></div></div></div>';

        document.getElementById("books").appendChild(singleBook);
    }
}

function sellBook(book_id){
    current_book_id = book_id;
    //alert(current_book_id);
    document.getElementById("books").innerHTML = "";
    document.getElementById("searchArea").innerHTML = "";
    document.getElementById("searchReport").innerHTML = "";
    window.location.href = "#sellBook";
    getBookById(current_book_id);
}

function getBookById(current_book_id){
    //alert(current_book_id);
    var str_url = "controller/controller.php?cmd=4&current_book_id="+current_book_id;
    objResult = sendRequest(str_url);

    if(objResult.result == 1){
        current_book = objResult.singleBook;
        alert(current_book[0]['author']);
        alert(current_book[0]['ISBN']);
        var title = current_book[0]['title'];
        $("#sellBook").load('views/sellBook.html');
        //document.getElementById('book_cover').innerHTML = "here"//'<img src='+current_book[0]['photo']+' class="book_cover" />';
        document.getElementById('book_title').innerHTML = title;
        document.getElementById('author').innerHTML = current_book[0]['author'];
        document.getElementById('ISBN').innerHTML = current_book[0]['ISBN'];
        alert(current_book[0]['ISBN']);
        document.getElementById('publisher').innerHTML = current_book[0]['publisher'];
        document.getElementById('sublect').innerHTML = current_book[0]['subject'];
        document.getElementById('retail_price').innerHTML = current_book[0]['retail_price'];
        document.getElementById('wholesale_price').innerHTML = current_book[0]['wholesale_price'];
    }
    else{
        current_book = [];
        alert("Book not found");
    }
}

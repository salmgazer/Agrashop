/**
 * Created by Salifu on 9/5/2015.
 */

//controller url
var ctrUrl = "controller/controller.php?cmd=";
//stores id of selected book
var current_book_id = -10;
//stores details of a selected book
var current_book = [];
//stores details of a sale
var cart = [];

//stores the latest cart's id
var latest_cart_id;

//Array to store current sale
var sale = {
    book_id: -10,
    sale_type: "none",
    quantity: 0,
    singleCost: 0,
    totalCost: 0
};

//current sale details
var current_sale_cost_single;
var current_sale_quantity;
var current_sale_cost;
var current_sale_type;

//user details
var current_username;
var current_usertype;

//in charge of login page animations
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

//Ajax sendRequest function
function sendRequest(u){
    // Send request to server
    //u a url as a string
    //async is type of request
    var obj=$.ajax({url:u,async:false});
    //Convert the JSON string to object
    var result=$.parseJSON(obj.responseText);
    return result;	//return object

}

//signIn events
$(function () {
  $('#login-form').submit(function(e) {
    e.preventDefault();
    signIn();
  });
});

//Register user events
$(function () {
  $('#register-form').submit(function(e) {
    e.preventDefault();
    registerUser();
  });
});

//search event
$(function () {
  $('#searchInput').keyup(function(e) {
    e.preventDefault();
    getBooks();
  });
});


//sign in function
function signIn(){
    var username = $("#username").val();
    var password = $("#password").val();

    if(username.length <= 1){
        alert("Enter correct username");
        return;
    }

    if(password.length < 6){
        alert("Password must be at least 6 characters!");
        return;
    }

    var strUrl = ctrUrl+"1&username="+username+"&password="+password;
    var objResult = sendRequest(strUrl);
    if(objResult.result == 0){
        alert(objResult.message);
        return;
    }
    getUserDetails();
    window.location.href = "home.html";
    }

function registerUser(){
    var seller_name = $("#seller_name").val();
    var seller_username = $("#seller_username").val();
    var seller_password = $("#seller_password").val();
    var seller_phone = $("#seller_phone").val();
    var seller_type = $("#seller_type").find(":selected").text();
    var admin_password = $("#admin_password").val();
    
    var strUrl = ctrUrl+"5&seller_name="+seller_name+"&seller_username="+seller_username+"&seller_password="+seller_password+
    "&seller_phone="+seller_phone+"&seller_type="+seller_type+"&admin_password="+admin_password;
    
    var objResult = sendRequest(strUrl);
    alert(objResult.message);
}    
    

//function to get details of user
function getUserDetails(){
    var strUrl = "controller/controller.php?cmd=2";
    var objResult = sendRequest(strUrl);

    if(objResult.result == 0){
        alert("nothing");
        alert(objResult.message);
        window.location.href = "index.html";
        return;
    }
    current_username = objResult.username;
    current_usertype = objResult.user_type;
    //alert(objResult.username+"  "+objResult.user_type);
    return;
}

//Function to get all books in search query
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

//function to get details fo a specific book
function getBookById(current_book_id){
    //alert(current_book_id);
    var str_url = "controller/controller.php?cmd=4&current_book_id="+current_book_id;
    objResult = sendRequest(str_url);

    if(objResult.result == 1){
        current_book = objResult.singleBook;
        var title = current_book[0]['title'];
        //$("#sellBook").load('views/sellBook.html');
        document.getElementById('book_cover').innerHTML = '<img src=img/'+current_book[0]['photo']+' class="book_cover" />';
        document.getElementById('book_title').innerHTML = title;
        document.getElementById('author').innerHTML = current_book[0]['author'];
        document.getElementById('ISBN').innerHTML = current_book[0]['ISBN'];
        document.getElementById('publisher').innerHTML = current_book[0]['publisher'];
        document.getElementById('subject').innerHTML = current_book[0]['subject'];
        document.getElementById('wholesale_price').innerHTML = current_book[0]['wholesale_price'];
        document.getElementById('retail_price').innerHTML = current_book[0]['retail_price'];
        document.getElementById("sale_type").innerHTML = '<option value="0">--Select sale type---</option><option id="whole" value="'+current_book[0]['wholesale_price']+'">Wholesale :'+current_book[0]['wholesale_price']+'</option><option id="retail" value="'+current_book[0]['retail_price']+'">Retail : GH¢'+current_book[0]['retail_price']+'</option>';
    }
    else{
        current_book = [];
        alert("Book not found");
    }
}

//function to start sell page of a single book
function sellBook(book_id){
    current_book_id = book_id;
    //alert(current_book_id);
    document.getElementById("books").innerHTML = "";
    document.getElementById("searchArea").innerHTML = "";
    document.getElementById("searchReport").innerHTML = "";
    window.location.href = "#sellBook";
    getBookById(current_book_id);
    document.getElementById("seller").innerHTML = current_username;
    if(cart.length == 0){
        document.getElementById("cart_state").innerHTML = "Empty";
        document.getElementById("cart_id").innerHTML = "none";
    }
    else{
        document.getElementById("cart_state").innerHTML = "shopping";
        document.getElementById("cart_id").innerHTML = cart['id'];
    }
    document.getElementById("available").innerHTML = current_book[0]['quantity'];
}

//update sale cost
function updateCurrentCost () {
    var costSingle = document.getElementById('sale_type').options[document.getElementById('sale_type').selectedIndex].value;
    current_sale_type = document.getElementById('sale_type').options[document.getElementById('sale_type').selectedIndex].id;
    if(costSingle == 0) {
        alert("Select a sale type");
        return;
    }
    //set current sale cost single to its value
    current_sale_cost_single = costSingle;
    //set current sale quantity
    current_sale_quantity = $("#quantity_tosell").val();
    //set current sale total cost
    current_sale_cost = current_sale_cost_single * current_sale_quantity;
    document.getElementById('current_sale_cost').innerHTML = current_sale_cost;
}

function addToCart(){
   cart[cart.length] = [current_book_id, current_sale_type, current_sale_quantity, current_sale_cost_single, current_sale_cost];
    var currentSale = cart[cart.length];
    alert(currentSale[0]);
}



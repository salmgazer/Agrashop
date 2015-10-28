/**
 * Created by Salifu on 9/5/2015.
 */

//controller url
var ctrUrl = "controller/controller.php?cmd=";
//stores id of selected book
//var current_book_id = -10;
//stores details of a selected book
//var current_book = [];
//stores details of a sale
//var cart = [];

//stores the latest cart's id
//var latest_cart_id;

//Array to store current sale
/*var sale = {
    book_id: -10,
    sale_type: "none",
    quantity: 0,
    singleCost: 0,
    totalCost: 0
};
*/

//current sale details
var current_sale_cost_single;
var current_sale_quantity;
var current_sale_cost;
var current_product;

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
    getProducts();
  });
});

//search event
$(function () {
  $('#addProduct_form').submit(function(e) {
    e.preventDefault();
    addProduct();
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
    var strUrl = ctrUrl+"2";
    var objResult = sendRequest(strUrl);

    if(objResult.result == 0){
        alert(objResult.message);
        window.location.href = "index.html";
        return;
    }
    current_username = objResult.username;
    current_usertype = objResult.user_type;
    return;
}

function addProduct(){
    var product_id = $("#product_id").val();
    var product_name = $("#product_name").val();
    var product_quantity = $("#product_quantity").val();
    var product_unit_price = $("#product_unit_price").val();

    var strUrl = ctrUrl+"6&product_id="+product_id+"&product_name="+product_name+"&product_quantity="+product_quantity+"&product_unit_price="+product_unit_price;
    var objResult = sendRequest(strUrl);
    alert("me");
    if(objResult.result == 0){

    }else{

    }
    alert(objResult.message);
}

//Function to get all books in search query
function getProducts(){
    var searchEntry = $("#searchInput").val();
    var strUrl = "controller/controller.php?cmd=3&searchEntry="+searchEntry;
    var objResult = sendRequest(strUrl);

    if(objResult.result == 0){
        document.getElementById("searchReport").innerHTML = '<div class="row"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>No books with key words '+searchEntry+' found.</strong></div></div>';
        return;
    }
    var products = objResult.products;
    document.getElementById("books").innerHTML = "";
    for(var i = 0; i < products.length; i++){
        var singleProduct = document.createElement("div");
        var product_id = products[i]['product_id'];

        singleProduct.innerHTML = '<div class="col-sm-3" style="margin-bottom: 50px;"><div class="book-content"><img src="" class="book_cover"/><h5 class="book-title">'+products[i]['product_name']+'</h5><h5>ID: '+product_id+'</h5><h6 class="publisher">Price: <span>Gh&#8373; '+products[i]['product_unit_price']+'</span></h6><h5 class="quantity">Quantity: <span>'+products[i]['product_quantity']+'</span></h5><div><button class="btn btn-default sell-book" onclick=sellProduct("'+product_id+'")>Sell Product</button></div></div></div>';

        document.getElementById("books").appendChild(singleProduct);
    }
}

//function to get details of a book
function getProductById(product_id){
    var strUrl = ctrUrl+"4&current_product_id="+product_id;
    var objResult = sendRequest(strUrl);
    
    if(objResult.result == 0){
        return "false";
    }
    //successfully got product
    return objResult.singleProduct;
}

//function to start sell page of a single book
function sellProduct(product_id){
   // $("#sellBook").load("views/sellProduct.html");  
    var theProduct = getProductById(product_id);
    if(theProduct == "false"){
        alert("Could not get product");
        return;
    }
    var myProd = theProduct[0];
    //alert(myProd['product_name']);
    document.getElementById("seller_username_Sell").innerHTML = current_username;
    document.getElementById("product_name_sell").innerHTML = myProd['product_name'];
    document.getElementById("product_id_sell").innerHTML = myProd['product_id'];
    document.getElementById("product_quantity_sell").innerHTML = myProd['product_quantity'];
    document.getElementById("product_unit_price_sell").innerHTML = myProd['product_unit_price']; 
}

//update sale cost
function updateCurrentCost () {
    var quantity = $("#quantity_tosell").val();
    var price = document.getElementById("product_unit_price_sell").innerHTML * 1;
    document.getElementById("current_sale_cost_sell").innerHTML = quantity * price + "";
}

function addSale(){
    var product_id = document.getElementById("product_id_sell").innerHTML;
    var product_price = document.getElementById("product_unit_price_sell").innerHTML * 1;
    var quantity_sold = $("#quantity_tosell").val() * 1;
    var total_cost = product_price * quantity_sold;
    var buyer_phone = $("#buyer_phone").val() + "";
    var strUrl = ctrUrl+"7&product_id="+product_id+"&product_price="+product_price+"&quantity_sold="+quantity_sold+"&total_cost="+total_cost+"&buyer_phone="+buyer_phone;
    var objesult = sendRequest(strUrl);
    
    if(objesult.result == 0){
        //could not add sale
    }
    alert(objesult.message);
}


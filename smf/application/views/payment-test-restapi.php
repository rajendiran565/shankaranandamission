<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paypal Payment</title>

    <link rel="stylesheet" href="style.css">
</head>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Lato&family=Nunito:wght@300&display=swap");
body {
    font-family: 'Nunito', sans-serif;
}

* > * {
    margin: 0%;
    padding: 0%;
}

.container {
    width: 80%;
    margin: auto;
}

@media screen and (max-width: 768px) {
    .container {
        width: 100%;
    }
}

.text-center {
    text-align: center;
}

.text-white {
    color: white;
}

.text-gray {
    color: #e9ecef;
}

.font-title {
    font-family: 'Lato', sans-serif;
}

/*          Cart.html           */
main#cart-main .site-title h1 {
    margin: 2em 0em;
}

main#cart-main .container > .grid {
    display: -ms-grid;
    display: grid;
    -ms-grid-columns: 3fr 1fr;
    grid-template-columns: 3fr 1fr;
    margin: 0 2rem;
}

main#cart-main .container > .grid > .col-1 > .item {
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
    padding: 1.5em 3em;
}

main#cart-main .container > .grid > .col-1 > .item .img img {
    width: 60%;
}

main#cart-main .container > .grid > .col-1 > .item .buttons {
    margin-top: 1em;
}

main#cart-main .container > .grid > .col-1 > .item .buttons input {
    padding: .3rem .2rem;
    border: 1px solid #e9ecef;
    width: 20%;
    text-align: center;
}

main#cart-main .container > .grid > .col-1 > .item .buttons input:focus {
    outline: none;
}

main#cart-main .container > .grid > .col-1 > .item .buttons button {
    background-color: transparent;
    border: 1px solid #e9ecef;
    padding: .3em .3em;
    margin-bottom: .8rem;
}

main#cart-main .container > .grid > .col-1 > .item a {
    text-decoration: none;
    color: #fca311;
}

main#cart-main .container > .grid > .col-1 > .item .price {
    color: #ef476f;
}

main#cart-main .container > .grid > .col-2 .subtotal {
    border: 1px solid #e9ecef;
    padding: 1em 2.4em;
    margin: 0 2rem;
}

main#cart-main .container > .grid > .col-2 .subtotal > h3 {
    margin-bottom: 1rem;
}

main#cart-main .container > .grid > .col-2 .subtotal ul hr {
    border: 1px solid #e9ecef;
    margin: .3rem 0;
}

main#cart-main .container > .grid > .col-2 .subtotal ul li {
    padding: .2rem 0;
}

main#cart-main .flex {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}

main#cart-main .justify-content-between {
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}

main#cart-main .text-red {
    color: #ef476f;
}
/*# sourceMappingURL=style.css.map */
</style>

<body>
    <main id="cart-main">
        <div class="site-title text-center">
            <h1 class="font-title">Shopping Cart</h1>
        </div>

        <div class="container">
            <div class="grid">
                <div class="col-1">
                    <div class="flex item justify-content-between">
                        <div class="flex">
                            <div class="img text-center">
                                <img src="./assets/pro1.png" alt="">
                            </div>
                            <div class="title">
                                <h3>Canon EOS 1500D</h3>
                                <span>Electronics</span>

                                <div class="buttons">
                                    <button type="submit"><i class="fas fa-chevron-up"></i> </button>
                                    <input type="text" class="font-title" value="1">
                                    <button type="submit"><i class="fas fa-chevron-down"></i> </button>
                                </div>
                                <a href="#">Save for later</a> |
                                <a href="#">Delete From Cart</a>
                            </div>
                        </div>
                        <div class="price">
                            <h4 class="text-red">$349</h4>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="subtotal text-center">
                        <h3>Price Details</h3>

                        <ul>
                            <li class="flex justify-content-between">
                                <label for="price">Products ( 3 items ) : </label>
                                <span>$399</span>
                            </li>
                            <li class="flex justify-content-between">
                                <label for="price">Delivery Charges : </label>
                                <span>Free</span>
                            </li>
                            <hr>
                            <li class="flex justify-content-between">
                                <label for="price">Amout Payble : </label>
                                <span class="text-red font-title">$399</span>
                            </li>
                        </ul>
                        <div id="paypal-payment-button">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="https://www.paypal.com/sdk/js?client-id=AfEZmoS3vcSSNrp-mLqWbAwLQrmGOYhcD7WTbhWmRV2cPYlTZ3dMIQjFwuXaemTVqrFUDNRWsJaEEz8I&disable-funding=credit,card"></script>
  
    <script>
    
       paypal.Buttons({
        style : {
        color: 'blue',
        shape: 'pill'
    },
    createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units : [{
                amount: {
                    value: '10.00'
                }
            }]
        });
    },
    onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
            console.log(details)
            window.location.replace("http://shankaranandamissionfoundation.com/paypalandroid/success1")
        })
    },
    onCancel: function (data) {
        window.location.replace("http://shankaranandamissionfoundation.com/paypalandroid/cancel")
    }
}).render('#paypal-payment-button'); 
        
        
    </script>
</body>
</html>

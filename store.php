<?php
// Landing PAGE

include "./header.php";
?>
<script src='./jrsArt.js'></script>
<div class="container">
<div class="row">
    <div id="store-heading" class="col-md-10 col-md-offset-1 center-it">
		Online Store to Benefit the <a target="_blank" class="press-links" href="https://www.vtfoodbank.org/">Vermont Food Bank</a>. 
        <br/>100% of sales go to the Food Bank.
    </div>
</div>
<br/>
<div id="store-items"></div>
<script>
    var storeItemsArray = [
        {
            "imgSrc": "http://jamessecor.com/img/TreesontheNorthBranch2016.jpg",
            "itemNumber": "1",
            "title": "Trees on the North Branch"
        },
        {
            "imgSrc": "http://jamessecor.com/img/teacup.jpg",
            "itemNumber": "5",
            "title": "Espresso at Art Hop"
        },
        {
            "imgSrc": "http://jamessecor.com/img/IMG_20200308_112616.jpg",
            "itemNumber": "2",
            "title": "Modern Social Hour II"
        },
        {
            "imgSrc": "http://jamessecor.com/img/animalMug_dish_andGlass_I.jpg",
            "itemNumber": "3",
            "title": "animal mug, dish, and glass I"
        },        
        {
            "imgSrc": "http://jamessecor.com/img/FadingLight2016.jpg",
            "itemNumber": "7",
            "title": "Fading Light"
        },
        {
            "imgSrc": "http://jamessecor.com/img/IMG_20191207_102302.jpg",
            "itemNumber": "6",
            "title": "animal mug, dish, and glass II"
        },        
        {
            "imgSrc": "http://jamessecor.com/img/TrademoreShoppingCenter2017.jpg",
            "itemNumber": "8",
            "title": "Trademore Shopping Center"
        },
        {
            "imgSrc": "http://jamessecor.com/img/DeliveryCorridor2018.jpg",
            "itemNumber": "9",
            "title": "Delivery Corridor"
        },
        {
            "imgSrc": "http://jamessecor.com/img/barcodes2019.jpg",
            "itemNumber": "4",
            "title": "Barcodes"
        },
        {            
            "imgSrc": "http://jamessecor.com/img/TreesontheNorthBranch2016.jpg;"
                        + "http://jamessecor.com/img/teacup.jpg;" 
                        + "http://jamessecor.com/img/animalMug_dish_andGlass_I.jpg;"
                        + "http://jamessecor.com/img/IMG_20200308_112616.jpg;"
                        + "http://jamessecor.com/img/barcodes2019.jpg;"
                        + "http://jamessecor.com/img/DeliveryCorridor2018.jpg",
            "itemNumber": "10",
            "title": "Mix Pack - assorted images"
        }
        
    ];

    function displayStoreItems(dataArray) {
        var out = '';
        for(var i = 0; i < dataArray.length; i++) {
            if(i % 3 == 0) {
                out += '<div class="row store-row">';
            }
            var imgSources = dataArray[i].imgSrc.split(";");
            var width = 100 / imgSources.length;
            out += '<div class="col-md-4">';
            for(var j = 0; j < imgSources.length; j++) {
                out += '<img width="' + width + '%" src="' + imgSources[j] + '"/>';
            }
            out += '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" >'
                + '<input type="hidden" name="cmd" value="_cart">'
                + '<input type="hidden" name="business" value="james.secor@gmail.com">'
                + '<input type="hidden" name="lc" value="US">'
                + '<input type="hidden" name="item_name" value="Postcards - ' + dataArray[i].title + '">'
                + '<input type="hidden" name="item_number" value="' + dataArray[i].itemNumber + '">'
                + '<input type="hidden" name="button_subtype" value="products">'
                + '<input type="hidden" name="no_note" value="0">'
                + '<input type="hidden" name="tax_rate" value="6.000">'
                + '<input type="hidden" name="shipping" value="0.00">'
                + '<input type="hidden" name="add" value="1">'
                + '<input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_LG.gif:NonHostedGuest">'
                + '<table>'    
                + '<tr><td>' + dataArray[i].title + '</td></tr>'
                + '<tr><td><input type="hidden" name="on0" value="Postcards">4.5 x 5.5 inch postcards</td></tr><tr><td><select name="os0">'
                + '    <option value="5 cards">5 cards $20.00 USD</option>'
                + '    <option value="10 cards">10 cards $35.00 USD</option>'
                + '    <option value="15 cards">15 cards $45.00 USD</option>'
		        + '</select> </td></tr>'
		        + '<tr><td>'
		        + '	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">'
		        + '	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">'
		        + '</td></tr>'
                + '</table>'
                + '<input type="hidden" name="currency_code" value="USD">'
                + '<input type="hidden" name="option_select0" value="5 cards">'
                + '<input type="hidden" name="option_amount0" value="20.00">'
                + '<input type="hidden" name="option_select1" value="10 cards">'
                + '<input type="hidden" name="option_amount1" value="35.00">'
                + '<input type="hidden" name="option_select2" value="15 cards">'
                + '<input type="hidden" name="option_amount2" value="45.00">'
                + '<input type="hidden" name="option_index" value="0">'
                + '</form>'
                + '</div>';
            if(i % 3 == 2 || i == dataArray.length - 1) {
                out += '</div>';
            }
        }            
        document.getElementById("store-items").innerHTML = out;
        console.log($("#store-items").html());
    }

    displayStoreItems(storeItemsArray);
</script>
<?php
include "./footer.php";
?>
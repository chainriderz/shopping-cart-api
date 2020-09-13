# Codeigniter Shopping Cart API (GET, POST)

<h2>Get all Products</h2>
<strong>http://localhost:8080/shopping-cart-api/index.php/Api/getAllProducts</strong>
<p>Request should be a raw with json format</p>
<pre>
	<code>
BODY = RAW
CONTENT TYPE = JSON
METHOD = GET
REQUEST =
{
    
}
RESPONSE =
{
    "response": {
        "status": 200,
        "result": [
            {
                "id": "1",
                "name": "shirts",
                "price": "100",
                "image_path": [
                    "C:\\xampp\\htdocs\\shopping-cart-api\\system\\../img_gallery/shirt2.jpg",
                    "C:\\xampp\\htdocs\\shopping-cart-api\\system\\../img_gallery/shirt3.jpg"
                ]
            },
            {
                "id": "2",
                "name": "pants",
                "price": "233",
                "image_path": [
                    "C:\\xampp\\htdocs\\shopping-cart-api\\system\\../img_gallery/pant2.jpg",
                    "C:\\xampp\\htdocs\\shopping-cart-api\\system\\../img_gallery/pant3.jpg",
                    "C:\\xampp\\htdocs\\shopping-cart-api\\system\\../img_gallery/pant4.jpg"
                ]
            }
        ]
    }
}
	</code>
</pre>

<h2>Add to Cart</h2>
<strong>URL = http://localhost:8080/shopping-cart-api/index.php/Api/addToCart</strong>
<pre>
	<code>
BODY = RAW
CONTENT TYPE = JSON
METHOD = POST
REQUEST =
{
    "user_id" : "1",
    "products":[
        {
            "product_id":"1",
            "quantity":"111"
        },
        {
            "product_id":"2",
            "quantity":"333"
        }
    ]
}
RESPONSE =
{
    "response": {
        "status": 200,
        "result": "User cart updated successfully."
    }
}
	</code>
</pre>




<h2>Get cart by userid</h2>
<strong>URL = http://localhost:8080/shopping-cart-api/index.php/Api/getCart?id=1</strong>

<pre>
	<code>
BODY = RAW
CONTENT TYPE = JSON
METHOD = GET
REQUEST = 
{

}
RESPONSE =
{
    "response": {
        "status": 200,
        "result": [
            {
                "id": "1",
                "product_id": "1",
                "user_id": "1",
                "quantity": "111"
            },
            {
                "id": "2",
                "product_id": "2",
                "user_id": "1",
                "quantity": "333"
            }
        ]
    }
}
	</code>
</pre>
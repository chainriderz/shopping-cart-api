<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        <h2>Add Product form</h2>
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Product Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" placeholder="Enter product name" name="name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="price">Product Price:</label>
                <div class="col-sm-10">          
                    <input type="text" class="form-control" id="price" placeholder="Enter product price" name="price">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="files">Upload images:</label>
                <div class="col-sm-10">          
                    <input type="file" class="form-control" id="files" placeholder="Enter product files" name="files[]" multiple>
                    <p><strong>Note: Supported image format: .jpeg, .jpg, .png</strong></p>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>

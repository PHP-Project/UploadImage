<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once("connection.php");
        ?>
    </head>
    <body>
        <form action="save_image.php" method="post" enctype="multipart/form-data" name="frm_upload">
            Choose Image:<input type="file" name="file">
            <input type="submit" name="btnSubmit" value="Submit">
        </form>
    
    
    </body>
</html>
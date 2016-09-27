<?PHP
    include_once("connection.php");
    //Upload Image
    function notAllowedPHPExtension($file){
        $blacklist = array(".php",".phtml",".php3",".js",".php4","exe");
        foreach($blacklist as $item){
            if(preg_match("/$item\$/i", $_FILES[$file]['name'])){
                return true;
            }
        }
        return false;
    }

    $idir ="photo/"; //Path Image Directory // change here
    $tdir ="photo/thumbs/"; //Path To Thumbnails Directory //change here
    $twidth ="250"; //Maximun Width for thumbnail image
    $theight ="200"; //Maximun Height  for thumbnail image
    
    if(notAllowedPHPExtension('file')){
        echo "<script language=javascript>
                alert(\"Photo Can not Upload\");
                document.location=\"index.php\"; 
        
            </script>"; //alert and go to index
    }
    else{ //If Extension not .php
        $url = strtolower($_FILES['file']['name']);
        
        if(($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/jpeg")
        && ($_FILES["file"]["size"] < 5097152 )){ //size image
            if($_FILES["file"]["error"] > 0){
                $upload_report .="Return Code: ".$_FILES["file"]["error"]."<br />";
            }
            else{
                $fileName = $_FILES['file']['name']; //Get File Name From Upload
                $fileName =preg_replace('#[^a-z.0-9]#i','',$fileName);
                $replacefilename = explode(".",$fileName); //Encryption File Name
                $fileExt = end($replacefilename); //FileExt = File Extension
                $imagename = time().rand().".".$fileExt;
                
                $source = $_FILES['file']['tmp_name'];
                $target = $idir . $imagename;
                
                move_uploaded_file($source,$target);
                
                $imagepath = $imagename;
                $save = $idir . $imagepath; // This Is The New File You Save
                $file = $idir . $imagepath; // This Get Orginal File
                
                list($width , $height) = getimagesize($file);
                
                $modwidth = 500;
                
                $diff = $width / $modwidth;
                
                $modheight = $height / $diff;
                
                $tn = @imagecreatetruecolor($modwidth,$modheight);
                $image = @imagecreatefromjpeg($file);
                @imagecopyresampled($tn,$image,0,0,0,0,$modwidth,$modheight,$width,$height);
                
                $thumb = $tdir . $imagepath;
                
                imagejpeg($tn,$thumb,100);
                
                //End of Create Thumbnail
                
                $gal_filename = $imagename;
                
                $query = "INSERT INTO tbl_image VALUES(NULL,'$gal_filename')";  
                if ($result = $conn->query($query)) {
                    echo "<script language=javascript>
                            alert(\"Photo Successfully\");
                            document.location=\"index.php\";
                        </script>";
                    $result->close();
                }
                //End of Store to Dabatabase  
                else{
                    echo "<script language=javascript>
                            alert(\"Photo Not Successfully\");
                            document.location=\"index.php\";
                        </script>";
                }
                //End Else
            }
        } 
    }
    
//End of Upload Image
    
mysql_close($server_connection);

?>
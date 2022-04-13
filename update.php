<?php

require_once "db.php";
 

$name = $price = $description = $longitude = $latitude = "";
$name_err = $price_err = $description_err = $longitude_err = $latitude_err = "";
 

if(isset($_POST["id"]) && !empty($_POST["id"])){
   
    $id = $_POST["id"];
    
    
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter an price.";     
    } else{
        $price = $input_price;
    }
    
    
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter description.";     
    }  else{
        $description = $input_description;
    }
    $input_longitude = trim($_POST["longitude"]);
    if(empty($input_longitude )){
        $longitude_err = "Please enter longitude .";     
    }  else{
        $longitude  = $input_longitude ;
    }
    $input_latitude = trim($_POST["latitude"]);
    if(empty($input_latitude )){
        $latitude_err = "Please enter latitude .";     
    }  else{
        $latitude  = $input_description;
    }
    
    
    if(empty($name_err) && empty($price_err) && empty($description_err) && empty($longitude_err) && empty($latitude_err)){
        
        $sql = "UPDATE mount SET name=?, price=?, description=?, longitude=?, latitude=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "sssssi", $param_name, $param_price, $param_description,$param_longitude, $param_latitude, $param_id);
            
            
            $param_name = $name;
            $param_price = $price;
            $param_description = $description;
            $param_longitude = $longitude;
            $param_latitude = $latitude;
            $param_id = $id;
            
           
            if(mysqli_stmt_execute($stmt)){
                
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        
        mysqli_stmt_close($stmt);
    }
    
   
    mysqli_close($link);
} else{
    
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
      
        $id =  trim($_GET["id"]);
        
       
        $sql = "SELECT * FROM mount WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            
            $param_id = $id;
            
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                   
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                 
                    $name = $row["name"];
                    $price = $row["price"];
                    $description = $row["description"];
                    $longitude = $row["longitude"];
                    $latitude = $row["latitude"];
                } else{
                    
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        
        mysqli_stmt_close($stmt);
        
        
        mysqli_close($link);
    }  else{
        
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the location record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>price</label>
                            <textarea name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>"><?php echo $price; ?></textarea>
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>description</label>
                            <input type="text" name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $description; ?>">
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>longitude</label>
                            <input type="text" name="longitude" class="form-control <?php echo (!empty($longitude_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $longitude; ?>">
                            <span class="invalid-feedback"><?php echo $longitude_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>latitude</label>
                            <input type="text" name="latitude" class="form-control <?php echo (!empty($latitude_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $latitude; ?>">
                            <span class="invalid-feedback"><?php echo $latitude_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
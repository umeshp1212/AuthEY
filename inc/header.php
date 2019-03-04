<?php $db= new Database()?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Della by Jimmy Mistry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <script src="assets/js/prefixfree.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    

    <link rel="stylesheet" href="main.css">
    
</head>
<body>

<header>
    <div class="container mt-1 mb-1 ">
        <div class="row align-items-center">
        
            <div class="col-md-4 "> 
            <ul class="list-inline">
                <li  class="list-inline-item">Company Profile</li>
                <li  class="list-inline-item">Della Talks</li>
                <li  class="list-inline-item">Business Enquiries</li>
            </ul>
            </div>
            <div class="col-md-4"> 
                <a href="/Auth02"><img class="mx-auto d-block" src="assets/images/logo.png" alt="" srcset=""></a>
            </div>
            <div class="col-md-4"> 
                <ul class="list-inline float-right">
                    <li  class="list-inline-item"><i class="fas fa-search"></i></li>
                    <li  class="list-inline-item"><i class="fas fa-user"></i></li>
                    <li  class="list-inline-item"><i class="fas fa-phone"></i></li>
                    <li  class="list-inline-item"><i class="fas fa-shopping-cart"></i></li>                
                </ul>
            </div>
        </div>
    </div>
    
    <nav class="navbar-expand-lg navbar-light bg-white nav-custom-border"> 
        <div class="container">
        <div class="row">
                <ul class="menu"> 
                    <?php 
                        $query = "SELECT * FROM tbl_Category WHERE ParentCategoryRecId = 0 ORDER BY EYCategorySequence";
                        $read = $db->select($query);
                    ?>
                    <?php if($read) {?>
                        <?php while($row = $read->fetch_assoc()){ ?>
                            <li><a  href="javascript:void(0)"><?php echo $row['CategoryName'];?></a>
                                <ul class="sub-menu">   
                                    <?php 
                                        $rootParent = $row['CategoryRecId'];
                                        $secChildCatQuery =  "SELECT * FROM tbl_Category WHERE ParentCategoryRecId = $rootParent ORDER BY EYCategorySequence";
                                        $readSecChildCatQuery = $db->select($secChildCatQuery);  
                                    ?>
                                    <?php if($readSecChildCatQuery) { ?>
                                        <?php while($row1 = $readSecChildCatQuery->fetch_assoc()){ ?>
                                            <?php $hypen = strtolower(str_replace(" ", "-", $row1['CategoryName']));?>
                                            <li><a href="/Auth02/product-category.php?id=<?php echo $row1['CategoryRecId'];?>"><?php echo $row1['CategoryName'];?></a>
                                                <ul>
                                                    <?php $secParent = $row1['CategoryRecId'];
                                                        $thirdChildCatQuery = "SELECT * FROM tbl_Category WHERE ParentCategoryRecId = $secParent ORDER BY EYCategorySequence";
                                                        $readThirdChildCatQuery = $db->select($thirdChildCatQuery);  
                                                    ?>
                                                    <?php if($readThirdChildCatQuery) {?>
                                                        <?php while($row2 = $readThirdChildCatQuery->fetch_assoc()){ ?>
                                                            <?php $urlHypen = strtolower(str_replace(" ", "-", $row2['CategoryName']));?>
                                                            <li><a href="/Auth02/product-category.php?id=<?php echo $row2['CategoryRecId'];?>"><?php echo $row2['CategoryName'];?></a></li>   
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>      
                                </ul>
                            </li> 
                        <?php } ?>    
                    <?php } ?>
                </ul>                                                                        
        </div>
        </div>
    </nav>        
</header>







<?php 
    include "API/config.php";
    include "API/Database.php";
?>

<?php include "inc/header.php" ?>
<?php $Catid = $_GET['id'];
    if(isset($Catid)){ ?>
        <div class="container mt-4">
            <div class="row">
                <?php 
                $query = "SELECT * FROM tbl_Product WHERE RecIdCategory = $Catid";
                $read = $db->select($query);
                if ($read) {
                    while ($row = $read->fetch_assoc()) {
                        ?>
                    <div class="col-sm-12 col-md-4 col-xs-12 border p-0">
                        <img src="<?php echo $row['Images']; ?>" alt="" width="100%">
                        <h2><?php echo $row['Name']; ?></h2>
                        <p>SKU: <?php echo $row['SKU']; ?></p>
                        <p>Price:<?php echo $row['Price']; ?></p>
                    </div>
                    <?php
                    }
                } else {
                    echo "<h1>No Product Found</h1>";
                } ?>
            </div>
        </div>
    
    
    <?php } ?>      
<?php include "inc/footer.php" ?>

<?php 


include 'config.php';
include 'Database.php';

/*********** Get Access Token *************/
$postdata = http_build_query(
    array (
		'tenant_id'=>'https://login.windows.net/dellagrouponline.onmicrosoft.com',
		'client_id'=>'f156ab73-733c-460b-87c9-14dc7e128c98',
		'client_secret'=>'Vy39jCzxh4CWBBLz92OomhaNwgI+zEjpQtuEeCjM12I=',
		'grant_type'=>'client_credentials',
		'resource'=>'https://della02devecom.sandbox.ax.dynamics.com'
    ) 
);
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context  = stream_context_create($opts);
$result = file_get_contents('https://login.microsoftonline.com/dellagrouponline.onmicrosoft.com/oauth2/token',false,$context);
//$json_auth=json_encode($result);
$json_auth=json_decode($result,true);
//print_r($json_auth);
$access_type=$json_auth['token_type'];
$access_token=$json_auth['access_token'];
/************ Get Access Token ************/







/*************** Get Data ****************/
$opts = array(
		'http'=>array(
		'method'=>"GET",
		'header'=>"Authorization: ".$access_type.' '.$access_token
	)
);
$context = stream_context_create($opts);
$file = file_get_contents('https://della02devecom.sandbox.ax.dynamics.com/api/EYProduct', false, $context);

$webservice_array = json_decode($file);
$db = new Database();

// echo '<pre>';
// print_r($webservice_array);
// echo '</pre>';



//$i=0;
foreach ($webservice_array as $product) {

	$RecordId = $product->RecordId;
	$ItemId = $product->ItemId;
	$SKU = $product->SKU;
	$Name = $product->Name;

	$Images = $product->Images;
	$Images = implode(",", $Images);

	$IsKit = $product->IsKit;
	if($IsKit == true){
		$IsKit = 1;
	}
	

	$RecIdCategory = $product->RecIdCategory;
    $RecIdCategory = implode(",", $RecIdCategory);
	


	$Price = $product->Price;
	$Specification = $product->Specification;
	

	$CreatedDateTimeStamp = strtotime($product->CreatedDateTimeStamp);
	$Description = $product->Description;
	
	$query = "SELECT * FROM tbl_Product WHERE RecordId = $RecordId";
	$read = $db->select($query);

	if($read){
		
		//echo $i++ ."<br>";
		while($row = $read->fetch_assoc()){
			//echo $row['RecordId']."<br>";		
		}
	} else {
		$query = "INSERT INTO tbl_Product(RecordId, ItemId, SKU, Name, Images, IsKit, RecIdCategory, Price, Description, CreatedDateTimeStamp, Specification) 
					VALUES('$RecordId', '$ItemId', '$SKU', '$Name', '$Images', '$IsKit', '$RecIdCategory', '$Price', '$Description', '$CreatedDateTimeStamp', '$Specification')";

		$insert = $db->insert($query);
	}
}

/*************** Get Data ****************/


// foreach($webservice_array as $web){
// 	$web_tstamp=strtotime($web->CreatedDateTimeStamp);
// 	$unique=true;
	//echo 'start_time'.$start_time.'   web_time'.$web_tstamp.'<br>';
//if($start_time<$web_tstamp){
	//echo 'updated_group '.$web->MainGroupCode.'<br>';
	// $MainGroupCode_args = array(
	// 	'taxonomy'   => 'product_cat',
	// 	'hide_empty' => false,
	// 	'meta_query' => array(
	// 		 array(
	// 			'key'       => 'CategoryRecId',
	// 			'value'     => $web->CategoryRecId,
	// 			'compare'   => '='
	// 		 )
	// 	)
	// );
	// $MainGroup=array_keys($MainGroupCode_args);

//$MainGroup=get_terms($MainGroupCode_args);
// echo "<pre>";
// print_r($MainGroupCode_args);
// echo "</pre>";

// echo "<pre>";
// print_r($MainGroup);
// echo "</pre>";


// echo count($MainGroup);
 //}
?>
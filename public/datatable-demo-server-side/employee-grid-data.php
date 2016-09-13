<?php
/* Database connection start */
$servername = "localhost";
$username = "postgres";
$password = "postgre";
$dbname = "laravel_crm";
$port_id = "5432";

//$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
//$conn = pg_connect($servername,$username,$password,$port_id,$dbname)or die("Connection failed: ");
$conn = pg_connect("host=localhost port=5432 dbname=laravel_crm user=postgres password=welcome-123") or die('Could not connect: ' . pg_last_error());
/* Database connection end */


// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;


$columns = array(
// datatable column index  => database column name
	0 =>'action_id',
	1 => 'created_at',
	2=> 'updated_at'
);

// getting total number records without any search
$sql = "SELECT action_id, created_at, updated_at";
$sql.=" FROM users_logs";
$query=pg_query($conn,$sql) or die("employee-grid-data.php: get employees");
$totalData = pg_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT action_id, created_at, updated_at";
$sql.=" FROM users_logs WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( action_id LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR created_at LIKE '".$requestData['search']['value']."%' ";

	$sql.=" OR updated_at LIKE '".$requestData['search']['value']."%' )";
}
$query=pg_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = pg_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
//$query=pg_num_rows($conn,$sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=pg_fetch_array($query) ) {  // preparing an array
	$nestedData=array();

	$nestedData[] = $row["action_id"];
	$nestedData[] = $row["created_at"];
	$nestedData[] = $row["updated_at"];

	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

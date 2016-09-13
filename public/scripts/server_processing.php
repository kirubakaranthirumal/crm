<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'crm_users';
// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'first_name', 'dt' => 1 ),
    array( 'db' => 'email',  'dt' => 2 ),
    array(
        'db'        => 'last_logged_on',
        'dt'        => 3,
       /*'formatter' => function( $d, $row ) {
            return date( 'jS M y', strtotime($d));
        }*/
    ),
    array(
        'db'        => 'create_on',
        'dt'        => 4,
       /* 'formatter' => function( $d, $row ) {
            return date( 'jS M y', strtotime($d));
        }*/
    )
);
 /*  My SQL Connection and class file

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'data',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
/*require( 'ssp.class.php' );*/


// SQL server connection information
$sql_details = array(
    'user' => 'postgres',
    'pass' => 'welcome-123',
    'db'   => 'crm',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
require( 'ssp.class.psql.php' );

//print"<pre>";
//print_r(SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns ));

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
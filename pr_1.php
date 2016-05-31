<?php


$conn = oci_connect('hr', '5243', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, "SELECT city FROM locations WHERE city LIKE :bv");
$ciudad = 'South%';  // '%' es un comodín en SQL
oci_bind_by_name($stid, ":bv", $ciudad);
oci_execute($stid);
oci_fetch_all($stid, $res);

foreach ($res['CITY'] as $c)
    {
    print $c . "<br>\n";
}
// La salida es
//   South Brunswick
//   South San Francisco
//   Southlake

oci_free_statement($stid);
oci_close($conn);


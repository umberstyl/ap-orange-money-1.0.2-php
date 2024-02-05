<?php

// easy ntegraton full class
require_once '../src/configuration.php';
require_once '../src/OrangeMoneyApi.php';


//convert http requested data as json;
$data = isset($_REQUEST) ? json_encode($_REQUEST) : [];

$process = true;

?>

<!DOCTYPE html>
<html>
<link href="style.css" rel="stylesheet">

<body>
    <?php
    if (isset($_GET['status'])) {
        //use Api_Orange_Money\OrangeMoneyApi;
        $api_om = new OrangeMoneyApi($data);
        $mp = ($_REQUEST['mp'] > 0) ? true : false;
        $Om = $api_om->check_status(false);
    } elseif (isset($_REQUEST['omoney']) && $_REQUEST['omoney'] == "mpayment") {
        //use Api_Orange_Money\OrangeMoneyApi;
        $api_om = new OrangeMoneyApi($data);
        $mp = 1;
        $Om = $api_om->deposite(false);
    } elseif (isset($_REQUEST['omoney']) && $_REQUEST['omoney'] == "cashout") {
        //use Api_Orange_Money\OrangeMoneyApi;
        $api_om = new OrangeMoneyApi($data);
        $mp = 0;
        $Om = $api_om->cashout(false);
    } else {
        $process = false;
        include 'form.php';
    }
    if ($process) {
        include 'payment.php';
    }
    ?>

</body>

</html>
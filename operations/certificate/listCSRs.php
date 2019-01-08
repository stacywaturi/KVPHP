<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/15
 * Time: 15:33
 */

require '../../vendor/autoload.php';

use azure\keyvault\Certificate as keyVaultCert;
use azure\authorisation\Token as azureAuthorisation;
use azure\Config;

session_start();
if($_SESSION['user']){
}
else{
    header("location:index.php");
}

 if($_SERVER['REQUEST_METHOD'] = "POST"){

    // $name = $_POST['name'];

    $keyVault = new keyVaultCert(
        [
            'accessToken'  => azureAuthorisation::getKeyVaultToken(
                [
                    'appTenantDomainName'   => Config::$APP_TENANT_ID ,
                    'clientId'              => Config::$CLIENT_ID,
                    'username'              => Config::$USERNAME,
                    'password'              => Config::$PASSWORD
                ]
            ),
            'keyVaultName' => Config::$KEY_VAULT_NAME
        ]
    );
    
    $listCSRsResponse =  $keyVault->listCSRs();

    if ($listCSRsResponse["responsecode"] == 200) {
        // var_dump($listCSRsResponse["data"]["value"]);
        // echo "<br><br>";
       foreach ($listCSRsResponse["data"]["value"] as $CSR) {
        if ($CSR["attributes"]["enabled"] == false)
            var_dump($CSR);
            echo "<br>";
       }

       //var_dump($listCSRsResponse["data"]["value"]);
        // var_dump(json_encode($listCSRsResponse["data"]["value"], JSON_PRETTY_PRINT)); 
    }
    else {
        var_dump($listCSRsResponse["responseMessage"]);
    }
}
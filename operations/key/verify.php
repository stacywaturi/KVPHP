<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/20
 * Time: 07:39
 */

require '../../vendor/autoload.php';
use hash\digest as Digest;
use hash\base64url as Base64url;
use azure\keyvault\Key as keyVaultKey;
use azure\authorisation\Token as azureAuthorisation;
use azure\Config;

session_start();

if($_SESSION['user']){
}
else{
    header("location:index.php");
}

if($_SERVER['REQUEST_METHOD'] = "POST"){

    $keyName = $_POST['name'];
    $algorithm = $_POST['algorithm'];
    $hashValue = $_POST['value'];
    $signature = $_POST['signature'];

    //Create DIGEST with BASE64URL encoding
    // $input = "file.txt";
    // $method = "RS512";
    // $hashObj = new Digest($input,$method,true);

    // $digest = $hashObj->getOutput();
    // $base64URLObj = new Base64url();
    // $base64URLEncoded = $base64URLObj->encode($digest);
    // var_dump($base64URLEncoded);


    $keyVault = new KeyVaultKey(
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
    $keyResponse = $keyVault->get($keyName);
   
    if($keyResponse["responsecode"] == 200){
        $keyID=$keyResponse['data']['key']['kid'];
        $verifyResponse = $keyVault->verify($keyID, $algorithm, $hashValue, $signature);
  
        if ($verifyResponse["responsecode"] == 200)
            $response = $verifyResponse['data'];

        else
            $response = $verifyResponse["responseMessage"];

        var_dump($response);
    }


    else
        var_dump($keyResponse["responseMessage"]);
}

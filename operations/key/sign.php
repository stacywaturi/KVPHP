<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/20
 * Time: 07:39
 */

require '../../vendor/autoload.php';
use hash\Digest as Digest;
use hash\Base64url as Base64url;
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
	
	/* Generates hash value as well as bas64 encoding
	*/
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
        $signResponse = $keyVault->sign($keyID, $algorithm, $hashValue);


        if ($signResponse["responsecode"] == 200)
            $signature = $signResponse['data']['value'];

        else
            $signature = $signResponse["responseMessage"];

        var_dump($signature);
    }


    else
        var_dump($keyResponse["responseMessage"]);
}



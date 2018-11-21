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


//Create DIGEST with BASE64URL encoding
$input = "file.txt";
$method = "RS384";
$hashObj = new Digest($input,$method,true);

$digest = $hashObj->getOutput();
$base64URLObj = new Base64url();
$base64URLEncoded = $base64URLObj->encode($digest);

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
$keyResponse = $keyVault->get("key1311");
//var_dump($keyVault->get("key1311"));
if($keyResponse["responsecode"] == 200){
    $keyID=$keyResponse['data']['key']['kid'];
    $signResponse = $keyVault->sign($keyID, $method, $base64URLEncoded);
    var_dump($signResponse);

    if ($signResponse["responsecode"] == 200)
        $signature = $signResponse['data']['value'];

    else
        $signature = $signResponse["responseMessage"];

    var_dump($signature);
}


else
    var_dump($keyResponse["responseMessage"]);

//var_dump(substr($keyID, strpos($keyID, "/keys/")+1));

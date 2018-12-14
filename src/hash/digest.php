<?php
/**
 * Key Vault API sign and verify operations
 * doesn't support hashing of content as part of signature creation
 * This class generates Hash of content to be signed locally
 *
 * Currently Supported Algorithms
 * ES256 - ECDSA for SHA-256 digests and keys created with curve P-256. This algorithm is described at RFC7518.
 * ES384 - ECDSA for SHA-384 digests and keys created with curve P-384. This algorithm is described at RFC7518.
 * ES512 - ECDSA for SHA-512 digests and keys created with curve P-521. This algorithm is described at RFC7518.
 *
 * RS256 - RSASSA-PKCS-v1_5 using SHA-256. The application supplied digest value must be computed using SHA-256 and must be 32 bytes in length.
 * RS384 - RSASSA-PKCS-v1_5 using SHA-384. The application supplied digest value must be computed using SHA-384 and must be 48 bytes in length.
 * RS512 - RSASSA-PKCS-v1_5 using SHA-512. The application supplied digest value must be computed using SHA-512 and must be 64 bytes in length.
 *
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/20
 * Time: 08:13
 */

namespace hash;


class digest
{
    private $output;

    public function __construct(string $path, string $algo, bool $is_doc)
    {
        switch ($is_doc) {
            case true:
                $this->output = $this->hashDoc($path, $algo);
                break;
            case false:
                $this->output = $this->hashString($path, $algo);
                break;
            default:
                $this->output = $this->hashDoc($path, $algo);
                break;
        }
    }


    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /* Call to HASH DOCUMENT
    The path defines the location of the file
    The algorithm defines the algorithm used to hash the file
    */

    public function hashDoc(string $path, string $algo)
    {
        if ($algo == "RS256" || $algo == "ES256") {
            $algorithm = "SHA256";

        } else if ($algo == "RS384" || $algo == "ES384") {
            $algorithm = "SHA384";

        } else if ($algo == "RS512" || $algo == "ES512") {
            $algorithm = "SHA512";

        } else {
            var_dump('INVALID ALGORITHM');
            return -1;

        }

       // Calculate checksum of file using specific algorithm
       return hash_file($algorithm, $path, true);
    }

    /* Call to HASH STRING
    The path defines the string to be hashed
    The algorithm defines the algorithm used to hash the string
    */
    public function hashString(string $string, string $algo)
    {
        if ($algo == "RS256" || $algo == "ES256") {
            $algorithm = "SHA256";


        } else if ($algo == "RS384" || $algo == "ES384") {
            $algorithm = "SHA384";

        } else if ($algo == "RS512" || $algo == "ES512") {
            $algorithm = "SHA512";

        } else {
            var_dump('INVALID ALGORITHM');
            return -1;

        }
        //Generate Hash of string using specific algorithm
        return openssl_digest($string, $algorithm,true);

    }
}

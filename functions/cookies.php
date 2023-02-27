<?php

// criptografa
function encryptCookieContent($toEncrypt)
{

    // Store a string into the variable which
    // need to be Encrypted
    $simple_string = $toEncrypt;

    // Display the original string
    //echo "Original String: " . $simple_string;

    // Store the cipher method
    $ciphering = "AES-128-CTR";

    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    // Non-NULL Initialization Vector for encryption
    $encryption_iv = '7852584365425884';

    // Store the encryption key
    // retrieve encryption key
    $me = json_decode($toEncrypt, true);

    //$encryption_key = $me['email'].$me['id'].$me['id'];

    $encryption_key = "fasdçlkfjdsalfkajdsaçlfjadsçlfjdsaçlkj**";

    // Use openssl_encrypt() function to encrypt the data
    $encryption = openssl_encrypt(
        $simple_string,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    // Display the encrypted string
    //echo "Encrypted String: " . $encryption . "\n";
    return $encryption;
}


// descriptografa
function decryptCookieContent($encriptedString)
{

    // Store the cipher method
    $ciphering = "AES-128-CTR";

    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    // Non-NULL Initialization Vector for decryption
    $decryption_iv = '7852584365425884';

    // Store the decryption key
    $decryption_key = "fasdçlkfjdsalfkajdsaçlfjadsçlfjdsaçlkj**";

    // Use openssl_decrypt() function to decrypt the data
    $decryption = openssl_decrypt(
        $encriptedString,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );

    // Display the decrypted string
    //echo "Decrypted String: " . $decryption;  
    return $decryption;
}


// // recupera o login
// function recoverLogin($api_url)
// {


// }

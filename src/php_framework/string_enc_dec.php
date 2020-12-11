<?php
function encryptString ($data,$key) {
    $encrypt_mode='aes-256-cbc';
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($encrypt_mode));
    $encrypted = openssl_encrypt($data, $encrypt_mode, $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
function decryptString ($data,$key) {
    $encrypt_mode='aes-256-cbc';
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, $encrypt_mode, $encryption_key, 0, $iv);
}
?>
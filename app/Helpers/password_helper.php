<?php

 function hashPassword($plainTex) {
    return password_hash($plainTex, PASSWORD_DEFAULT);
    
}

function verifyPassword($plainTex, $hash) {
    return password_verify($plainTex, $hash);
}
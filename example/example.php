<?php

require_once '../vendor/autoload.php';

use WideNet\ZipCode;

$code = '06233030';
$zipcode = new ZipCode($code);

echo "Procurando pelo CEP $code:\n\n";

if ($zipcode->wasFound()) {
    echo "Endereço encontrado: \n\n";
    echo "CEP...: {$zipcode->code}\n";
    echo "Estado: {$zipcode->state}\n";
    echo "Cidade: {$zipcode->city}\n";
    echo "Bairro: {$zipcode->district}\n";
    echo "Rua...: {$zipcode->address}\n\n";
    echo "Por extenso: $zipcode\n\n";
} else {
    echo "O CEP $code não foi encontrado!\n\n";
}

$code = strval(rand(0, 9999));
$zipcode = new ZipCode($code);

if ($zipcode->isInvalid()) {
    echo "O CEP $code é inválido:\n";
}
<?php

require_once '../vendor/autoload.php';

use WideNet\ZipCode;

$code = '06233030';
$zipCode = new ZipCode($code);

echo "Procurando pelo CEP $code:\n\n";

if ($zipCode->found()) {
    echo "Endereço encontrado: \n\n";
    echo "CEP...: {$zipCode->code}\n";
    echo "Estado: ({$zipCode->state}) {$zipCode->stateName}\n";
    echo "Cidade: {$zipCode->city}\n";
    echo "Bairro: {$zipCode->district}\n";
    echo "Rua...: {$zipCode->address}\n\n";
    echo "Por extenso: $zipCode\n\n";
} else {
    echo "O CEP $code não foi encontrado!\n\n";
}

$code = strval(rand(0, 9999));
$zipCode = new ZipCode($code);

if ($zipCode->invalid()) {
    echo "O CEP $code é inválido:\n";
}

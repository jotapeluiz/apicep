# APICEP

Classe que busca um endereço no site https://apicep.com/api-de-consulta/ a partir do CEP.

## Instalação

```bash
composer require jotapeluiz/apicep
```

## Modo de usar

```php
require_once '/vendor/autoload.php';

use WideNet\ZipCode;

$zipCode = new ZipCode('06233030');

if ($zipCode->wasFound()) {
    echo $zipCode->code;        // CEP
    echo $zipCode->state;       // Estado (sigla)
    echo $zipCode->city;        // Cidade
    echo $zipCode->district;    // Bairro
    echo $zipCode->address;     // Rua
}

// endereço no formato de array
$zipCode->toArray();

// endereço no formato json
$zipCode->toJson();
```

Acesse o arquivo **example/example.php** para ver mais modo de uso.
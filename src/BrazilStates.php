<?php

namespace WideNet;

use WideNet\Exceptions\StateNotFoundException;

final class BrazilStates
{
    private $states;

    public function __construct()
    {
        $this->initStates();
    }

    public function name(string $stateAbbreviation): string
    {
        $abbreviation = strtoupper(trim($stateAbbreviation));
        
        if (!array_key_exists($abbreviation, $this->states)) {
            throw new StateNotFoundException("Estado não encontrado para a sigla $abbreviation.");
        }

        return $this->states[$abbreviation];
    }

    private function initStates(): void
    {
        $this->states = [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônio',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        ];
    }
}

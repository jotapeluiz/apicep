<?php

declare(strict_types=1);

namespace WideNet;

use WideNet\BrazilStates;
use WideNet\Request\APIRequest;
use WideNet\Constants\ZipCodeStatus;
use WideNet\Helpers\ZipCodeHelper;
use WideNet\Exceptions\AttributeNotFoundException;
use WideNet\Exceptions\UpdateAttributeException;

final class ZipCode
{
    private $found;
    
    private $valid;
    
    private $attributes;

    /**
     * ZipCode can receive a code in the format 99999-999 or 99999999
     *
     * @param string $zipcode the code to be searched
     */
    public function __construct(string $zipcode)
    {
        $this->initializeAttributes();

        $this->found = false;
        $this->valid = ZipCodeHelper::isValid($zipcode);
        
        if ($this->valid) {
            $this->searchAddress($zipcode);
        }
    }
    
    /**
     * Returns true if the address was found
     *
     * @return boolean
     */
    public function wasFound(): bool
    {
        return $this->found;
    }

    /**
     * Returns true if the zipcode was invalid
     *
     * @return boolean
     */
    public function isInvalid(): bool
    {
        return !$this->valid;
    }

    /**
     * Returns address data in array format
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
    
    /**
     * Returns address data in json format
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->attributes);
    }
    
    /**
     * Returns an attribute of the found address
     *
     * @param string $key The name of the attribute which can be: code, state, city, district or address
     * @throws WideNet\Exceptions\AttributeNotFoundException;
     * @return string
     */
    public function __get(string $key): string
    {
        if (!array_key_exists($key, $this->attributes)) {
            throw new AttributeNotFoundException("Atributo $key não existe");
        }
        
        return $this->attributes[$key];
    }

    /**
     * Prevents a class attribute from being overwritten
     *
     * @param string $key
     * @param mixed $value
     * @throws WideNet\Exceptions\UpdateAttributeException
     * @return void
     */
    public function __set(string $key, $value): void
    {
        throw new UpdateAttributeException("Atributo $key não pode ser sobreescrito");
    }

    /**
     * Convert the class to a string representing the address
     *
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->address}, {$this->district}, {$this->city} - {$this->state}, {$this->code}";
    }
    
    /**
     * Initializes the attributes of an address
     *
     * @return void
     */
    private function initializeAttributes(): void
    {
        $this->attributes = array_fill_keys(['code', 'state', 'stateName', 'city', 'district', 'address'], '');
    }

    /**
     * Fill in the address attributes
     *
     * @param  array $attributes
     * @return void
     */
    private function fillAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $this->attributes)) {
                $this->attributes[$key] = $value;
            }
        }

        $brazilState = new BrazilStates();
        $this->attributes['stateName'] = $brazilState->name($this->state);
    }
    
    /**
     * Performs an address search via zip code
     *
     * @param  string $zipcode
     * @return void
     */
    private function searchAddress(string $zipcode): void
    {
        $request = new APIRequest();
        $response = $request->get($zipcode);

        $this->found = ($response['status'] === ZipCodeStatus::FOUND);

        if ($this->found) {
            $this->fillAttributes($response);
        }
    }
}

<?php declare(strict_types=1);

namespace APICEP;

use APICEP\Request\APIRequest;
use APICEP\Constants\ZipCodeStatus;
use APICEP\Helpers\ZipCodeHelper;
use APICEP\Exceptions\AttributeNotFoundException;
use APICEP\Exceptions\UpdateAttributeException;

final class ZipCode
{
    private $found;
    
    private $valid;
    
    private $attributes;

    public function __construct(string $zipcode) 
    {        
        $this->initializeAttributes();

        $this->found = false;
        $this->valid = ZipCodeHelper::isValid($zipcode);
        
        if ($this->valid) {
            $this->searchAddress($zipcode);
        }
    }
    
    public function wasFound(): bool
    {
        return $this->found;
    }

    public function isInvalid(): bool
    {
        return !$this->valid;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
    
    public function toJson(): string
    {
        return json_encode($this->attributes);
    }
    
    public function __get(string $key): string
    {
        if (!array_key_exists($key, $this->attributes)) {
            throw new AttributeNotFoundException("Atributo $key não existe");
        }
        
        return $this->attributes[$key];
    }

    public function __set(string $key, $value): void
    {        
        throw new UpdateAttributeException("Atributo $key não pode ser sobreescrito");
    }

    public function __toString(): string
    {
        return "{$this->address}, {$this->district}, {$this->city} - {$this->state}, {$this->code}";
    }
    
    private function initializeAttributes(): void
    {
        $this->attributes = array_fill_keys(['code', 'state', 'city', 'district', 'address'], '');
    }

    private function fillAttributes(array $attributes): void
    {        
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $this->attributes)) {
                $this->attributes[$key] = $value;                
            }
        }        
    }
    
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

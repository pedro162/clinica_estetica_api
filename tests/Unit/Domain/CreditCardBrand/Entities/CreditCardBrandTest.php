<?php

namespace Tests\Unit\Domain\CreditCardBrand\Entities;

use App\Domain\CreditCardBrand\Entities\CreditCardBrand as EntitiesCreditCardBrand;
use PHPUnit\Framework\TestCase;

class CreditCardBrandTest extends TestCase
{
    //XDEBUG_MODE=coverage ./vendor/bin/phpunit coverage
    //XDEBUG_MODE=coverage php artisan test


    /**
     * 
     * @param array<mixed> $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function test_create_a_new_credit_card_brand_entity($data): void
    {
        $entity = EntitiesCreditCardBrand::buildEntity($data);
        $this->assertInstanceOf(EntitiesCreditCardBrand::class, $entity);

        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $entity->toArray());
            $this->assertEquals($value, $entity->toArray()[$key]);
        }
    }

    public static function entityDataProvider(): array
    {
        return [
            'credit_card_brand_entity' => [
                [
                    'id' => 1,
                    'name' => 'Teste 01',
                    'standard' => 'yes',
                    'active' => 'yes',
                    'userId' => 1,
                    'userUpdateId' => null,
                    'tenantId' => 1,
                ]
            ]
        ];
    }
}

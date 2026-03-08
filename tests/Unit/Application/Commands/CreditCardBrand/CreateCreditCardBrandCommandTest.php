<?php

namespace Tests\Unit\Application\Commands\CreditCardBrand;

use App\Application\Commands\CreditCardBrand\CreateCreditCardBrandCommand;
use PHPUnit\Framework\TestCase;

class CreateCreditCardBrandCommandTest extends TestCase
{
    //XDEBUG_MODE=coverage ./vendor/bin/phpunit coverage

    /**
     *
     * @param array<mixed> $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function test_create_a_new_credit_card_brand_command($data): void
    {
        $entity = CreateCreditCardBrandCommand::build($data);
        $this->assertInstanceOf(CreateCreditCardBrandCommand::class, $entity);

        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $entity->toArray());
            $this->assertEquals($value, $entity->toArray()[$key]);
        }
    }
    /**
     *
     * @param array<mixed> $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function test_create_a_new_credit_card_brand_teste_command($data): void
    {
        $entity = CreateCreditCardBrandCommand::build($data);
        $this->assertInstanceOf(CreateCreditCardBrandCommand::class, $entity);

        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $entity->toArray());
            $this->assertEquals($value, $entity->toArray()[$key]);
        }
    }

    /**
     *
     * @param array<mixed> $data
     * @dataProvider entityModelPropertiesDataProvider
     * @return void
     */
    public function test_create_a_new_credit_card_brand_command_with_model_properties($data): void
    {
        $entity = CreateCreditCardBrandCommand::build($data);
        $this->assertInstanceOf(CreateCreditCardBrandCommand::class, $entity);
        $this->assertEquals($data['id'], $entity->getId());
        $this->assertEquals($data['name'], $entity->getName());
        $this->assertEquals($data['standard'], $entity->getStandard());
        $this->assertEquals($data['active'], $entity->getActive());
        $this->assertEquals($data['user_id'], $entity->getUserId());
        $this->assertEquals($data['user_update_id'], $entity->getUserUpdateId());
        $this->assertEquals($data['tenant_id'], $entity->getTenantId());
        $this->assertEquals($data['pessoa_autor_id'], $entity->getPersonAuthorId());
    }

    public static function entityDataProvider(): array
    {
        return [
            'credit_card_brand_command_with_its_own_properties' => [
                [
                    'id' => 1,
                    'name' => 'Teste 01',
                    'standard' => 'yes',
                    'active' => 'yes',
                    'userId' => 1,
                    'userUpdateId' => 1,
                    'tenantId' => 1,
                    'personAuthorId' => 1,
                ]
            ],
        ];
    }

    public static function entityModelPropertiesDataProvider(): array
    {
        return [
            'credit_card_brand_command_with_model_properties' => [
                [
                    'id' => 1,
                    'name' => 'Teste 01',
                    'standard' => 'yes',
                    'active' => 'yes',
                    'user_id' => 1,
                    'user_update_id' => 1,
                    'tenant_id' => 1,
                    'pessoa_autor_id' => 1,
                ]
            ]
        ];
    }
}

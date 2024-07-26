<?php

namespace App\Infrastructure\Services\Payments\PagBank;

use App\Domain\Person\Entities\Person;
use Exception;

class PagBank
{
    /*
    CPF:
    199600
    //https://portaldev.pagbank.com.br/tokens
    https://acesso.pagbank.com.br/portaldev
    //https://developer.pagbank.com.br/reference/objeto-order
    //194b9f99-8552-4e1c-a65f-fd8d444bafef9e12ce8d47709c33a6ac156521f6b10bee36-b5ee-48ce-a395-cd0605a757d3
    
     */
    const BASE_URL_SANDBOX = 'https://sandbox.api.pagseguro.com';
    const BASE_URL_PRODUCTION = 'https://api.pagseguro.com';
    protected $token;
    protected static $productionMode = false;
    protected array $dataRequest = [];

    public static function getBaseURL()
    {
        if (self::$productionMode) {
            return self::BASE_URL_PRODUCTION;
        }
        return self::BASE_URL_SANDBOX;
    }

    public function token($token)
    {
        $this->token = $token;;
        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function publicKeyCreate()
    {
        $response = null;
        $httpCode = null;
        $public_key = null;
        $created_at = null;

        $url = self::getBaseURL();
        $token = $this->getToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "{$url}/public-keys",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'type' => 'card'
            ]),
            CURLOPT_HTTPHEADER => [
                "Authorization: {$token}",
                "accept: */*",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $response_array = json_decode($response, true);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        }

        if (in_array($httpCode, [200])) {
            $public_key = $response_array['public_key'];
            $created_at = $response_array['created_at'];
        }

        if ($httpCode >= 400) {
            throw new Exception("cURL Error #:" . $err);
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Decode Error: " . json_last_error_msg());
        }
        return ['response' => $response, 'response_array' => $response_array, 'http_response_code' => $httpCode, 'public_key' => $public_key, 'created_at' => $created_at];
    }

    public function publicKeyGet()
    {
        $response = null;
        $httpCode = null;
        $public_key = null;
        $created_at = null;

        $url = self::getBaseURL();
        $token = $this->getToken();


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "{$url}/public-keys/card",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$token}",
                "accept: */*"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        }

        $response_array = json_decode($response, true);

        if (in_array($httpCode, [200])) {
            $public_key = $response_array['public_key'];
            $created_at = $response_array['created_at'];
        }

        if ($httpCode >= 400) {
            throw new Exception("cURL Error #:" . $err);
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Decode Error: " . json_last_error_msg());
        }
        //PaymentApiException
        return ['response' => $response, 'response_array' => $response_array, 'http_response_code' => $httpCode, 'public_key' => $public_key, 'created_at' => $created_at];
    }


    public function publicKeyPut()
    {
        $response = null;
        $httpCode = null;
        $public_key = null;
        $created_at = null;

        $url = self::getBaseURL();
        $token = $this->getToken();


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "{$url}/public-keys/card",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$token}",
                "accept: */*"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        }

        $response_array = json_decode($response, true);

        if (in_array($httpCode, [200])) {
            $public_key = $response_array['public_key'];
            $created_at = $response_array['created_at'];
        }

        if ($httpCode >= 400) {
            throw new Exception("cURL Error #:" . $err);
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Decode Error: " . json_last_error_msg());
        }
        //PaymentApiException
        return ['response' => $response, 'response_array' => $response_array, 'http_response_code' => $httpCode, 'public_key' => $public_key, 'created_at' => $created_at];
    }

    public function addCustomer(Person $person)
    {
        $this->dataRequest['customer'] = [
            "name" => "Jose da Silva",
            "email" => "email@test.com",
            "tax_id" => "12345678909",
            "phones" => [
                "country" => "55",
                "area" => "11",
                "number" => "999999999",
                "type" => "MOBILE"
            ]
        ];
    }

    public function addItem(Person $item)
    {
        $this->dataRequest['items'][] = [
            "reference_id" => "referencia do item",
            "name" => "nome do item",
            "quantity" => 1,
            "unit_amount" => 500
        ];
    }
    public function addShipping(Person $item)
    {
        $this->dataRequest['shipping'] = [
            "address" => [
                "street" => "Avenida Brigadeiro Faria Lima",
                "number" => "1384",
                "complement" => "apto 12",
                "locality" => "Pinheiros",
                "city" => "São Paulo",
                "region_code" => "SP",
                "country" => "BRA",
                "postal_code" => "01452002"
            ]
        ];
    }

    public function addNotificationUrl($url)
    {
        $this->dataRequest['notification_urls'][] = [
            //"https://meusite.com/notificacoes"
            $url
        ];
    }

    public function addCharges(Person $item)
    {
        $this->dataRequest['charges'][] = [
            "reference_id" => "MY-ID-123",
            "description" => "Motivo de pagamento",
            "amount" => [
                "value" => 1000,
                "currency" => "BRL"
            ],
            "payment_method" => [
                "type" => "CREDIT_CARD",
                "installments" => 1,
                "capture" => true,
                "soft_descriptor" => "Loja do meu teste",
                "card" => [
                    "number" => "4111111111111111",
                    "exp_month" => "03",
                    "exp_year" => "2026",
                    "security_code" => "123",
                    "holder" => [
                        "name" => "Jose da Silva",
                        "tax_id" => "65544332211"
                    ]
                ]
            ],
            "sub_merchant" => [
                "reference_id" => "MY-ID",
                "name" => "Razão Social / Nome completo",
                "tax_id" => "42167200803",
                "mcc" => "155",
                "address" => [
                    "country" => "BRA",
                    "region_code" => "SP",
                    "city" => "Sao Paulo",
                    "postal_code" => "01452002",
                    "street" => "Avenida Brigadeiro Faria Lima",
                    "number" => "1384",
                    "locality" => "Pinheiros",
                    "complement" => "Apto 16"
                ],
                "phones" => [
                    [
                        "country" => "55",
                        "area" => "11",
                        "number" => "98877887788",
                        "type" => "MOBILE"
                    ]
                ]
            ],
            "notification_urls" => [
                "https://yourserver.com/nas_ecommerce/277be731-3b7c-4dac-8c4e-4c3f4a1fdc46/"
            ]
        ];
    }

    public function createOrderWithCard(Person $person)
    {
        //https://developer.pagbank.com.br/reference/criar-pedido-cartao-facilitador-pagamento
        $this->addCustomer($person);
        $this->addItem($person);
        $this->addShipping($person);
        $this->addNotificationUrl('https://meusite.com/notificacoes');
        $this->addCharges($person);
    }
}

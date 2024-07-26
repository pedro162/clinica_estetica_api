<?php

namespace App\Infrastructure\Services\Notifications\Whatsapp;

use App\Application\Commands\CreateHttpCommand;
use App\Application\Handlers\CreateHttpHandler;
use App\Application\Handlers\HttpRequestResponseHandler;
use App\Application\Services\HttpApplicationService;
use App\Domain\Http\Interfaces\HttpRequesResponseInterace;
use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Http\Entities\Http;
use App\Domain\Http\ValueObjects\HttpBody;
use App\Http as HttpModel;
use Illuminate\Support\Facades\Http as HttpClientRequest;
use App\Infrastructure\Persistence\Eloquent\EloquentHttpRepository;

class WhatsAppOfficialApi implements NotificationInterface, WhatsAppInterface
{
    //EAADjprMvvYoBO2v2XBymTEiaEfgtj7OYEITKqwShYiZBRYgiYZBn9taJezIxofy7LW9YSW2ZCqDLUWFrwjGhA8ZCMdfHqsFwciaqrDPJsjCXnIJGmd3mGPDmReqQpP7YM5428IEi7VJOc2SgUdiBAXjM0u93okkupN2W2gFaPZA0yJKPi8cVZCSyZBIVSaosuHF2oyFLTcmFnMmUpXGVhXrzhZAGlcEFmuIHHp0EuZBkz
    protected string $baseUrl = 'https://graph.facebook.com';
    protected string $accessToken = 'EAAG3C2TVdgsBO3n1E6V97Jm0LF5wB6u2uGLNl9DH5MoO8sNB4onZApXAyC5zETLl6Bkg9ZCFLvZCNUv1brZBaQVv6ahUaHoeZCPifUXZCrhqZAHzviKIDW6vveoZBbNglPazsKbXttBbV4aLHAoZBQ1lvoW4WGxHkLc8yJy6Komt7haBYkyZAjx48N1Y9IYeDlsD5oZA0XZBCkjTSQLYKty81sUZD';
    protected string $whatsAppBusinessAccountId  = '253133564553408'; //253133564553408//253133564553408
    protected string $apiVersoin = 'v20.0';
    protected string $targetContact;
    protected array $data = [];
    protected array $mediaData = [];
    protected array $responseUploadMedia = [];

    public function targetContact(string $targetContact): WhatsAppOfficialApi
    {
        $this->targetContact = $targetContact;
        return $this;
    }
    //App\Infrastructure\Services\Notifications\Whatsapp\HttpApplicationService
    public function fetchSomeData(): array
    {
        //TODO---
        return [];
    }

    public function buildUrlRequest()
    {
        return $this->baseUrl . '/' . $this->apiVersoin;
    }

    public function addMedia($content, $type, $size)
    {
        $this->mediaData[] = ['content' => $content, 'type' => $type, 'size' => $size];
        return $this;
    }

    public function addResponseUploadMedia($response)
    {
        $this->responseUploadMedia[] = $response;
        return $this;
    }

    public function uploadDocument()
    {
        if (is_array($this->mediaData) && count($this->mediaData) > 0) {
            foreach ($this->mediaData as $data) {
                $content = $data['content'];
                $type = $data['type'];
                $size = $data['size'];

                $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '/uploads?file_length=' . $size . '&file_type=' . $type;
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                ));

                $response = curl_exec($curl);

                curl_close($curl);
            }
        }

        /*
            {
    "id": "upload:MTphdHRhY2htZW50OjU5Nzc0MDgzLWRhNzgtNGEzMS1iYmRhLTVkNzEyOGEyYjFhZD9maWxlX2xlbmd0aD0yMTg5OTUxJmZpbGVfdHlwZT1pbWFnZSUyRmpwZw==?sig=ARazXSD9mAc-wPYJffA"
}
        */
    }

    public function sendDocument()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/{{api-version}}/<SESSION_ID>',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "<file contents here>",
            CURLOPT_HTTPHEADER => array(
                'file_offset: 0',
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getDataWhatsAppBusinessAccount()
    {
        $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '?fields=id,name,message_templates,phone_numbers';

        $response = HttpClientRequest::withHeaders([

            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json'
        ])->get($url);
    }

    public function createQRCode()
    {
        //Documentation: https://www.postman.com/meta/workspace/whatsapp-business-platform/request/13382743-83c3aeef-04be-420d-8ad0-689ca4477ee4
        $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '/messages';
        $accessToken = $this->accessToken;
        $message = "Show me Cyber Monday deals!";
        $image = "SVG";
        $data = [
            "prefilled_message" => $message,
            "generate_qr_image" => $image
        ];
        $response = HttpClientRequest::withHeaders([
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ])->post($url, $data);

        if ($response) {
            return true;
        }

        return false;
    }

    public function send(Notification $notification): bool
    {
        $typeMessage    = 'text';
        $tamplateId = (string) $notification->getTemplateId();
        $tamplateId = (int) $tamplateId;
        if ($tamplateId > 0) {
            $typeMessage    = 'template';
        }
        if ($typeMessage == 'template') { //Criar metodo para melhorar esa condicao
            return $this->sendMessageTemplate($notification);
        } else {
            return $this->sendMessageText($notification);
        }
    }

    public function sendMessageText(Notification $notification): bool
    {

        $objHttpRepository = new EloquentHttpRepository();
        $objHttpHandler = new CreateHttpHandler($objHttpRepository);
        $objHttpService = new HttpApplicationService($objHttpHandler);

        $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '/messages';
        $accessToken = $this->accessToken;
        $to = (string) $notification->getTargetContactAddress();
        $to = str_replace(['+'], [''], $to);
        $data = [
            "messaging_product" => "whatsapp",
            "to" => $to,
            "type" => "text",
            "text" => [
                "body" => "Olá Pedro" //(string)$notification->getMessage()
            ]
        ];

        $ch = curl_init();

        //Configura as ações
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true); // Inclui o cabeçalho na saída
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeader = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);

        //---Save the HTTP request        
        $httpCommand = (new CreateHttpCommand())
            ->httpId(0)
            ->httpCode('200')
            ->httpUrl($url)
            ->httpHeader(json_encode($requestHeader))
            ->httpDataRequest(json_encode($data))
            ->HttpBody(json_encode($data));
        $resp = $objHttpService->createHttp($httpCommand);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseHeader = substr($response, 0, $headerSize);
        $err = curl_error($ch);
        curl_close($ch);
        $response_array = json_decode($response, true);

        //---Save the HTTP response        
        $httpCommand = (new CreateHttpCommand())
            ->httpId(0)
            ->httpCode($httpCode)
            ->httpUrl($url)
            ->httpHeader($responseHeader)
            ->httpDataRequest(json_encode($response))
            ->HttpBody(json_encode($response));
        $resp = $objHttpService->createHttp($httpCommand);

        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
        }

        if ($httpCode >= 400) {
            $error = '';
            if (isset($response_array['error']) && count($response_array['error']) > 0) {
                $error = $response_array['error']['message'];
                $type = $response_array['error']['type'];
                $code = $response_array['error']['code'];
                $fbtrace_id = $response_array['error']['fbtrace_id'];
                $error .= ' | Type: ' . $type;
            }
            throw new \Exception($error);
        }

        echo '<pre>';
        print_r($httpCode);
        echo '</pre>';
        echo '<pre>';
        print_r($response_array);
        echo '</pre>';
        echo '<pre>';
        print_r($err);
        echo '</pre>';
        dd($response);
        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        }
        if ($response == false) {
            return false;
        }
        return false;
    }



    public function sendMessageTemplate(Notification $notification): bool
    {
        //Documentation: https://laravel.com/docs/8.x/http-client#main-content
        //Postman: https://www.postman.com/meta/workspace/whatsapp-business-platform/request/13382743-8eb0859b-b19e-43bc-acd3-ab46b9ead11b
        //API-Exemplos: https://www.postman.com/meta/workspace/whatsapp-business-platform/documentation/13382743-2fd9b32d-f63c-4056-873e-4c398dde9d6d?entity=request-13382743-7dee3bda-71c2-4c15-8f48-4778548b5501
        //Models: https://business.facebook.com/wa/manage/message-templates/?business_id=882940378796059&waba_id=250832364784730&global_scope_id=882940378796059&filters=%7B%22search_text%22%3A%22%22%2C%22tag%22%3A[]%2C%22language%22%3A[]%2C%22status%22%3A[%22APPROVED%22%2C%22IN_APPEAL%22%2C%22PAUSED%22%2C%22PENDING%22%2C%22REJECTED%22]%2C%22quality%22%3A[]%2C%22date_range%22%3A30%7D
        //https://developers.facebook.com/docs/whatsapp/business-management-api/guides
        //$objRepo = new EloquentHttpRepository();
        //$objCreateHandler = new CreateHttpHandler($objRepo);
        //$objServiceHttp = new HttpApplicationService($objCreateHandler);
        //App\Application\Services\HttpApplicationService
        //https://business.facebook.com/wa/manage/message-templates/?business_id=882940378796059&waba_id=292058767334842&global_scope_id=882940378796059&filters=%7B%22search_text%22%3A%22%22%2C%22tag%22%3A[]%2C%22language%22%3A[]%2C%22status%22%3A[%22APPROVED%22%2C%22IN_APPEAL%22%2C%22PAUSED%22%2C%22PENDING%22%2C%22REJECTED%22]%2C%22quality%22%3A[]%2C%22date_range%22%3A30%7D
        //https://developers.facebook.com/docs/whatsapp/business-management-api/get-started#system-users
        /*
            Subject: Appointment Reminder - Studio Beleza

            Dear {{1}},

            This is a friendly reminder of your upcoming appointment at {{2}}.

            Appointment Details:

            Date: {{3}}
            Time: {{4}}
            Service: {{5}}
            Location: Studio Beleza, {{6}}
            We look forward to seeing you and providing you with the best possible care. If you need to reschedule or have any questions, please contact us at {{7}} or reply to this email.

            Please confirm your attendance by replying to this email or calling us at your earliest convenience.

            Thank you for choosing {{2}}!

            Best regards,

            {{2}} Team
            {{8}}
        */
        $objHttpRepository = new EloquentHttpRepository();
        $objHttpHandler = new CreateHttpHandler($objHttpRepository);
        $objHttpService = new HttpApplicationService($objHttpHandler);

        $templateObj    = $notification->getTemplate();
        $typeMessage    = 'template'; //text
        $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '/messages';
        $accessToken = $this->accessToken;
        $to = (string) $notification->getTargetContactAddress();
        $to = str_replace(['+'], [''], $to);
        $variables = [];
        $tempArrayObj   = $templateObj->getVariables();
        $template       = $templateObj->getTitle() ?? 'confirm_service'; //previa//hello_world//statement_available_2//confirm_service
        $language       = $templateObj->getLanguage() ?? 'en_US'; //en_US//pt_BR
        if (is_array($tempArrayObj) && count($tempArrayObj) > 0) {
            foreach ($tempArrayObj as $variable) {
                $variables[] = ['type' => 'text', 'text' => (string) $variable->getValue()];
            }
        }

        $component = [];
        if (is_array($variables) && count($variables) > 0) {
            $component['type'] = 'body';
            $component['parameters'] = $variables;
        }

        $data = [
            "messaging_product" => "whatsapp",
            "to" => $to,
            "type" => $typeMessage,
            "template" => [
                'name' => (string)$template,
                'language' => [
                    'code' => (string)$language
                ],
                'components' => [$component]
            ]
        ];

        //$data = $templateObj->getDataRequest();

        $ch = curl_init();
        //Configura as ações
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true); // Inclui o cabeçalho na saída
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeader = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);
        //---Save the HTTP request        
        $httpCommand = (new CreateHttpCommand())
            ->httpId(0)
            ->httpCode('200')
            ->httpUrl($url)
            ->httpHeader(json_encode($requestHeader))
            ->httpDataRequest(json_encode($data))
            ->HttpBody(json_encode($data));
        $resp = $objHttpService->createHttp($httpCommand);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseHeader = substr($response, 0, $headerSize);
        $err = curl_error($ch);
        curl_close($ch);
        $response_array = json_decode($response, true);

        //---Save the HTTP response        
        $httpCommand = (new CreateHttpCommand())
            ->httpId(0)
            ->httpCode($httpCode)
            ->httpUrl($url)
            ->httpHeader($responseHeader)
            ->httpDataRequest(json_encode($response))
            ->HttpBody(json_encode($response));
        $resp = $objHttpService->createHttp($httpCommand);

        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
        }

        if ($httpCode >= 400) {
            $error = '';
            if (isset($response_array['error']) && count($response_array['error']) > 0) {
                $error = $response_array['error']['message'];
                $type = $response_array['error']['type'];
                $code = $response_array['error']['code'];
                $fbtrace_id = $response_array['error']['fbtrace_id'];
                $error .= ' | Type: ' . $type;
            }
            throw new \Exception($error);
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        }
        if ($response == false) {
            return false;
        }
        return false;
    }

    public function settingModelComponent()
    {

        $template = 'hello_world'; // * Max length 512
        $language = 'en_US'; //*
        $category = 'UTILITY'; //*UTILITY,AUTHENTICATION,MARKETING
        $allow_category_change = true;
        $library_template_button_inputs = "[ {'type': 'URL', 'url': {'base_url' : 'https://www.example.com/{{1}}', 'url_suffix_example' : 'https://www.example.com/demo'}}, {type: 'PHONE_NUMBER', 'phone_number': '+16315551010'} ]";
        $data = [
            'name' => $template,
            'category' => $category,
            'allow_category_change' => $allow_category_change,
            'language' => $language,
            'LIBRARY_TEMPLATE_BUTTON_INPUTS' => $library_template_button_inputs,
            'components' => [

                [
                    "type" => "BODY",
                    "text" => "Thank you for your order, {{1}}! Your confirmation number is {{2}}. If you have any questions, please use the buttons below to contact support. Thank you for being a customer!",
                    "example" => [
                        "body_text" => [
                            [
                                "Pablo", "860198-230332"
                            ]
                        ]
                    ]
                ],
                [
                    "type" => "BUTTONS",
                    "buttons" => [
                        [
                            "type" => "PHONE_NUMBER",
                            "text" => "Call",
                            "phone_number" => "15550051310"
                        ],
                        [
                            "type" => "URL",
                            "text" => "Contact Support",
                            "url" => "https://www.luckyshrub.com/support"
                        ]
                    ]
                ]

            ],
        ];
        $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '/message_templates';
        $accessToken = $this->accessToken;
        $response = HttpClientRequest::withHeaders([
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ])->post($url, $data);

        if ($response) {
            return true;
        }

        return false;
    }
}

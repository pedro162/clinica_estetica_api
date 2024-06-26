<?php

namespace App\Infrastructure\Services\Notifications\Whatsapp;

use App\Application\Commands\CreateHttpCommand;
use App\Application\Handlers\CreateHttpHandler;
use App\Application\Handlers\HttpRequestResponseHandler;
use App\Domain\Http\Interfaces\HttpRequesResponseInterace;
use App\Domain\Notification\Interfaces\NotificationInterface;
use App\Domain\Notification\Entities\Notification;
use App\Domain\Http\Entities\Http;
use App\Http as HttpModel;
use Illuminate\Support\Facades\Http as HttpClientRequest;
use App\Infrastructure\Persistence\Eloquent\EloquentHttpRepository;

class WhatsAppOfficialApi implements NotificationInterface, WhatsAppInterface
{
    protected string $baseUrl = 'https://graph.facebook.com';
    protected string $accessToken = 'EAAG3C2TVdgsBOwhbkJacdQLWHkPEqqq5P3ZA5jQnZBlI63bwcOu99mpe6JXgNDFCi5peQQq1rAuYaZBmyLsxcQazeydUhwZB5wfJILRsLo7INW4pxdoSDTHqGNMI4LdhZBc5GXlMmORfbjTokSZACMHfikWED0QRexVEKFI97KOewCjSnulRrZAgfy5TcF5vhrZAyeWkuk7hHtPHdmBIsKQZD';
    protected string $whatsAppBusinessAccountId  = '253133564553408'; //253133564553408//253133564553408
    protected string $apiVersoin = 'v19.0';
    protected string $targetContact;

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
        $typeMessage    = 'template'; //text


        if ($typeMessage == 'template') { //Criar metodo para melhorar esa condicao
            return $this->sendMessageTemplate($notification);
        } else {
            return $this->sendMessageText($notification);
        }
    }

    public function sendMessageText(Notification $notification): bool
    {

        $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '/messages';
        $accessToken = $this->accessToken;
        $to = (string) $notification->getTargetContactAddress();

        $data = [
            "messaging_product" => "whatsapp",
            "to" => $to,
            "type" => "text",
            "text" => [
                "body" => $notification->getMessage(),
            ]
        ];

        $ch = curl_init();

        //Configura as ações
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        dd($response);
        if ($response == false) {
            return false;
        }
        return true;
    }



    public function sendMessageTemplate(Notification $notification): bool
    {
        //Documentation: https://laravel.com/docs/8.x/http-client#main-content
        //Postman: https://www.postman.com/meta/workspace/whatsapp-business-platform/request/13382743-8eb0859b-b19e-43bc-acd3-ab46b9ead11b
        //https://www.postman.com/meta/workspace/whatsapp-business-platform/documentation/13382743-2fd9b32d-f63c-4056-873e-4c398dde9d6d?entity=request-13382743-7dee3bda-71c2-4c15-8f48-4778548b5501
        //Models: https://business.facebook.com/wa/manage/message-templates/?business_id=882940378796059&waba_id=250832364784730&global_scope_id=882940378796059&filters=%7B%22search_text%22%3A%22%22%2C%22tag%22%3A[]%2C%22language%22%3A[]%2C%22status%22%3A[%22APPROVED%22%2C%22IN_APPEAL%22%2C%22PAUSED%22%2C%22PENDING%22%2C%22REJECTED%22]%2C%22quality%22%3A[]%2C%22date_range%22%3A30%7D
        //https://developers.facebook.com/docs/whatsapp/business-management-api/guides
        //$objRepo = new EloquentHttpRepository();
        //$objCreateHandler = new CreateHttpHandler($objRepo);
        //$objServiceHttp = new HttpApplicationService($objCreateHandler);
        //App\Application\Services\HttpApplicationService
        //https://business.facebook.com/wa/manage/message-templates/?business_id=882940378796059&waba_id=292058767334842&global_scope_id=882940378796059&filters=%7B%22search_text%22%3A%22%22%2C%22tag%22%3A[]%2C%22language%22%3A[]%2C%22status%22%3A[%22APPROVED%22%2C%22IN_APPEAL%22%2C%22PAUSED%22%2C%22PENDING%22%2C%22REJECTED%22]%2C%22quality%22%3A[]%2C%22date_range%22%3A30%7D

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

        $templateObj    = $notification->getTemplate();
        $typeMessage    = 'template'; //text

        $url = $this->buildUrlRequest() . '/' . $this->whatsAppBusinessAccountId . '/messages';
        $accessToken = $this->accessToken;
        $to = (string) $notification->getTargetContactAddress();
        /* $variables = [
            ['type' => 'text', 'text' => (string) $notification->getTargetContactName()], //Client name
            ['type' => 'text', 'text' => "Studio Beleza"], //Company
            ['type' => 'text', 'text' => "2024-06-30"], //Date
            ['type' => 'text', 'text' => "10:10 A.M"], //Hour
            ['type' => 'text', 'text' => "Skin care"], //Service
            ['type' => 'text', 'text' => "Rua das Amoras, Brazil"], //Origin Address
            ['type' => 'text', 'text' => "+55(98)984257623"], //Origin phone number
            ['type' => 'text', 'text' => "http://localhost:3000"], //Origin phone number

        ]; */

        $variables = [];

        $tempArrayObj   = $templateObj->getVariables();
        $template       = $templateObj->getName() ?? 'confirm_service'; //previa//hello_world//statement_available_2//confirm_service
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
            "type" => "text",
            "template" => [
                'name' => $template,
                'language' => [
                    'code' => $language
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        dd($response);
        if ($response == false) {
            return false;
        }
        return true;
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

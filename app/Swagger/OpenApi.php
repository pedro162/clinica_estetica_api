<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="Central de Serviços API",
 *     version="1.0.0",
 *     description="API responsável pela centralização e orquestração de serviços"
 *   ),
 *
 *   @OA\Components(
 *     @OA\SecurityScheme(
 *       securityScheme="passport",
 *       type="oauth2",
 *       description="OAuth2 via Laravel Passport",
 *       flows={
 *         @OA\Flow(
 *           flow="password",
 *           tokenUrl="/oauth/token",
 *           scopes={}
 *         )
 *       }
 *     )
 *   )
 * )
 */
class OpenApi
{
}

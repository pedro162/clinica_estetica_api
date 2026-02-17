<?php

namespace App\Swagger\Schemas\Service;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ServiceResponseSchema",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Premium Service"),
 *     @OA\Property(property="descricao", type="string", example="Premium Service Description"),
 *     @OA\Property(property="unidade", type="string", example="unit"),
 *     @OA\Property(property="type", type="string", example="mensalidade"),
 *     @OA\Property(property="active", type="string", example="yes"),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="user_update_id", type="integer", nullable=true, example=null),
 *     @OA\Property(property="tenant_id", type="integer", example=1),
 *     @OA\Property(property="vrServico", type="number", format="float", example=99.90),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-04T18:25:28.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-04T18:25:28.000000Z"),
 * )
 */
class ServiceResponseSchema {}

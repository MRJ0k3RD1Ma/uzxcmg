<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Site",
 *     description="Frontend uchun apilar ro'yhati (har bir til uchun bitta)"
 * )
 */


/**
 * @OA\Get(
 *     path="/home/{language}",
 *     tags={"Home"},
 *     summary="Home page uchun endpoint",
 *     description="Home pagedagi barcha ma'lumotlarni olish",
 *
 *     @OA\Response(
 *          response=200,
 *          description="Maqolalar ro'yxati",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Article")),
 *              @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *          )
 *      ),
 *
 *     */


class SiteApi
{
}

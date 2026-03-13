<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Article",
 *     description="Maqolalar boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/article",
 *     tags={"Article"},
 *     summary="Maqolalar ro'yxati",
 *     description="Barcha maqolalarni olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Sahifa raqami",
 *         @OA\Schema(type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Har sahifadagi elementlar soni",
 *         @OA\Schema(type="integer", default=20)
 *     ),
 *     @OA\Parameter(
 *         name="navigation_id",
 *         in="query",
 *         description="Navigatsiya ID bo'yicha filter",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="language",
 *         in="query",
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="Status bo'yicha filter",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Global qidiruv (name, description)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="expand",
 *         in="query",
 *         description="Qo'shimcha relatsiyalarni olish (navigation, language)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Maqolalar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Article")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/article/{id}",
 *     tags={"Article"},
 *     summary="Maqola ma'lumotlari",
 *     description="ID bo'yicha maqola ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Maqola ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Maqola ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Article")
 *     ),
 *     @OA\Response(response=404, description="Maqola topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/article",
 *     tags={"Article"},
 *     summary="Yangi maqola yaratish",
 *     description="Yangi maqola qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "navigation_id"},
 *             @OA\Property(property="name", type="string", example="Yangilik sarlavhasi"),
 *             @OA\Property(property="description", type="string", example="Yangilik matni"),
 *             @OA\Property(property="navigation_id", type="integer", example=1),
 *             @OA\Property(property="language", type="string", example="uz"),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Maqola yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Article")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/article/{id}",
 *     tags={"Article"},
 *     summary="Maqola yangilash",
 *     description="Maqola ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Maqola ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="navigation_id", type="integer"),
 *             @OA\Property(property="language", type="string"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Maqola yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Article")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Maqola topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/article/{id}",
 *     tags={"Article"},
 *     summary="Maqola o'chirish",
 *     description="Maqolani o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Maqola ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Maqola o'chirildi"),
 *     @OA\Response(response=404, description="Maqola topilmadi")
 * )
 */
class ArticleApi
{
}

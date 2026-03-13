<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Banner",
 *     description="Bannerlar boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/banner",
 *     tags={"Banner"},
 *     summary="Bannerlar ro'yxati",
 *     description="Barcha bannerlarni olish",
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
 *     @OA\Response(
 *         response=200,
 *         description="Bannerlar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Banner")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/banner/{id}",
 *     tags={"Banner"},
 *     summary="Banner ma'lumotlari",
 *     description="ID bo'yicha banner ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Banner ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Banner ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Banner")
 *     ),
 *     @OA\Response(response=404, description="Banner topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/banner",
 *     tags={"Banner"},
 *     summary="Yangi banner yaratish",
 *     description="Yangi banner qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"language"},
 *             @OA\Property(property="name", type="string", example="Banner sarlavhasi"),
 *             @OA\Property(property="description", type="string", example="Banner tavsifi"),
 *             @OA\Property(property="language", type="string", example="uz"),
 *             @OA\Property(property="image_id", type="integer", example=1),
 *             @OA\Property(property="button", type="object", example={"text": "Batafsil", "url": "/about"}),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Banner yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Banner")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/banner/{id}",
 *     tags={"Banner"},
 *     summary="Banner yangilash",
 *     description="Banner ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Banner ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="language", type="string"),
 *             @OA\Property(property="image_id", type="integer"),
 *             @OA\Property(property="button", type="object"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Banner yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Banner")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Banner topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/banner/{id}",
 *     tags={"Banner"},
 *     summary="Banner o'chirish",
 *     description="Bannerni o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Banner ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Banner o'chirildi"),
 *     @OA\Response(response=404, description="Banner topilmadi")
 * )
 */
class BannerApi
{
}

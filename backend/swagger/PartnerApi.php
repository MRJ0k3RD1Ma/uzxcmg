<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Partner",
 *     description="Hamkorlar boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/partner",
 *     tags={"Partner"},
 *     summary="Hamkorlar ro'yxati",
 *     description="Barcha hamkorlarni olish",
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
 *         description="Global qidiruv (name)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="expand",
 *         in="query",
 *         description="Qo'shimcha relatsiyalarni olish (language)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hamkorlar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Partner")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/partner/{id}",
 *     tags={"Partner"},
 *     summary="Hamkor ma'lumotlari",
 *     description="ID bo'yicha hamkor ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hamkor ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hamkor ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Partner")
 *     ),
 *     @OA\Response(response=404, description="Hamkor topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/partner",
 *     tags={"Partner"},
 *     summary="Yangi hamkor yaratish",
 *     description="Yangi hamkor qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "language"},
 *             @OA\Property(property="name", type="string", example="Hamkor nomi"),
 *             @OA\Property(property="language", type="string", example="uz"),
 *             @OA\Property(property="image_id", type="integer", example=1),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Hamkor yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Partner")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/partner/{id}",
 *     tags={"Partner"},
 *     summary="Hamkor yangilash",
 *     description="Hamkor ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hamkor ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="language", type="string"),
 *             @OA\Property(property="image_id", type="integer"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Hamkor yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Partner")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Hamkor topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/partner/{id}",
 *     tags={"Partner"},
 *     summary="Hamkor o'chirish",
 *     description="Hamkorni o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Hamkor ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Hamkor o'chirildi"),
 *     @OA\Response(response=404, description="Hamkor topilmadi")
 * )
 */
class PartnerApi
{
}

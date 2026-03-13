<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Navigation",
 *     description="Navigatsiya boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/navigation",
 *     tags={"Navigation"},
 *     summary="Navigatsiyalar ro'yxati",
 *     description="Barcha navigatsiyalarni olish",
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
 *         name="name",
 *         in="query",
 *         description="Nom bo'yicha qidirish",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="parent_id",
 *         in="query",
 *         description="Parent navigatsiya ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="language",
 *         in="query",
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="template",
 *         in="query",
 *         description="Shablon turi (single, list, category, extra)",
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
 *         description="Global qidiruv",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Navigatsiyalar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Navigation")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/navigation/tree",
 *     tags={"Navigation"},
 *     summary="Navigatsiya daraxti",
 *     description="Navigatsiyalarni daraxt ko'rinishda olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="language",
 *         in="query",
 *         description="Til kodi (uz, ru, en). Berilmasa barcha tillar uchun qaytaradi",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Navigatsiya daraxti",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="name", type="string"),
 *                 @OA\Property(property="slug", type="string"),
 *                 @OA\Property(property="template", type="string"),
 *                 @OA\Property(property="children", type="array", @OA\Items(type="object"))
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/navigation/{id}",
 *     tags={"Navigation"},
 *     summary="Navigatsiya ma'lumotlari",
 *     description="ID bo'yicha navigatsiya ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Navigatsiya ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Navigatsiya ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Navigation")
 *     ),
 *     @OA\Response(response=404, description="Navigatsiya topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/navigation",
 *     tags={"Navigation"},
 *     summary="Yangi navigatsiya yaratish",
 *     description="Yangi navigatsiya qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Bosh sahifa"),
 *             @OA\Property(property="slug", type="string", example="bosh-sahifa"),
 *             @OA\Property(property="icon", type="string", example="icon-home"),
 *             @OA\Property(property="image_id", type="integer"),
 *             @OA\Property(property="parent_id", type="integer"),
 *             @OA\Property(property="language", type="string", example="uz"),
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="extra_url", type="string"),
 *             @OA\Property(property="is_category", type="boolean", example=false),
 *             @OA\Property(property="is_extra", type="boolean", example=false),
 *             @OA\Property(property="sort_order", type="integer", example=1),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Navigatsiya yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Navigation")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/navigation/{id}",
 *     tags={"Navigation"},
 *     summary="Navigatsiya yangilash",
 *     description="Navigatsiya ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Navigatsiya ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="slug", type="string"),
 *             @OA\Property(property="icon", type="string"),
 *             @OA\Property(property="image_id", type="integer"),
 *             @OA\Property(property="parent_id", type="integer"),
 *             @OA\Property(property="language", type="string"),
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="extra_url", type="string"),
 *             @OA\Property(property="is_category", type="boolean"),
 *             @OA\Property(property="is_extra", type="boolean"),
 *             @OA\Property(property="sort_order", type="integer"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Navigatsiya yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Navigation")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Navigatsiya topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/navigation/{id}",
 *     tags={"Navigation"},
 *     summary="Navigatsiya o'chirish",
 *     description="Navigatsiyani o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Navigatsiya ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Navigatsiya o'chirildi"),
 *     @OA\Response(response=404, description="Navigatsiya topilmadi")
 * )
 */
class NavigationApi
{
}

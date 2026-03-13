<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Category",
 *     description="Kategoriyalar boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/category",
 *     tags={"Category"},
 *     summary="Kategoriyalar ro'yxati",
 *     description="Barcha kategoriyalarni olish",
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
 *         description="Parent kategoriya ID",
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
 *         description="Global qidiruv",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Kategoriyalar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Category")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/category/tree",
 *     tags={"Category"},
 *     summary="Kategoriyalar daraxti",
 *     description="Kategoriyalarni daraxt ko'rinishda olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="language",
 *         in="query",
 *         description="Til kodi (uz, ru, en). Berilmasa barcha tillar uchun qaytaradi",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Kategoriyalar daraxti",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="name", type="string"),
 *                 @OA\Property(property="slug", type="string"),
 *                 @OA\Property(property="children", type="array", @OA\Items(type="object"))
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/category/{id}",
 *     tags={"Category"},
 *     summary="Kategoriya ma'lumotlari",
 *     description="ID bo'yicha kategoriya ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Kategoriya ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Kategoriya ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Response(response=404, description="Kategoriya topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/category",
 *     tags={"Category"},
 *     summary="Yangi kategoriya yaratish",
 *     description="Yangi kategoriya qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Elektronika"),
 *             @OA\Property(property="slug", type="string", example="elektronika"),
 *             @OA\Property(property="icon", type="string", example="icon-electronics"),
 *             @OA\Property(property="image_id", type="integer", example=1),
 *             @OA\Property(property="parent_id", type="integer", example=null),
 *             @OA\Property(property="language", type="string", example="uz"),
 *             @OA\Property(property="spec_template", type="string"),
 *             @OA\Property(property="sort_order", type="integer", example=1),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Kategoriya yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/category/{id}",
 *     tags={"Category"},
 *     summary="Kategoriya yangilash",
 *     description="Kategoriya ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Kategoriya ID",
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
 *             @OA\Property(property="spec_template", type="string"),
 *             @OA\Property(property="sort_order", type="integer"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Kategoriya yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Kategoriya topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/category/{id}",
 *     tags={"Category"},
 *     summary="Kategoriya o'chirish",
 *     description="Kategoriyani o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Kategoriya ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Kategoriya o'chirildi"),
 *     @OA\Response(response=404, description="Kategoriya topilmadi")
 * )
 */
class CategoryApi
{
}

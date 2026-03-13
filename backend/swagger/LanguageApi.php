<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Language",
 *     description="Tillar boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/language",
 *     tags={"Language"},
 *     summary="Tillar ro'yxati",
 *     description="Barcha tillarni olish",
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
 *         name="code",
 *         in="query",
 *         description="Kod bo'yicha filter (uz, ru, en)",
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
 *         description="Tillar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Language")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/language/{id}",
 *     tags={"Language"},
 *     summary="Til ma'lumotlari",
 *     description="ID bo'yicha til ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Til ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Til ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Language")
 *     ),
 *     @OA\Response(response=404, description="Til topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/language",
 *     tags={"Language"},
 *     summary="Yangi til yaratish",
 *     description="Yangi til qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "code"},
 *             @OA\Property(property="name", type="string", example="O'zbekcha"),
 *             @OA\Property(property="code", type="string", example="uz"),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Til yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Language")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/language/{id}",
 *     tags={"Language"},
 *     summary="Til yangilash",
 *     description="Til ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Til ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="code", type="string"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Til yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Language")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Til topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/language/{id}",
 *     tags={"Language"},
 *     summary="Til o'chirish",
 *     description="Tilni o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Til ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Til o'chirildi"),
 *     @OA\Response(response=404, description="Til topilmadi")
 * )
 */
class LanguageApi
{
}

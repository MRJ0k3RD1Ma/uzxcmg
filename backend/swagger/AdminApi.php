<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Admin",
 *     description="Admin boshqaruv API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/admin",
 *     tags={"Admin"},
 *     summary="Adminlar ro'yxati",
 *     description="Barcha adminlarni olish",
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
 *         description="Ism bo'yicha qidirish",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="username",
 *         in="query",
 *         description="Username bo'yicha qidirish",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="phone",
 *         in="query",
 *         description="Telefon bo'yicha qidirish",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="role_id",
 *         in="query",
 *         description="Rol bo'yicha filter",
 *         @OA\Schema(type="integer")
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
 *         description="Adminlar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Admin")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/admin/{id}",
 *     tags={"Admin"},
 *     summary="Admin ma'lumotlari",
 *     description="ID bo'yicha admin ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Admin ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Admin ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Admin")
 *     ),
 *     @OA\Response(response=404, description="Admin topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/admin",
 *     tags={"Admin"},
 *     summary="Yangi admin yaratish",
 *     description="Yangi admin qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "password", "name", "role_id"},
 *             @OA\Property(property="username", type="string", example="newadmin"),
 *             @OA\Property(property="password", type="string", example="password123"),
 *             @OA\Property(property="name", type="string", example="New Admin"),
 *             @OA\Property(property="phone", type="string", example="+998901234567"),
 *             @OA\Property(property="role_id", type="integer", example=1),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Admin yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Admin")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/admin/{id}",
 *     tags={"Admin"},
 *     summary="Admin yangilash",
 *     description="Admin ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Admin ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="username", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="phone", type="string"),
 *             @OA\Property(property="role_id", type="integer"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Admin yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Admin")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Admin topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/admin/{id}",
 *     tags={"Admin"},
 *     summary="Admin o'chirish",
 *     description="Adminni o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Admin ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Admin o'chirildi"),
 *     @OA\Response(response=404, description="Admin topilmadi")
 * )
 */
class AdminApi
{
}

<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Admin Role",
 *     description="Admin rollar boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/admin-role",
 *     tags={"Admin Role"},
 *     summary="Rollar ro'yxati",
 *     description="Barcha admin rollarini olish",
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
 *         description="Rollar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/AdminRole")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/admin-role/{id}",
 *     tags={"Admin Role"},
 *     summary="Rol ma'lumotlari",
 *     description="ID bo'yicha rol ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Rol ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Rol ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/AdminRole")
 *     ),
 *     @OA\Response(response=404, description="Rol topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/admin-role",
 *     tags={"Admin Role"},
 *     summary="Yangi rol yaratish",
 *     description="Yangi admin roli qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Moderator"),
 *             @OA\Property(property="permissions", type="string", example="[]"),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Rol yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/AdminRole")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/admin-role/{id}",
 *     tags={"Admin Role"},
 *     summary="Rol yangilash",
 *     description="Rol ma'lumotlarini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Rol ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="permissions", type="string"),
 *             @OA\Property(property="status", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Rol yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/AdminRole")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Rol topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/admin-role/{id}",
 *     tags={"Admin Role"},
 *     summary="Rol o'chirish",
 *     description="Rolni o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Rol ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Rol o'chirildi"),
 *     @OA\Response(response=404, description="Rol topilmadi")
 * )
 */
class AdminRoleApi
{
}

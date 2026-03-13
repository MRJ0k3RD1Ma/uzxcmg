<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Admin Auth",
 *     description="Admin autentifikatsiya API"
 * )
 */

/**
 * @OA\Post(
 *     path="/v1/admin-auth/login",
 *     tags={"Admin Auth"},
 *     summary="Admin login",
 *     description="Admin tizimga kirishi",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "password"},
 *             @OA\Property(property="username", type="string", example="admin"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Muvaffaqiyatli login",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="admin", ref="#/components/schemas/Admin"),
 *                 @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
 *                 @OA\Property(property="refresh_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
 *                 @OA\Property(property="expires_in", type="integer", example=3600)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Username va password kiritilishi shart"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Login yoki parol noto'g'ri"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/v1/admin-auth/refresh",
 *     tags={"Admin Auth"},
 *     summary="Token yangilash",
 *     description="Refresh token orqali yangi access token olish",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"refresh_token"},
 *             @OA\Property(property="refresh_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Token muvaffaqiyatli yangilandi",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="access_token", type="string"),
 *                 @OA\Property(property="refresh_token", type="string"),
 *                 @OA\Property(property="expires_in", type="integer", example=3600)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Refresh token kiritilishi shart"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Refresh token yaroqsiz"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/v1/admin-auth/me",
 *     tags={"Admin Auth"},
 *     summary="Joriy admin ma'lumotlari",
 *     description="Token orqali joriy admin ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Admin ma'lumotlari",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", ref="#/components/schemas/Admin")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Token topilmadi yoki yaroqsiz"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/v1/admin-auth/logout",
 *     tags={"Admin Auth"},
 *     summary="Tizimdan chiqish",
 *     description="Admin tizimdan chiqishi",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Muvaffaqiyatli chiqish",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Tizimdan chiqdingiz")
 *         )
 *     )
 * )
 */
class AdminAuthApi
{
}

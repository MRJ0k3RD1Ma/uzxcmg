<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Media Type",
 *     description="Media turlari boshqaruvi API"
 * )
 *
 * @OA\Tag(
 *     name="Media",
 *     description="Media boshqaruvi API"
 * )
 */

/**
 * @OA\Schema(
 *     schema="MediaType",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Video"),
 *     @OA\Property(property="slug", type="string", example="video"),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Media",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Reklama banneri"),
 *     @OA\Property(property="slug", type="string", example="reklama-banneri"),
 *     @OA\Property(property="url", type="string", nullable=true, example="https://youtube.com/watch?v=xxx"),
 *     @OA\Property(property="has_url", type="boolean", example=false),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(
 *         property="type",
 *         nullable=true,
 *         ref="#/components/schemas/MediaType"
 *     ),
 *     @OA\Property(
 *         property="file",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer", example=10),
 *         @OA\Property(property="name", type="string", example="banner.jpg"),
 *         @OA\Property(property="slug", type="string", example="banner-jpg"),
 *         @OA\Property(property="exts", type="string", example="jpg"),
 *         @OA\Property(property="download_url", type="string", example="/api/v1/getfile/banner-jpg"),
 *         @OA\Property(
 *             property="download",
 *             type="object",
 *             nullable=true,
 *             description="Faqat rasm fayllari uchun (jpg, jpeg, png, gif, webp)",
 *             @OA\Property(property="sm", type="string", example="/api/v1/getfile/banner-jpg?size=sm"),
 *             @OA\Property(property="md", type="string", example="/api/v1/getfile/banner-jpg?size=md"),
 *             @OA\Property(property="lg", type="string", example="/api/v1/getfile/banner-jpg?size=lg")
 *         ),
 *         @OA\Property(
 *             property="url",
 *             type="object",
 *             nullable=true,
 *             description="Faqat rasm fayllari uchun",
 *             @OA\Property(property="sm", type="string"),
 *             @OA\Property(property="md", type="string"),
 *             @OA\Property(property="lg", type="string")
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * ===================== MEDIA TYPE =====================
 *
 * @OA\Get(
 *     path="/v1/media-type",
 *     tags={"Media Type"},
 *     summary="Media turlari ro'yxati",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
 *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer", default=20)),
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="Media turlari ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MediaType")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/media-type/{id}",
 *     tags={"Media Type"},
 *     summary="Media turi ma'lumotlari",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Media turi", @OA\JsonContent(ref="#/components/schemas/MediaType")),
 *     @OA\Response(response=404, description="Topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/media-type",
 *     tags={"Media Type"},
 *     summary="Yangi media turi yaratish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Video"),
 *             @OA\Property(property="status", type="integer", example=1, description="1 = active, 0 = inactive")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Media turi yaratildi", @OA\JsonContent(ref="#/components/schemas/MediaType")),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/media-type/{id}",
 *     tags={"Media Type"},
 *     summary="Media turini yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Rasm"),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Media turi yangilandi", @OA\JsonContent(ref="#/components/schemas/MediaType")),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/media-type/{id}",
 *     tags={"Media Type"},
 *     summary="Media turini o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=204, description="O'chirildi"),
 *     @OA\Response(response=404, description="Topilmadi")
 * )
 *
 * ===================== MEDIA =====================
 *
 * @OA\Get(
 *     path="/v1/media",
 *     tags={"Media"},
 *     summary="Media ro'yxati",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
 *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer", default=20)),
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="type_id", in="query", description="Media turi ID", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="has_url", in="query", description="URL bormi: 0 yoki 1", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="search", in="query", description="Nom bo'yicha qidirish", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="Media ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Media")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/media/{id}",
 *     tags={"Media"},
 *     summary="Media ma'lumotlari",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Media", @OA\JsonContent(ref="#/components/schemas/Media")),
 *     @OA\Response(response=404, description="Topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/media",
 *     tags={"Media"},
 *     summary="Yangi media yaratish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Reklama banneri"),
 *             @OA\Property(property="file_id", type="integer", example=10, nullable=true),
 *             @OA\Property(property="url", type="string", example="https://youtube.com/watch?v=xxx", nullable=true),
 *             @OA\Property(property="has_url", type="integer", example=0, description="0 = fayl, 1 = URL"),
 *             @OA\Property(property="type_id", type="integer", example=1, nullable=true),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(response=201, description="Media yaratildi", @OA\JsonContent(ref="#/components/schemas/Media")),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/media/{id}",
 *     tags={"Media"},
 *     summary="Media yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Yangilangan nom"),
 *             @OA\Property(property="file_id", type="integer", example=10, nullable=true),
 *             @OA\Property(property="url", type="string", example="https://youtube.com/watch?v=xxx", nullable=true),
 *             @OA\Property(property="has_url", type="integer", example=0),
 *             @OA\Property(property="type_id", type="integer", example=1, nullable=true),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Media yangilandi", @OA\JsonContent(ref="#/components/schemas/Media")),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/media/{id}",
 *     tags={"Media"},
 *     summary="Media o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=204, description="O'chirildi"),
 *     @OA\Response(response=404, description="Topilmadi")
 * )
 */
class MediaApi
{
}

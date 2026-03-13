<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="File",
 *     description="Fayl boshqaruvi API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/file",
 *     tags={"File"},
 *     summary="Fayllar ro'yxati",
 *     description="Barcha aktiv fayllarni olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Fayllar ro'yxati",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/File")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/file/{id}",
 *     tags={"File"},
 *     summary="Fayl ma'lumotlari",
 *     description="ID bo'yicha fayl ma'lumotlarini olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Fayl ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Fayl ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/File")
 *     ),
 *     @OA\Response(response=404, description="Fayl topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/file/upload",
 *     tags={"File"},
 *     summary="Fayl yuklash (Chunked)",
 *     description="Chunked upload orqali fayl yuklash. Katta fayllar uchun qismlarga bo'lib yuklash mumkin.",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"chunk", "fileId", "fileName", "chunkIndex", "totalChunks"},
 *                 @OA\Property(
 *                     property="chunk",
 *                     type="string",
 *                     format="binary",
 *                     description="Fayl chunk"
 *                 ),
 *                 @OA\Property(
 *                     property="fileId",
 *                     type="string",
 *                     description="Unikal fayl identifikatori (client tomonidan generatsiya qilinadi)"
 *                 ),
 *                 @OA\Property(
 *                     property="fileName",
 *                     type="string",
 *                     description="Original fayl nomi"
 *                 ),
 *                 @OA\Property(
 *                     property="chunkIndex",
 *                     type="integer",
 *                     description="Chunk indeksi (0 dan boshlanadi)"
 *                 ),
 *                 @OA\Property(
 *                     property="totalChunks",
 *                     type="integer",
 *                     description="Jami chunklar soni"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Chunk qabul qilindi (hali tugallanmagan)",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Chunk 0 qabul qilindi"),
 *             @OA\Property(property="uploadedChunks", type="integer", example=1),
 *             @OA\Property(property="totalChunks", type="integer", example=5)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Fayl muvaffaqiyatli yuklandi",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="status", type="string", example="ACTIVE"),
 *             @OA\Property(property="slug", type="string", example="abc123xyz"),
 *             @OA\Property(property="exts", type="string", example="jpg"),
 *             @OA\Property(property="download_url", type="string", example="/api/v1/getfile/abc123xyz"),
 *             @OA\Property(
 *                 property="download",
 *                 type="object",
 *                 @OA\Property(property="sm", type="string"),
 *                 @OA\Property(property="md", type="string"),
 *                 @OA\Property(property="lg", type="string")
 *             ),
 *             @OA\Property(
 *                 property="url",
 *                 type="object",
 *                 @OA\Property(property="sm", type="string"),
 *                 @OA\Property(property="md", type="string"),
 *                 @OA\Property(property="lg", type="string")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Post(
 *     path="/v1/file/cancel",
 *     tags={"File"},
 *     summary="Yuklashni bekor qilish",
 *     description="Yuklash jarayonida bekor qilish va temp fayllarni tozalash",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"fileId"},
 *             @OA\Property(property="fileId", type="string", description="Yuklash uchun ishlatilgan fileId")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Temp fayllar tozalandi",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Temp fayllar tozalandi")
 *         )
 *     ),
 *     @OA\Response(response=400, description="fileId majburiy")
 * )
 *
 * @OA\Delete(
 *     path="/v1/file/{id}",
 *     tags={"File"},
 *     summary="Fayl o'chirish",
 *     description="Faylni o'chirish (soft delete)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Fayl ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Fayl o'chirildi"),
 *     @OA\Response(response=404, description="Fayl topilmadi")
 * )
 */
class FileApi
{
}

<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Setting",
 *     description="Sayt sozlamalari API (har bir til uchun bitta)"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/setting",
 *     tags={"Setting"},
 *     summary="Barcha sozlamalar",
 *     description="Barcha tillar uchun sozlamalarni olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="language",
 *         in="query",
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sozlamalar ro'yxati",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Setting"))
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/setting/by-language",
 *     tags={"Setting"},
 *     summary="Til bo'yicha sozlama",
 *     description="Ma'lum til uchun sozlamani olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="language",
 *         in="query",
 *         required=true,
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sozlama ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Setting")
 *     ),
 *     @OA\Response(response=404, description="Sozlama topilmadi")
 * )
 *
 * @OA\Get(
 *     path="/v1/setting/{id}",
 *     tags={"Setting"},
 *     summary="Sozlama ma'lumotlari",
 *     description="ID bo'yicha sozlama olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Sozlama ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sozlama ma'lumotlari",
 *         @OA\JsonContent(ref="#/components/schemas/Setting")
 *     ),
 *     @OA\Response(response=404, description="Sozlama topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/setting",
 *     tags={"Setting"},
 *     summary="Sozlama yaratish/yangilash",
 *     description="Yangi sozlama yaratish yoki mavjud bo'lsa yangilash (har bir til uchun faqat bitta)",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"language"},
 *             @OA\Property(property="language", type="string", example="uz"),
 *             @OA\Property(property="name", type="string", example="UZXCMG"),
 *             @OA\Property(property="logo_orginal_id", type="integer", example=1),
 *             @OA\Property(property="logo_white_id", type="integer", example=2),
 *             @OA\Property(property="url_instagram", type="string", example="https://instagram.com/uzxcmg"),
 *             @OA\Property(property="url_telegram", type="string", example="https://t.me/uzxcmg"),
 *             @OA\Property(property="url_facebook", type="string", example="https://facebook.com/uzxcmg"),
 *             @OA\Property(property="url_linkedIn", type="string", example="https://linkedin.com/company/uzxcmg"),
 *             @OA\Property(property="url_threads", type="string"),
 *             @OA\Property(property="url_discord", type="string"),
 *             @OA\Property(property="url_youtube", type="string", example="https://youtube.com/@uzxcmg"),
 *             @OA\Property(property="url_whatsapp", type="string", example="https://wa.me/998901234567"),
 *             @OA\Property(property="phone", type="string", example="+998 90 123 45 67"),
 *             @OA\Property(property="other_phones", type="array", @OA\Items(type="string"), example={"+998 90 111 22 33", "+998 90 444 55 66"}),
 *             @OA\Property(property="emails", type="array", @OA\Items(type="string"), example={"info@uzxcmg.uz", "sales@uzxcmg.uz"}),
 *             @OA\Property(property="address", type="string", example="Toshkent sh., Chilonzor t."),
 *             @OA\Property(property="count_employee", type="integer", example=50),
 *             @OA\Property(property="count_delivered", type="integer", example=1000),
 *             @OA\Property(property="count_product_types", type="integer", example=100),
 *             @OA\Property(property="count_international_clients", type="integer", example=25),
 *             @OA\Property(property="about_name", type="string", example="Biz haqimizda"),
 *             @OA\Property(property="about_description", type="string", example="Kompaniya haqida batafsil ma'lumot"),
 *             @OA\Property(property="company_name", type="string", example="UZXCMG LLC"),
 *             @OA\Property(
 *                 property="questions",
 *                 type="array",
 *                 @OA\Items(type="object"),
 *                 example={
 *                     {"question": "Yetkazib berish qancha vaqt oladi?", "answer": "1-3 ish kuni ichida"},
 *                     {"question": "To'lov qanday amalga oshiriladi?", "answer": "Naqd, karta yoki bank o'tkazmasi orqali"}
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Sozlama yaratildi",
 *         @OA\JsonContent(ref="#/components/schemas/Setting")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sozlama yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Setting")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/setting/{id}",
 *     tags={"Setting"},
 *     summary="Sozlama yangilash",
 *     description="Sozlama ma'lumotlarini yangilash (tilni o'zgartirib bo'lmaydi)",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Sozlama ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="logo_orginal_id", type="integer"),
 *             @OA\Property(property="logo_white_id", type="integer"),
 *             @OA\Property(property="url_instagram", type="string"),
 *             @OA\Property(property="url_telegram", type="string"),
 *             @OA\Property(property="url_facebook", type="string"),
 *             @OA\Property(property="url_linkedIn", type="string"),
 *             @OA\Property(property="url_threads", type="string"),
 *             @OA\Property(property="url_discord", type="string"),
 *             @OA\Property(property="url_youtube", type="string"),
 *             @OA\Property(property="url_whatsapp", type="string"),
 *             @OA\Property(property="phone", type="string"),
 *             @OA\Property(property="other_phones", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="emails", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="address", type="string"),
 *             @OA\Property(property="count_employee", type="integer"),
 *             @OA\Property(property="count_delivered", type="integer"),
 *             @OA\Property(property="count_product_types", type="integer"),
 *             @OA\Property(property="count_international_clients", type="integer"),
 *             @OA\Property(property="about_name", type="string"),
 *             @OA\Property(property="about_description", type="string"),
 *             @OA\Property(property="company_name", type="string"),
 *             @OA\Property(property="questions", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Sozlama yangilandi",
 *         @OA\JsonContent(ref="#/components/schemas/Setting")
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Sozlama topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/setting/{id}",
 *     tags={"Setting"},
 *     summary="Sozlama o'chirish",
 *     description="Sozlamani o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Sozlama ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=204, description="Sozlama o'chirildi"),
 *     @OA\Response(response=404, description="Sozlama topilmadi")
 * )
 */
class SettingApi
{
}

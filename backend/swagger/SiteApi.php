<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Site",
 *     description="Frontend uchun apilar ro'yhati (har bir til uchun bitta)"
 * )
 */

/**
 * @OA\Get(
 *     path="/home/{language}",
 *     tags={"Site"},
 *     summary="Home page uchun endpoint",
 *     description="Home page'dagi barcha ma'lumotlarni olish (navigation, category, articles, setting)",
 *
 *     @OA\Parameter(
 *         name="language",
 *         in="path",
 *         required=true,
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string", example="uz")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Home page ma'lumotlari muvaffaqiyatli qaytarildi",
 *         @OA\JsonContent(
 *             @OA\Property(property="navigation", type="array", description="Navigatsiya daraxti", @OA\Items(type="object")),
 *             @OA\Property(property="category", type="array", description="Kategoriyalar daraxti", @OA\Items(type="object")),
 *             @OA\Property(property="articles", type="array", description="4 ta eng oxirgi maqolalar", @OA\Items(type="object")),
 *             @OA\Property(property="setting", type="object", description="Sayt sozlamalari")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Til topilmadi",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Til topilmadi: xx")
 *         )
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/category/{language}",
 *     tags={"Site"},
 *     summary="Kategoriyalar daraxti",
 *     description="Barcha kategoriyalarni daraxt ko'rinishda olish",
 *
 *     @OA\Parameter(
 *         name="language",
 *         in="path",
 *         required=true,
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string", example="uz")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Kategoriyalar muvaffaqiyatli qaytarildi",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", description="Kategoriyalar daraxti",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="parent_id", type="integer", example=null),
 *                     @OA\Property(property="name", type="string", example="Elektronika"),
 *                     @OA\Property(property="slug", type="string", example="elektronika"),
 *                     @OA\Property(property="icon", type="string", example="icon-electronics"),
 *                     @OA\Property(property="spec_template", type="object", nullable=true, description="Xususiyatlar shabloni"),
 *                     @OA\Property(property="sort_order", type="integer", example=1),
 *                     @OA\Property(property="status", type="string", example="ACTIVE"),
 *                     @OA\Property(property="language_code", type="string", example="uz"),
 *                     @OA\Property(property="language_name", type="string", example="O'zbekcha"),
 *                     @OA\Property(property="created_at", type="string", format="date-time"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time"),
 *                     @OA\Property(property="image", type="object", nullable=true),
 *                     @OA\Property(property="children", type="array", @OA\Items(type="object"))
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Til topilmadi",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Til topilmadi: xx")
 *         )
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/navigation/{language}",
 *     tags={"Site"},
 *     summary="Navigatsiya daraxti",
 *     description="Barcha navigatsiyalarni daraxt ko'rinishda olish",
 *
 *     @OA\Parameter(
 *         name="language",
 *         in="path",
 *         required=true,
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string", example="uz")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Navigatsiyalar muvaffaqiyatli qaytarildi",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", description="Navigatsiya daraxti",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="parent_id", type="integer", example=null),
 *                     @OA\Property(property="name", type="string", example="Bosh sahifa"),
 *                     @OA\Property(property="slug", type="string", example="bosh-sahifa"),
 *                     @OA\Property(property="icon", type="string", example="icon-home"),
 *                     @OA\Property(property="template", type="string", example="SINGLE"),
 *                     @OA\Property(property="extra_url", type="string", nullable=true),
 *                     @OA\Property(property="sort_order", type="integer", example=1),
 *                     @OA\Property(property="status", type="string", example="ACTIVE"),
 *                     @OA\Property(property="language_code", type="string", example="uz"),
 *                     @OA\Property(property="language_name", type="string", example="O'zbekcha"),
 *                     @OA\Property(property="created_at", type="string", format="date-time"),
 *                     @OA\Property(property="updated_at", type="string", format="date-time"),
 *                     @OA\Property(property="image", type="object", nullable=true),
 *                     @OA\Property(property="category", type="object", nullable=true),
 *                     @OA\Property(property="children", type="array", @OA\Items(type="object"))
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Til topilmadi",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Til topilmadi: xx")
 *         )
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/articles/{language}/{slug}",
 *     tags={"Site"},
 *     summary="Maqola yoki maqolalar ro'yxati",
 *     description="Navigation slug orqali maqola yoki maqolalar ro'yxatini olish. 
 *     
 *     ## Template turlari:
 *     - **SINGLE** - 1 ta maqola qaytariladi (about, contact kabi sahifalar)
 *     - **LIST** - Maqolalar ro'yxati pagination bilan (yangiliklar, blog kabi)",
 *
 *     @OA\Parameter(
 *         name="language",
 *         in="path",
 *         required=true,
 *         description="Til kodi (uz, ru, en)",
 *         @OA\Schema(type="string", example="uz")
 *     ),
 *     @OA\Parameter(
 *         name="slug",
 *         in="path",
 *         required=true,
 *         description="Navigation slug (masalan: about, news, blog)",
 *         @OA\Schema(type="string", example="about")
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Sahifa raqami (faqat LIST template uchun)",
 *         @OA\Schema(type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Har sahifadagi elementlar soni (faqat LIST template uchun)",
 *         @OA\Schema(type="integer", default=13)
 *     ),
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Qidiruv so'zi (faqat LIST template uchun)",
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Maqola muvaffaqiyatli qaytarildi",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", description="SINGLE template - 1 ta maqola yoki LIST template - maqolalar ro'yxati"),
 *             @OA\Property(property="navigation", type="object", description="Navigation ma'lumotlari"),
 *             @OA\Property(property="pagination", type="object", description="Pagination (faqat LIST template)",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="per_page", type="integer", example=13),
 *                 @OA\Property(property="total_items", type="integer", example=50),
 *                 @OA\Property(property="total_pages", type="integer", example=4),
 *                 @OA\Property(property="has_next", type="boolean", example=true),
 *                 @OA\Property(property="has_prev", type="boolean", example=false)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Til, navigatsiya yoki maqola topilmadi",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Maqola topilmadi")
 *         )
 *     )
 * )
 */
class SiteApi
{
}

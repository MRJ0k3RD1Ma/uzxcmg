<?php

namespace backend\swagger;

/**
 * @OA\Tag(
 *     name="Product",
 *     description="Mahsulotlar boshqaruvi API"
 * )
 *
 * @OA\Tag(
 *     name="Product Guide",
 *     description="Mahsulot qo'llanmalari API"
 * )
 *
 * @OA\Tag(
 *     name="Product Image",
 *     description="Mahsulot rasmlari API"
 * )
 *
 * @OA\Tag(
 *     name="Product Soft",
 *     description="Mahsulot dasturlari API"
 * )
 *
 * @OA\Tag(
 *     name="Product Rating",
 *     description="Mahsulot baholari API"
 * )
 */

/**
 * @OA\Get(
 *     path="/v1/product",
 *     tags={"Product"},
 *     summary="Mahsulotlar ro'yxati",
 *     description="Barcha mahsulotlarni olish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
 *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer", default=20)),
 *     @OA\Parameter(name="category_id", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="language", in="query", @OA\Schema(type="string")),
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="featured", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="min_price", in="query", @OA\Schema(type="number")),
 *     @OA\Parameter(name="max_price", in="query", @OA\Schema(type="number")),
 *     @OA\Parameter(name="in_stock", in="query", @OA\Schema(type="boolean")),
 *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
 *     @OA\Parameter(name="expand", in="query", description="images,guides,softs", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="Mahsulotlar ro'yxati",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Avtorizatsiya xatosi")
 * )
 *
 * @OA\Get(
 *     path="/v1/product/{id}",
 *     tags={"Product"},
 *     summary="Mahsulot ma'lumotlari",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Mahsulot ma'lumotlari", @OA\JsonContent(ref="#/components/schemas/Product")),
 *     @OA\Response(response=404, description="Mahsulot topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/product",
 *     tags={"Product"},
 *     summary="Yangi mahsulot yaratish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "category_id"},
 *             @OA\Property(property="name", type="string", example="Mahsulot nomi"),
 *             @OA\Property(property="sku", type="string", example="SKU-001"),
 *             @OA\Property(property="price", type="number", example=100000),
 *             @OA\Property(property="stock_quantity", type="integer", example=10),
 *             @OA\Property(property="category_id", type="integer", example=1),
 *             @OA\Property(property="language", type="string", example="uz"),
 *             @OA\Property(property="featured", type="integer", example=0),
 *             @OA\Property(property="status", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(response=201, description="Mahsulot yaratildi", @OA\JsonContent(ref="#/components/schemas/Product")),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/product/{id}",
 *     tags={"Product"},
 *     summary="Mahsulot yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="sku", type="string"),
 *         @OA\Property(property="price", type="number"),
 *         @OA\Property(property="stock_quantity", type="integer"),
 *         @OA\Property(property="category_id", type="integer"),
 *         @OA\Property(property="language", type="string"),
 *         @OA\Property(property="featured", type="integer"),
 *         @OA\Property(property="status", type="integer")
 *     )),
 *     @OA\Response(response=200, description="Mahsulot yangilandi", @OA\JsonContent(ref="#/components/schemas/Product")),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Mahsulot topilmadi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/product/{id}",
 *     tags={"Product"},
 *     summary="Mahsulot o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=204, description="Mahsulot o'chirildi"),
 *     @OA\Response(response=404, description="Mahsulot topilmadi")
 * )
 *
 * @OA\Post(
 *     path="/v1/product/create-fully",
 *     tags={"Product"},
 *     summary="To'liq mahsulot yaratish",
 *     description="Mahsulot bilan birga guides, images, softs yaratish",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="sku", type="string"),
 *             @OA\Property(property="price", type="number"),
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="language", type="string"),
 *             @OA\Property(property="guides", type="array", @OA\Items(ref="#/components/schemas/ProductGuide")),
 *             @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/ProductImage")),
 *             @OA\Property(property="softs", type="array", @OA\Items(ref="#/components/schemas/ProductSoft"))
 *         )
 *     ),
 *     @OA\Response(response=201, description="Mahsulot yaratildi"),
 *     @OA\Response(response=400, description="Validatsiya xatosi")
 * )
 *
 * @OA\Put(
 *     path="/v1/product/{id}/update-fully",
 *     tags={"Product"},
 *     summary="To'liq mahsulot yangilash",
 *     description="Mahsulot bilan birga guides, images, softs yangilash.
 *
 * ## Muhim qoidalar:
 *
 * ### Mavjud elementni YANGILASH (guides/images/softs):
 * - `id` maydoni **SHART** - qaysi elementni yangilash kerakligini bildiradi
 * - Faqat o'zgartirmoqchi bo'lgan maydonlarni yuboring
 *
 * ### YANGI element QO'SHISH:
 * - `id` maydonini **YUBORMASLIK KERAK** - id bo'lmasa yangi element yaratiladi
 * - Barcha majburiy maydonlarni to'ldiring
 *
 * ### Elementni O'CHIRISH (soft delete):
 * - Request da yuborilmagan elementlar avtomatik o'chiriladi (status=0)
 * - Masalan: 3 ta image bor, faqat 2 tasini yuborsangiz, 3-chi o'chiriladi
 *
 * ### Product maydonlari:
 * - Faqat o'zgartirmoqchi bo'lgan maydonlarni yuboring
 * - `language` - til kodi (uz, ru, en) yoki `language_id` ishlatish mumkin",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="id", in="path", required=true, description="Mahsulot ID", @OA\Schema(type="integer")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", description="Mahsulot nomi", example="Yangilangan mahsulot nomi"),
 *             @OA\Property(property="description", type="string", description="Tavsif", example="Mahsulot haqida batafsil ma'lumot"),
 *             @OA\Property(property="sku", type="string", description="SKU (avtomatik generatsiya qilinadi)", example="UZ-PRODU-ABC1234"),
 *             @OA\Property(property="price", type="integer", description="Narx (so'mda)", example=1500000),
 *             @OA\Property(property="discount_price", type="integer", description="Chegirmali narx", example=1200000),
 *             @OA\Property(property="discount_expires", type="string", format="date-time", description="Chegirma tugash vaqti", example="2025-12-31T23:59:59"),
 *             @OA\Property(property="stock_quantity", type="integer", description="Ombordagi soni", example=50),
 *             @OA\Property(property="category_id", type="integer", description="Kategoriya ID", example=5),
 *             @OA\Property(property="language", type="string", description="Til kodi", example="uz"),
 *             @OA\Property(property="image_id", type="integer", description="Asosiy rasm ID", example=10),
 *             @OA\Property(property="featured", type="integer", description="Tanlangan (0/1)", example=1),
 *             @OA\Property(property="rating", type="integer", description="Reyting (1-5)", example=5),
 *             @OA\Property(property="status", type="integer", description="Status (0=inactive, 1=active)", example=1),
 *             @OA\Property(property="seo_title", type="string", description="SEO sarlavha", example="Mahsulot nomi - UZXCMG"),
 *             @OA\Property(property="seo_description", type="string", description="SEO tavsif", example="Mahsulot haqida qisqacha SEO tavsifi"),
 *             @OA\Property(
 *                 property="specifications",
 *                 type="object",
 *                 description="Xususiyatlar (JSON)",
 *                 example={"Og'irligi": "2.5 kg", "Rangi": "Qora", "O'lchami": "100x50x30 cm"}
 *             ),
 *             @OA\Property(
 *                 property="guides",
 *                 type="array",
 *                 description="Qo'llanmalar. id bilan = yangilash, id siz = yangi qo'shish",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", description="Mavjud qo'llanma ID (yangilash uchun). YANGI qo'shishda BU MAYDONNI YUBORMASLIK KERAK"),
 *                     @OA\Property(property="title", type="string", description="Sarlavha (majburiy yangi uchun)", example="O'rnatish qo'llanmasi"),
 *                     @OA\Property(property="content", type="string", description="Mazmuni", example="<p>1-qadam: Qutidan chiqaring...</p>"),
 *                     @OA\Property(property="has_video", type="integer", description="Video bormi (0/1)", example=1),
 *                     @OA\Property(property="video_id", type="integer", description="Video fayl ID", example=15),
 *                     @OA\Property(property="sort_order", type="integer", description="Tartib", example=1),
 *                     @OA\Property(property="status", type="integer", description="Status (0/1)", example=1)
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="images",
 *                 type="array",
 *                 description="Rasmlar. id bilan = yangilash, id siz = yangi qo'shish",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", description="Mavjud rasm ID (yangilash uchun). YANGI qo'shishda BU MAYDONNI YUBORMASLIK KERAK"),
 *                     @OA\Property(property="image_id", type="integer", description="Fayl ID (majburiy yangi uchun)", example=20),
 *                     @OA\Property(property="alt_text", type="string", description="Alt matn", example="Mahsulot rasmi - old ko'rinish"),
 *                     @OA\Property(property="is_primary", type="integer", description="Asosiy rasmmi (0/1)", example=0),
 *                     @OA\Property(property="sort_order", type="integer", description="Tartib", example=1),
 *                     @OA\Property(property="status", type="integer", description="Status (0/1)", example=1)
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="softs",
 *                 type="array",
 *                 description="Dasturlar/Fayllar. id bilan = yangilash, id siz = yangi qo'shish",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", description="Mavjud dastur ID (yangilash uchun). YANGI qo'shishda BU MAYDONNI YUBORMASLIK KERAK"),
 *                     @OA\Property(property="name", type="string", description="Dastur nomi (majburiy yangi uchun)", example="Windows Driver v2.0"),
 *                     @OA\Property(property="file_id", type="integer", description="Fayl ID", example=25),
 *                     @OA\Property(property="status", type="integer", description="Status (0/1)", example=1)
 *                 )
 *             ),
 *             example={
 *                 "name": "Smart TV 55 inch 4K",
 *                 "description": "Ultra HD Smart televizor, HDR10+ qo'llab-quvvatlash",
 *                 "price": 5500000,
 *                 "discount_price": 4900000,
 *                 "discount_expires": "2025-06-30T23:59:59",
 *                 "stock_quantity": 25,
 *                 "category_id": 3,
 *                 "language": "uz",
 *                 "featured": 1,
 *                 "specifications": {
 *                     "Ekran": "55 inch",
 *                     "Razreshenie": "3840x2160",
 *                     "HDR": "HDR10+"
 *                 },
 *                 "guides": {
 *                     {
 *                         "id": 5,
 *                         "title": "Yangilangan o'rnatish qo'llanmasi",
 *                         "content": "<p>Yangilangan mazmun...</p>"
 *                     },
 *                     {
 *                         "title": "Yangi qo'llanma (id yo'q = yangi yaratiladi)",
 *                         "content": "<p>Yangi qo'llanma mazmuni</p>",
 *                         "has_video": 0,
 *                         "sort_order": 2
 *                     }
 *                 },
 *                 "images": {
 *                     {
 *                         "id": 10,
 *                         "alt_text": "Yangilangan alt text",
 *                         "sort_order": 1
 *                     },
 *                     {
 *                         "id": 11,
 *                         "is_primary": 1
 *                     },
 *                     {
 *                         "image_id": 30,
 *                         "alt_text": "Yangi rasm (id yo'q = yangi yaratiladi)",
 *                         "sort_order": 3
 *                     }
 *                 },
 *                 "softs": {
 *                     {
 *                         "id": 3,
 *                         "name": "Yangilangan driver nomi"
 *                     },
 *                     {
 *                         "name": "Yangi dastur (id yo'q = yangi yaratiladi)",
 *                         "file_id": 35
 *                     }
 *                 }
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mahsulot muvaffaqiyatli yangilandi",
 *         @OA\JsonContent(
 *             @OA\Property(property="product", ref="#/components/schemas/Product"),
 *             @OA\Property(property="guides", type="array", @OA\Items(ref="#/components/schemas/ProductGuide")),
 *             @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/ProductImage")),
 *             @OA\Property(property="softs", type="array", @OA\Items(ref="#/components/schemas/ProductSoft"))
 *         )
 *     ),
 *     @OA\Response(response=400, description="Validatsiya xatosi"),
 *     @OA\Response(response=404, description="Mahsulot topilmadi")
 * )
 *
 * ===================== UPDATE-FULLY MISOLLAR =====================
 *
 * MISOL 1: Faqat mahsulot ma'lumotlarini yangilash (guides/images/softs o'zgarmaydi)
 * @OA\Schema(
 *     schema="UpdateFullyExample1_OnlyProduct",
 *     description="Faqat mahsulot ma'lumotlarini yangilash",
 *     @OA\Property(property="name", example="Yangi nom"),
 *     @OA\Property(property="price", example=2000000),
 *     @OA\Property(property="stock_quantity", example=100)
 * )
 *
 * MISOL 2: Mavjud guide ni yangilash (id bilan)
 * @OA\Schema(
 *     schema="UpdateFullyExample2_UpdateGuide",
 *     description="Mavjud qo'llanmani yangilash - id SHART",
 *     @OA\Property(
 *         property="guides",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", example=5, description="MAVJUD guide ID - SHART"),
 *             @OA\Property(property="title", example="Yangilangan sarlavha"),
 *             @OA\Property(property="content", example="Yangilangan mazmun")
 *         )
 *     )
 * )
 *
 * MISOL 3: Yangi guide qo'shish (id YO'Q)
 * @OA\Schema(
 *     schema="UpdateFullyExample3_NewGuide",
 *     description="Yangi qo'llanma qo'shish - id YUBORILMAYDI",
 *     @OA\Property(
 *         property="guides",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="title", example="Yangi qo'llanma", description="SHART"),
 *             @OA\Property(property="content", example="Qo'llanma mazmuni"),
 *             @OA\Property(property="has_video", example=0),
 *             @OA\Property(property="sort_order", example=1)
 *         )
 *     )
 * )
 *
 * MISOL 4: Mavjud image yangilash (id bilan)
 * @OA\Schema(
 *     schema="UpdateFullyExample4_UpdateImage",
 *     description="Mavjud rasmni yangilash - id SHART",
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", example=10, description="MAVJUD image ID - SHART"),
 *             @OA\Property(property="alt_text", example="Yangi alt text"),
 *             @OA\Property(property="is_primary", example=1),
 *             @OA\Property(property="sort_order", example=1)
 *         )
 *     )
 * )
 *
 * MISOL 5: Yangi image qo'shish (id YO'Q)
 * @OA\Schema(
 *     schema="UpdateFullyExample5_NewImage",
 *     description="Yangi rasm qo'shish - id YUBORILMAYDI",
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="image_id", example=25, description="Fayl ID - SHART"),
 *             @OA\Property(property="alt_text", example="Yangi rasm tavsifi"),
 *             @OA\Property(property="is_primary", example=0),
 *             @OA\Property(property="sort_order", example=2)
 *         )
 *     )
 * )
 *
 * MISOL 6: Mavjud soft yangilash (id bilan)
 * @OA\Schema(
 *     schema="UpdateFullyExample6_UpdateSoft",
 *     description="Mavjud dasturni yangilash - id SHART",
 *     @OA\Property(
 *         property="softs",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="id", example=3, description="MAVJUD soft ID - SHART"),
 *             @OA\Property(property="name", example="Driver v2.1 (yangilangan)"),
 *             @OA\Property(property="file_id", example=30)
 *         )
 *     )
 * )
 *
 * MISOL 7: Yangi soft qo'shish (id YO'Q)
 * @OA\Schema(
 *     schema="UpdateFullyExample7_NewSoft",
 *     description="Yangi dastur qo'shish - id YUBORILMAYDI",
 *     @OA\Property(
 *         property="softs",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="name", example="Yangi dastur", description="SHART"),
 *             @OA\Property(property="file_id", example=35, description="Fayl ID")
 *         )
 *     )
 * )
 *
 * MISOL 8: Aralash - yangilash + yangi qo'shish
 * @OA\Schema(
 *     schema="UpdateFullyExample8_Mixed",
 *     description="Aralash holat: mavjudlarni yangilash + yangilarni qo'shish",
 *     @OA\Property(property="name", example="Mahsulot nomi yangilandi"),
 *     @OA\Property(property="price", example=3000000),
 *     @OA\Property(
 *         property="guides",
 *         type="array",
 *         @OA\Items(type="object"),
 *         example={
 *             {"id": 5, "title": "Mavjud guide yangilandi"},
 *             {"title": "Yangi guide", "content": "Yangi mazmun", "sort_order": 2}
 *         }
 *     ),
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(type="object"),
 *         example={
 *             {"id": 10, "is_primary": 1},
 *             {"id": 11, "sort_order": 2},
 *             {"image_id": 40, "alt_text": "Yangi rasm", "sort_order": 3}
 *         }
 *     ),
 *     @OA\Property(
 *         property="softs",
 *         type="array",
 *         @OA\Items(type="object"),
 *         example={
 *             {"id": 3, "name": "Yangilangan dastur nomi"},
 *             {"name": "Yangi dastur fayli", "file_id": 45}
 *         }
 *     )
 * )
 *
 * MISOL 9: Ba'zi elementlarni o'chirish
 * @OA\Schema(
 *     schema="UpdateFullyExample9_DeleteSome",
 *     description="O'chirish: Faqat saqlamoqchi bo'lganlarni yuboring. Yuborilmaganlar o'chiriladi (soft delete)",
 *     @OA\Property(
 *         property="images",
 *         type="array",
 *         @OA\Items(type="object"),
 *         description="Agar 5 ta rasm bor bo'lib, faqat 2 tasini yuborsangiz, qolgan 3 tasi o'chiriladi",
 *         example={
 *             {"id": 10, "sort_order": 1},
 *             {"id": 11, "sort_order": 2}
 *         }
 *     )
 * )
 *
 * ===================== PRODUCT GUIDES =====================
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/guides",
 *     tags={"Product Guide"},
 *     summary="Qo'llanmalar ro'yxati",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="has_video", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
 *     @OA\Response(response=200, description="Qo'llanmalar ro'yxati")
 * )
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/guides/{id}",
 *     tags={"Product Guide"},
 *     summary="Qo'llanma ma'lumotlari",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Qo'llanma ma'lumotlari", @OA\JsonContent(ref="#/components/schemas/ProductGuide"))
 * )
 *
 * @OA\Post(
 *     path="/v1/product/{product_id}/guides",
 *     tags={"Product Guide"},
 *     summary="Yangi qo'llanma yaratish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="title", type="string"),
 *         @OA\Property(property="content", type="string"),
 *         @OA\Property(property="has_video", type="integer"),
 *         @OA\Property(property="video_id", type="integer"),
 *         @OA\Property(property="sort_order", type="integer")
 *     )),
 *     @OA\Response(response=201, description="Qo'llanma yaratildi")
 * )
 *
 * @OA\Put(
 *     path="/v1/product/{product_id}/guides/{id}",
 *     tags={"Product Guide"},
 *     summary="Qo'llanma yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="title", type="string"),
 *         @OA\Property(property="content", type="string"),
 *         @OA\Property(property="has_video", type="integer"),
 *         @OA\Property(property="video_id", type="integer"),
 *         @OA\Property(property="sort_order", type="integer")
 *     )),
 *     @OA\Response(response=200, description="Qo'llanma yangilandi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/product/{product_id}/guides/{id}",
 *     tags={"Product Guide"},
 *     summary="Qo'llanma o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=204, description="Qo'llanma o'chirildi")
 * )
 *
 * ===================== PRODUCT IMAGES =====================
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/images",
 *     tags={"Product Image"},
 *     summary="Rasmlar ro'yxati",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="is_primary", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="expand", in="query", description="image", @OA\Schema(type="string")),
 *     @OA\Response(response=200, description="Rasmlar ro'yxati")
 * )
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/images/{id}",
 *     tags={"Product Image"},
 *     summary="Rasm ma'lumotlari",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Rasm ma'lumotlari", @OA\JsonContent(ref="#/components/schemas/ProductImage"))
 * )
 *
 * @OA\Post(
 *     path="/v1/product/{product_id}/images",
 *     tags={"Product Image"},
 *     summary="Yangi rasm qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="image_id", type="integer"),
 *         @OA\Property(property="is_primary", type="integer"),
 *         @OA\Property(property="sort_order", type="integer")
 *     )),
 *     @OA\Response(response=201, description="Rasm qo'shildi")
 * )
 *
 * @OA\Put(
 *     path="/v1/product/{product_id}/images/{id}",
 *     tags={"Product Image"},
 *     summary="Rasm yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="image_id", type="integer"),
 *         @OA\Property(property="is_primary", type="integer"),
 *         @OA\Property(property="sort_order", type="integer")
 *     )),
 *     @OA\Response(response=200, description="Rasm yangilandi")
 * )
 *
 * @OA\Put(
 *     path="/v1/product/{product_id}/images/{id}/set-primary",
 *     tags={"Product Image"},
 *     summary="Asosiy rasm qilish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Asosiy rasm o'rnatildi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/product/{product_id}/images/{id}",
 *     tags={"Product Image"},
 *     summary="Rasm o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=204, description="Rasm o'chirildi")
 * )
 *
 * ===================== PRODUCT SOFTS =====================
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/softs",
 *     tags={"Product Soft"},
 *     summary="Dasturlar ro'yxati",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
 *     @OA\Parameter(name="expand", in="query", description="file", @OA\Schema(type="string")),
 *     @OA\Response(response=200, description="Dasturlar ro'yxati")
 * )
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/softs/{id}",
 *     tags={"Product Soft"},
 *     summary="Dastur ma'lumotlari",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Dastur ma'lumotlari", @OA\JsonContent(ref="#/components/schemas/ProductSoft"))
 * )
 *
 * @OA\Post(
 *     path="/v1/product/{product_id}/softs",
 *     tags={"Product Soft"},
 *     summary="Yangi dastur qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="file_id", type="integer")
 *     )),
 *     @OA\Response(response=201, description="Dastur qo'shildi")
 * )
 *
 * @OA\Put(
 *     path="/v1/product/{product_id}/softs/{id}",
 *     tags={"Product Soft"},
 *     summary="Dastur yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="file_id", type="integer")
 *     )),
 *     @OA\Response(response=200, description="Dastur yangilandi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/product/{product_id}/softs/{id}",
 *     tags={"Product Soft"},
 *     summary="Dastur o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=204, description="Dastur o'chirildi")
 * )
 *
 * ===================== PRODUCT RATINGS =====================
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/ratings",
 *     tags={"Product Rating"},
 *     summary="Baholar ro'yxati",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="rate", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="user_id", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="order_id", in="query", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
 *     @OA\Parameter(name="expand", in="query", description="user,order", @OA\Schema(type="string")),
 *     @OA\Response(response=200, description="Baholar ro'yxati")
 * )
 *
 * @OA\Get(
 *     path="/v1/product/{product_id}/ratings/{id}",
 *     tags={"Product Rating"},
 *     summary="Baho ma'lumotlari",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Baho ma'lumotlari", @OA\JsonContent(ref="#/components/schemas/Rating"))
 * )
 *
 * @OA\Post(
 *     path="/v1/product/{product_id}/ratings",
 *     tags={"Product Rating"},
 *     summary="Yangi baho qo'shish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="user_id", type="integer"),
 *         @OA\Property(property="order_id", type="integer"),
 *         @OA\Property(property="rate", type="integer", example=5),
 *         @OA\Property(property="description", type="string")
 *     )),
 *     @OA\Response(response=201, description="Baho qo'shildi")
 * )
 *
 * @OA\Put(
 *     path="/v1/product/{product_id}/ratings/{id}",
 *     tags={"Product Rating"},
 *     summary="Baho yangilash",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *         @OA\Property(property="rate", type="integer"),
 *         @OA\Property(property="description", type="string")
 *     )),
 *     @OA\Response(response=200, description="Baho yangilandi")
 * )
 *
 * @OA\Delete(
 *     path="/v1/product/{product_id}/ratings/{id}",
 *     tags={"Product Rating"},
 *     summary="Baho o'chirish",
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="product_id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=204, description="Baho o'chirildi")
 * )
 */
class ProductApi
{
}

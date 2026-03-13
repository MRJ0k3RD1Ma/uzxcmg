<?php

namespace backend\swagger;

/**
 * @OA\Info(
 *     title="UZXCMG Admin API",
 *     version="1.0.0",
 *     description="UZXCMG Admin panel API dokumentatsiyasi",
 *     @OA\Contact(
 *         email="admin@uzxcmg.uz"
 *     )
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="JWT token orqali autentifikatsiya"
 * )
 *
 * @OA\Schema(
 *     schema="Pagination",
 *     type="object",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="per_page", type="integer", example=20),
 *     @OA\Property(property="total_items", type="integer", example=100),
 *     @OA\Property(property="total_pages", type="integer", example=5),
 *     @OA\Property(property="has_next", type="boolean", example=true),
 *     @OA\Property(property="has_prev", type="boolean", example=false)
 * )
 *
 * @OA\Schema(
 *     schema="Error",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Xatolik yuz berdi"),
 *     @OA\Property(property="errors", type="object")
 * )
 *
 * @OA\Schema(
 *     schema="Admin",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="username", type="string", example="admin"),
 *     @OA\Property(property="name", type="string", example="Admin User"),
 *     @OA\Property(property="phone", type="string", example="+998901234567"),
 *     @OA\Property(property="role_id", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="AdminRole",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Super Admin"),
 *     @OA\Property(property="permissions", type="string", example="[]"),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Language",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="O'zbekcha"),
 *     @OA\Property(property="code", type="string", example="uz"),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Elektronika"),
 *     @OA\Property(property="slug", type="string", example="elektronika"),
 *     @OA\Property(property="icon", type="string", example="icon-electronics"),
 *     @OA\Property(property="image_id", type="integer", example=1),
 *     @OA\Property(property="parent_id", type="integer", example=null),
 *     @OA\Property(property="language_id", type="integer", example=1),
 *     @OA\Property(property="spec_template", type="string"),
 *     @OA\Property(property="sort_order", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Navigation",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Bosh sahifa"),
 *     @OA\Property(property="slug", type="string", example="bosh-sahifa"),
 *     @OA\Property(property="icon", type="string", example="icon-home"),
 *     @OA\Property(property="image_id", type="integer"),
 *     @OA\Property(property="template", type="string", example="single"),
 *     @OA\Property(property="parent_id", type="integer"),
 *     @OA\Property(property="language_id", type="integer", example=1),
 *     @OA\Property(property="category_id", type="integer"),
 *     @OA\Property(property="extra_url", type="string"),
 *     @OA\Property(property="sort_order", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Article",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Yangilik sarlavhasi"),
 *     @OA\Property(property="description", type="string", example="Yangilik matni"),
 *     @OA\Property(property="navigation_id", type="integer", example=1),
 *     @OA\Property(property="language_id", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Mahsulot nomi"),
 *     @OA\Property(property="sku", type="string", example="SKU-001"),
 *     @OA\Property(property="price", type="number", example=100000),
 *     @OA\Property(property="stock_quantity", type="integer", example=10),
 *     @OA\Property(property="category_id", type="integer", example=1),
 *     @OA\Property(property="language_id", type="integer", example=1),
 *     @OA\Property(property="featured", type="integer", example=0),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="ProductGuide",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="product_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Qo'llanma sarlavhasi"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="has_video", type="integer", example=0),
 *     @OA\Property(property="video_id", type="integer"),
 *     @OA\Property(property="sort_order", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="ProductImage",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="product_id", type="integer", example=1),
 *     @OA\Property(property="image_id", type="integer", example=1),
 *     @OA\Property(property="is_primary", type="integer", example=0),
 *     @OA\Property(property="sort_order", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="ProductSoft",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="product_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Dastur nomi"),
 *     @OA\Property(property="file_id", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Rating",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="product_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="order_id", type="integer"),
 *     @OA\Property(property="rate", type="integer", example=5),
 *     @OA\Property(property="description", type="string", example="Juda yaxshi mahsulot"),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="File",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="slug", type="string", example="abc123"),
 *     @OA\Property(property="name", type="string", example="image"),
 *     @OA\Property(property="exts", type="string", example="jpg"),
 *     @OA\Property(property="url", type="string"),
 *     @OA\Property(property="status", type="integer", example=1),
 *     @OA\Property(property="created", type="string", format="date-time"),
 *     @OA\Property(property="updated", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Partner",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Hamkor nomi"),
 *     @OA\Property(property="language_code", type="string", example="uz"),
 *     @OA\Property(property="language_name", type="string", example="O'zbekcha"),
 *     @OA\Property(property="image", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="image"),
 *         @OA\Property(property="url", type="object")
 *     ),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Banner",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Banner sarlavhasi"),
 *     @OA\Property(property="description", type="string", example="Banner tavsifi"),
 *     @OA\Property(property="language_code", type="string", example="uz"),
 *     @OA\Property(property="language_name", type="string", example="O'zbekcha"),
 *     @OA\Property(property="image", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="image"),
 *         @OA\Property(property="url", type="object")
 *     ),
 *     @OA\Property(property="button", type="object", example={"text": "Batafsil", "url": "/about"}),
 *     @OA\Property(property="status", type="string", example="ACTIVE"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Setting",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="UZXCMG"),
 *     @OA\Property(property="language_code", type="string", example="uz"),
 *     @OA\Property(property="language_name", type="string", example="O'zbekcha"),
 *     @OA\Property(property="logo_orginal", type="object"),
 *     @OA\Property(property="logo_white", type="object"),
 *     @OA\Property(property="url_instagram", type="string"),
 *     @OA\Property(property="url_telegram", type="string"),
 *     @OA\Property(property="url_facebook", type="string"),
 *     @OA\Property(property="url_linkedIn", type="string"),
 *     @OA\Property(property="url_threads", type="string"),
 *     @OA\Property(property="url_discord", type="string"),
 *     @OA\Property(property="url_youtube", type="string"),
 *     @OA\Property(property="url_whatsapp", type="string"),
 *     @OA\Property(property="phone", type="string", example="+998 90 123 45 67"),
 *     @OA\Property(property="other_phones", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="emails", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="address", type="string"),
 *     @OA\Property(property="count_employee", type="integer", example=50),
 *     @OA\Property(property="count_delivered", type="integer", example=1000),
 *     @OA\Property(property="count_product_types", type="integer", example=100),
 *     @OA\Property(property="count_international_clients", type="integer", example=25),
 *     @OA\Property(property="about_name", type="string"),
 *     @OA\Property(property="about_description", type="string"),
 *     @OA\Property(property="company_name", type="string", example="UZXCMG LLC"),
 *     @OA\Property(property="questions", type="array", @OA\Items(type="object"))
 * )
 */
class OpenApi
{
}

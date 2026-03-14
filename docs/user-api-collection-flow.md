# User API Collection Flow

## Base Info

- Base URL: `{{base_url}}/api`
- Auth type: `Bearer {{token}}`
- Unified response wrapper:

```json
{
  "status": 200,
  "msg": "success",
  "data": {}
}
```

## Important Note

مش كل endpoint في الـ user flow المفروض "دايما" يرجع HTTP `200`.
الـ happy path غالبا بيرجع `200`، لكن في حالات validation/auth/business rules المشروع نفسه بيرجع:

- `400` للـ validation
- `401` للمشاكل الخاصة بالـ auth/activation
- `403` لبعض الـ forbidden actions
- `404` لو record مش موجود
- `422` لبعض reset-password cases
- `500` موجود في شوية business failures داخل الكود، وده محتاج يتراجع لأنه مستخدم بدل `4xx` في شوية أماكن

عشان كده verification الصح بعد ما نخلص collection هو:

- happy path requests: نتأكد إن HTTP status = `200`
- وكل response body فيها `status = 200`
- negative test requests: نتأكد إنها بترجع الـ status المتوقع حسب السيناريو

## Recommended Collection Folders

### 1. Public Bootstrap

Requests المستخدم يقدر يضربها من غير login:

- `GET /home`
- `GET /info`
- `GET /countries`
- `GET /categories/{{offset}}/{{limit}}`
- `GET /get/providers/{{offset}}/{{limit}}`
- `GET /get/ratings/{{offset}}/{{limit}}`
- `GET /products/{{offset}}/{{limit}}`
- `GET /products/details/{{product_id}}`
- `POST /contact-us`

### 2. Auth Flow

- `POST /auth/register`
- `POST /auth/mobile-check`
- `POST /auth/regenerate-code`
- `POST /auth/login`
- `GET /auth/check-token`
- `POST /auth/send-reset-code`
- `POST /auth/verify-reset-code`
- `POST /auth/reset`

Suggested happy path order:

1. `register`
2. `login`
3. store `token`
4. `auth/me`
5. `auth/refresh`

### 3. Authenticated Profile Flow

كل اللي تحت محتاج token + user active:

- `GET /auth`
- `GET /auth/refresh`
- `POST /auth/change-password`
- `POST /auth/change-mobile-number`
- `POST /auth/update`
- `POST /auth/guide/album`
- `POST /auth/logout`
- `GET /auth/delete-account`
- `GET /auth/statistics`
- `GET /auth/cart`
- `GET /auth/notifications/{{offset}}/{{limit}}`
- `GET /auth/favorites/{{offset}}/{{limit}}`
- `GET /auth/favorites/remove`

### 4. Favorites Flow

- `GET /favorites/toggle/{{product_id}}`
- `GET /favorites/remove/{{product_id}}`
- `GET /favorites/remove/all/products`

Suggested order:

1. list products
2. store `product_id`
3. toggle favorite
4. get favorites
5. remove favorite

### 5. Cart Flow

- `GET /cart/toggle/{{product_id}}`
- `GET /cart/add/{{product_id}}`
- `GET /cart/remove/{{product_id}}`
- `GET /cart/remove/all/products`
- `GET /cart/update/quantity/{{product_id}}?quantity={{quantity}}`
- `GET /auth/cart`

Suggested order:

1. add product
2. check cart
3. update quantity
4. remove product
5. remove all

### 6. Orders Flow

#### Purchase Order

- `POST /orders`
- `GET /orders/get/{{offset}}/{{limit}}`
- `GET /orders/order/{{order_id}}`
- `POST /orders/order/update/{{order_id}}`
- `POST /orders/check/coupon`
- `GET /orders/order/cancel/{{order_id}}`
- `GET /orders/get-link/online-payment/{{order_id}}`

#### Quotations

- `POST /orders/quotations`

#### Maintenance

- `POST /orders/maintenances`

#### Timeline / Partial Receive

- `POST /orders/order/change/timeline`
- `POST /orders/order/partial/receive`

#### Offers

- `POST /orders/offers`
- `POST /orders/offers/update/{{offer_id}}`
- `POST /orders/offer/actions`
- `GET /orders/offers/delete/{{offer_id}}`

#### Listing Helpers

- `GET /orders/get/random/{{offset}}/{{limit}}`
- `GET /orders/get/provider/orders/{{offset}}/{{limit}}`

### 7. Chat Flow

- `GET /chat/conversations`
- `GET /chat/conversation`
- `GET /chat/conversation/{{conversation_id}}/{{offset}}/{{limit}}`
- `POST /chat/messages/send`
- `GET /chat/messages/mark-as-read/{{message_id}}`
- `GET /chat/messages/delete/{{message_id}}`
- `GET /chat/unread-count/{{conversation_id}}`
- `POST /chat/conversations/{{conversation_id}}/toggle-block`

Suggested order:

1. get conversations
2. store `conversation_id`
3. get messages
4. send message
5. store `message_id`
6. unread count
7. mark as read
8. optional delete

### 8. Ratings

- `POST /ratings`

## Useful Collection Variables

- `base_url`
- `token`
- `offset`
- `limit`
- `product_id`
- `category_id`
- `provider_id`
- `order_id`
- `offer_id`
- `conversation_id`
- `message_id`
- `coupon_name`
- `quantity`
- `user_email`
- `user_password`
- `user_mobile`
- `verification_code`
- `reset_code`

## Request Body Hints From Validation

### `POST /auth/register`

Required fields found in code:

- `name`
- `email`
- `mobile`
- `password`
- `user_type`

Optional:

- `fcm_token`

### `POST /auth/login`

- `email`
- `password`
- optional `fcm_token`

### `POST /auth/update`

- `name`
- `email`
- `iban`

### `POST /auth/change-password`

- `old_password`
- `password`

### `POST /auth/change-mobile-number`

- `mobile`

### `POST /orders/check/coupon`

- `coupon`

### `POST /orders`

At minimum from validation:

- `address`

وبرضه لازم يكون عندك cart فيه منتجات قبل ما تضربها، لأن الكود بيرجع `400` لو الـ cart فاضي.

### `POST /orders/quotations`

Important validated fields:

- `files[]`
- `request_type`
- `frequency` لو `request_type = 2`
- `delivery_duration` لو `request_type = 2`
- `schedule_start_date` لو `request_type = 2`

### `POST /orders/maintenances`

Important validated fields:

- `files[]`

### `POST /orders/order/partial/receive`

- `order_id`
- `files[]`

### `POST /orders/order/change/timeline`

- `order_type`
- `timeline_no`
- `order_id`

### `POST /orders/offers`

- `files[]`
- `cost`
- `delivery_time`
- `warranty`
- `order_id`

### `POST /orders/offer/actions`

- `action`
- `offer_id`
- `rejected_reson` if `action = 3`

### `POST /chat/messages/send`

- `receiver_id`
- `message` or `file`

### `POST /ratings`

- `rating`
- `for_id`
- `for_type` = `User` or `Product`

## Recommended Postman Tests

### A. Collection-level test for happy path folders

استخدم ده في requests اللي المفروض تنجح:

```javascript
pm.test("HTTP 200", function () {
  pm.response.to.have.status(200);
});

pm.test("Body status is 200", function () {
  const json = pm.response.json();
  pm.expect(json.status).to.eql(200);
});
```

### B. Token capture after login/refresh

```javascript
const json = pm.response.json();
const token = json?.data?.token || json?.data;
if (token) {
  pm.collectionVariables.set("token", token);
}
```

### C. Capture IDs dynamically

Example after products list:

```javascript
const json = pm.response.json();
const firstProduct = json?.data?.data?.[0] || json?.data?.[0];
if (firstProduct?.id) {
  pm.collectionVariables.set("product_id", firstProduct.id);
}
```

Example after my orders:

```javascript
const json = pm.response.json();
const firstOrder = json?.data?.data?.[0] || json?.data?.[0];
if (firstOrder?.id) {
  pm.collectionVariables.set("order_id", firstOrder.id);
}
```

## Verification Strategy After Building The Collection

### Level 1: Manual smoke run inside Postman

شغّل الفولدرات بالترتيب:

1. Public Bootstrap
2. Auth Flow
3. Profile
4. Favorites
5. Cart
6. Orders
7. Chat
8. Ratings

### Level 2: Automated Collection Runner

استخدم Collection Runner مع Environment واحدة فيها:

- `base_url`
- credentials ليوزر test ثابت
- IDs ثابتة fallback لو dynamic extraction فشل

Target:

- كل happy path request تعدي
- no failed assertions
- no unexpected `500`

### Level 3: Newman in CI or locally

بعد ما الـ collection تجهز، تقدر تشغل:

```bash
npx newman run postman/user-app.postman_collection.json -e postman/local.postman_environment.json
```

ولو عايز report:

```bash
npx newman run postman/user-app.postman_collection.json -e postman/local.postman_environment.json -r cli,htmlextra
```

## What To Verify Besides 200

بعد الـ collection ما تشتغل، متقفش عند `200` بس. لازم نراجع:

- response schema ثابت
- الـ token بيتخزن وبيتستخدم صح
- الـ IDs بتتلقط صح بين requests
- الـ auth-protected endpoints بترفض access بدون token
- الـ validation endpoints بترجع `400` مش `500`
- business rule failures متتحولش لـ false positive

## Suggested Next Step

أفضل workflow عملي:

1. نعمل Postman collection مرتبة بنفس الفولدرات اللي فوق
2. نضيف tests مشتركة على مستوى collection
3. نعمل environment للـ local/staging
4. نشغل runner
5. أي endpoint تقع نرجع نحدد هل المشكلة:
   validation
   auth
   missing seeded data
   bug في الكود
   endpoint بترجع status code غلط

## Code References

- Routes: [routes/api.php](/c:/laragon/www/himaPlus_backend-main/routes/api.php)
- Response wrapper: [app/helper/functions.php](/c:/laragon/www/himaPlus_backend-main/app/helper/functions.php#L28)
- Auth API: [app/Http/Controllers/Api/AuthController.php](/c:/laragon/www/himaPlus_backend-main/app/Http/Controllers/Api/AuthController.php)
- Cart API: [app/Http/Controllers/Api/CartController.php](/c:/laragon/www/himaPlus_backend-main/app/Http/Controllers/Api/CartController.php)
- Favorites API: [app/Http/Controllers/Api/FavoriteController.php](/c:/laragon/www/himaPlus_backend-main/app/Http/Controllers/Api/FavoriteController.php)
- Orders API: [app/Http/Controllers/Api/OrderController.php](/c:/laragon/www/himaPlus_backend-main/app/Http/Controllers/Api/OrderController.php)
- Chat API: [app/Http/Controllers/Api/ChatController.php](/c:/laragon/www/himaPlus_backend-main/app/Http/Controllers/Api/ChatController.php)
- Products API: [app/Http/Controllers/Api/ProductController.php](/c:/laragon/www/himaPlus_backend-main/app/Http/Controllers/Api/ProductController.php)
- Ratings API: [app/Http/Controllers/Api/RatingController.php](/c:/laragon/www/himaPlus_backend-main/app/Http/Controllers/Api/RatingController.php)

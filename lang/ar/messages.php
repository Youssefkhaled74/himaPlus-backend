<?php

return [
    'success' => 'نجاح',
    'error' => 'خطأ',
    'warning' => 'تنبيه',
    'info' => 'معلومات',

    // General
    'something_went_wrong' => 'حدث خطأ ما، يرجى التواصل مع الدعم الفني',
    'not_found' => ':item غير موجود',
    'unauthorized' => 'غير مصرح לך بتنفيذ هذا الإجراء',
    'bad_request' => 'طلب غير صحيح',
    'internal_server_error' => 'خطأ داخلي في الخادم',
    'saved_successfully' => 'تم الحفظ بنجاح',
    'updated_successfully' => 'تم التحديث بنجاح',
    'deleted_successfully' => 'تم الحذف بنجاح',
    'action_successful' => 'تم الإجراء بنجاح',

    // Auth
    'account_not_activated' => 'هذا الحساب غير مفعل، يرجى التواصل مع الدعم الفني',
    'account_not_verified' => 'هذا الحساب غير مؤكد، يرجى تأكيد البريد الإلكتروني أو رقم الجوال',
    'invalid_credentials' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
    'login_failed' => 'فشل تسجيل الدخول، يرجى المحاولة مرة أخرى',
    'logged_out' => 'تم تسجيل الخروج بنجاح',
    'registration_successful' => 'تم التسجيل بنجاح، يرجى تأكيد حسابك',
    'account_verified' => 'تم تأكيد الحساب بنجاح',
    'invalid_verification_code' => 'رمز التحقق غير صالح أو منتهي الصلاحية',
    'invalid_reset_code' => 'رمز إعادة التعيين غير صالح أو منتهي الصلاحية',
    'reset_code_sent' => 'تم إرسال رمز إعادة التعيين بنجاح',
    'password_changed' => 'تم تغيير كلمة المرور بنجاح',
    'password_reset' => 'تم إعادة تعيين كلمة المرور بنجاح',
    'old_password_incorrect' => 'كلمة المرور القديمة غير صحيحة',
    'profile_updated' => 'تم تحديث الملف الشخصي بنجاح',
    'profile_update_failed' => 'فشل تحديث الملف الشخصي',
    'language_updated' => 'تم تحديث اللغة بنجاح',
    'password_change_failed' => 'فشل تغيير كلمة المرور',
    'vendor_not_found' => 'حساب المورد غير موجود',
    'account_not_found_or_deactivated' => 'الحساب غير موجود أو معطل',
    'invalid_verification_link' => 'رابط التحقق غير صالح، يرجى التواصل مع الدعم الفني',
    'invalid_reset_code_or_account' => 'رمز إعادة التعيين غير صالح أو الحساب غير موجود',
    'email_or_phone_required' => 'البريد الإلكتروني أو رقم الهاتف مطلوب',
    'reset_requires_verified_email' => 'إعادة التعيين عبر البريد الإلكتروني يتطلب بريداً إلكترونياً موثقاً',
    'reset_requires_verified_phone' => 'إعادة التعيين عبر الهاتف يتطلب رقماً موثقاً',
    'security_alert' => 'تنبيه أمني',
    'failed_login_attempts' => 'تم اكتشاف محاولات تسجيل دخول فاشلة متكررة على حسابك',
    'this_action_providers_only' => 'هذا الإجراء للموردين فقط',

    // Products
    'product_created' => 'تم إضافة المنتج بنجاح',
    'product_updated' => 'تم تحديث المنتج بنجاح',
    'product_deleted' => 'تم حذف المنتج بنجاح',
    'product_activated' => 'تم تفعيل المنتج',
    'product_deactivated' => 'تم إلغاء تفعيل المنتج',
    'product_not_found' => 'المنتج غير موجود',
    'product_created_error' => 'حدث خطأ أثناء إضافة المنتج',
    'product_updated_error' => 'حدث خطأ أثناء تحديث المنتج',

    // Orders
    'order_created' => 'تم إنشاء الطلب بنجاح',
    'order_created_payment_failed' => 'تم إنشاء الطلب، لكن فشل إنشاء رابط الدفع الإلكتروني',
    'order_not_found' => 'الطلب غير موجود',
    'order_deleted' => 'تم حذف هذا الطلب',
    'order_already_paid' => 'هذا الطلب مدفوع بالفعل',
    'order_paid' => 'هذا الطلب مدفوع',
    'order_has_offer' => 'يوجد عرض مقدم لهذا الطلب بالفعل',
    'order_canceled' => 'تم إلغاء الطلب',
    'order_canceled_title' => 'تم إلغاء الطلب',
    'order_canceled_content' => 'تم إلغاء الطلب رقم :id',
    'cant_cancel_processing' => 'لا يمكن الإلغاء لأن الطلب قيد المعالجة',
    'cant_cancel_paid' => 'لا يمكن الإلغاء لأن الطلب مدفوع، يرجى التواصل مع الدعم الفني',
    'order_sent_to_provider' => 'تم إرسال طلبك إلى المورد',
    'new_order_received' => 'لديك طلب جديد',
    'multiple_orders_created' => 'تم إنشاء طلبات متعددة، يتم توجيهك لدفع الطلب الأول الآن',
    'redirecting_to_payment' => 'جارٍ التوجيه إلى بوابة الدفع...',
    'continue_to_payment' => 'متابعة الدفع',

    // Offers
    'offer_created' => 'تم تقديم العرض بنجاح',
    'offer_updated' => 'تم تحديث العرض بنجاح',
    'offer_deleted' => 'تم حذف العرض بنجاح',
    'offer_already_exists' => 'لقد قدمت عرضاً لهذا الطلب بالفعل',
    'offer_not_found' => 'العرض غير موجود',
    'offer_has_actions' => 'هذا العرض لديه إجراءات مرتبطة به',
    'cant_remove_offer' => 'لا يمكن حذف هذا العرض، لديه إجراءات مرتبطة',
    'offer_updates' => 'تحديثات العرض',
    'offer_updated_content' => 'تم :action العرض رقم :id',

    // Notifications
    'notification_marked' => 'تم تعليم الإشعار كمقروء',
    'notification_deleted' => 'تم حذف الإشعار بنجاح',
    'all_marked' => 'تم تعليم جميع الإشعارات كمقروءة',
    'verified_your_account' => 'تحقق من حسابك',
    'your_code' => 'رمزك: :code',
    'reset_password_code' => 'رمز إعادة تعيين كلمة المرور',
    'your_code_is' => 'رمزك: :code',

    // Cart
    'cart_empty' => 'السلة فارغة',
    'added_to_cart' => 'تمت الإضافة إلى السلة بنجاح',
    'removed_from_cart' => 'تمت الإزالة من السلة بنجاح',
    'cart_updated' => 'تم تحديث السلة بنجاح',

    // Favorites
    'added_to_favorites' => 'تمت الإضافة إلى المفضلة',
    'removed_from_favorites' => 'تمت الإزالة من المفضلة',

    // Ratings
    'rating_submitted' => 'تم تقديم التقييم بنجاح',
    'rating_error' => 'خطأ في تقديم التقييم',

    // Coupons
    'coupon_invalid' => 'الكوبون المحدد غير صالح',

    // Categories
    'category_added' => 'تم إضافة التصنيف بنجاح',

    // Payment
    'arb_link_failed' => 'فشل إنشاء رابط الدفع',
    'paymob_link_failed' => 'فشل إنشاء رابط الدفع',

    // Email subjects
    'email_verify_account' => 'تحقق من حسابك',
    'email_order_updates' => 'تحديثات الطلب',
    'email_new_order' => 'طلب جديد',

    // API messages
    'must_select_user' => 'يجب اختيار مستخدم',
    'conversation_blocked' => 'هذه المحادثة محظورة',

    // Notifications content
    'notification_type_order' => 'طلب جديد',
    'notification_type_offer_accepted' => 'تم قبول العرض',
    'notification_type_offer_rejected' => 'تم رفض العرض',
    'notification_type_message' => 'رسالة جديدة',

    // Misc
    'deleted_order' => 'هذا الطلب تم حذفه',
    'this_offer_has_actions' => 'هذا العرض لديه إجراءات',
    'cant_remove_offer_actions' => 'لا يمكن حذف هذا العرض، لديه إجراءات مرتبطة',
    'cant_cancel_order_processing' => 'لا يمكن الإلغاء لأن الطلب قيد المعالجة بالفعل',
    'this_order_already_paid' => 'هذا الطلب مدفوع بالفعل',
    'paymob_link_generation_failed' => 'فشل إنشاء رابط الدفع',
    'something_wrong_technical' => 'حدث خطأ ما، يرجى التواصل مع الدعم الفني',
    'something_wrong_wrong' => 'حدث خطأ ما',
    'unauthorized_user_not_logged' => 'غير مصرح: المستخدم غير مسجل الدخول',
    'old_password_incorrect_api' => 'كلمة المرور القديمة غير صحيحة',
    'password_changed_successfully' => 'تم تغيير كلمة المرور بنجاح',
    'password_reset_successfully' => 'تم إعادة تعيين كلمة المرور بنجاح',
    'reset_code_sent_successfully' => 'تم إرسال رمز إعادة التعيين بنجاح',
    'code_verified_successfully' => 'تم التحقق من الرمز بنجاح',
    'successfully_logged_out' => 'تم تسجيل الخروج بنجاح',
    'user_not_found' => 'المستخدم غير موجود',
    'there_is_something_wrong' => 'حدث خطأ ما، يرجى التواصل مع الدعم الفني',
    'reset_by_email_requires_verified' => 'إعادة التعيين عبر البريد الإلكتروني تتطلب بريداً إلكترونياً موثقاً',
    'reset_by_phone_requires_verified' => 'إعادة التعيين عبر الهاتف تتطلب رقماً موثقاً',
    'invalid_email_or_password' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',

    // Order Status Labels (front-end)
    'status_pending' => 'قيد الانتظار',
    'status_confirmed' => 'تم التأكيد',
    'status_processing' => 'قيد التنفيذ',
    'status_completed' => 'مكتمل',
    'status_scheduled' => 'مجدول',
    'status_active' => 'نشط',
    'status_cancelled' => 'ملغي',
    'status_rejected' => 'مرفوض',

    // Order timeline notifications
    'order_status_update' => 'تم :step طلبك',
    'order_status_update_content' => 'تم :step الطلب رقم :id',
    'account_not_active' => 'هذا الحساب غير مفعل',
    'account_not_email_verified' => 'هذا الحساب غير مؤكد بالبريد الإلكتروني',
];

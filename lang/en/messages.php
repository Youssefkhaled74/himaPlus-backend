<?php

return [
    'success' => 'Success',
    'error' => 'Error',
    'warning' => 'Warning',
    'info' => 'Info',

    // General
    'something_went_wrong' => 'There is something wrong, please contact technical support',
    'not_found' => ':item not found',
    'unauthorized' => 'You are not authorized to perform this action',
    'bad_request' => 'Bad Request',
    'internal_server_error' => 'Internal Server Error',
    'saved_successfully' => 'Saved successfully',
    'updated_successfully' => 'Updated successfully',
    'deleted_successfully' => 'Deleted successfully',
    'action_successful' => 'Action completed successfully',

    // Auth
    'account_not_activated' => 'This account is not activated. Please contact technical support',
    'account_not_verified' => 'This account is not verified. Please verify your email or mobile number',
    'invalid_credentials' => 'Invalid email or password',
    'login_failed' => 'Login failed. Please try again',
    'logged_out' => 'Logged out successfully',
    'registration_successful' => 'Registration successful. Please verify your account',
    'account_verified' => 'Account verified successfully',
    'invalid_verification_code' => 'Invalid or expired verification code',
    'invalid_reset_code' => 'Invalid or expired reset code',
    'reset_code_sent' => 'Reset code sent successfully',
    'password_changed' => 'Password changed successfully',
    'password_reset' => 'Password reset successfully',
    'old_password_incorrect' => 'Old password is incorrect',
    'profile_updated' => 'Profile updated successfully',
    'profile_update_failed' => 'Failed to update profile',
    'language_updated' => 'Language updated successfully',
    'password_change_failed' => 'Failed to change password',
    'vendor_not_found' => 'Vendor account not found',
    'account_not_found_or_deactivated' => 'Account not found or deactivated',
    'invalid_verification_link' => 'Invalid verification link. Please contact technical support',
    'invalid_reset_code_or_account' => 'Invalid reset code or account not found',
    'email_or_phone_required' => 'Email or phone number is required',
    'reset_requires_verified_email' => 'Reset by email requires a verified email address',
    'reset_requires_verified_phone' => 'Reset by phone requires a verified phone number',
    'security_alert' => 'Security alert',
    'failed_login_attempts' => 'Repeated failed login attempts were detected on your account',
    'this_action_providers_only' => 'This action is for providers only',

    // Products
    'product_created' => 'Product created successfully',
    'product_updated' => 'Product updated successfully',
    'product_deleted' => 'Product deleted successfully',
    'product_activated' => 'Product activated successfully',
    'product_deactivated' => 'Product deactivated successfully',
    'product_not_found' => 'Product not found',
    'product_created_error' => 'Error while creating product',
    'product_updated_error' => 'Error while updating product',

    // Orders
    'order_created' => 'Order created successfully',
    'order_created_payment_failed' => 'Order created, but online payment link generation failed',
    'order_not_found' => 'Order not found',
    'order_deleted' => 'This order has been deleted',
    'order_already_paid' => 'This order is already paid',
    'order_paid' => 'This order is paid',
    'order_has_offer' => 'This order already has an offer',
    'order_canceled' => 'Order has been canceled',
    'order_canceled_title' => 'Order Canceled',
    'order_canceled_content' => 'The order #:id has been canceled',
    'cant_cancel_processing' => 'Cannot cancel because this order is already being processed',
    'cant_cancel_paid' => 'Cannot cancel because this order is paid. Please contact technical support',
    'order_sent_to_provider' => 'Your order has been sent to the provider',
    'new_order_received' => 'You have a new order',
    'multiple_orders_created' => 'Multiple orders were created. You are being redirected to pay the first order now',
    'redirecting_to_payment' => 'Redirecting to payment gateway...',
    'continue_to_payment' => 'Continue To Payment',

    // Offers
    'offer_created' => 'Offer submitted successfully',
    'offer_updated' => 'Offer updated successfully',
    'offer_deleted' => 'Offer deleted successfully',
    'offer_already_exists' => 'You have already submitted an offer for this order',
    'offer_not_found' => 'Offer not found',
    'offer_has_actions' => 'This offer has associated actions',
    'cant_remove_offer' => 'Cannot remove this offer, it has associated actions',
    'offer_updates' => 'Offer Updates',
    'offer_updated_content' => 'The offer #:id has been :action',

    // Notifications
    'notification_marked' => 'Notification marked as read',
    'notification_deleted' => 'Notification deleted successfully',
    'all_marked' => 'All notifications marked as read',
    'verified_your_account' => 'verified your account',
    'your_code' => 'Your code: :code',
    'reset_password_code' => 'Reset password code',
    'your_code_is' => 'Your code: :code',

    // Cart
    'cart_empty' => 'Cart is empty',
    'added_to_cart' => 'Added to cart successfully',
    'removed_from_cart' => 'Removed from cart successfully',
    'cart_updated' => 'Cart updated successfully',

    // Favorites
    'added_to_favorites' => 'Added to favorites',
    'removed_from_favorites' => 'Removed from favorites',

    // Ratings
    'rating_submitted' => 'Rating submitted successfully',
    'rating_error' => 'Error submitting rating',

    // Coupons
    'coupon_invalid' => 'The selected coupon is invalid',

    // Categories
    'category_added' => 'Category added successfully',

    // Payment
    'arb_link_failed' => 'ARB link generation failed',
    'paymob_link_failed' => 'Paymob link generation failed',

    // Email subjects
    'email_verify_account' => 'Verify your account',
    'email_order_updates' => 'Order Updates',
    'email_new_order' => 'New Order',

    // API messages
    'must_select_user' => 'Must select user',
    'conversation_blocked' => 'This conversation is blocked',

    // Notifications content
    'notification_type_order' => 'New Order',
    'notification_type_offer_accepted' => 'Offer Accepted',
    'notification_type_offer_rejected' => 'Offer Rejected',
    'notification_type_message' => 'New Message',

    // Misc
    'deleted_order' => 'This order was deleted',
    'this_offer_has_actions' => 'This offer has actions',
    'cant_remove_offer_actions' => 'Cannot remove this offer, this offer has actions',
    'cant_cancel_order_processing' => "Cannot cancel because this order is already being processed",
    'this_order_already_paid' => 'This order is already paid',
    'paymob_link_generation_failed' => 'Paymob link generation failed',
    'something_wrong_technical' => 'There is something wrong, please contact technical support',
    'something_wrong_wrong' => 'There IS Something Wrong',
    'unauthorized_user_not_logged' => 'Unauthorized: User not logged in',
    'old_password_incorrect_api' => 'Old password is incorrect',
    'password_changed_successfully' => 'Password changed successfully',
    'password_reset_successfully' => 'Password reset successfully',
    'reset_code_sent_successfully' => 'Reset code sent successfully',
    'code_verified_successfully' => 'Code verified successfully',
    'successfully_logged_out' => 'Successfully logged out',
    'user_not_found' => 'User not found',
    'there_is_something_wrong' => 'There Is Something Wrong, Please Contact Technical Support',
    'reset_by_email_requires_verified' => 'Reset by email requires a verified email address',
    'reset_by_phone_requires_verified' => 'Reset by phone requires a verified phone number',
    'invalid_email_or_password' => 'Invalid email or password',

    // Vendor specific
    'offer_already_submitted' => 'You have already submitted an offer for this order',
    'offer_submitted' => 'Offer submitted successfully',
    'offer_submit_error' => 'Error while submitting offer',
    'offer_updated_successfully' => 'Offer updated successfully',
    'offer_update_error' => 'Error while updating offer',
    'offer_deleted_successfully' => 'Offer deleted successfully',
    'product_added_successfully' => 'Product added successfully',
    'product_add_error' => 'Error while adding product',
    'product_updated_successfully' => 'Product updated successfully',
    'product_update_error' => 'Error while updating product',
    'product_toggled_successfully' => 'Product status toggled successfully',
    'product_deactivated_successfully' => 'Product deactivated successfully',
    'product_deleted_successfully' => 'Product deleted successfully',
    'category_added_successfully' => 'Category added successfully',

    // Order Status Labels (front-end)
    'status_pending' => 'Pending',
    'status_confirmed' => 'Confirmed',
    'status_processing' => 'Processing',
    'status_completed' => 'Completed',
    'status_scheduled' => 'Scheduled',
    'status_active' => 'Active',
    'status_cancelled' => 'Cancelled',
    'status_rejected' => 'Rejected',

    // Order timeline notifications
    'order_status_update' => 'Your order has been :step',
    'order_status_update_content' => 'Order #:id has been :step',
    'account_not_active' => 'This account is not active',
    'account_not_email_verified' => 'This account is not email-verified',
];

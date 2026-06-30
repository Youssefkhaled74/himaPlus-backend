<?php
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\Lang;
    use App\Services\OrderStatusService;

	define('PAGINATION_COUNT', 10);
	define('PAGINATION_COUNT_FRONT', 10);

	function uploadIamge($file, $folder){
		$destinationPath = 'admin/assets/images/' . $folder . '/'; // upload path
		$extension = $file->getClientOriginalExtension(); // getting image extension
        $fileName = time() . rand(11111, 99999) . '.' . $extension;  
		$file_move = $file->move(public_path($destinationPath), $fileName);
		return $destinationPath . $fileName;
	}

	function uploadIamges($files, $folder){
		$images = [];
		foreach ($files as $file){
			$destinationPath = 'admin/assets/images/' . $folder . '/'; // upload path
			$extension = $file->getClientOriginalExtension(); // getting image extension
			$fileName = time() . rand(11111, 99999) . '.' . $extension;  
			$file_move = $file->move(public_path($destinationPath), $fileName);
			$images[] = $destinationPath . $fileName;
		}
		$files = implode(",", $images);
		return $files;
	}

	function responseJson($status, $msg, $data = null)
	{
		$response = [
			'status' => $status,
			'msg' => __($msg),
			'data' => $data
		];
		return response()->json($response);
	}

	function trans_or_fallback($key, $fallback = null, array $replace = [], $locale = null)
	{
		$locale = $locale ?: app()->getLocale();

		if (Lang::hasForLocale($key, $locale)) {
			return __($key, $replace, $locale);
		}

		return $fallback ?? __($key, $replace, $locale);
	}

	function orderType($order_no)
	{
		switch ($order_no) {
			case 1:
				return 'Purchase Order';
				break;

			case 2:
				return 'Quotations';
				break;
			
			case 3:
				return 'Maintenance';
				break;
			
			default:
				return '---';
				break;
		}
	}

	function timelineName($timeline_no)
	{
		
		// 1 => Order Created, 2 => Confirmed by Supplier, 3 => Processing, 4 => Shipped, 
		// 5 => Delivered, 6 => Completed, 7 => Offers Received, 8 => Supplier Selected, 
		// 9 => Converted to Order, 10 => Under Review, 11 => Assigned to Supplier, 12 => Cancelled
		switch ($timeline_no) {
			case 1:
				return 'Order Created';
				break;

			case 2:
				return 'Confirmed by Supplier';
				break;
			
			case 3:
				return 'Processing';
				break;
				
			case 4:
				return 'Shipped';
				break;
				
			case 5:
				return 'Delivered';
				break;
			
			case 6:
				return 'Completed';
				break;
			
			case 7:
				return 'Offers Received';
				break;
			
			case 8:
				return 'Supplier Selected';
				break;
			
			case 9:
				return 'Converted to Order';
				break;
			
			case 10:
				return 'Under Review';
				break;
			
			case 11:
				return 'Assigned to Supplier';
				break;
			case 12:
				return 'Canceled';
				break;
			
			default:
				return '---';
				break;
		}
	}

	function timelineNameBackground($timeline_no)
	{
		$map = [
            2 => 'confirmed',
            3 => 'inprogress',
            4 => 'shipped',
            5 => 'delivered',
            6 => 'completed',
            8 => 'upcoming',
            12 => 'canceled',
        ];

		return $map[(int) $timeline_no] ?? 'pending';
	}


    function customerTimelineName($timeline_no, $order_type = 1)
    {
        $ar = app()->getLocale() === 'ar';

        if ((int) $order_type === 1) {
            $labels = [
                1 => $ar ? 'تم الطلب' : 'Ordered',
                3 => $ar ? 'قيد التجهيز' : 'Processing',
                4 => $ar ? 'قيد الشحن' : 'Shipped',
                5 => $ar ? 'تم التسليم' : 'Delivered',
                6 => $ar ? 'مكتمل' : 'Completed',
                12 => $ar ? 'ملغي' : 'Canceled',
            ];
        } elseif ((int) $order_type === 2) {
            $labels = [
                1 => $ar ? 'تم الطلب' : 'Ordered',
                7 => $ar ? 'قيد التسعير' : 'Under Pricing',
                9 => $ar ? 'تم استلام العرض' : 'Offer Received',
                6 => $ar ? 'مكتمل' : 'Completed',
                12 => $ar ? 'ملغي' : 'Canceled',
            ];
        } elseif ((int) $order_type === 3) {
            $labels = [
                1 => $ar ? 'تم الطلب' : 'Ordered',
                7 => $ar ? 'تم جدولة الزيارة' : 'Visit Scheduled',
                9 => $ar ? 'قيد الصيانة' : 'Under Maintenance',
                6 => $ar ? 'مكتمل' : 'Completed',
                12 => $ar ? 'ملغي' : 'Canceled',
            ];
        } else {
            $labels = [];
        }

        return $labels[$timeline_no] ?? timelineName($timeline_no);
    }

    function vendorTimelineName($timeline_no, $order_type = 1)
    {
        $ar = app()->getLocale() === 'ar';

        if ((int) $order_type === 1) {
            $labels = [
                1 => $ar ? 'طلب جديد' : 'New Order',
                3 => $ar ? 'قيد التجهيز' : 'Processing',
                4 => $ar ? 'تم الشحن' : 'Shipped',
                5 => $ar ? 'تم التسليم' : 'Delivered',
                6 => $ar ? 'مكتمل' : 'Completed',
                12 => $ar ? 'ملغي' : 'Canceled',
            ];
        } elseif ((int) $order_type === 2) {
            $labels = [
                1 => $ar ? 'طلب تسعير جديد' : 'New Quotation Request',
                7 => $ar ? 'إعداد العرض' : 'Preparing Offer',
                9 => $ar ? 'تم إرسال العرض' : 'Offer Sent',
                6 => $ar ? 'مكتمل' : 'Completed',
                12 => $ar ? 'ملغي' : 'Canceled',
            ];
        } elseif ((int) $order_type === 3) {
            $labels = [
                1 => $ar ? 'طلب صيانة جديد' : 'New Maintenance Request',
                7 => $ar ? 'تم تحديد الموعد' : 'Appointment Set',
                9 => $ar ? 'قيد التنفيذ' : 'In Progress',
                6 => $ar ? 'مكتمل' : 'Completed',
                12 => $ar ? 'ملغي' : 'Canceled',
            ];
        } else {
            $labels = [];
        }

        return $labels[$timeline_no] ?? timelineName($timeline_no);
    }

	    function frontScheduledStatusLabel($status, $isVendor = false)
	    {
	        $normalized = app(OrderStatusService::class)->normalizeStatus((string) $status);

            if ($normalized === OrderStatusService::STATUS_ACTIVE_SCHEDULED) {
                $normalized = OrderStatusService::STATUS_ACTIVE_SCHEDULED;
            } elseif ($normalized === OrderStatusService::STATUS_COMPLETED_SCHEDULED) {
                $normalized = OrderStatusService::STATUS_COMPLETED_SCHEDULED;
            } elseif ($normalized === OrderStatusService::STATUS_CANCELLED) {
                $normalized = OrderStatusService::STATUS_CANCELLED;
            } else {
                $normalized = OrderStatusService::STATUS_SCHEDULED;
            }

            return app(OrderStatusService::class)->makeState($normalized, 'front')['label'];
	    }

        function orderStatusService()
        {
            return app(OrderStatusService::class);
        }

        function orderStatusOptions($audience = 'admin')
        {
            $service = orderStatusService();
            $statuses = [
                OrderStatusService::STATUS_PENDING,
                OrderStatusService::STATUS_CONFIRMED,
                OrderStatusService::STATUS_ACCEPTED_ORDERS,
                OrderStatusService::STATUS_PROCESSING,
                OrderStatusService::STATUS_COMPLETED,
                OrderStatusService::STATUS_SCHEDULED,
                OrderStatusService::STATUS_ACTIVE_SCHEDULED,
                OrderStatusService::STATUS_COMPLETED_SCHEDULED,
                OrderStatusService::STATUS_CANCELLED,
                OrderStatusService::STATUS_REJECTED,
            ];

            $options = [];
            foreach ($statuses as $status) {
                $options[$status] = $service->makeState($status, $audience);
            }

            return $options;
        }

        function orderStatusChipClass(?string $statusKey): string
        {
            return match ((string) $statusKey) {
                'confirmed', 'accepted_orders' => 'confirmed',
                'processing' => 'inprogress',
                'completed', 'completed_scheduled' => 'completed',
                'scheduled', 'active_scheduled' => 'upcoming',
                'cancelled', 'rejected' => 'cancelled',
                default => 'pending',
            };
        }

    // "autoload": {
    //     "psr-4": {
    //         "App\\": "app/",
    //         "Database\\Factories\\": "database/factories/",
    //         "Database\\Seeders\\": "database/seeders/"
    //     },
    //     "files" : [
    //         "app/helper/functions.php"
    //     ]
    // },

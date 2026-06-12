<?php
	use Illuminate\Support\Facades\File;

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
		
        // <div class="chip chip--pending 1">Pending</div>
        // <div class="chip chip--active 1">Assigned</div>
        // <div class="chip chip--shipped "4>Shipped</div>
        // <div class="chip chip--confirmed 2">Confirmed</div>
        // <div class="chip chip--delivered 5">Delivered</div>
        // <div class="chip chip--completed 6">Completed</div>
        // <div class="chip chip--cancelled 12">Cancelled</div>
        // <div class="chip chip--inprogress 3">In Progress</div>
        // <div class="chip chip--upcoming 8">Supplier Selected</div>
        // <div class="chip chip--upcoming 8">Upcoming</div>
		switch ((int)$timeline_no) {
			case 1:
				return 'pending';
				break;
			case 7:
				return 'pending';
				break;
			case 9:
				return 'pending';
				break;
			case 10:
				return 'pending';
				break;
			case 11:
				return 'pending';
				break;

			case 2:
				return 'confirmed';
				break;
			
			case 3:
				return 'inprogress';
				break;
				
			case 4:
				return 'shipped';
				break;
				
			case 5:
				return 'delivered';
				break;
			
			case 6:
				return 'completed';
				break;
			
			case 8:
				return 'upcoming';
				break;

			case 12:
				return 'canceled';
				break;
			
			default:
				return 'pending';
				break;
		}
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
        $ar = app()->getLocale() === 'ar';

        if ($isVendor) {
            $labels = [
                'upcoming' => $ar ? 'تم اعتماد الجدولة' : 'Schedule Approved',
                'active' => $ar ? 'سارية' : 'Active',
                'paused' => $ar ? 'متوقفة' : 'Paused',
                'completed' => $ar ? 'منتهية' : 'Expired',
                'cancelled' => $ar ? 'ملغية' : 'Cancelled',
            ];
        } else {
            $labels = [
                'upcoming' => $ar ? 'تمت الموافقة' : 'Approved',
                'active' => $ar ? 'قيد التوريد' : 'Supplying',
                'paused' => $ar ? 'متوقف' : 'Paused',
                'completed' => $ar ? 'تم الاستلام' : 'Received',
                'cancelled' => $ar ? 'ملغي' : 'Cancelled',
            ];
        }

        return $labels[strtolower($status)] ?? ucfirst($status);
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
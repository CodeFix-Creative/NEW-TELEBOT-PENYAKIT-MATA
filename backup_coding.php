else if (in_array($action, $arrBookingTime)) {
            $booking = Booking::where('booking_time', $action)->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->first();
            $bookedCustomerService = Booking::where('id_booking_time', 1)->where('booking_date', Carbon::tomorrow()->format('Y-m-d'))->pluck('id_customer_service');
            $availableCustomerService = CustomerService::whereNotIn('id', $bookedCustomerService)->inRandomOrder()->first();

            if($booking) {
                $text .= "Jadwal tidak tersedia atau sudah dibooking, silahkan pilih jadwal lainnya. \n";

                $customerService = CustomerService::all();
                $btn = [];

                // checking
                foreach ($customerService as $customerService) {
                    if (Booking::where('id_customer_service' , $customerService->id)->where('booking_date' , Carbon::tomorrow()->format('Y-m-d'))->exists() == true ) {
                        $bookingTime = BookingTime::all();
                        // $booking = Booking::where('id_customer_service' , $customerService->id)->where('booking_date' , Carbon::tomorrow()->format('Y-m-d'))->get();

                        foreach ($bookingTime as $bookingTime) {
                            if (Booking::where('id_customer_service' , $customerService->id)->where('booking_date' , Carbon::tomorrow()->format('Y-m-d'))->where('id_booking_time',$bookingTime->id)->exists() == false) {
                                if (!in_array($bookingTime->booking_time, $btn)) {
                                    $btn[] = ["$bookingTime->booking_time"];
                                }
                            }
                        }
                    } else {
                        $bookingTime = BookingTime::all();

                        foreach ($bookingTime as $bookingTime) {
                            if (!in_array($bookingTime->booking_time, $btn)) {
                                $btn[] = ["$bookingTime->booking_time"];
                            }
                        }
                    }
                }

                $btn = array_unique($btn, SORT_REGULAR);

                $this->apiRequest('sendMessage', [
                    'chat_id' => $userId,
                    'text' => $text,
                    'reply_markup' => $this->keyboardBtn($btn),
                ]);
            } else if( ! $availableCustomerService) {
                $text = "Customer Service saat ini tidak tersedia untuk dibooking pada esok hari. Silahkan coba lagi keesokan harinya. Silahkan pilih menu di bawah ini: ";

                $this->apiRequest('sendMessage', [
                    'chat_id' => $userId,
                    'text' => $text,
                    'reply_markup' => $this->keyboardBtn($this->mainMenu),
                ]);
            } else {
                $time = BookingTime::where('booking_time', $action)->first();
                
                // save booking time into the table
                $saveBooking = Booking::create([
                    'nama_lengkap' => NULL,
                    'no_telp' => NULL,
                    'chat_id' => $userId,
                    'id_customer_service' => $availableCustomerService->id,
                    'id_booking_time' => $time->id,
                    'booking_date' => Carbon::tomorrow()->format('Y-m-d'),
                    'status' => 'Waiting',
                ]);

                $text = "Jadwal berhasil dibooking. Silahkan reply chat ini dengan Nama Lengkap dan No Telp Anda dengan format sebagai berikut: \n";
                $text .= "Nama Lengkap#No Telp\n";
                $text .= "Contoh: \n";
                $text .= "Budi Setiawan#081xxxxxxxxx\n";

                $this->apiRequest('sendMessage', [
                    'chat_id' => $userId,
                    'text' => $text,
                ]);
            }
        } else if(strpos($action, '#') == true) {
            $customerData = explode($action, '#');

            // update booking detail based on customer's reply by chat id
            $bookingDetail = Booking::where('booking_time', $action)
                ->where('chat_id', $userId)
                ->where('booking_date', Carbon::tomorrow()
                ->format('Y-m-d'))
                ->first();
                
            $bookingDetail->update([
                'nama_lengkap' => $customerData[0],
                'no_telp' => $customerData[1],
            ]);

            $text = "Data Anda telah tersimpan. Jadwal service Anda pada: \n";
            $text .= "Hari/Tanggal: ". Carbon::parse($bookingDetail->booking_date)->isoFormat('dddd, DD MMMM Y') ."\n";
            $text .= "Waktu: " . $bookingDetail->booking_time->booking_time . "\n";
            $text .= "Harap datang ke ASUS Service Center pada hari dan waktu yang telah ditentukan, terima kasih.\n";

            $this->apiRequest('sendMessage', [
                'chat_id' => $userId,
                'text' => $text,
            ]);
        }
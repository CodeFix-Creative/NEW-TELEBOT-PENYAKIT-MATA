<table>
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Chat ID</th>
            <th>Nama Lengkap</th>
            <th>Nomor Telephone/Hp</th>
            <th>Customer Service</th>
            <th>Booking Time</th>
            <th>Booking Date</th>
            <th>Booking Status</th>
            {{-- <th>Foto Surat Keterangan Sakit/Izin</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($booking as $booking)
        <tr>
            <td>{{ $booking->booking_id }}</td>
            <td>{{ $booking->chat_id }}</td>
            <td>{{ $booking->nama_lengkap }}</td>
            <td>{{ $booking->no_telp }}</td>
            <td>{{ $booking->customer_service->user->nama }}</td>
            <td>{{ $booking->booking_time->booking_time }}</td>
            <td>{{ $booking->booking_date }}</td>
            <td>{{ $booking->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

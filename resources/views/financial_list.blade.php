<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายการรายรับ/รายจ่าย</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>รายการรายรับ/รายจ่าย</h1>
    <div class="search">
        <form method="GET" action="{{ route('financial.index') }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ค้นหาชื่อ หรือ นามสกุล...">
            <button type="submit">ค้นหา</button>
        </form>
    </div>
    <table border="1" cellpadding="8" cellspacing="0" style="margin-top:20px; width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>คำนำหน้า</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>วันเกิด</th>
                <th>อายุ</th>
                <th>รูปภาพโปรไฟล์</th>
                <th>แก้ไขล่าสุด</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($financials as $item)
                <tr>
                    <td>{{ $item->prefix }}</td>
                    <td>{{ $item->first_name }}</td>
                    <td>{{ $item->last_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->birthdate)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->birthdate)->age }}</td>
                    <td>
                        @if($item->profile_image)
                            <img src="{{ asset('storage/' . $item->profile_image) }}" alt="Profile" style="max-width:80px; max-height:80px;">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                    <td class="action-buttons">
                        <a class="btn-edit" href="{{ route('financial.edit', $item->id) }}">แก้ไข</a>
                        <form action="{{ route('financial.destroy', $item->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบข้อมูล?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-submit">ลบ</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">ไม่พบข้อมูล</td></tr>
            @endforelse
        </tbody>
    </table>
    @include('layouts.footer-buttons')
</body>
</html>

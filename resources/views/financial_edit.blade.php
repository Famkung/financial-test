<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <title>แก้ไขข้อมูล รายรับ/รายจ่าย</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>แก้ไขข้อมูล รายรับ/รายจ่าย</h1>

    <form action="{{ route('financial.update', $financial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="prefix">คำนำหน้าชื่อ</label>
        <input list="prefixes" name="prefix" id="prefix" value="{{ old('prefix', $financial->prefix) }}" required>
        <datalist id="prefixes">
            <option value="นาย"></option>
            <option value="นาง"></option>
            <option value="นางสาว"></option>
        </datalist>

        <label for="first_name">ชื่อ</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $financial->first_name) }}" required>

        <label for="last_name">นามสกุล</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $financial->last_name) }}" required>

        <label for="birthdate">วันเดือนปีเกิด</label>
        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', \Carbon\Carbon::parse($financial->birthdate)->format('Y-m-d')) }}" required>

        <label for="profile_image">รูปภาพโปรไฟล์</label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*">

        @if($financial->profile_image)
            <p>รูปปัจจุบัน:</p>
            <img src="{{ asset('storage/' . $financial->profile_image) }}" alt="Profile Image" style="max-width: 100px;">
        @endif

        <button type="submit">บันทึกการแก้ไข</button>
    </form>
</body>
</html>

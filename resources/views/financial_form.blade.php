<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <title>ฟอร์มบันทึกรายรับ/รายจ่าย</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>ฟอร์มบันทึกรายการ รายรับ/รายจ่าย</h1>

    <form action="{{ route('financial.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="prefix">คำนำหน้าชื่อ</label>
        <input list="prefixes" name="prefix" id="prefix" required>
        <datalist id="prefixes">
            <option value="นาย"></option>
            <option value="นาง"></option>
            <option value="นางสาว"></option>
        </datalist>

        <label for="first_name">ชื่อ</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="last_name">นามสกุล</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="birthdate">วันเดือนปีเกิด</label>
        <input type="date" name="birthdate" id="birthdate" required>

        <label for="profile_image">รูปภาพโปรไฟล์</label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*">

        <button type="submit">บันทึกข้อมูล</button>
    </form>
    @include('layouts.footer-buttons')
</body>
</html>

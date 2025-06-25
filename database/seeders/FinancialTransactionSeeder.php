<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FinancialTransactionSeeder extends Seeder
{
    public function run()
    {
        $prefixes = ['นาย', 'นาง', 'นางสาว'];

        // รูปต้นแบบใน storage/app/public/profiles/
        $templateImage = 'profiles/test-profile.png';

        // โฟลเดอร์ปลายทางที่เก็บรูป
        $destinationFolder = 'profiles';

        $ageGroups = [
            ['min' => 18, 'max' => 25, 'weight' => 20],
            ['min' => 26, 'max' => 35, 'weight' => 40],
            ['min' => 36, 'max' => 45, 'weight' => 25],
            ['min' => 46, 'max' => 60, 'weight' => 15],
        ];

        function weightedRandomAgeGroup($groups) {
            $totalWeight = array_sum(array_column($groups, 'weight'));
            $rand = rand(1, $totalWeight);
            $sum = 0;
            foreach ($groups as $group) {
                $sum += $group['weight'];
                if ($rand <= $sum) {
                    return $group;
                }
            }
            return $groups[0];
        }

        for ($i = 1; $i <= 20; $i++) {
            $group = weightedRandomAgeGroup($ageGroups);
            $age = rand($group['min'], $group['max']);
            $birthdate = Carbon::now()->subYears($age)->subDays(rand(0, 365));

            // สร้างชื่อไฟล์ใหม่ เช่น profile_1.jpg
            $newFileName = "profile_{$i}.png";
            $newFilePath = $destinationFolder . '/' . $newFileName;

            // คัดลอกไฟล์ต้นแบบไปยังไฟล์ใหม่ (ถ้ายังไม่มีไฟล์นี้)
            if (!Storage::disk('public')->exists($newFilePath)) {
                Storage::disk('public')->copy($templateImage, $newFilePath);
            }

            FinancialTransaction::create([
                'prefix' => $prefixes[array_rand($prefixes)],
                'first_name' => 'ทดสอบ' . $i,
                'last_name' => 'นามสกุล' . $i,
                'birthdate' => $birthdate->format('Y-m-d'),
                'profile_image' => $newFilePath,
                'updated_at' => now(),
            ]);
        }
    }
}

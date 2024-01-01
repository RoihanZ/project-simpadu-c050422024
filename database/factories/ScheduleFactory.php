<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{

    private static $subjectId;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        self::$subjectId = self::$subjectId ?? Subject::orderBy('id')->first()->id;

        return [
            'subject_id' => self::$subjectId++,
            'hari' => $this->faker->dayOfWeek,
            'jam_mulai' => $this->faker->randomElement(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00']),
            'jam_selesai' => $this->faker->randomElement(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00']),
            'ruangan' => $this->faker->randomElement(['R1', 'R2', 'R3', 'R4', 'R5']),
            'kode_absensi' => $this->faker->randomElement(['K1', 'K2', 'K3', 'K4', 'K5']),
            'tahun_akademik' => $this->faker->randomElement(['2020/2021', '2021/2022', '2022/2023', '2023/2024', '2024/2025']),
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap']),
            'created_by' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9']),
            'updated_by' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9']),
            'deleted_by' => $this->faker->optional()->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9']),
        ];
    }
}

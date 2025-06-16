<?php

namespace App\Helpers;

class GradeHelper
{
    /**
     * Convert numerical grade to letter grade
     */
    public static function getPredikat($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }

    /**
     * Convert numerical grade to description
     */
    public static function getKeterangan($nilai)
    {
        if ($nilai >= 90) return 'Sangat Baik';
        if ($nilai >= 80) return 'Baik';
        if ($nilai >= 70) return 'Cukup';
        if ($nilai >= 60) return 'Kurang';
        return 'Sangat Kurang';
    }

    /**
     * Get KKM (minimum passing grade) for a subject
     * You can customize this based on your school's requirements
     */
    public static function getKKM($mataPelajaran = null)
    {
        // Default KKM for all subjects
        $defaultKKM = 75;

        // You can set specific KKM for different subjects
        $subjectKKM = [
            'Matematika' => 70,
            'Bahasa Indonesia' => 75,
            'Bahasa Inggris' => 75,
            // Add more subjects as needed
        ];

        return $subjectKKM[$mataPelajaran] ?? $defaultKKM;
    }

    /**
     * Determine if a student passes based on KKM
     */
    public static function isLulus($nilai, $kkm = 75)
    {
        return $nilai >= $kkm;
    }

    /**
     * Get color class based on grade value
     */
    public static function getGradeColor($nilai)
    {
        if ($nilai >= 90) return 'text-success';
        if ($nilai >= 80) return 'text-primary';
        if ($nilai >= 70) return 'text-warning';
        return 'text-danger';
    }

    /**
     * Calculate final grade based on multiple assessments
     */
    public static function calculateFinalGrade($assessments)
    {
        if (empty($assessments)) return 0;

        $totalWeight = 0;
        $weightedSum = 0;

        foreach ($assessments as $assessment) {
            $weight = $assessment['weight'] ?? 1;
            $value = $assessment['value'] ?? 0;

            $weightedSum += $value * $weight;
            $totalWeight += $weight;
        }

        return $totalWeight > 0 ? round($weightedSum / $totalWeight, 2) : 0;
    }

    /**
     * Format grade display (show letter grade if available, otherwise convert from number)
     */
    public static function formatGrade($nilai, $nilaiHuruf = null)
    {
        if ($nilaiHuruf) {
            return $nilaiHuruf;
        }

        if ($nilai !== null) {
            return self::getPredikat($nilai);
        }

        return '-';
    }

    /**
     * Get achievement level description
     */
    public static function getAchievementLevel($averageGrade)
    {
        if ($averageGrade >= 95) return 'Istimewa';
        if ($averageGrade >= 90) return 'Sangat Baik';
        if ($averageGrade >= 80) return 'Baik';
        if ($averageGrade >= 70) return 'Cukup';
        if ($averageGrade >= 60) return 'Kurang';
        return 'Sangat Kurang';
    }

    /**
     * Calculate class ranking based on average scores
     */
    public static function calculateRanking($studentAverage, $classAverages)
    {
        $rank = 1;
        foreach ($classAverages as $average) {
            if ($average > $studentAverage) {
                $rank++;
            }
        }
        return $rank;
    }
}

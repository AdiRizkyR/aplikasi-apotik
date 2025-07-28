<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataObat;
use Faker\Factory as Faker;

class DataObatSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar lengkap 50 data obat yang realistis
        // Tidak perlu lagi menggunakan Faker
        $data = [
            ['nama' => 'Paracetamol', 'jenis' => 'Tablet', 'kategori' => 'Analgesik'],
            ['nama' => 'Amoxicillin', 'jenis' => 'Kapsul', 'kategori' => 'Antibiotik'],
            ['nama' => 'Ibuprofen', 'jenis' => 'Tablet', 'kategori' => 'Anti-inflamasi Nonsteroid'],
            ['nama' => 'Omeprazole', 'jenis' => 'Kapsul', 'kategori' => 'Penghambat Pompa Proton'],
            ['nama' => 'Loratadine', 'jenis' => 'Tablet', 'kategori' => 'Antihistamin'],
            ['nama' => 'Cetirizine', 'jenis' => 'Tablet', 'kategori' => 'Antihistamin'],
            ['nama' => 'Metformin', 'jenis' => 'Tablet', 'kategori' => 'Antidiabetes'],
            ['nama' => 'Amlodipine', 'jenis' => 'Tablet', 'kategori' => 'Antihipertensi'],
            ['nama' => 'Simvastatin', 'jenis' => 'Tablet', 'kategori' => 'Statin'],
            ['nama' => 'Salbutamol', 'jenis' => 'Inhaler', 'kategori' => 'Bronkodilator'],
            ['nama' => 'Ranitidine', 'jenis' => 'Tablet', 'kategori' => 'Antagonis H2'],
            ['nama' => 'Ciprofloxacin', 'jenis' => 'Tablet', 'kategori' => 'Antibiotik'],
            ['nama' => 'Dexamethasone', 'jenis' => 'Tablet', 'kategori' => 'Kortikosteroid'],
            ['nama' => 'Glibenclamide', 'jenis' => 'Tablet', 'kategori' => 'Antidiabetes'],
            ['nama' => 'Furosemide', 'jenis' => 'Tablet', 'kategori' => 'Diuretik'],
            ['nama' => 'Captopril', 'jenis' => 'Tablet', 'kategori' => 'ACE Inhibitor'],
            ['nama' => 'Asam Mefenamat', 'jenis' => 'Kapsul', 'kategori' => 'Anti-inflamasi Nonsteroid'],
            ['nama' => 'Lansoprazole', 'jenis' => 'Kapsul', 'kategori' => 'Penghambat Pompa Proton'],
            ['nama' => 'Ambroxol', 'jenis' => 'Sirup', 'kategori' => 'Mukolitik'],
            ['nama' => 'Domperidone', 'jenis' => 'Tablet', 'kategori' => 'Antiemetik'],
            ['nama' => 'Prednisone', 'jenis' => 'Tablet', 'kategori' => 'Kortikosteroid'],
            ['nama' => 'Clopidogrel', 'jenis' => 'Tablet', 'kategori' => 'Antiplatelet'],
            ['nama' => 'Azithromycin', 'jenis' => 'Tablet', 'kategori' => 'Antibiotik'],
            ['nama' => 'Digoxin', 'jenis' => 'Tablet', 'kategori' => 'Glikosida Jantung'],
            ['nama' => 'Allopurinol', 'jenis' => 'Tablet', 'kategori' => 'Antipirai'],
            ['nama' => 'Ketoconazole', 'jenis' => 'Krim', 'kategori' => 'Antijamur'],
            ['nama' => 'Meloxicam', 'jenis' => 'Tablet', 'kategori' => 'Anti-inflamasi Nonsteroid'],
            ['nama' => 'Metronidazole', 'jenis' => 'Tablet', 'kategori' => 'Antibiotik'],
            ['nama' => 'Ondansetron', 'jenis' => 'Tablet', 'kategori' => 'Antiemetik'],
            ['nama' => 'Codeine', 'jenis' => 'Tablet', 'kategori' => 'Analgesik Opioid'],
            ['nama' => 'Lisinopril', 'jenis' => 'Tablet', 'kategori' => 'ACE Inhibitor'],
            ['nama' => 'Atorvastatin', 'jenis' => 'Tablet', 'kategori' => 'Statin'],
            ['nama' => 'Hydrochlorothiazide', 'jenis' => 'Tablet', 'kategori' => 'Diuretik'],
            ['nama' => 'Diazepam', 'jenis' => 'Tablet', 'kategori' => 'Ansiolitik'],
            ['nama' => 'Cefixime', 'jenis' => 'Kapsul', 'kategori' => 'Antibiotik'],
            ['nama' => 'Tramadol', 'jenis' => 'Kapsul', 'kategori' => 'Analgesik Opioid'],
            ['nama' => 'Nifedipine', 'jenis' => 'Tablet', 'kategori' => 'Antihipertensi'],
            ['nama' => 'Vitamin C', 'jenis' => 'Tablet Hisap', 'kategori' => 'Vitamin'],
            ['nama' => 'Vitamin B Kompleks', 'jenis' => 'Tablet', 'kategori' => 'Vitamin'],
            ['nama' => 'Kalsium Laktat', 'jenis' => 'Tablet', 'kategori' => 'Suplemen Mineral'],
            ['nama' => 'Antasida Doen', 'jenis' => 'Tablet Kunyah', 'kategori' => 'Antasida'],
            ['nama' => 'Guaifenesin', 'jenis' => 'Sirup', 'kategori' => 'Ekspektoran'],
            ['nama' => 'Loperamide', 'jenis' => 'Tablet', 'kategori' => 'Antidiare'],
            ['nama' => 'Betahistine', 'jenis' => 'Tablet', 'kategori' => 'Antivertigo'],
            ['nama' => 'Methylprednisolone', 'jenis' => 'Tablet', 'kategori' => 'Kortikosteroid'],
            ['nama' => 'Erythromycin', 'jenis' => 'Kapsul', 'kategori' => 'Antibiotik'],
            ['nama' => 'Piroxicam', 'jenis' => 'Kapsul', 'kategori' => 'Anti-inflamasi Nonsteroid'],
            ['nama' => 'Spironolactone', 'jenis' => 'Tablet', 'kategori' => 'Diuretik'],
            ['nama' => 'Levofloxacin', 'jenis' => 'Tablet', 'kategori' => 'Antibiotik'],
            ['nama' => 'Bisoprolol', 'jenis' => 'Tablet', 'kategori' => 'Beta Blocker'],
        ];

        // Masukkan semua data dari array ke dalam database
        // Loop ini akan membuat 50 record baru di tabel data_obats
        foreach ($data as $item) {
            DataObat::create($item);
        }
    }
}
<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Create slug using the correct 'name' value
        $slug = \Str::slug($row['name']);

        return new Category([
            'name' => $row['name'],
            'image' => $imagePath,
            'status' => $row['status'],
            'slug' => $slug,
        ]);
    }
}

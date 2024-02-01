<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
    // This is going to add data to categories table, so we need to connect to categories table. the same as when we do it in Controller.

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add to categories table. any functions. We use insert function here.
        $categories = [     // inside categories array
            [               // small 3 arrays, with records
                'name' => 'Theater',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Literature',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Gardening',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->category->insert($categories);
            // insert whatever in the big array above (see $categories).
            // need to add a record of 'created_at' or 'updated_at'

            // Difference of "insert" and "createMany":
                // "createMany": you don't have to add 'created_at' and 'updated_at' columns. It's automatic.
                // "insert": you have to add 'created_at' or 'updated_at' columns and values of each column.

            // Another difference of "insert" and "createMany":
                // "insert": we dont need to add $fillable to the models.
                // "create" and "createMany": we need to add $fillable in model. (ex: User model)
    }
}

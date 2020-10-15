<!-- seeder -->
DB::table('categories')->insert([
'name' => 'Purchase',
'slug' => 'purchase',
'created_at' => date('Y-m-d'),
'updated_at' => date('Y-m-d'),
]);
factory(App\Category::class, 4)->create();
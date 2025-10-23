<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $images = [
            'imgs/1715677856568.png',
            'imgs/anh-hoa-tulip-26.jpg',
            'imgs/Bat-mi-y-nghia-ben-trong-loai-hoa-cam-tu-cau-min.jpg',
            'imgs/bo-hoa-cam-chuong-hong-su-ai-mo311.jpg',
            'imgs/bo-hoa-hong-dep-nhat.jpg',
            'imgs/hoa_dao_nhat_277eb7310fe64819b8007b60aca1027c_grande.jpg',
            'imgs/images (1).jpg',
            'imgs/images.jpg',
            'imgs/pexels-muffin-1653877.jpg',
            'imgs/pexels-narda-yescas-724842-1566837.jpg',
            'imgs/y-nghia-cua-hoa-ly-3.jpg',
        ];
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10000, 200000),
            'cover_image' => $this->faker->randomElement($images),
            'quantity' => $this->faker->numberBetween(5, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
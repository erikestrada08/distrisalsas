<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Variante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variante>
 */
class VarianteFactory extends Factory
{
    // protected $model = Variante::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idsProducto = Producto::pluck('id');
        return [
            'producto_id' => $idsProducto->random(),
            'codigo_barra' => $this->faker->ean13(),
            'atributos_json' => json_encode([
                'cantidad' => $this->faker->randomElement(['7oz','12oz','5oz']),
                'color' => $this->faker->randomElement(['BLANCO','TRANS.','COLOR'])
            ]),
            'precio_venta' => $this->faker->randomFloat(2,10000,20000),
            'costo' => $this->faker->randomFloat(2,20000,90000),
            'stock_minimo' => $this->faker->numberBetween(10,100),
            'stock_maximo' => $this->faker->numberBetween(100,500),
            'imagen' => $this->faker->imageUrl(640,480, 'products', true),
            'stock_actual' => $this->faker->numberBetween(10,500),
            'activo' => true
        ];
    }
}

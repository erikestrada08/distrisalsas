<?php

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->index();
            $table->text("descripcion")->nullable();
            $table->string("codigo_barra")->unique()->index();
            $table->foreignIdFor(Marca::class)->constrained("marcas")->restrictOnDelete();
            $table->foreignIdFor(Categoria::class)->constrained("categorias")->restrictOnDelete();
            $table->foreignIdFor(User::class, "created_by")->constrained("users")->restrictOnDelete()->index();
            $table->foreignIdFor(User::class, "updated_by")->constrained("users")->restrictOnDelete();
            $table->decimal("precio", 15, 2);
            $table->decimal("costo", 15, 2);
            $table->boolean("activo")->default(true)->index();
            $table->json("atributos")->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

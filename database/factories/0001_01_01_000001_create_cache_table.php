<?php

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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email')->unique();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->string('password_hash');
            $table->boolean('activo')->default(true);
            $table->timestamp('ultimo_login')->nullable();
            $table->boolean('rol')->default(false);
            $table->timestamps();
        });
                Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->enum('tipo', ['2x1', 'combo', 'happy_hour', 'primera_compra', 'cumpleaños'])->default('2x1');
            $table->decimal('descuento_porcentaje', 5, 2)->nullable();
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->json('dias_aplicables')->nullable();
            $table->boolean('activa')->default(true);
            $table->json('combo_detalle')->nullable();
            $table->timestamps();
        });
                $items = [
            [
                'tipo' => 'producto',
                'id' => $this->faker->numberBetween(1, 20), // IDs de productos simulados
                'cantidad' => $this->faker->numberBetween(1, 5),
            ],
            [
                'tipo' => 'ingrediente',
                'id' => $this->faker->numberBetween(1, 10), // IDs de ingredientes simulados
                'cantidad' => $this->faker->numberBetween(1, 3),
            ],
        ];
                Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->text('descripcion')->nullable();
            $table->string('imagen_url')->nullable();
            $table->integer('orden_display')->default(0);
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
                Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->decimal('precio_base', 10, 2);
            $table->string('imagen_url')->nullable();
            $table->boolean('disponible')->default(true);
            $table->boolean('es_personalizado')->default(false);
            $table->integer('tiempo_preparacion')->nullable();
            $table->timestamps();
        });
                Schema::create('ingredientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio_extra', 10, 2)->default(0);
            $table->boolean('disponible')->default(true);
            $table->string('tipo');
            $table->string('imagen_url')->nullable();
            $table->timestamps(); 
        });
                Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->timestamp('fecha_pedido')->useCurrent();
            $table->enum('estado', ['pendiente', 'preparando', 'entregado', 'cancelado'])->default('pendiente');
            $table->decimal('total', 10, 2);
            $table->text('direccion_entrega')->nullable();
            $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'qr', 'transferencia']);
            $table->text('notas')->nullable();
            $table->timestamps();
        });
                Schema::create('producto_ingrediente', function (Blueprint $table) {
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('ingrediente_id')->constrained('ingredientes')->onDelete('cascade');
            $table->boolean('es_default')->default(false);
            $table->primary(['producto_id', 'ingrediente_id']);
            $table->timestamps();
        });
                Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->text('instrucciones_especiales')->nullable();
            $table->foreignId('promocion_id')->nullable()->constrained('promociones')->onDelete('cascade');
            $table->timestamps();
        });
                Schema::create('detalle_pedido_ingredientes', function (Blueprint $table) {
            $table->foreignId('detalle_id')->constrained('detalle_pedidos')->onDelete('cascade');
            $table->foreignId('ingrediente_id')->constrained('ingredientes')->onDelete('cascade');
            $table->boolean('es_extra')->default(false);
            $table->primary(['detalle_id', 'ingrediente_id']);
            $table->timestamps();
        });
                Schema::create('fidelizacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->unique()->constrained('clientes')->onDelete('cascade');
            $table->integer('puntos_acumulados')->default(0);
            $table->enum('nivel', ['bronce', 'plata', 'oro'])->default('bronce');
            $table->timestamp('fecha_ultima_actualizacion')->nullable();
            $table->timestamps();
        });
                Schema::create('notificaciones', function (Blueprint $table) {
            $table->id('notificacion_id');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('titulo');
            $table->text('mensaje');
            $table->enum('tipo', ['promocion', 'nuevo_sabor', 'pedido', 'fidelizacion']);
            $table->timestamp('fecha_envio')->useCurrent();
            $table->boolean('leida')->default(false);
            $table->string('url_destino')->nullable();
            $table->timestamps();
        });
                Schema::create('transacciones_puntos', function (Blueprint $table) {
            $table->id('transaccion_id');
            $table->foreignId('fidelizacion_id')->constrained('fidelizacion')->onDelete('cascade');
            $table->integer('puntos');
            $table->enum('tipo', ['ganado', 'usado']);
            $table->string('motivo');
            $table->timestamp('fecha_transaccion')->useCurrent();
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};

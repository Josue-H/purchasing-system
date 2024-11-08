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
        Schema::table('Usuario', function (Blueprint $table) {
            $table->string('codigo_2fa')->nullable(); // Código de autenticación de 2FA
            $table->timestamp('codigo_2fa_expiracion')->nullable(); // Fecha de expiración del código 2FA
            $table->string('codigo_password_reset')->nullable(); // Código para restablecimiento de contraseña
            $table->timestamp('codigo_password_reset_expiracion')->nullable(); // Fecha de expiración del código de restablecimiento
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Usuario', function (Blueprint $table) {
            $table->dropColumn('codigo_2fa');
            $table->dropColumn('codigo_2fa_expiracion');
            $table->dropColumn('codigo_password_reset');
            $table->dropColumn('codigo_password_reset_expiracion');
        });
    }
};

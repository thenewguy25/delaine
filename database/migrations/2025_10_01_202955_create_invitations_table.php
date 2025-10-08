<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('token')->unique()->index();
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->enum('invitation_type', ['admin', 'user', 'custom'])->default('user');
            $table->timestamps();

            // Add unique constraint to prevent duplicate invitations for the same email
            $table->unique(['email', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};

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
        // تحقّق أولاً من وجود العمود قبل محاولة حذفه
        if (Schema::hasColumn('doctors', 'license_number')) {
            Schema::table('doctors', function (Blueprint $table) {
                // إذا كان عليه فهرس فريد، نحذفه قبل حذف العمود
                try {
                    $table->dropUnique(['license_number']);
                } catch (\Throwable $e) {
                    // تجاهل الخطأ في حال لم يكن هناك فهرس بهذا الاسم
                }

                $table->dropColumn('license_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة العمود عند التراجع (rollback)
        if (!Schema::hasColumn('doctors', 'license_number')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->string('license_number')->unique()->nullable();
            });
        }
    }
};

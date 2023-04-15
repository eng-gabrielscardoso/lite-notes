<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->uuid('public_id')->after('id');
        });

        DB::table('notes')->whereNull('public_id')->chunkById(200, function ($notes) {
            foreach ($notes as $note) {
                DB::table('notes')->where('id', $note->id)->update(['public_id' => Uuid::uuid4()->toString()]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('public_id');
        });
    }
};

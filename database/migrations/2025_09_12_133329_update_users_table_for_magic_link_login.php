<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing users table
        Schema::dropIfExists('users');

        // Create new users table with UUID and magic link structure
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username');
            $table->string('email')->unique();
            $table->rememberToken();
            $table->timestamps();
        });

        // Update sessions table to use UUID for user_id
        if (Schema::hasTable('sessions')) {
            // Check if foreign key exists using raw SQL
            $foreignKeyExists = DB::select(
                "SELECT COUNT(*) as count FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'sessions' 
                AND COLUMN_NAME = 'user_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL"
            );

            if ($foreignKeyExists[0]->count > 0) {
                Schema::table('sessions', function (Blueprint $table) {
                    $table->dropForeign(['user_id']);
                });
            }

            // Drop the user_id column if it exists
            if (Schema::hasColumn('sessions', 'user_id')) {
                Schema::table('sessions', function (Blueprint $table) {
                    $table->dropColumn('user_id');
                });
            }

            // Add new UUID user_id column with foreign key
            Schema::table('sessions', function (Blueprint $table) {
                $table->uuid('user_id')->nullable()->after('id')->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Drop password_reset_tokens table as it's not needed for magic links
        Schema::dropIfExists('password_reset_tokens');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the new users table
        Schema::dropIfExists('users');

        // Recreate original users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Restore sessions table foreign key
        if (Schema::hasTable('sessions')) {
            // Check if foreign key exists using raw SQL
            $foreignKeyExists = DB::select(
                "SELECT COUNT(*) as count FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'sessions' 
                AND COLUMN_NAME = 'user_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL"
            );

            if ($foreignKeyExists[0]->count > 0) {
                Schema::table('sessions', function (Blueprint $table) {
                    $table->dropForeign(['user_id']);
                });
            }

            // Drop the user_id column if it exists
            if (Schema::hasColumn('sessions', 'user_id')) {
                Schema::table('sessions', function (Blueprint $table) {
                    $table->dropColumn('user_id');
                });
            }

            // Add back the original foreign key
            Schema::table('sessions', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Recreate password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
};

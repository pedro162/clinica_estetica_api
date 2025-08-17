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
        // oauth_clients: mudar id para UUID
        Schema::table('oauth_clients', function (Blueprint $table) {
            if (!Schema::hasColumn('oauth_clients', 'id_uuid')) {
                $table->uuid('id_uuid')->nullable();
            }
        });

        // oauth_access_tokens
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_access_tokens', 'client_id')) {
                $table->uuid('client_id')->change();
            }
        });

        // oauth_auth_codes
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_auth_codes', 'client_id')) {
                $table->uuid('client_id')->change();
            }
        });

        // oauth_refresh_tokens
        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_refresh_tokens', 'client_id')) {
                $table->uuid('client_id')->change();
            }
        });

        // oauth_personal_access_clients
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_personal_access_clients', 'client_id')) {
                $table->uuid('client_id')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // voltar client_id para inteiro
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_access_tokens', 'client_id')) {
                $table->bigInteger('client_id')->change();
            }
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_auth_codes', 'client_id')) {
                $table->bigInteger('client_id')->change();
            }
        });

        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_refresh_tokens', 'client_id')) {
                $table->bigInteger('client_id')->change();
            }
        });

        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_personal_access_clients', 'client_id')) {
                $table->bigInteger('client_id')->change();
            }
        });

        Schema::table('oauth_clients', function (Blueprint $table) {
            if (Schema::hasColumn('oauth_clients', 'id_uuid')) {
                $table->dropColumn('id_uuid');
            }
        });
    }
};

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();

            // your custom columns may go here
            $table->string('tenant_name')->nullable();
            $table->string("tenant_contact_name")->nullable();
            $table->string("tenant_contact_number")->nullable();
            $table->string('tenancy_db_email')->unique();
            $table->string('license_user_count')->nullable();
            $table->string('valid_from');
            $table->string('valid_till');
            $table->string('color_code');
            $table->boolean('web_access')->default(1)->comment('0 = disabled, 1 = enabled');
            $table->boolean('app_access')->default(1)->comment('0 = disabled, 1 = enabled');
            $table->longText('tenant_logo');
            $table->boolean('is_fr_enabled')->default(0)->comment('0 = disabled, 1 = enabled');
            $table->boolean('kiosk_version')->default(0)->comment('0 = disabled, 1 = enabled');
            $table->string('base_timezone')->nullable();
            $table->unsignedTinyInteger("tenant_type")->default(1);
            $table->boolean('final_activity_mail_sent')->default(0)->index()->comment('this flag will be set after 15 more days of tenant creation in activity mail cron');
            $table->string('created_by')->nullable()->index();
            $table->timestamps();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}

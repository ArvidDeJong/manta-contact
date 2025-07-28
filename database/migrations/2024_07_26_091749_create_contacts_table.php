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
        Schema::create('manta_contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            
            // CMS tracking fields
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('host')->nullable();
            $table->integer('pid')->nullable();
            $table->string('locale')->nullable();
            
            // Status fields
            $table->boolean('active')->default(true);
            $table->integer('sort')->default(1);
            
            // Contact information
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('sex')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            // Address information
            $table->string('address')->nullable();
            $table->string('address_nr')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->date('birthdate')->nullable();
            
            // Communication preferences
            $table->boolean('newsletters')->nullable();
            
            // Message content
            $table->string('subject')->nullable();
            $table->text('comment')->nullable();
            $table->string('internal_contact')->nullable();
            $table->string('ip')->nullable();
            
            // Additional comments
            $table->text('comment_client')->nullable();
            $table->text('comment_internal')->nullable();
            
            // Flexible option fields
            $table->text('option_1')->nullable();
            $table->text('option_2')->nullable();
            $table->text('option_3')->nullable();
            $table->text('option_4')->nullable();
            $table->text('option_5')->nullable();
            $table->text('option_6')->nullable();
            $table->text('option_7')->nullable();
            $table->text('option_8')->nullable();
            
            // System fields
            $table->string('administration')->nullable()->comment('Administration column');
            $table->string('identifier')->nullable()->comment('Identifier column');
            $table->longText('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manta_contacts');
    }
};

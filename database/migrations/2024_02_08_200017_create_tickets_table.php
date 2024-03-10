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

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('companyname');
            $table->text('companydescription')->nullable();
            $table->text('companyaddress')->nullable();
            $table->string('companywebsite')->nullable();
            $table->string('companylogo')->nullable();
            $table->string('contactname')->nullable();
            $table->string('cntactphone')->nullable();
            $table->string('contactemail')->nullable();
            $table->json('customfields')->nullable();
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('customername');
            $table->text('customerdescription')->nullable();
            $table->text('customeraddress')->nullable();
            $table->string('cntactphone')->nullable();
            $table->string('contactemail')->nullable();
            $table->string('ticketslatime')->nullable(); // Ticket SLA time
            $table->json('customfields')->nullable();
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('companies_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('assetname');
            $table->string('assettype')->nullable();
            $table->text('assetdescription')->nullable();
            $table->text('assetserialnumber')->nullable();
            $table->text('assetlocation')->nullable();
            $table->text('assetnotes')->nullable();
            $table->string('assetimage')->nullable();
            $table->json('customfields')->nullable();
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('companies_id')->constrained();
            $table->foreignId('customers_id')->constrained(); //end user of asset
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ticketboards', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('boardname');
            $table->text('boarddescription')->nullable();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ticketcolumns', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('columnname');
            $table->text('columndescription')->nullable();
            $table->string('colour')->nullable;
            $table->foreignId('ticketboards_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('tickettitle');
            $table->text('ticketdescription')->nullable();
            $table->foreignId('user_id')->constrained(); //created by
            $table->string('assignee')->nullble();
            $table->string('ticketpriority')->nullable();
            $table->json('ticketcustomfields')->nullable();
            $table->string('ticketstatus')->nullable();
            $table->foreignId('team_id')->constrained();
            $table->foreignId('ticketcolumns_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ticketcolumnsorder', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticketboards_id')->constrained()->onDelete('cascade');
            $table->text('columnorder')->nullable();
            $table->timestamps();
        });

        Schema::create('ticketorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticketcolumns_id')->constrained()->onDelete('cascade')->unique();
            $table->text('ticketorder')->nullable();
            $table->timestamps();
        });

        Schema::create('customticketfields', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('fieldname');
            $table->string('fieldtype');
            $table->json('fieldoptions')->nullable();
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('customcompanyfields', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('fieldname');
            $table->string('fieldtype');
            $table->json('fieldoptions')->nullable();
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('customcustomerfields', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('fieldname');
            $table->string('fieldtype');
            $table->json('fieldoptions')->nullable();
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('users', function ($table) {
            $table->integer('currentactivekanbanboard')->nullable();
        });

        Schema::create('knowledgebaseentries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('knowledgebasetitle');
            $table->text('knowledgebasedescription');
            $table->string('knowledgebasecategories');
            $table->mediumText('knowledgebasecontent');
            $table->foreignId('user_id')->constrained(); // created by
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customticketfields');
        Schema::dropIfExists('customcompanyfields');
        Schema::dropIfExists('customcustomerfields');
        Schema::dropIfExists('ticketorders');
        Schema::dropIfExists('ticketcolumnsorders');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticketcolumns');
        Schema::dropIfExists('ticketboards');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('companies');
    }
};

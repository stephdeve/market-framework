<?php

use Framework\Database\Migration;
use Framework\Database\Schema;

class CreateUsersTable extends Migration {
    
    public function up(): void
    {
        $this->createTable('users', function(Schema $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        $this->dropTable('users');
    }
}

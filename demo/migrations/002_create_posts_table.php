<?php

use Framework\Database\Migration;
use Framework\Database\Schema;

class CreatePostsTable extends Migration {
    
    public function up(): void
    {
        $this->createTable('posts', function(Schema $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        $this->dropTable('posts');
    }
}

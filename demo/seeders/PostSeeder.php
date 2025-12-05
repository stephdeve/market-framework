<?php
use Framework\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder {
    
    public function run(): void
    {
        $postModel = new Post($this->db);
        
        // Create sample posts for users
        $posts = [
            ['user_id' => 1, 'title' => 'Getting Started with PHP', 'content' => 'PHP is a powerful server-side scripting language...'],
            ['user_id' => 1, 'title' => 'MVC Design Pattern', 'content' => 'The Model-View-Controller pattern separates concerns...'],
            ['user_id' => 2, 'title' => 'Database Relationships', 'content' => 'Understanding relationships is key to database design...'],
            ['user_id' => 2, 'title' => 'RESTful APIs', 'content' => 'REST is an architectural style for web services...'],
            ['user_id' => 3, 'title' => 'Authentication Best Practices', 'content' => 'Security is paramount when handling user data...'],
            ['user_id' => 3, 'title' => 'Building Scalable Applications', 'content' => 'Scalability should be considered from the start...'],
            ['user_id' => 4, 'title' => 'Testing Your Code', 'content' => 'Unit tests help ensure code quality and prevent regressions...'],
            ['user_id' => 4, 'title' => 'Deployment Strategies', 'content' => 'Proper deployment ensures smooth production releases...'],
            ['user_id' => 5, 'title' => 'Performance Optimization', 'content' => 'Optimizing performance improves user experience...'],
            ['user_id' => 5, 'title' => 'Code Refactoring Tips', 'content' => 'Refactoring keeps your codebase clean and maintainable...'],
        ];
        
        foreach ($posts as $postData) {
            $postModel->create($postData);
        }
        
        echo "  → Created 10 posts\n";
    }
}

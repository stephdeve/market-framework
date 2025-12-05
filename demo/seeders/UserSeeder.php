<?php
use Framework\Database\Seeder;
use App\Models\User;
use Framework\Auth\Auth;

class UserSeeder extends Seeder {
    
    public function run(): void
    {
        $userModel = new User($this->db);
        
        // Create sample users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Auth::hash('password123')
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Auth::hash('password123')
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'bob@example.com',
                'password' => Auth::hash('password123')
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice@example.com',
                'password' => Auth::hash('password123')
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie@example.com',
                'password' => Auth::hash('password123')
            ]
        ];
        
        foreach ($users as $userData) {
            $userModel->create($userData);
        }
        
        echo "  → Created 5 users\n";
    }
}

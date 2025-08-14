<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaskManagerSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $allUsers = User::all();
        $owner = $allUsers->first();

        // Create sample projects
        $projects = [
            [
                'name' => 'Website Redesign',
                'slug' => 'website-redesign',
                'description' => 'Complete redesign of the company website with modern UI/UX',
                'owner_id' => $owner->id,
                'visibility' => 'public',
            ],
            [
                'name' => 'Mobile App Development',
                'slug' => 'mobile-app-dev',
                'description' => 'Development of a cross-platform mobile application',
                'owner_id' => $owner->id,
                'visibility' => 'public',
            ],
            [
                'name' => 'API Integration',
                'slug' => 'api-integration',
                'description' => 'Integration with third-party APIs for enhanced functionality',
                'owner_id' => $owner->id,
                'visibility' => 'private',
            ],
        ];

        foreach ($projects as $projectData) {
            Project::firstOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );
        }

        $allProjects = Project::all();

        // Create sample tasks
        $tasks = [
            [
                'title' => 'Design Homepage Layout',
                'description' => 'Create wireframes and mockups for the new homepage design',
                'project_id' => $allProjects->where('slug', 'website-redesign')->first()->id,
                'status' => 'in_progress',
                'priority' => 2,
                'assignee_id' => $allUsers->skip(1)->first()->id,
                'due_date' => now()->addDays(7),
                'comments' => 'Need to discuss with the design team',
            ],
            [
                'title' => 'Implement User Authentication',
                'description' => 'Set up user registration, login, and password reset functionality',
                'project_id' => $allProjects->where('slug', 'mobile-app-dev')->first()->id,
                'status' => 'todo',
                'priority' => 1,
                'assignee_id' => $allUsers->skip(2)->first()->id,
                'due_date' => now()->addDays(14),
                'comments' => 'Need to discuss with the development team',
            ],
            [
                'title' => 'Database Schema Design',
                'description' => 'Design and implement the database schema for the application',
                'project_id' => $allProjects->where('slug', 'mobile-app-dev')->first()->id,
                'status' => 'done',
                'priority' => 2,
                'assignee_id' => $owner->id,
                'due_date' => now()->subDays(3),
                'comments' => '',
            ],
            [
                'title' => 'Setup Payment Gateway',
                'description' => 'Integrate Stripe payment processing into the application',
                'project_id' => $allProjects->where('slug', 'api-integration')->first()->id,
                'status' => 'blocked',
                'priority' => 1,
                'assignee_id' => $allUsers->skip(1)->first()->id,
                'due_date' => now()->addDays(21),
            ],
            [
                'title' => 'Write Unit Tests',
                'description' => 'Create comprehensive unit tests for all core functionality',
                'project_id' => $allProjects->where('slug', 'website-redesign')->first()->id,
                'status' => 'todo',
                'priority' => 3,
                'assignee_id' => null,
                'due_date' => now()->addDays(30),
            ],
            [
                'title' => 'Performance Optimization',
                'description' => 'Optimize application performance and reduce load times',
                'project_id' => $allProjects->where('slug', 'website-redesign')->first()->id,
                'status' => 'todo',
                'priority' => 4,
                'assignee_id' => $allUsers->skip(2)->first()->id,
                'due_date' => null,
            ],
            [
                'title' => 'Social Media Integration',
                'description' => 'Add social media login and sharing capabilities',
                'project_id' => $allProjects->where('slug', 'api-integration')->first()->id,
                'status' => 'in_progress',
                'priority' => 3,
                'assignee_id' => $owner->id,
                'due_date' => now()->addDays(10),
            ],
            [
                'title' => 'Security Audit',
                'description' => 'Conduct thorough security audit and fix vulnerabilities',
                'project_id' => $allProjects->where('slug', 'mobile-app-dev')->first()->id,
                'status' => 'todo',
                'priority' => 1,
                'assignee_id' => null,
                'due_date' => now()->addDays(5),
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::firstOrCreate(
                [
                    'title' => $taskData['title'],
                    'project_id' => $taskData['project_id']
                ],
                $taskData
            );
        }
    }
}

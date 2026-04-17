<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Sorn Piseth',
                'profession' => 'Full-Stack Developer',
                'bio' => 'A passionate web developer who enjoys creating modern, responsive, and user-friendly websites.',
                'phone' => '+855 96 985 1100',
                'address' => 'Phnom Penh, Cambodia',
                'gender' => 'Male',
                'birth_date' => '2004-04-01',
                'profile_image' => '/profile.jpg',
                'password' => Hash::make('password'),
            ]
        );

        // Delete old social links and add new ones
        SocialLink::where('user_id', $user->id)->delete();

        $socials = [
            ['platform' => 'github', 'url' => 'https://github.com/pisxth12'],
            ['platform' => 'facebook', 'url' => 'https://web.facebook.com/piseth.sorn.52493'],
            ['platform' => 'telegram', 'url' => 'https://t.me/seth12v12'],
            ['platform' => 'linkedin', 'url' => 'https://www.linkedin.com/in/piseth-sorn-758385389'],
        ];

        foreach ($socials as $social) {
            SocialLink::create([
                'user_id' => $user->id,
                'platform' => $social['platform'],
                'url' => $social['url'],
            ]);
        }

        // Delete old skills and add new ones
        Skill::where('user_id', $user->id)->delete();

        $skills = [
            [
                'name' => 'React',
                'level' => 'Advanced',
                'image' => '/images/skills/react.png',
                'category' => 'Frontend',
                'experience' => '1.5 years',
                'projects' => 15,
                'description' => 'Building modern UIs with React hooks and context'
            ],
            [
                'name' => 'Next.js',
                'level' => 'Advanced',
                'image' => '/images/skills/nextjs.png',
                'category' => 'Frontend',
                'experience' => '1 years',
                'projects' => 8,
                'description' => 'React framework for production with SSR'
            ],
            [
                'name' => 'Laravel',
                'level' => 'Intermediate',
                'image' => '/images/skills/laravel.png',
                'category' => 'Backend',
                'experience' => '1 years',
                'projects' => 10,
                'description' => 'PHP framework for building robust web applications'
            ],
            [
                'name' => 'Tailwind CSS',
                'level' => 'Advanced',
                'image' => '/images/skills/tailwind.png',
                'category' => 'Frontend',
                'experience' => '2 years',
                'projects' => 20,
                'description' => 'Utility-first CSS framework'
            ],
        ];

        foreach ($skills as $skill) {
            Skill::create(array_merge($skill, ['user_id' => $user->id]));
        }

        // Delete old projects and add new ones
        Project::where('user_id', $user->id)->delete();

        Project::create([
            'user_id' => $user->id,
            'title' => 'E-Commerce Website',
            'description' => 'A full-stack e-commerce web application with modern UI, secure authentication, and Telegram bot integration.',
            'languages' => json_encode(['Next.js', 'Tailwind CSS', 'Spring Boot', 'PostgreSQL']),
            'image' => '/images/projects/ecommerce.png',
            'github' => 'https://github.com/pisxth12/ecommerce',
            'link' => '',
        ]);
    }
}

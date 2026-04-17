<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{

    public function getPortfolio()
    {
        $user = User::first();

        return response()->json([
            'user' => [
                'name' => $user->name,
                'profession' => $user->profession,
                'bio' => $user->bio,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'gender' => $user->gender,
            ],
            'social' => $user->socialLinks ? $user->socialLinks->pluck('url', 'platform') : [],
            'skills' => $user->skills,
            'projects' => $user->projects,
        ]);
    }
    private function getUserOrFail()
    {
        $user  = User::first();
        if (!$user) {
            abort(404, 'No user found');
        }
        return $user;
    }

    public function getUser()
    {
        $user = $this->getUserOrFail();
        return response()->json([
            'name' => $user->name,
            'profession' => $user->profession,
            'bio' => $user->bio,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'gender' => $user->gender,
        ]);
    }

    public function getSocial(){
        $user = $this->getUserOrFail();
        $socialLinks = [];
        if($user->socialLinks){
            $socialLinks = $user->socialLinks->pluck('url','platform')->toArray();
        }
        return response()->json($socialLinks);
    }

    public function getProjects()
    {
        $user = $this->getUserOrFail();

        $projects = [];
        if ($user->projects) {
            $projects = $user->projects->map(function($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'languages' => $project->languages,
                    'image' => $project->image,
                    'github' => $project->github,
                    'link' => $project->link,
                ];
            });
        }

        return response()->json($projects);
    }
    public function getSkills()
    {
        $user = $this->getUserOrFail();

        $skills = [];
        if ($user->skills) {
            $skills = $user->skills->map(function($skill) {
                return [
                    'name' => $skill->name,
                    'level' => $skill->level,
                    'image' => $skill->image,
                    'category' => $skill->category,
                    'experience' => $skill->experience,
                    'projects' => $skill->projects,
                    'description' => $skill->description,
                ];
            });
        }

        return response()->json($skills);
    }

    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json(['message' => 'Message sent successfully'], 200);
    }
}

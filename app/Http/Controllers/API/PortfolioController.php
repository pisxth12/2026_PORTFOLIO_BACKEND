<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Helpers\ImageHelper;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function getPortfolio()
    {
        $user = User::with(['socialLinks', 'skills', 'projects'])->first();

        if (!$user) {
            return response()->json(['error' => 'No user found'], 404);
        }

        $skills = $user->skills->map(function ($skill) {
            $skill->image = ImageHelper::getUrl($skill->image);
            return $skill;
        });
        $projects = $user->projects->map(function ($project) {
            $project->image = ImageHelper::getUrl($project->image);
            return $project;
        });


        return response()->json([
            'user' => [
                'name' => $user->name,
                'profession' => $user->profession,
                'bio' => $user->bio,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'gender' => $user->gender,
                'experience' => $user->experience,
                'projects_count' => $user->projects_count,
                'clients_count' => $user->clients_count,
                'home_image' => ImageHelper::getUrl($user->home_image),
                'about_image' => ImageHelper::getUrl($user->about_image),
                'cv_url' => $user->cv ? ImageHelper::getUrl($user->cv) : null,
            ],
            'social' => $user->socialLinks ? $user->socialLinks->pluck('url', 'platform') : (object)[],
            'skills' => $skills,
            'projects' => $projects,
        ]);
    }

    public function submitContact(Request $request, TelegramService  $telegram)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contact = ContactMessage::create($validated);
        $telegram->sendMessage(
            $contact->name,
            $contact->email,
            $contact->subject,
            $contact->message
        );
        return response()->json(['message' => 'Message sent successfully'], 201);
    }
}

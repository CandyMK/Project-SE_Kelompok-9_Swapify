<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Hitung rating rata-rata dan jumlah review
        $rating = $user->receivedReviews()->avg('rating');
        $reviewCount = $user->receivedReviews()->count();

        return view('profile.edit', [
            'user' => $user,
            'rating' => $rating ? round($rating, 2) : null,
            'review_count' => $reviewCount,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Simpan foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->photo = basename($path);
            $user->save();
        }


        // Isi hanya field milik tabel users
        $user->fill(collect($validated)->only([
            'full_name',
            'username',
            'email',
            'phone',
            'bio',
            'location',
            'portfolio',
            'instagram',
            'facebook',
            'twitter',
        ])->toArray());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // return redirect()->route('seeker-dashboard')->with('status', 'profile-updated');

        // Fallback redirect
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showUpgradeForm(): View
    {
        return view('profile.upgrade');
    }
}

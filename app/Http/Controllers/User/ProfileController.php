<?php

namespace App\Http\Controllers\User;

use App\Cover;
use App\Http\Controllers\Controller;
use App\Picture;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

class ProfileController extends Controller {

    public function __construct() {
        $this->factory = (new Factory)->withServiceAccount(base_path('askcom-firebase-adminsdk-of79n-7a64d994d0.json'));
        $this->storage = $this->factory->createStorage();
    }

    public function index($user_id) {
        $user = User::where('id', '=', $user_id)->get()->shift();
        return view('user.profile.index', compact('user'));
    }

    public function uploadPicture(Request $request) {

        $validatedData = $request->validate([
            'picture' => 'required|image'
        ]);

        $file = $request->file('picture');
        $user = Auth::user();

        if ($filename = $this->uploadImage($file, $user, 'picture')) {
            $user->picture = $filename;
            $user->save();
            return $filename;
        }

        return '';
    }

    public function uploadCover(Request $request) {

        $validatedData = $request->validate([
            'cover'               => 'required|image'
        ]);

        $file = $request->file('cover');
        $user = Auth::user();

        if ($filename = $this->uploadImage($file, $user, 'cover')) {
            $user = Auth::user();
            $user->cover = $filename;
            $user->save();
            return $filename;
        }

        return '';
    }

    public function uploadImage($file, $user, $type) {

        $result = $this->storage->getBucket('askcom.appspot.com')->upload(
            file_get_contents($file->getPathname()),
            array('name' => $type . '/user_' . $user->id . '.' . $file->extension())
        );

        if ($result) {
            return $result->info()['mediaLink'];
        }

        return '';
    }

}

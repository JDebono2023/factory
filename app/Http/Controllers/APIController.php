<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Version;
use App\Models\Schedule;
use Illuminate\Http\Request;

class APIController extends Controller
{
    // versioning data
    public function versionData()
    {
        return Version::all();
    }

    // versioning data
    public function mediaData()
    {
        return Schedule::with('media')->where('visible', 1)->get();
    }
}

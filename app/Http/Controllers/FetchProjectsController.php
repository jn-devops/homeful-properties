<?php

namespace App\Http\Controllers;

use Homeful\Properties\Models\Project;
use Illuminate\Http\Request;
use App\Data\FetchData;

class FetchProjectsController extends Controller
{
    public function __invoke(Request $request): FetchData
    {
        $projects  = Project::all();

        return FetchData::from(compact('projects'));
    }
}

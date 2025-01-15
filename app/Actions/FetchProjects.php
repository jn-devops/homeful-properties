<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Homeful\Properties\Data\ProjectData;
use Homeful\Properties\Models\Project;
use Spatie\LaravelData\DataCollection;

class FetchProjects
{
    use AsAction;

    public function handle(?array $filter = []): DataCollection
    {
        $projects = Project::all();

       return new DataCollection(ProjectData::class, $projects);
    }
}

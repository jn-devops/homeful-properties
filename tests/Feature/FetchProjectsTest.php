<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\Properties\Data\ProjectData;
use Homeful\Properties\Models\Project;
use Spatie\LaravelData\DataCollection;
use App\Actions\FetchProjects;

uses(RefreshDatabase::class, WithFaker::class);

test('project has data', function () {
    $project = Project::factory()->create();
    $data = ProjectData::fromModel($project);
    expect($data)->toBeInstanceOf(ProjectData::class);
    $projects = Project::factory(10)->create();
    $dataCollection = new DataCollection(ProjectData::class, $projects);
    expect($dataCollection)->toHaveCount(10);
});

test('get projects has action', function () {
    Project::factory(10)->create();
    $dataCollection = FetchProjects::run();
    expect($dataCollection)->toBeInstanceOf(DataCollection::class);
    expect($dataCollection)->toHaveCount(10);
});

test('get projects has end point', function () {
    Project::factory(10)->create();
    $response = $this->get(route('fetch-projects'));
    expect($response->json('projects'))->toHaveCount(10);
});

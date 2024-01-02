<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $projects = Project::get();
        $data = collect();
        foreach ($projects as $project) {
            $data->push([
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'project_category_id' => $project->project_category_id,
                'tags' => $project->tags,
                // 'type' => $project->type,
                // 'type_id' => $project->type_id,
                'faculty_id' => $project->faculty_id,
                'program_id' => $project->program_id,
                'session_id' => $project->session_id,
                'semester_id' => $project->semester_id,
                'section_id' => $project->section_id,
                'status'  => $project->status,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['id','title', 'description', 'project_category_id', 'tags', 'faculty_id','program_id', 'session_id', 'semester_id', 'section_id', 'status',];
    }

}

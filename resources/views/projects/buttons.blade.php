<a class="btn btn-primary" style="width: 40px" href="{{route('projects.edit', $project->id)}}">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-secondary" style="width: 40px" href="{{route('projects.show', $project->id)}}">
    <i class="far fa-eye"></i>
</a>
<a class="btn btn-danger" onclick="showDelete({{$project->id}}, '{{$project->name}}')">
    <i class="fas fa-trash"></i>
</a>

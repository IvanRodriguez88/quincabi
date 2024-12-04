<a class="btn btn-primary" onclick="getAddEditModal('edit', {{$material->id}})">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-secondary" onclick="copyMaterial({{$material->id}}, '{{$material->name}}')">
    <i class="fas fa-copy"></i>
</a>
<a class="btn btn-danger" onclick="showDelete({{$material->id}}, '{{$material->name}}')">
    <i class="fas fa-trash"></i>
</a>
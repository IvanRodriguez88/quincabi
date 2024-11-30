<div class="image-preview-container position-relative d-inline-block project-picture" data-filename="{{$filename}}"  data-picture_id="{{$picture_id}}">
    <img src="{{$src}}" style="width: 100%; height: 100%; object-fit: cover;">
    <a class="delete-image-btn btn btn-danger btn-sm position-absolute" onclick="deleteProjectPicture('{{$filename}}', {{$picture_id}})">X</a>
</div>
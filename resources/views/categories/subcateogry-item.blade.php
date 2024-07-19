<li class="mt-1 ui-state-default">
	<a class="subcategory-order">
		<input type="hidden" name="subcategory_id" id="subcategory_id" value="{{$id ?? 0}}">
		<div class="d-flex align-items-center justify-content-between">
			<span>{{$subcategory ?? ""}}</span>
			<div class="d-flex align-items-center justify-content-between">
				<span class="btn btn-default" onclick="selectSubcategory({{$id}})">
					<i class="fas fa-eye"></i>
				</span>
				<span class="btn btn-default ml-2" onclick="deleteSubcategory(this)">
					<i class="fas fa-window-close"></i>
				</span>
			</div>
		</div>
	</a>
</li>
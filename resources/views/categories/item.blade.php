<li class="mt-1 ui-state-default">
	<a class="subcategory-order">
		<input type="hidden" name="item_id" id="item_id" value="{{$id ?? 0}}">
		<div class="d-flex align-items-center justify-content-between">
			<span>{{$item ?? ""}}</span>
			<div class="d-flex align-items-center justify-content-between">
				<span class="btn btn-default ml-2" onclick="deleteItem(this)">
					<i class="fas fa-window-close"></i>
				</span>
			</div>
		</div>
	</a>
</li>
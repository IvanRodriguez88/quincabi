<div class="info-box">
	<span class="info-box-icon bg-info"><i class="fas fa-stream"></i></span>
	<div class="info-box-content">
		<p class="info-box-text">Items of <b>{{$category->name}}</b></p>
		<span class="info-box-number">
			<ul id="items_list">
				@forelse ($category->categoryItems as $categoryItem)
					@include('categories.item', [
						'id' => $categoryItem->id,
						'item' => $categoryItem->name
					])
				@empty
					<span class="no-found">No items found</span>
				@endforelse
			</ul>
		</span>
	</div>
</div>
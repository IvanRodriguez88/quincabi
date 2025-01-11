<tr>
    <input type="hidden" value="{{$uniqueId}}" class="uniqueId">
    <td>
        <input type="hidden" value="{{$material->id ?? null}}" class="material_id">
        <input type="hidden" value="{{$material->name ?? $free_material}}" class="material_name">
        {{$material->name ?? $free_material}}
    </td>
    <td>
        <div class="d-flex">
            <button onclick="decrease(this)" class="btn">-</button>
            <input type="number" min="1" value="{{$amount}}" class="amount form-control" style="width: 100px">
            <button onclick="increase(this)" class="btn">+</button>
        </div>
    </td>
    <td>
        <input type="hidden" value="{{$unit_cost}}" class="unit_cost">
        ${{number_format($unit_cost, 4, '.', ',')}}
    </td>
    <td>
        <input type="hidden" value="{{$unit_price}}" class="unit_price">
        ${{number_format($unit_price, 4, '.', ',')}}
    </td>
    <input type="hidden" value="{{$total}}" class="total_input">
    <td class="total">
        ${{number_format($total, 4, '.', ',')}}
    </td>
    <td>
        <a class="btn btn-danger" onclick="deleteMaterial(this, '{{$material->name ?? $free_material}}')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
<tr>
    <input type="hidden" value="{{$uniqueId}}" class="uniqueId">
    <td>
        <input type="hidden" value="{{$material->id}}" class="material_id">
        {{$material->name}}
    </td>
    <td>
        <div class="d-flex">
            <button onclick="decrease(this)" class="btn">-</button>
            <input type="number" min="1" value="{{$amount}}" class="amount form-control" style="width: 100px">
            <button onclick="increase(this)" class="btn">+</button>
        </div>
    </td>
    <td>
        <input type="hidden" value="{{$unit_price}}" class="unit_price">
        ${{number_format($unit_price, 2, '.', ',')}}
    </td>
    <input type="hidden" value="{{$total}}" class="total_input">
    <td class="total">
        ${{number_format($total, 2, '.', ',')}}
    </td>
    <td>
        <a class="btn btn-danger" onclick="deleteMaterial(this, '{{$material->name}}')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
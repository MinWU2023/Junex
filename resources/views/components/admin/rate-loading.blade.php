@foreach($data  as $productCategoryIndexRateData_key=>$productCategoryIndexRateData)
    <tr>
        <td>{{ $productCategoryIndexRateData_key+1 }}</td>
        <td><a href="{{ $productCategoryIndexRateData['url_key'] }}"
               target="_blank">{{ $productCategoryIndexRateData['product_category_name'] }}</a>
        </td>
        <td>{{ $productCategoryIndexRateData['index_count'] }}</td>
        <td>{{ $productCategoryIndexRateData['rate'] }}%</td>
        <td>{{ date('Y-m-d H:i:s') }}</td>
    </tr>
@endforeach

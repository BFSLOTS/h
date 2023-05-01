@php
$currant_column = [];
@endphp
<table>
    <tbody>
        @foreach ($formvalues as $key => $form_value)
            @php
                $column = $form_value->columns();
            @endphp
            @if($currant_column != $column)
                @php
                $currant_column = $column;
                @endphp
                @if($key != 0)
                    <tr></tr>
                @endif
                <tr>
                @foreach ($currant_column as $value)
                    <th>{{ $value }}</th>
                @endforeach
                <th>{{ __('Amount') }}</th>
                <th>{{ __('Transaction ID') }}</th>
            </tr>

            @endif

            <tr>
                @foreach (json_decode($form_value->json) as $value)
                    @foreach ($value as $formvalue)
                        @if (isset($formvalue->value) || isset($formvalue->values))
                            @if (isset($formvalue->value))

                                @if ($formvalue->type == 'starRating')
                                    <td>{{ isset($formvalue->value) ? $formvalue->value : '' }}</td>

                                @elseif ($formvalue->type == 'button')
                                    <td> </td>

                                @elseif ($formvalue->type == 'date')
                                    <td>{{ isset($formvalue->value) ? $formvalue->value : '' }}</td>

                                @elseif ($formvalue->type == 'number')
                                    <td>{{ isset($formvalue->value) ? $formvalue->value : '' }}</td>

                                @elseif ($formvalue->type == 'paragraph')
                                    <td>{{ isset($formvalue->label) ? $formvalue->label : '' }}</td>

                                @elseif ($formvalue->type == 'text')
                                    <td>{{ isset($formvalue->value) ? $formvalue->value : '' }}</td>

                                @elseif ($formvalue->type == 'textarea')
                                    <td>{{ isset($formvalue->value) ? $formvalue->value : '' }}</td>
                                @endif
                            @elseif (isset($formvalue->values))
                                @php
                                    $value = '';
                                @endphp
                                @foreach ($formvalue->values as $sub_data)
                                    @if ($formvalue->type == 'checkbox-group')
                                        @if (isset($sub_data->selected))
                                            @php  $value .= $sub_data->label . ',' @endphp
                                        @endif
                                    @elseif ($formvalue->type == "radio-group")
                                        @if (isset($sub_data->selected))
                                            @php  $value .= $sub_data->label . ',' @endphp
                                        @endif
                                    @else
                                        @if (isset($sub_data->selected))
                                            @php  $value .= $sub_data->label . ',' @endphp
                                        @endif
                                    @endif
                                @endforeach
                                @php  $value = rtrim($value, ',') @endphp
                                <td>{{ $value ? $value : '' }}</td>
                            @else
                                @if ($formvalue->type == 'file')
                                    @if (isset($formvalue->value))
                                        @foreach ($formvalue->value as $key => $sub_data)
                                            <td><a href="{{ Storage::path($sub_data) }}"
                                                    alt="">{{ __('image') }}</a>
                                            </td>
                                        @endforeach
                                    @endif
                                @endif
                            @endif
                        @elseif ($formvalue->type == 'header')
                            @if (isset($formvalue->selected) && $formvalue->selected)
                                {{ intval($formvalue->number_of_control) }}
                                <td> {{ 'N/A' }}</td>
                            @else
                                <td>{{ isset($formvalue->value) ? $formvalue->value : '' }}</td>
                            @endif
                        @else
                            @if (isset($formvalue->value))
                                <td> </td>
                            @endif
                        @endif

                    @endforeach
                @endforeach
                <td>{{ $form_value->amount }}</td>
                <td>{{ $form_value->transaction_id }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

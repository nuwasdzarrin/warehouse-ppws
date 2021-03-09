@php
    $names = explode('.', $field['name']);
    $name = array_shift($names).(count($names) > 0 ? '['.collect($names)->map(function ($name) { return $name == '*' ? '' : $name; })->implode('][').']' : '');
@endphp

<div class="form-group{{ $errors->has($field['name']) ? ' has-error' : '' }}">
    @if (!empty($field['type']) && $field['type'] == 'checkbox')
        <input type="hidden" name="{{ $name }}" value="0" {{ isset($field['disabled']) && $field['disabled'] ? 'disabled' : '' }}>
        <div>
            <label>
                <input type="checkbox"
                       name="{{ $name }}"
                       class="i-checks"
                       value="1" {{ old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}) == 1 ? 'checked' : '' }}
                    {{ !empty($field['disabled']) ? 'disabled' : '' }}
                > {{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}
            </label>
        </div>
    @elseif (!empty($field['type']) && $field['type'] == 'radio')
        <label class="control-label">{!! !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) !!}{{ !empty($field['required']) ? '*' : '' }}</label>
        @foreach ($field['options'] as $key => $option)
            <div>
                <label style="display: flex">
                    <input type="radio"
                           name="{{ $name }}" class="i-checks"
                           style="width: 40px;"
                           value="{{ $option['value'] }}" {{ old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}) == $option['value'] ? 'checked' : '' }}
                        {{ !empty($field['disabled']) ? 'disabled' : '' }}
                    ><span class="m-l-xs">{{ $option['value'].'. '.$option['text'] }}</span>
                </label>
            </div>
        @endforeach
    @elseif (!empty($field['type']) && $field['type'] == 'file')
        <label class="control-label">
            {{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}
            @if(!empty($field['template']))
                (<a href="{{ $field['template'] }}" target="blank">{{ _('Template') }}</a>)
            @endif
        </label>

        @if (filter_var(old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}), FILTER_VALIDATE_URL) ||
             Storage::exists(old($field['name'], isset($model) ? $model->getOriginal($field['name']) : request()->{$field['name']})) ||
             Storage::cloud()->exists(old($field['name'], isset($model) ? $model->getOriginal($field['name']) : request()->{$field['name']})))
            <div>
                <label>
                    <input type="checkbox"
                           name="{{ $name }}"
                           class="i-checks"
                           value=""
                        {{ !empty($field['disabled']) ? 'disabled' : '' }}
                    > {{ __('Delete')  }}
                    @if (filter_var(old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}), FILTER_VALIDATE_URL))
                        <a href="{{ old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}) }}" target="_blank">
                            {{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}
                        </a>
                    @elseif (Storage::exists(old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']})))
                        <a href="{{ Storage::url(old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']})) }}" target="_blank">
                            {{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}
                        </a>
                    @elseif (Storage::cloud()->exists(old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']})))
                        <a href="{{ Storage::cloud()->url(old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']})) }}" target="_blank">
                            {{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}
                        </a>
                    @endif
                </label>
            </div>
        @endif
        <input type="file"
               class="form-control"
               name="{{ $name }}"
               accept="{{ !empty($field['accept']) ? $field['accept'] : '' }}"
            {{ !empty($field['required']) ? 'required' : '' }}
            {{ !empty($field['disabled']) ? 'disabled' : '' }}>
        @if(!empty($field['information'])&&!$errors->has($field['name']))
            <span class="help-block">{{ $field['information'] }}</span>
        @endif
    @elseif (!empty($field['type']) && $field['type'] == 'hidden')
        <input type="hidden" name="{{ $name }}" value="{{ old($field['name'], isset($model) ? data_get($model, $field['name'], $field['value']) : request()->input($field['name'], $field['value'])) }}" {{ isset($field['disabled']) && $field['disabled'] ? 'disabled' : '' }}>
    @else
        <label class="control-label">{{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}</label>
        <input type="{{ !empty($field['type']) ? $field['type'] : 'text' }}"
               class="form-control"
               name="{{ $name }}"
               value="{{ old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}) }}"
               @isset($field['placeholder']) placeholder="{{ $field['placeholder'] }}" @endisset
               @if (!empty($field['type']) && $field['type'] == 'number')
               @isset($field['min']) min="{{ $field['min'] }}" @endisset
               @isset($field['max']) max="{{ $field['max'] }}" @endisset
               step="{{ !empty($field['step']) ? $field['step'] : 'any' }}"
            @endif
            {{ !empty($field['required']) ? 'required' : '' }}
            {{ !empty($field['disabled']) ? 'disabled' : '' }}>
    @endif
    @if ($errors->has($field['name']))
        <span class="help-block">{{ $errors->first($field['name']) }}</span>
    @endif
</div>

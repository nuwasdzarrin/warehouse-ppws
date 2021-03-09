@php
    $names = explode('.', $field['name']);
    $name = array_shift($names).(count($names) > 0 ? '['.collect($names)->implode('][').']' : '');
@endphp

<div class="form-group{{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label class="control-label">{{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}</label>
    @if (isset($field['action']))
        <div class="input-group">
            @endif
            <input type="hidden" name="{{ $name }}" value="">
            <select2-ajax-child
                    class="form-control"
                    name="{{ $name }}"
                    parent-selector="{{ $field['parent-selector'] }}"
                    parent-path="{{ $field['parent-path'] }}"
                    child-path="{{ $field['child-path'] }}"
                    @isset($field['data-parent']) data-parent="{{ $field['data-parent'] }}" @endisset
                    @isset($field['data-property']) data-property="{{ $field['data-property'] }}" @endisset
                    @isset($field['current-page-property']) current-page-property="{{ $field['current-page-property'] }}" @endisset
                    @isset($field['last-page-property']) last-page-property="{{ $field['last-page-property'] }}" @endisset
                    @isset($field['id-property']) id-property="{{ $field['id-property'] }}" @endisset
                    @isset($field['text-property']) text-property="{{ $field['text-property'] }}" @endisset
                    @isset($field['note-property']) note-property="{{ $field['note-property'] }}" @endisset
                    @isset($field['minimum-input-length']) :minimum-input-length="{{ $field['minimum-input-length'] }}" @endisset
                    @isset($field['delay-ajax']) :delay-ajax="{{ $field['delay-ajax'] }}" @endisset
                    @isset($field['tags']) :tags="{{ $field['tags'] }}" @endisset
                    @isset($field['params']) :params='@json($field['params'])' @endisset
                    value="{{ old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}) }}"
                    @isset($field['disabled']){{ $field['disabled'] ? 'disabled' : '' }}@endisset
                    @isset($field['readonly']){{ $field['readonly'] ? 'readonly' : '' }}@endisset
                    @isset($field['options']) :options="{{ str_replace('"', '\'', json_encode($field['options'])) }}" @endisset
                    @isset($field['scope']) scope="{{ $field['scope'] }}" @endisset
                    @isset($field['update-param']) update-param="{{ $field['update-param'] }}" @endisset
            >
                @foreach ($field['options'] as $option)
                    <option value="{{ $option['value'] ?? $option['id'] }}" {{ in_array(($option['value'] ?? $option['id']), array_flatten([ old($field['name'], isset($model) ? data_get($model, $field['name']) : request()->{$field['name']}) ])) ? 'selected' : '' }}>{{ $option['text'] }}</option>
                @endforeach
            </select2-ajax-child>
            @if (isset($field['action']))
                <span class="input-group-btn">
                    <a href="{{ $field['action'] }}"
                       target="{{ isset($field['target']) ? $field['target'] : '' }}"
                       class="btn btn-default">
                        <i class="{{ isset($field['action-icon']) ? $field['action-icon'] : 'fa fa-plus' }}"></i>
                    </a>
                </span>
        </div>
    @endif
    @if ($errors->has($field['name']))
        <span class="help-block">{{ $errors->first($field['name']) }}</span>
    @endif
</div>

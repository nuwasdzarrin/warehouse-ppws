<input type="hidden" name="{{ $field['name'] }}" value="">
<div class="form-group{{ $errors->has($field['name'].'.*.'.$field['attribute']) ? ' has-error' : '' }}">
  <label class="control-label">{{ !empty($field['label']) ? $field['label'] : title_case(str_replace('_', ' ', snake_case($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}</label>
  <select2-ajax
    class="form-control"
    name="{{ $field['name'] }}[][{{ $field['attribute'] }}]"
    url="{{ $field['url'] }}"
    @isset($field['data-property']) data-property="{{ $field['data-property'] }}" @endisset
    @isset($field['current-page-property']) current-page-property="{{ $field['current-page-property'] }}" @endisset
    @isset($field['last-page-property']) last-page-property="{{ $field['last-page-property'] }}" @endisset
    @isset($field['id-property']) id-property="{{ $field['id-property'] }}" @endisset
    @isset($field['text-property']) text-property="{{ $field['text-property'] }}" @endisset
    @isset($field['tags']) :tags="{{ $field['tags'] }}" @endisset
    @isset($field['note-property']) note-property="{{ $field['note-property'] }}" @endisset
    @isset($field['minimum-input-length']) :minimum-input-length="{{ $field['minimum-input-length'] }}" @endisset
    :value="[{{ implode(',', collect(old($field['name'], isset($model) ? $model->{$field['name']}->toArray() : []))->pluck(isset($field['attribute']) ? $field['attribute'] : 'id')->map(function ($value) {
        return is_numeric($value) ? $value : '\''.$value.'\'';
    })->toArray()) }}]"
    multiple
    >
    @foreach ($field['options'] as $option)
    <option value="{{ $option['value'] }}" {{ collect(old($field['name'], isset($model) ? $model->{$field['name']}->toArray() : []))->contains(isset($field['id-property']) ? $field['id-property'] : 'id', $option['value']) ? 'selected' : '' }}>{{ $option['text'] }}</option>
    @endforeach
  </select2-ajax>
  @if ($errors->has($field['name'].'.*.'.$field['attribute']))
  <span class="help-block">{{ $errors->first($field['name'].'.*.'.$field['attribute']) }}</span>
  @endif
</div>

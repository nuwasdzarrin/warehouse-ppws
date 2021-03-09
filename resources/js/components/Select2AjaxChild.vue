<template>
  <select>
    <slot></slot>
  </select>
</template>

<script>
let _ = require('lodash');
let $ = require('jquery');
require('../select2');

import Select2Ajax from "./Select2Ajax";

export default {
  name: 'Select2AjaxChild',
  extends: Select2Ajax,
  props: {
    url: {type: String, default: ''},
    parentSelector: {type: String, required: true},
    parentPath: {type: String, required: true},
    childPath: {type: String, required: true},
    linkScope: {type: Boolean},
    disabled: {type: Boolean, default: false}
  },
  data: function () {
    return {
      target: this.parentPath,
      parentValueLoaded: false,
      parentValue: null,
      lang: require('select2/src/js/select2/i18n/' + (this.$i18n.locale || 'en')),
    }
  },
  mounted: function () {
    if (this.disabled) $(this.$el).attr("disabled", "disabled");
    this.parentValue = $(this.parentSelector).val();
    this.$nextTick(() => { this.parentValueLoaded = true; });
    if (this.parentValue) {
      this.target = this.parentPath + '/' + this.parentValue + this.childPath;
      if (!this.disabled) $(this.$el).removeAttr("disabled", "disabled");
    } else {
      $(this.$el).attr("disabled", "disabled");
    }

    this.parent = this.$el.parentNode;
    $(this.$el)
      .select2({
        ...this.config,
        data: this.parentValue && this.value && _.isEmpty(this.options) ? [{id: this.value, text: `${this.$t('Loading')}...`}] : this.options
      })
      .val(this.value)
      .on('change', (e) => {
        this.$emit('change', e.target.value);
        this.$emit('update:selected', $(this.$el).select2('data'));
      })
      .on('select2:open', (e) => {
        if (this.currentQuery)
          $(e.target).parent().find('.select2-search input').val(this.currentQuery).trigger('input');
      })
      .on('select2:closing', (e) => {
        this.currentQuery = $(e.target).parent().find('.select2-search input').prop('value');
      })
      .on('select2:select', (e) => {
        this.$emit('select2-select', e.params.data);
      });

    $(this.parentSelector).on('change', (e) => {
      if (String(this.parentValue || '') !== String(e.target.value || '')) {
        this.parentValue = e.target.value;
      }
    });

    if (this.parentValue && this.value && (_.isEmpty(this.options) || !this.options.find((option) => String(option.id || '') !== String(this.value || ''))))
      this.setValue(this.value, true)
  },
  watch: {
    parentValue: function (value, oldValue) {
      if (!this.parentValueLoaded) return;
      if (value && String(value || '') !== String(oldValue || '')) {
        this.target = this.parentPath + '/' + value + this.childPath;
        this.$nextTick(() => {
          this.clear()
        })
        if (!this.disabled) $(this.$el).removeAttr("disabled", "disabled");
      } else if (!value) {
        this.target = this.parentPath;
        this.$nextTick(() => {
          this.clear()
        })
        $(this.$el).attr("disabled", "disabled");
      }
    },
    value: function (value, oldValue) {
      if (!this.parentValue) return;
      let promise = this.setValue(value)
      if (String(value || '') !== String(oldValue || '')) {
        promise.then(() => $(this.$el).trigger('change'))
      }
    }
  }
}
</script>

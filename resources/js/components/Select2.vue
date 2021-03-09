<template>
    <select>
        <slot></slot>
    </select>
</template>

<script>
    let _ = require('lodash');
    let $ = require('jquery');
    require('../select2');

    export default {
        model: {
            event: 'change'
        },
        props: {
            options: {
                type: Array, default: function () {
                    return [];
                }
            },
            value: {type: [String, Number, Array], default: ''},
            placeholder: {type: String, default: ''},
            tags: {type: Boolean, default: false},
            allowClear: {type: String, default: '1'},
            minimumInputLength: {type: Number, default: 0},
            matcher: undefined,
            templateResult: undefined,
            templateSelection: undefined,
            customLang:{
                type:Object, default: function () {
                    return {};
                }
            },
        },
        data: function() {
          return {
              target: this.url,
              lang: require('select2/src/js/select2/i18n/' + (this.$i18n.locale || 'en')),
          }
        },
        mounted: function () {
            let vm = this;
            $(this.$el)
                .select2(this.config)
                .val(this.value)
                .on('change', function () {
                    vm.$emit('change', this.value);
                })
                .on('select2:select', function(e){
                    vm.$emit('select2-select', e.params.data);
                });
        },
        computed: {
            config: function () {
                return {
                    data: this.options,
                    placeholder: this.placeholder,
                    tags: this.tags,
                    allowClear: (this.allowClear == '1'),
                    theme: 'bootstrap',
                    width: null,
                    minimumInputLength: this.minimumInputLength,
                    language: this.langOption,
                    matcher: this.matcher,
                    templateResult: this.templateResult,
                    templateSelection: this.templateSelection
                };
            },
            langOption: function () {
                let l = Object.assign({}, this.lang);
                Object.keys(this.customLang).forEach(key => {
                    l[key] = this.customLang[key]
                })
                return l;
            }
        },
        watch: {
            config: function (config, oldConfig) {
                $(this.$el).select2(config);
                $(this.$el).val(this.value);
                if (config.data !== oldConfig.data)
                    $(this.$el).trigger('change');
            },
            options: function (options) {
                let vm = this;
                if (!_.find(options, (option) => _.get(option, this.idProperty) === vm.value)) {
                    $(this.$el).empty();
                }
                $(this.$el).select2(_.merge(this.config, {data: options}));
                $(this.$el).val(this.value);
                $(this.$el).trigger('change');
            },
            value: function (value, oldone) {
                $(this.$el).val(value);
            }
        },
        methods: {
          trigger: function (event) {
              $(this.$el).trigger(event);
          },
          val: function (val) {
              $(this.$el).val(val);
          }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy');
        },
    }
</script>

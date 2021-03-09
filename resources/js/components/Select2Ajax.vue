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
  name: 'Select2Ajax',
  model: {
    event: 'change'
  },
  props: {
    options: {
      type: Array, default: function () {
        return [];
      }
    },
    initialOptionsResolve: {
      type: Function,
      default: function () {
        const url = new URL(this.target, window.location.origin)
        return axios.get(`${url.pathname.replace(/\/$/, '')}/${this.value}${url.search}`, {params: this.params})
            .then((response) => {
              const datum = response.data.data;
              return [{
                id: _.get(datum, this.idProperty),
                text: this.textHandler ? this.textHandler(_.get(datum, this.textProperty), datum) : (_.get(datum, this.textProperty) + (this.noteProperty && _.get(datum, this.noteProperty) ? (' (' + _.get(datum, this.noteProperty) + ')') : '')),
                htmlResult: this.htmlResultHandler ? this.htmlResultHandler(_.get(datum, this.htmlResultProperty), datum) : _.get(datum, this.htmlResultProperty),
                htmlSelection: this.htmlSelectionHandler ? this.htmlSelectionHandler(_.get(datum, this.htmlSelectionProperty), datum) : _.get(datum, this.htmlSelectionProperty),
                datum: datum
              }]
            }).catch(() => [])
      }
    },
    value: {type: [String, Number, Array], default: ''},
    url: {type: String, required: true},
    baseUrl: {type: String, default: ''},
    params: {
      type: [Object, Array],
      default: function () {
        return {};
      }
    },
    htmlResult: {type: Boolean, default: false},
    htmlSelection: {type: Boolean, default: false},
    dataProperty: {type: String, default: 'data'},
    dataParent: {type: String, default: ''},
    currentPageProperty: {type: String, default: 'meta.current_page'},
    lastPageProperty: {type: String, default: 'meta.last_page'},
    idProperty: {type: String, default: 'id'},
    textProperty: {type: String, default: 'text'},
    textHandler: {type: Function, default: undefined},
    noteProperty: {type: String, default: ''},
    groupProperty: {type: String},
    htmlResultProperty: {type: String, default: ''},
    htmlResultHandler: {type: Function, default: undefined},
    htmlSelectionProperty: {type: String, default: ''},
    htmlSelectionHandler: {type: Function, default: undefined},
    placeholder: {type: String, default: ''},
    tags: {type: Boolean, default: false},
    allowClear: {type: String, default: '1'},
    minimumInputLength: {type: Number, default: 0},
    delayAjax: {type: Number, default: 500},
    scope: {type: String},
    updateParam: {type: Boolean, default: false},
    customLang: {
      type: Object, default: function () {
        return {};
      }
    },
    mergeConfig: {
      type: Object, default: function () {
        return {}
      }
    }
  },
  data: function () {
    return {
      target: this.url,
      currentQuery: '',
      lang: require('select2/src/js/select2/i18n/' + (this.$i18n.locale || 'en')),
      parent: null
    }
  },
  mounted: function () {
    if (this.$options.name !== 'Select2Ajax') return;
    this.parent = this.$el.parentNode;
    $(this.$el)
      .select2({
        ...this.config,
        data: this.value && _.isEmpty(this.options) ? [{
          id: this.value,
          text: `${this.$t('Loading')}...`
        }] : this.options
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

    if (this.value && (_.isEmpty(this.options) || !this.options.find((option) => String(option.id || '') !== String(this.value || ''))))
      this.setValue(this.value, true)
  },
  computed: {
    config: function () {
      return {
        data: this.options,
        ajax: this.ajax,
        placeholder: this.placeholder,
        tags: this.tags,
        allowClear: (String(this.allowClear || 0) === String(1)),
        theme: 'bootstrap',
        width: null,
        minimumInputLength: this.minimumInputLength,
        language: this.langOption,
        templateResult: this.htmlResult ? this.templateResult : undefined,
        templateSelection: this.htmlSelection ? this.templateSelection : undefined,
        dropdownParent: this.parent,
        ...this.mergeConfig
      };
    },
    ajax: function () {
      return {
        url: this.target,
        dataType: 'json',
        delay: this.delayAjax,
        processResults: this.processResults,
        transport: this.transport,
        cache: true,
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
    url: function (value) {
      this.target = value;
    },
    config: function (config, oldConfig) {
      if (config.data !== oldConfig.data)
        $(this.$el).empty();
      $(this.$el).select2(config);
      $(this.$el).val(this.value);
      if (config.data !== oldConfig.data) {
        $(this.$el).trigger('change');
      }
    },
    value: function (value, oldValue) {
      if (this.$options.name !== 'Select2Ajax') return;
      let promise = this.setValue(value)
      if (String(value || '') !== String(oldValue || '')) {
        promise.then(() => $(this.$el).trigger('change'))
      }
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy');
  },
  methods: {
    processResults: function (response) {
      let data = this.dataProperty ? _.get(response.data, this.dataProperty) : response.data;
      let currentPage = this.currentPageProperty ? _.get(response.data, this.currentPageProperty) : 1;
      let lastPage = this.lastPageProperty ? _.get(response.data, this.lastPageProperty) : 1;
      let results = [];
      if (this.groupProperty) {
        let groupResult = _.uniq(data.map((datum) => {
          return _.get(datum, this.groupProperty)
        }))
        results = _.map(groupResult, (group) => ({
          text: _.startCase(group),
          children: _.map(data.filter((datum) => {
            return _.get(datum, this.groupProperty) === group
          }), (datum) => ({
            id: _.get(datum, this.idProperty),
            text: this.textHandler ? this.textHandler(_.get(datum, this.textProperty), datum) : (_.get(datum, this.textProperty) + (this.noteProperty && _.get(datum, this.noteProperty) ? (' (' + _.get(datum, this.noteProperty) + ')') : '')),
            htmlResult: this.htmlResultHandler ? this.htmlResultHandler(_.get(datum, this.htmlResultProperty), datum) : _.get(datum, this.htmlResultProperty),
            htmlSelection: this.htmlSelectionHandler ? this.htmlSelectionHandler(_.get(datum, this.htmlSelectionProperty), datum) : _.get(datum, this.htmlSelectionProperty),
            datum: datum
          }))
        }));
      } else {
        results = _.map(data, (datum) => ({
          id: _.get(datum, this.idProperty),
          text: this.textHandler ? this.textHandler(_.get(datum, this.textProperty), datum) : (_.get(datum, this.textProperty) + (this.noteProperty && _.get(datum, this.noteProperty) ? (' (' + _.get(datum, this.noteProperty) + ')') : '')),
          htmlResult: this.htmlResultHandler ? this.htmlResultHandler(_.get(datum, this.htmlResultProperty), datum) : _.get(datum, this.htmlResultProperty),
          htmlSelection: this.htmlSelectionHandler ? this.htmlSelectionHandler(_.get(datum, this.htmlSelectionProperty), datum) : _.get(datum, this.htmlSelectionProperty),
          datum: datum
        }));
      }
      return {
        results: results,
        pagination: {
          more: (currentPage < lastPage)
        }
      };
    },
    transport: function (params, success, failure) {
      return axios.get(params.url, {
        params: {
          page: params.data.page,
          search: params.data.term || this.currentQuery,
          ...this.params
        }
      }).then(success).catch(failure);
    },
    templateResult(state) {
      if (!state.id || !state.htmlResult) return state.text;
      return $(state.htmlResult);
    },
    templateSelection(state) {
      if (!state.id || !state.htmlSelection) return state.text;
      return $(state.htmlSelection);
    },
    clear: function () {
      $(this.$el).empty().val('').trigger('change');
    },
    setValue: function (value, force = false) {
      let promise = Promise.resolve();
      if (value && (force || (String(value) !== String($(this.$el).val() || '')))) {
        promise = promise.then(this.initialOptionsResolve.bind(this))
          .then((options) => {
            $(this.$el).empty()
              .select2({...this.config, data: options})
              .val(value);
            if (!$(this.$el).val())
              this.clear();
          })
      }
      return promise;
    }
  }
}
</script>

<style>
.select2-results__group {
  background-color: #EAEFF5;
  color: #004492 !important;
  padding: 15px 12px !important;
}
</style>

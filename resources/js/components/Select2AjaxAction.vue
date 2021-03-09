<template>
    <select2-ajax
            class="form-control"
            :id="selectId"
            :url="url"
            :id-property="idProperty"
            :text-property="textProperty"
            :note-property="noteProperty"
            :options="options"
            :place-holder="placeholder"
            v-model="selectedOption"
            allow-clear="0"
            @change="change"
    >
    </select2-ajax>
</template>

<script>
    import axios from 'axios';
    import toastr from 'toastr';

    export default {
        name: "Select2AjaxAction",
        props:{
            selectId:{type: String, default:'select2Action'},
            action:{type: String, default:''},
            actionUrl:{type:String, default: ''},
            name:{type:String, default: ''},
            options: {
                type: Array, default: function () {
                    return [];
                }
            },
            value: {type: [String, Number, Array], default: ''},
            url: {type: String, required: true},
            params: {
                type: Object, default: function () {
                    return {};
                }
            },
            idProperty: {type: String, default: 'id'},
            textProperty: {type: String, default: 'text'},
            noteProperty: {type: String, default: ''},
            placeholder: {type: String, default: ''},
        },
        data: function () {
            return {
                selectedOption: this.value,
                toastr: toastr
            }
        },
        methods:{
            change: function (event) {
                console.log(event, this.selectedOption, this.value)
                this.$emit('change', event);

                if (this.action !== '' && this.actionUrl !== '' && this.selectedOption && this.selectedOption != this.value){
                    if (confirm(this.$t('Are you sure you?'))) {
                        let body = {};
                        body[this.name] = this.selectedOption;
                        axios[this.action](this.actionUrl,
                            body
                        ).then((response) => {
                            this.toastr.options.progressBar = true;
                            this.toastr.success(this.$t('Success'));
                        }).catch((error) => {
                            this.selectedOption = this.value;
                            this.$nextTick(()=>{
                                $('#'+this.selectId).trigger('change');
                            })
                            this.toastr.options.progressBar = true;
                            this.toastr.error(error, this.$t('Failed'));
                        })
                    }else {
                        this.selectedOption = this.value;
                        this.$nextTick(()=>{
                            $('#'+this.selectId).trigger('change');
                        })
                    }
                }
            }
        },
        mounted() {
            this.$nextTick(()=>{
                $('#'+this.selectId).trigger('change');
            })
        }
    }
</script>

<style scoped>

</style>
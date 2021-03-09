<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 offset-md-2">
                <form class="form">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Edit Master Data</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('product_category_id')}">
                                <label class="control-label">Kategori</label>
                                <select2-ajax
                                    name="product_category_id"
                                    class="form-control"
                                    url="/api/product_categories"
                                    :params="{institution_id: institutionId}"
                                    id-property="id"
                                    text-property="name"
                                    :delay-ajax="750"
                                    :placeholder="'Pilih Kategori'"
                                    :options="productCategories"
                                    v-model="update.product_category_id"
                                >
                                </select2-ajax>
                                <span class="help-block" v-if="formErrors && formErrors.has('product_category_id')">{{ formErrors.first('product_category_id') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('name')}">
                                <label class="control-label">Nama*</label>
                                <input type="text" name="name" value="" required="required" class="form-control" v-model="update.name">
                                <span class="help-block" v-if="formErrors && formErrors.has('name')">{{ formErrors.first('name') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Stok</label>
                                <input type="text" name="user" value="0" required="required" class="form-control" disabled>
                                <span class="help-block">Perubahan nilai stok dapat di lakukan pada fitur penyesuaian stok</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('noted')}">
                                <label class="control-label">Keterangan</label>
                                <textarea type="text" name="noted" required="required" class="form-control" v-model="update.noted"></textarea>
                                <span class="help-block" v-if="formErrors && formErrors.has('noted')">{{ formErrors.first('noted') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('picture')}">
                                <label class="control-label">Foto</label>
                                <div class="m-t-sm m-b-sm" v-if="this.originProduct.picture">
                                    <img :src="`/storage/${this.originProduct.picture}`" style="width: 250px;height: auto;">
                                    <div class="m-t-sm m-b-sm" style="display: flex;align-items: center; font-weight: bold; font-size: 14px;">
                                        <input type="checkbox" name="change-image" style="width: 25px; height: 25px;" v-model="changeImage">
                                        <div class="m-t-xs m-l-xs">Ganti Gambar</div>
                                    </div>
                                </div>
                                <input type="file" name="picture" accept="" class="form-control" @change="readImage($event)" :disabled="(!changeImage)&&(this.originProduct.picture)">
                                <span class="help-block" v-if="formErrors && formErrors.has('picture')">{{ formErrors.first('picture') }}</span>
                            </div>
                        </div>
                        <div class="ibox-footer">
                            <div class="pull-right float-right">
                                <button type="button" name="redirect" class="btn btn-primary" @click="updateTransaction()">Update</button>
                            </div>
                            <a href="/products" class="btn btn-default btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <vue-loading-overlay
            :active.async="isLoading"
            :can-cancel="false"
            color="#007bff"
        >
        </vue-loading-overlay>
    </div>
</template>

<script>
import VeeValidate from "vee-validate";
import id from "vee-validate/dist/locale/id";
import imageCompression from "browser-image-compression";

export default {
    name: "Edit",
    props: {
        institutionId: Number,
        originProduct: Object
    },
    data: function () {
        return {
            isLoading: false,
            changeImage: null,
            productCategories: [],
            formValidator: null,
            formErrors: null,
            update: {
                product_category_id: this.originProduct.product_category_id,
                institution_id: this.institutionId,
                name: this.originProduct.name,
                noted: this.originProduct.noted,
                picture: null
            }
        }
    },
    methods: {
        settingValidation: function () {
            this.formValidator = new VeeValidate.Validator({}, {});
            this.formValidator.localize('id', id);
            this.formValidator.attach({name: 'product_category_id', rules: 'required', alias: 'master data'});
            this.formValidator.attach({name: 'name', rules: 'required', alias: 'nama'});
            this.formValidator.attach({name: 'noted', rules: `max:254`, alias: 'keterangan'});
            this.formValidator.attach({name: 'picture', rules: 'ext:jpeg,jpg,png', alias: 'foto transaksi'});
            this.$set(this, 'formErrors', this.formValidator.errors);
        },
        async readImage(event) {
            this.$set(this,'isLoading',true);
            let photo = event.target.files[0];
            this.settingValidation();
            this.formValidator.validateAll({
                picture: photo
            }).then((value) => {
                if (!value) return null;
            });
            const options = {
                maxSizeMB: 1,
                maxWidthOrHeight: 1024,
                useWebWorker: false
            };
            try {
                this.$set(this.update, 'picture', await imageCompression(photo, options)
                    .then(blob => new File([blob], blob.name)));
                this.$set(this,'isLoading',false);
            } catch (error) {
                this.$set(this,'isLoading',false);
            }
            return photo;
        },
        convertToFormData: function () {
            let data = new FormData;
            ['product_id','transaction_status_id','institution_id','officer','amount_before','amount','noted','picture'].forEach((key) => {
                if (this.update[key]) data.append(`${key}`, this.update[key]);
            });
            data.append('_method', 'PUT');
            return data;
        },
        updateTransaction: function () {
            this.settingValidation();
            this.formValidator.validateAll({
                product_category_id: this.update.product_category_id,
                name: this.update.name,
                noted: this.update.noted
            }).then((value) => {
                if (value) {
                    this.$set(this,'isLoading',true);
                    let formData = this.convertToFormData();
                    axios({
                        method: 'post',
                        headers: {'Content-Type': 'multipart/form-data'},
                        url: `/api/products/${this.originProduct.id}`,
                        data: formData,
                    }).then((res) => {
                        console.log(res);
                        this.$set(this,'isLoading',false);
                        toastr.options.progressBar = true;
                        toastr.success('Master Data Berhasil Di Perbaharui', this.$t('Success'));
                        window.location.replace('/products');
                    }).catch((err) => {
                        this.$set(this,'isLoading',false);
                        toastr.options.progressBar = true;
                        toastr.error(err.response.data.message ? err.response.data.message : err.response.data.exception.split('\\').pop(), this.$t('Error'));
                    });
                }
            });
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 offset-md-2">
                <form action="http://instock.test/transaction_ins" method="POST" enctype="multipart/form-data" class="form">
                    <input type="hidden" name="_token" value="n7G9qP4Aw3aMwwxCilv9V7bvSzn3kbfw5KSrnLTG">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Buat baru Transaksi Keluar</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('product_id')}">
                                <label class="control-label">Master Data</label>
                                <select2-ajax
                                    name="product_id"
                                    class="form-control"
                                    url="/api/products"
                                    :params="{institution_id: institutionId}"
                                    id-property="id"
                                    text-property="name"
                                    :delay-ajax="750"
                                    :placeholder="'Pilih Master Data'"
                                    :options="ProductOptions"
                                    v-model="productSelected"
                                >
                                </select2-ajax>
                                <span class="help-block" v-if="formErrors && formErrors.has('product_id')">{{ formErrors.first('product_id') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('transaction_status_id')}">
                                <label class="control-label">Status</label>
                                <select2-ajax
                                    name="transaction_status_id"
                                    class="form-control"
                                    url="/api/transaction_statuses"
                                    :params="{type: 'out'}"
                                    id-property="id"
                                    text-property="name"
                                    :delay-ajax="750"
                                    :placeholder="'Pilih Status Transaksi'"
                                    :options="TransactionStatusOptions"
                                    v-model="store.transaction_status_id"
                                >
                                </select2-ajax>
                                <span class="help-block" v-if="formErrors && formErrors.has('transaction_status_id')">{{ formErrors.first('transaction_status_id') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Staff</label>
                                <input type="text" name="user" :value="userName" required="required" class="form-control" disabled>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('officer')}">
                                <label class="control-label">Petugas Lapangan*</label>
                                <input type="text" name="officer" value="" required="required" class="form-control" v-model="store.officer">
                                <span class="help-block" v-if="formErrors && formErrors.has('officer')">{{ formErrors.first('officer') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('amount')}">
                                <label class="control-label">Jumlah*</label>
                                <div style="padding: 2px 0;" v-if="amount">Stok: {{stock}} - {{amount}} = {{ stock - amount }}</div>
                                <input type="number" name="amount" value="" required="required" class="form-control" v-model="amount" :disabled="!productSelected">
                                <span class="help-block" v-if="formErrors && formErrors.has('amount')">{{ formErrors.first('amount') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('noted')}">
                                <label class="control-label">Keterangan</label>
                                <textarea type="text" name="noted" required="required" class="form-control" v-model="store.noted"></textarea>
                                <span class="help-block" v-if="formErrors && formErrors.has('noted')">{{ formErrors.first('noted') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('picture')}">
                                <label class="control-label">Foto Transaksi</label>
                                <input type="file" name="picture" accept="" class="form-control" @change="readImage($event)">
                                <span class="help-block" v-if="formErrors && formErrors.has('picture')">{{ formErrors.first('picture') }}</span>
                            </div>
                        </div>
                        <div class="ibox-footer">
                            <div class="pull-right float-right">
                                <button type="button" name="redirect" class="btn btn-primary" @click="storeTransaction()">Simpan</button>
<!--                                <button type="button" name="redirect" class="btn btn-primary" @click="storeTransaction(true)">Simpan &amp; Buat baru</button>-->
                            </div>
                            <a href="/transaction_ins" class="btn btn-default btn-secondary">Kembali</a>
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
import imageCompression from "browser-image-compression";
import VeeValidate from "vee-validate";
import id from "vee-validate/dist/locale/id";

export default {
    name: "Create",
    props: {
        institutionId: Number,
        userName: String
    },
    data: function () {
        return {
            isLoading: false,
            productSelected: null,
            ProductOptions: [],
            TransactionStatusOptions: [],
            formValidator: null,
            formErrors: null,
            stock: null,
            amount: null,
            store: {
                product_id: null,
                transaction_status_id: null,
                institution_id: this.institutionId,
                officer: null,
                amount: null,
                noted: null,
                picture: null
            }
        }
    },
    watch: {
        productSelected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$set(this.store,'product_id',newVal);
                this.fetchProduct();
            }
        },
        stock: function (newVal, oldVal) {
            if (newVal !== oldVal && this.amount) {
                this.settingValidation();
                this.formValidator.validateAll({
                    amount: this.amount
                });
            }
        },
        amount: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.settingValidation();
                this.formValidator.validateAll({
                    amount: newVal
                });
                this.$set(this.store,'amount',newVal);
            }
        }
    },
    methods: {
        fetchProduct: function () {
            axios.get(`/api/products/${this.productSelected}`).then((res)=>{
                this.$set(this,'stock',res.data.data.stock);
            }).catch((err)=>{
                toastr.options.progressBar = true;
                toastr.error(err.response.data.message ? err.response.data.message : err.response.data.exception.split('\\').pop(), this.$t('Error'));
            });
        },
        settingValidation: function () {
            this.formValidator = new VeeValidate.Validator({}, {});
            this.formValidator.localize('id', id);
            this.formValidator.attach({name: 'product_id', rules: 'required', alias: 'master data'});
            this.formValidator.attach({name: 'transaction_status_id', rules: 'required', alias: 'status transaksi'});
            this.formValidator.attach({name: 'officer', rules: 'required', alias: 'petugas lapangan'});
            this.formValidator.attach({name: 'amount', rules: `required|max_value:${this.stock}`, alias: 'jumlah'});
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
                this.$set(this.store, 'picture', await imageCompression(photo, options)
                    .then(blob => new File([blob], blob.name)));
                this.$set(this,'isLoading',false);
            } catch (error) {
                this.$set(this,'isLoading',false);
            }
            return photo;
        },
        convertToFormData: function () {
            let data = new FormData;
            ['product_id','transaction_status_id','institution_id','officer','amount','noted','picture'].forEach((key) => {
                if (this.store[key]) data.append(`${key}`, this.store[key]);
            });
            return data;
        },
        storeTransaction: function (create = false) {
            this.settingValidation();
            this.formValidator.validateAll({
                product_id: this.store.product_id,
                transaction_status_id: this.store.transaction_status_id,
                officer: this.store.officer,
                amount: this.store.amount,
                noted: this.store.noted
            }).then((value) => {
                if (value) {
                    this.$set(this,'isLoading',true);
                    let formData = this.convertToFormData();
                    axios({
                        method: 'post',
                        headers: {'Content-Type': 'multipart/form-data'},
                        url: '/api/transaction_outs',
                        data: formData,
                    }).then((res) => {
                        this.$set(this,'isLoading',false);
                        toastr.options.progressBar = true;
                        toastr.success('Transaksi Keluar Berhasil Dibuat', this.$t('Success'));
                        if (create) window.location.reload();
                        else window.location.replace('/transaction_outs');
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

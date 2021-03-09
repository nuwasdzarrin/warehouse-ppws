<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 offset-md-2">
                <form class="form">
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
                                    :options="productOptions"
                                    :disabled="true"
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
                                    :params="{type: 'in'}"
                                    id-property="id"
                                    text-property="name"
                                    :delay-ajax="750"
                                    :placeholder="'Pilih Status Transaksi'"
                                    :options="transactionStatusOptions"
                                    v-model="update.transaction_status_id"
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
                                <input type="text" name="officer" value="" required="required" class="form-control" v-model="update.officer">
                                <span class="help-block" v-if="formErrors && formErrors.has('officer')">{{ formErrors.first('officer') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('amount')}">
                                <label class="control-label">Jumlah*</label>
                                <div style="padding: 2px 0;" v-if="amount">Stok: {{(Number(stock)+Number(originTransaction.amount))}} - {{amount}} = {{ (Number(stock)+Number(originTransaction.amount)) - Number(amount) }}</div>
                                <input type="number" name="amount" value="" required="required" class="form-control" v-model="amount" :disabled="!productSelected">
                                <span class="help-block" v-if="formErrors && formErrors.has('amount')">{{ formErrors.first('amount') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('noted')}">
                                <label class="control-label">Keterangan</label>
                                <textarea type="text" name="noted" required="required" class="form-control" v-model="update.noted"></textarea>
                                <span class="help-block" v-if="formErrors && formErrors.has('noted')">{{ formErrors.first('noted') }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': formErrors && formErrors.has('picture')}">
                                <label class="control-label">Foto Transaksi</label>
                                <div class="m-t-sm m-b-sm" v-if="this.originTransaction.picture">
                                    <img :src="`/storage/${this.originTransaction.picture}`" style="width: 250px;height: auto;">
                                    <div class="m-t-sm m-b-sm" style="display: flex;align-items: center; font-weight: bold; font-size: 14px;">
                                        <input type="checkbox" name="change-image" style="width: 25px; height: 25px;" v-model="changeImage">
                                        <div class="m-t-xs m-l-xs">Ganti Gambar</div>
                                    </div>
                                </div>
                                <input type="file" name="picture" accept="" class="form-control" @change="readImage($event)" :disabled="(!changeImage)&&(this.originTransaction.picture)">
                                <span class="help-block" v-if="formErrors && formErrors.has('picture')">{{ formErrors.first('picture') }}</span>
                            </div>
                        </div>
                        <div class="ibox-footer">
                            <div class="pull-right float-right">
                                <button type="button" name="redirect" class="btn btn-primary" @click="updateTransaction()">Update</button>
                            </div>
                            <a href="/transaction_outs" class="btn btn-default btn-secondary">Kembali</a>
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
        originTransaction: Object,
        userName: String
    },
    data: function () {
        return {
            isLoading: false,
            changeImage: null,
            productOptions: [],
            productSelected: this.originTransaction.product_id,
            transactionStatusOptions: [],
            formValidator: null,
            formErrors: null,
            amount: this.originTransaction.amount,
            stock: null,
            update: {
                product_id: null,
                transaction_status_id: this.originTransaction.transaction_status_id,
                institution_id: this.institutionId,
                officer: this.originTransaction.officer,
                amount_before: this.originTransaction.amount,
                amount: null,
                noted: this.originTransaction.noted,
                picture: null
            }
        }
    },
    watch: {
        productSelected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$set(this.update,'product_id',newVal);
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
                this.$set(this.update,'amount',newVal);
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
            this.formValidator.attach({name: 'amount', rules: `min_value:1|max_value:${(Number(this.stock)+Number(this.originTransaction.amount))}`, alias: 'jumlah'});
            this.formValidator.attach({name: 'noted', rules: `max:254`, alias: 'keterangan'});
            this.formValidator.attach({name: 'picture', rules: 'ext:jpeg,jpg,png', alias: 'foto transaksi'});
            this.$set(this, 'formErrors', this.formValidator.errors);
        },
        async readImage(event) {
            this.$set(this,'isLoading',true);
            let photo = event.target.files[0];
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
                product_id: this.update.product_id,
                transaction_status_id: this.update.transaction_status_id,
                officer: this.update.officer,
                amount: this.update.amount,
                noted: this.update.noted
            }).then((value) => {
                if (value) {
                    this.$set(this,'isLoading',true);
                    let formData = this.convertToFormData();
                    axios({
                        method: 'post',
                        headers: {'Content-Type': 'multipart/form-data'},
                        url: `/api/transaction_outs/${this.originTransaction.id}`,
                        data: formData,
                    }).then((res) => {
                        console.log(res);
                        this.$set(this,'isLoading',false);
                        toastr.options.progressBar = true;
                        toastr.success('Transaksi Keluar Berhasil Di Perbaharui', this.$t('Success'));
                        window.location.replace('/transaction_outs');
                    }).catch((err) => {
                        this.$set(this,'isLoading',false);
                        toastr.options.progressBar = true;
                        toastr.error(err.response.data.message ? err.response.data.message : err.response.data.exception.split('\\').pop(), this.$t('Error'));
                    });
                }
            });
        }
    },
    mounted: function () {
        this.$set(this.update,'product_id',this.originTransaction.product_id);
        this.fetchProduct();
    }
}
</script>

<style scoped>

</style>

<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 offset-md-2">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Penyesuaian Stok {{ originProduct.name }}</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="p-sm b-r-md m-b-md" :class="stockCondition">
                            <h4>Stok Sebelum Disesuaikan: {{ originProduct.stock }}</h4>
                            <h4>Stok Setelah Disesuaikan: {{ stock }}</h4>
                            <div>Penyesuaian akan menyesuaikan stok <u>{{ originProduct.name }}</u> anda.</div>
                            <div v-if="stock">
                                <div v-if="stock > originProduct.stock">
                                    Nilai stok penyesuaian lebih besar daripada stok sebelum disesuaikan maka secara otomatis akan
                                    terbuat <b>Transaksi Masuk</b> baru sejumlah <b>{{ stock - originProduct.stock }}</b>
                                    dengan keterangan penyesuaian stok.
                                </div>
                                <div v-else>
                                    Nilai stok penyesuaian lebih kecil daripada stok sebelum disesuaikan maka secara otomatis akan
                                    terbuat <b>Transaksi Keluar</b> baru sejumlah <b>{{ originProduct.stock - stock }}</b>
                                    dengan keterangan penyesuaian stok.
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error': formErrors && formErrors.has('stock')}">
                            <label class="control-label">Stok Penyesuaian</label>
                            <input type="number" name="stock" class="form-control" autocomplete="off" v-model="stock">
                            <span class="help-block" v-if="formErrors && formErrors.has('stock')">{{ formErrors.first('stock') }}</span>
                        </div>
                    </div>
                    <div class="ibox-footer">
                        <div class="pull-right float-right">
                            <button type="button" name="redirect" class="btn btn-primary" @click="adjustStock">Sesuaikan</button>
                        </div>
                        <a href="/products" class="btn btn-default btn-secondary">Kembali</a>
                    </div>
                </div>
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

export default {
    name: "Adjust",
    props: {
        institutionId: Number,
        originProduct: Object
    },
    data: function () {
        return {
            isLoading: false,
            formValidator: null,
            formErrors: null,
            stock: null
        }
    },
    watch: {
        stock: function (newVal, oldVal) {
            if (newVal !==  oldVal && this.stock) {
                this.settingValidation();
                this.formValidator.validateAll({
                    stock: newVal
                });
            }
        }
    },
    methods: {
        settingValidation: function () {
            this.formValidator = new VeeValidate.Validator({}, {});
            this.formValidator.localize('id', id);
            this.formValidator.attach({
                name: 'stock',
                rules: `required|min_value:0|is_not:${this.originProduct.stock}`,
                alias: 'stok baru'
            });
            this.$set(this, 'formErrors', this.formValidator.errors);
        },
        adjustStock: function () {
            this.settingValidation();
            this.formValidator.validateAll({
                stock: this.stock
            }).then((value) => {
                if (value) {
                    this.$set(this, 'isLoading', true);
                    axios({
                        method: 'post',
                        headers: {'Content-Type': 'application/json'},
                        url: `/api/products/adjust/${this.originProduct.id}`,
                        data: {
                            stock: this.stock
                        },
                    }).then((res) => {
                        this.$set(this, 'isLoading', false);
                        toastr.options.progressBar = true;
                        toastr.success('Penyesuaian stok berhasil dilakukan', this.$t('Success'));
                        window.location.replace('/products');
                    }).catch((err) => {
                        this.$set(this, 'isLoading', false);
                        toastr.options.progressBar = true;
                        toastr.error(err.response.data.message ? err.response.data.message : err.response.data.exception.split('\\').pop(), this.$t('Error'));
                    });
                }
            });
        }
    },
    computed: {
        stockCondition: function () {
            if (this.stock) {
                if (this.stock > this.originProduct.stock) return 'alert-success';
                else return 'alert-warning';
            } else return 'alert-info';
        }
    }
}
</script>

<style scoped>

</style>

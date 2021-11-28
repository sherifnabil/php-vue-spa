<script>
    const addProduct = Vue.component('addProduct', {
        props: ['add'],

        data() {
            return {
                formData: {
                    name: '',
                    sku: '',
                    type: '',
                    price: '',
                    attributes: {
                        lengthAttr: null,
                        width: null,
                        height: null,
                        size: null,
                        weight: null,
                    },
                },
                errors: {
                    name: '',
                    sku: '',
                    price: '',
                    type: '',
                    attributes: {
                        lengthAttr: '',
                        width: '',
                        height: '',
                        size: '',
                        weight: '',
                    },
                }
            }
        },

        methods: {

            addProduct() {
                this.$emit('cancelling');
                this.validation();
                const self = this;

                if(this.notValidData()) return;

                if (this.formData.type == 'Furniture') {
                    if(this.formData.attributes.lengthAttr == '' || this.formData.attributes.lengthAttr == 0 || this.formData.attributes.width == '' || this.formData.attributes.width == 0 || this.formData.attributes.height == '' || this.formData.attributes.height == 0) {
                        return;
                    }
                    this.formData.attributes = JSON.stringify({
                        width: self.formData.attributes.width,
                        length: self.formData.attributes.lengthAttr,
                        height: self.formData.attributes.height
                    })

                }

                if (this.formData.type == 'Book') {
                    if(this.formData.attributes.weight == '' || this.formData.attributes.weight == 0 ){
                        return;
                    }
                    this.formData.attributes = JSON.stringify({weight: self.formData.attributes.weight})

                }

                if (this.formData.type == 'DVD') {
                    if(this.formData.attributes.size == '' || this.formData.attributes.size == 0) {
                        return;
                    }
                    this.formData.attributes = JSON.stringify({size: self.formData.attributes.size})
                }

                axios
                .post('/product-store', this.formData)
                .then(({data}) => {
                    self.$emit('newproduct', data.data)
                    this.$router.push('/')
                })
                .catch(err => {
                    console.log(err);
                });
            },

            notValidData() {
                return this.formData.name == '' || this.formData.sku == '' || this.formData.price == '' || this.formData.price == 0;
            },

            validation() {
                if(this.formData.name.trim() == '') {
                    this.errors.name = 'The name field is required.';
                }
                if(this.formData.sku.trim() == '') {
                    this.errors.sku = 'The sku field is required.';
                }
                if(this.formData.price == 0) {
                    this.errors.price = 'The price field is is required and can not be 0';
                }
                if(this.formData.type.trim() == '') {
                    this.errors.type = 'please, select a type for your product.';
                }

                if(this.formData.type == 'Furniture') {
                    if(this.formData.attributes.lengthAttr == null || this.formData.attributes.lengthAttr == '' || this.formData.attributes.lengthAttr == 0) {
                        this.errors.attributes.lengthAttr = 'The length field is required.';
                    }
                    if(this.formData.attributes.lengthAttr == 0) {
                        this.errors.attributes.lengthAttr = 'The length field is can not be 0';
                    }

                    if(this.formData.attributes.width == null || this.formData.attributes.width == '' || this.formData.attributes.width == 0) {
                        this.errors.attributes.width = 'The width field is required.';
                    }
                    if(this.formData.attributes.width == 0) {
                        this.errors.attributes.width = 'The width field is can not be 0';
                    }

                    if(this.formData.attributes.height == null || this.formData.attributes.height == '' || this.formData.attributes.height == 0) {
                        this.errors.attributes.height = 'The height field is required.';
                    }
                    if(this.formData.attributes.height == 0) {
                        this.errors.attributes.height = 'The height field is can not be 0';
                    }
                }

                if(this.formData.type == 'Book') {
                    if(this.formData.attributes.weight == null || this.formData.attributes.weight == '' || this.formData.attributes.weight == 0) {
                        this.errors.attributes.weight = 'The weight field is required.';
                    }
                    if(this.formData.attributes.weight == 0) {
                        this.errors.attributes.weight = 'The weight field is can not be 0';
                    }
                }

                if(this.formData.type == 'DVD') {
                    if(this.formData.attributes.size == null || this.formData.attributes.size == '' || this.formData.attributes.size == 0) {
                        this.errors.attributes.size = 'The size field is required.';
                    }
                    if(this.formData.attributes.size == 0) {
                        this.errors.attributes.size = 'The size field is can not be 0';
                    }
                }
            }
        },

        watch: {
            add: function(newVal, oldVal) {
                if(newVal){
                    this.addProduct()
                }
            }
        },

        template: `
            <form>
                <div class="col-md-8">
                    <div class="form-group mb-3">
                        <div class="col-md-2">
                            <label for="sku">SKU</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" id="sku" @input="errors.sku = ''" maxlength="50" v-model="formData.sku" class="form-control" placeholder="SKU">
                            <p class="text-danger" v-if="errors.sku">{{ errors.sku }}</p>
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group mb-3">
                        <div class="col-md-2">
                            <label for="name">Name</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" id="name"  @input="errors.name = ''" maxlength="50" v-model="formData.name" class="form-control" placeholder="Name">
                            <p class="text-danger" v-if="errors.name">{{ errors.name }}</p>
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group mb-3">
                        <div class="col-md-2">
                            <label for="price">Price</label>
                        </div>
                        <div class="col-md-10">
                            <input type="number" @input="errors.price = ''" v-model="formData.price" id="price" maxlength="50" class="form-control" placeholder="Price $">
                            <p class="text-danger" v-if="errors.price">{{ errors.price }}</p>
                        </div>
                    </div>
                    <br><br>

                    <div class="form-group mb-3">
                        <div class="col-md-2">
                            <label for="type">Type</label>
                        </div>
                        <div class="col-md-10">
                            <select id="productType" @input="errors.type = ''" v-model="formData.type" class="form-control">
                                <option disabled selected></option>
                                <option value="Furniture">Furniture</option>
                                <option value="Book">Book</option>
                                <option value="DVD">DVD-disc</option>
                            </select>
                            <p class="text-danger" v-if="errors.type">{{ errors.type }}</p>
                        </div>
                        <br><br>
                    </div>
                    <br><br>
                    <div class="form-group mb-3" v-if="formData.type == 'Furniture'">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="width">Width</label>
                            </div>
                            <div class="col-md-10">
                                <input type="number"  @input="errors.attributes.width = ''" v-model="formData.attributes.width" id="width" maxlength="10" class="form-control" placeholder="Width">
                                <p class="text-danger" v-if="errors.attributes.width">{{ errors.attributes.width }}</p>
                            </div>
                            <br><br>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="height">Height</label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" @input="errors.attributes.height = ''" v-model="formData.attributes.height" id="height" maxlength="10" class="form-control" placeholder="Height">
                                <p class="text-danger" v-if="errors.attributes.height">{{ errors.attributes.height }}</p>
                            </div>
                            <br><br>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="length">Length</label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" @input="errors.attributes.lengthAttr = ''" v-model="formData.attributes.lengthAttr" id="length" maxlength="10" class="form-control" placeholder="Length">
                                <p class="text-danger" v-if="errors.attributes.lengthAttr">{{ errors.attributes.lengthAttr }}</p>
                            </div>
                        </div>
                        <p>Please, Provide dimensions in HxWxL format</p>
                    </div>

                    <div class="form-group mb-3" v-if="formData.type == 'DVD'">
                        <div class="col-md-2">
                            <label for="size">Size</label>
                        </div>
                        <div class="col-md-10">
                            <input type="number" @input="errors.attributes.size = ''" v-model="formData.attributes.size" id="size" maxlength="10" class="form-control" placeholder="Size in MB">
                            <p class="text-danger" v-if="errors.attributes.size">{{ errors.attributes.size }}</p>
                        </div>
                        <p>Please, Provide Size</p>
                    </div>

                    <div class="form-group mb-3" v-if="formData.type == 'Book'">
                        <div class="col-md-2">
                            <label for="weight">weight</label>
                        </div>
                        <div class="col-md-10">
                            <input type="number" @input="errors.attributes.weight = ''" v-model="formData.attributes.weight" id="weight" maxlength="10" class="form-control" placeholder="Weight in KG">
                            <p class="text-danger" v-if="errors.attributes.weight">{{ errors.attributes.weight }}</p>
                        </div>
                        <p>Please, Provide Weight</p>
                    </div>
                    <br><br>
                </div>
            </form>
        `,
    });
</script>
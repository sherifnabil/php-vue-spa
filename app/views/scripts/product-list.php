<script>
    const ProductList = Vue.component('ProductList', {
        props: ['products'],

        template: `
            <div class="row">
                <div v-if="products.length" v-for="product in products" class="col-md-3 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <input class="delete-checkbox" type="checkbox" :value="product.id">
                        </div>
                        <h5>{{ product.sku }}</h5>
                        <h5>{{ product.name }}</h5>
                        <h5>{{ product.price }} $</h5>
                        <h6 v-if="product.type == 'furniture'">
                            Dimensions:
                            <span v-for="(v, k) in product.attributes">
                                <span v-if="k == 'length' || k == 'height'">*</span>
                                {{v}}
                            </span>
                        </h6>
                        <h6 v-if="product.type == 'book'">
                            Weight:
                            <span v-for="(v, k) in product.attributes">
                                {{v}} KG
                            </span>
                        </h6>
                        <h6 v-if="product.type == 'dvd'">
                            Size:
                            <span v-for="(v, k) in product.attributes">
                                {{v}} MB
                            </span>
                        </h6>
                    </div>
                </div>
            </div>
        `,
    });
</script>
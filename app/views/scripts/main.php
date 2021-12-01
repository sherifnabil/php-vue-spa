<?php require_once('add-product.php') ?>
<?php require_once('product-list.php') ?>
<script>

    var routes = [
        {path:'/', component: ProductList},
        {path:'/add-product',component:addProduct}
    ];

    var router = new VueRouter({
        mode: 'history',
        routes:routes
    });

    var routerR = new Vue({
        router,
        el:'#app',
        data: {
            products: [],
            idsToDelete: [],
            add: false
        },

        components: {
            ProductList,
            addProduct
        },
        mounted() {
            this.getProducts()
        },

        methods: {
            deleteProducts() {
                let ids = [];
                let checkboxes = document.querySelectorAll('.delete:checked');
                let allchecked = document.querySelectorAll('.delete');
                const self = this;

                for (var i = 0; i < checkboxes.length; i++) {
                    ids.push(checkboxes[i].value)
                }
                if(!ids.length) return alert('No products selected!');

                if(confirm('Are you sure you want to delete Products')) {
                    if(checkboxes.length == document.querySelectorAll('.delete').length) {
                        document.querySelectorAll('.delete-checkbox').forEach(e => e.remove());

                        document.getElementsByTagName('script')[7].remove();
                        document.getElementsByTagName('script')[6].remove();
                        document.getElementsByTagName('script')[5].remove();
                    }
                    axios.post('/product-delete', {ids:ids})
                    .then((res) => {
                        for (let i = 0; i < ids.length; i++) {
                            const element = self.products.find(e => e.id === ids[i]);
                            self.products.splice(self.products.indexOf(element), 1);
                        }
                    })
                    for (var ii = 0; ii < allchecked.length; ii++) {
                        allchecked[ii].checked = false
                    }
                }
            },

            async getProducts() {
                await axios
                .get('/products')
                .then(({data}) => {
                    this.products = data.data
                    this.products.map(product => {
                        product.attributes = JSON.parse(product.attributes)
                    });
                });
            },

            newProduct(product) {
                product.attributes = JSON.parse(product.attributes)
                this.products.push(product);
            }
        }
    }).$mount("#app")
</script>
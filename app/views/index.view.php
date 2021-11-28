<?php require('partial/head.php') ?>
<div class="container" id="app">
    <div class="row">
        <div class="col-md-6">
            <h3 v-if="window.location.pathname == '/'"> Product List</h3>
            <h3 v-if="window.location.pathname == '/add-product'">Add Product</h3>
        </div>
        <div class="col-md-6 text-right">
            <template v-if="window.location.pathname !== '/'">
                <router-link class="btn btn-warning" to="/">Cancel</router-link>
                <button class="btn btn-primary" @click="add = true">Save</button>
            </template>
            <template v-if="window.location.pathname !== '/add-product'" >
                <router-link class="btn btn-primary" to="/add-product">Add</router-link>
                <button class="btn btn-danger" @click="deleteProducts">Mass Delete</button>
            </template>
        </div>
    </div>
    <div class="row">
        <router-view @newproduct="newProduct" @cancelling="add = false" :add="add" :products="products"></router-view>
    </div>
</div>
<?php require('partial/footer.php') ?>

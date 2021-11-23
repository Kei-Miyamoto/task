
<template>
<div>
  <div class="card card-body mb-2" v-for="product in products" v-bind:key="product.id">
    <h3>{{ product.id }}</h3>
    <h2>{{ product.name }}</h2>
    <p>{{ product.stock }}</p>
  </div>  
</div>
</template>

<script>
  export default {
        data() {
          return {
            products:[],
            product: {
              id: '',
              name: '',
              stock: '',
            },
            product_id: '',
            pagination: {},
            edit: false
          };
        },
        methods: {
          fetchProducts(page_url) {
            let vm = this;
            page_url = page_url || 'http://localhost:8000/api/products';
            fetch(page_url)
              .then(res => res.json())
              .then(res => {
                this.products =res.data;
                vm.makePagination(res.meta, res.links);
              })
              .catch(err => concole.log(err));
          },
          makePagination(meta, links) {
            let pagination = {
              current_page: meta.current_page,
              last_page: meta.last_page,
              next_page_url: links.next,
              prev_page_url:links.prev
            };
            this.pagination = pagination;
          },
        },
        mounted() {
            console.log('Component mounted.')
        }
    };
</script>
<script setup>
    import { onMounted, reactive } from 'vue';
    import axios from 'axios';
    import ProductList from './products/ProductList.vue';

    const data = reactive({
        products: []
    })

    const fetchAllProducts = async() => {
        try {
            const response = await axios.get('http://127.0.0.1:8000/api/products')

            data.products = response.data.data
        } catch (error) {
            console.log(error)
        }
    }

    onMounted(() => fetchAllProducts())
</script>

<template>
    <ProductList :products="data.products" />
</template>
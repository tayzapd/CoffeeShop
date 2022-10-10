<template>
    <v-tabs
      v-model="tab"
      background-color="primary"
    >
      <v-tab class="text-capitalize" value="1">Products</v-tab>
      <v-tab class="text-capitalize" value="2">Create New Product</v-tab>
    </v-tabs>

    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="1">
          <ProductsView :key="tab" />
        </v-window-item>

        <v-window-item value="2">
          <ProductsCreate @created="NewProduct"/> 
        </v-window-item>

      </v-window>
    </v-card-text>
</template>

<script>
import ProductsCreate from './ProductsCreate.vue';
import ProductsView from './ProductsView.vue';
export default {
    data(){
        return {
            tab:1
        }
    },
    methods:{
      NewProducts(){
        
      }
    },
    components:{ProductsView,ProductsCreate}
}
</script>
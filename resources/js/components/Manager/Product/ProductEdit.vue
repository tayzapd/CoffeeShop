<template>
        <v-dialog persistent v-model="dialog">
            <v-card>
                    <v-toolbar
                    prominent
                    >

                    <v-toolbar-title>Edit Product <span class="font-weight-bold">{{ product.name }}</span> </v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-btn icon @click="$emit('close')">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    </v-toolbar>                  
                <v-divider></v-divider>
                <v-card-text>
                 <v-form v-model="valid"  >
                    <v-text-field
                        variant="solo"
                        label="Name"
                        v-model="product.name"
                        :rules="nameRules"
                        :counter="20"
                        required
                    ></v-text-field>
                    
                    <v-select
                        variant="solo"
                        label="Categories"
                        v-model="product.category.name"
                        :items="categories"
                        item-title="name"
                        item-value="id"
                        :rules="[v => !!v || 'Item is required']"
                        required
                    ></v-select>

                    <v-text-field
                        v-model="product.price"
                        variant="solo"
                        label="Price"
                        prefix="$"
                        :counter='5'
                        :rules="PriceRules"
                    ></v-text-field>

                   
                    <v-checkbox
                        label="Are You Sure?"
                        v-model="checkbox"
                        :rules="[v => !!v || 'You must agree to continue!']"
                        required
                    ></v-checkbox>

                    <v-btn
                        class="float-right"
                        flat text 
                        @click="submit"
                        :disabled="!checkbox"
                    >
                        submit
                    </v-btn>

                 </v-form>
                </v-card-text>
            </v-card>
            
        </v-dialog>
</template>


<script>
export default {
    props:['dialog','product'],
    data(){
        return {
            valid: true,
            categories:{},
            nameRules: [v => !!v || "Name is required", v => (v && v.length <= 20) || "Name must be less than 20 characters"],
            PriceRules: [v => !!v || "Price is required", v => (v && v.length <= 5) || "Price must be less than 5 characters"],
            checkbox: false
        }
    },
    methods:{
        getCategories(){
            axios.post(`/api/manager/category/get`,{user_id:localStorage.getItem('user_id')}).then((res) => {
                this.categories = res.data;
            })
        },
        submit(){
            const form = {
                user_id:localStorage.getItem('user_id'),
                category_id:this.product.category_id,
                product_id:this.product.id,
                name:this.product.name,
                price:this.product.price
            };
            axios.post(`/api/manager/product/edit`,form).then((res) => {
                if(res.data == true ){
                    
                    this.$emit('edited')
                }
            })
        }
    },
    mounted() {
        this.getCategories();
    }
}
</script>
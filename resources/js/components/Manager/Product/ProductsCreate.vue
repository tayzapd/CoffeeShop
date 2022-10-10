<template>
    <v-form v-model="valid"  >
        <v-text-field
            variant="solo"
            label="Name"
            v-model="name"
            :rules="nameRules"
            :counter="20"
            required
        ></v-text-field>
        
        <v-select
            variant="solo"
            label="Categories"
            v-model="category_id"
            :items="categories"
            item-title="name"
            item-value="id"
            :rules="[v => !!v || 'Item is required']"
            required
        ></v-select>

        <v-text-field
          v-model="price"
          variant="solo"
          label="Price"
          prefix="$"
          :rules="PriceRules"
        ></v-text-field>

        <v-file-input
            variant="solo"
            @change="selectFile"
            :rules="ImageRules"
            chips show-size counter
            accept="image/png, image/jpeg, image/bmp"
            placeholder="Pick an avatar"
            prepend-icon="mdi-camera"
            label="Product Iamge"
        ></v-file-input>
        <v-btn block  @mouseover="show = true" @mouseleave="show = false" v-if="image != null">Show Image.... </v-btn>
        <v-fade-transition>
            <v-img :src="url"  @mouseover="show = true"  @mouseleave="show = false"  class="col-12 w-auto h-auto" v-show="show==true" height="30vh"
          width="100%"></v-img>
        </v-fade-transition>
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
            :disabled="!valid"
        >
            submit
        </v-btn>
        <v-btn class="float-right" flat text @click="clear">clear</v-btn>
        <v-snackbar
            v-model="message.open"
            :color="message.color"
            variant="tonal"
            :timeout="4000"
        >
            {{ message.text }}
        </v-snackbar>
    </v-form>
</template>

<script>
export default {
    data: () => ({
        message:{
            open:false,
            color:"",
            text:""
        },
        valid: true,
        name: "",
        image:null,
        url:'',
        price:'',
        categories:{},
        nameRules: [v => !!v || "Name is required", v => (v && v.length <= 20) || "Name must be less than 20 characters"],
        PriceRules: [v => !!v || "Price is required", v => (v && v.length <= 5) || "Price must be less than 5 characters"],
        ImageRules: [
            value => {
            return !value || !value.length || value[0].size < 2000000 || 'Avatar size should be less than 2 MB!'
            },
        ],
        show:false,
        category_id: null,
        checkbox: false
    }),

    methods: {
        getCategories(){
            axios.post(`/api/manager/category/get`,{user_id:localStorage.getItem('user_id')}).then((res) => {
                this.categories = res.data;
            })
        },
        submit() {
                // Native form submission is not yet supported
                
                var form = new FormData();
                form.append('user_id',localStorage.getItem('user_id'));
                form.append('category_id',this.category_id);
                form.append('name',this.name);
                form.append("price",this.price);
                form.append("image",this.image);
                form.forEach((value, key) => {
                    console.log("key %s: value %s", key, value);
                })
                axios.post(`/api/manager/product/create`,form).then((res) => {
                    if(res.data == true){
                        this.message.open = true;
                        this.message.text = "Successfully Created A New Product!";
                        this.message.color = "success";
                        this.$emit("Created",'success')
                    }
                })
        },
        clear() {
            // this.$refs.form.reset();
        },
        selectFile(file){
            this.image = file.target.files[0];
            this.url= URL.createObjectURL(this.image)
        }
    },
    mounted(){
        this.getCategories();
    },
    
};
</script>

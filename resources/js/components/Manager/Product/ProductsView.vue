<template>
    <div >
        <v-card
            v-for="item in products " :key="item.id"
            class="mx-auto my-4"
        >
            <span class="d-none">{{ item.show = false }}</span>
            <span class="d-none">{{ item.menu = false }}</span>
            <span class="d-none">{{ item.edit = false }}</span>
            <span class="d-none">{{ item.delete = false }}</span>

            <v-img
            :src="`/`+item.image"
            height="300px"
            cover
            >
            <v-layout full-height>
            <v-app-bar
              density="comfortable"
              color="rgba(0, 0, 0, 0)"
              flat   
            >

            <v-app-bar-title style="color:white">
                {{ item.name }}
              </v-app-bar-title>


              <template v-slot:append>
                    <v-menu
                    v-if="item.user_id == user_id"
                    :close-on-content-click="true"
                    v-model="item.menu"
                    >
                    <template v-slot:activator="{ props }">
                        <v-btn icon  v-bind="props" color="white">
                            <v-icon >mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>

                    <v-list >
                        <v-list-item>
                        <v-list-item-text>
                            <v-btn @click="item.edit  = !item.eidt ">
                                Edit <v-icon class="ml-2" size="xl-sm">mdi-pencil</v-icon>
                            </v-btn>
                             
                        </v-list-item-text>
                        </v-list-item>

                        <v-list-item>
                        <v-list-item-text>
                            <v-btn @click="item.delete = !item.delete"  >
                                Delete <v-icon class="ml-2" size="xl-sm">mdi-delete</v-icon>
                            </v-btn>
                        </v-list-item-text>
                        </v-list-item>

                    </v-list>
                    </v-menu>
                     <ProductEdit :dialog='item.edit' :product="item" @edited="Edited" @close="item.edit = false" />
                     <ProductDelete :dialog='item.delete'  @delete="Delete(item.id)" @close="item.delete = false" />

              </template>
            </v-app-bar>
          </v-layout>
          </v-img>
         
            <v-card-title>

                <v-avatar
                    size="40"
                    color="pink"
                >
                    {{ item.user.name[0] }} 
                </v-avatar>
                <span class="font-weight-bold text-body mx-2 "> {{ item.user.name }}</span>
                <v-chip >{{ item.category.name }} </v-chip>
                <v-chip class="mx-1">${{ item.price }} </v-chip>
                
            </v-card-title>

            <v-card-subtitle>
  
                

            </v-card-subtitle>

        </v-card>
        <v-snackbar
            v-model="message.open"
            :color="message.color"
            variant="tonal"
            :timeout="4000"
        >
            {{ message.text }}
        </v-snackbar>
    </div>
</template>


<script>
import ProductEdit from './ProductEdit.vue';
import ProductDelete from './ProductDelete.vue';

export default {
    data(){
        return {
            message:{
                open:false,
                color:"",
                text:""
            },
            products:{},
            user_id:localStorage.getItem('user_id')
        }
    },
    methods:{
        GetProducts(){
            axios.post(`/api/manager/product/get`,{user_id:this.user_id}).then((res) => {
                this.products = res.data;
            })
        },
        Edited(){
            this.message.open = true;
            this.message.text = "Successfully Edited!";
            this.message.color = "success";
            this.GetProducts();
        },
        Delete(id){
            const form = {
                user_id:this.user_id,
                product_id:id
            };
            axios.post(`/api/manager/product/delete`,form).then((res) => {
                this.message.open = true;
                this.message.text = "Successfully Deleted!";
                this.message.color = "success";
                this.GetProducts();
            })
        }
    },
    mounted(){
        this.GetProducts();
    },
    components:{ProductEdit,ProductDelete}
}
</script>
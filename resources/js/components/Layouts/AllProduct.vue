<template>
    <v-card class="col-12 overflow-auto" height="500">
        <v-card-title >
            Products
        </v-card-title>
        <v-card-text>
            <div v-show="true" class="row col-12 justify-content-center">
              <v-card class="col-md-3 mx-3 my-5 mx-5 " v-for="(item,i) in products" :key="i" >


                <v-img
                  height="300px" cover
                  :src="`/`+item.image"
                >
                    <v-layout full-height>
                        <v-app-bar
                        density="comfortable"
                        color="rgba(0, 0, 0, 0)"
                        flat
                        theme="white"
                        >


                          <template v-slot:append>
                                <v-menu
                                :close-on-content-click="true"
                                v-model="item.menu"
                                >
                                <template v-slot:activator="{ props }">
                                    <v-btn icon  v-bind="props" color="white">
                                        <v-icon >mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>

                                <v-list class="bg-white">
                                    <v-list-item>
                                    <v-list-item-text>
                                        <v-btn flat @click="$emit('ProductReport',item.id,)" >
                                            Report <v-icon class="ml-2" size="xl-sm">mdi-alert</v-icon>
                                        </v-btn>
                                        
                                    </v-list-item-text>
                                    </v-list-item>

                                    <v-list-item>
                                    <v-list-item-text>
                                        <v-btn   flat @click="$emit('ProductFeedback',item.id)" >
                                            Feedback <v-icon class="ml-2" size="xl-sm">mdi-information</v-icon>
                                        </v-btn>
                                    </v-list-item-text>
                                    </v-list-item>

                                </v-list>
                                </v-menu>

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
                  <span class="font-weight-bold text-body mx-2 "> {{ item.name }}</span>
                </v-card-title>

                <v-card-text>
                  <v-row
                    align="center"
                    class="mx-0"
                  >
                    <v-rating
                      :value="4.5"
                      color="amber"
                      dense
                      half-increments
                      readonly
                      size="14"
                    ></v-rating>
                  </v-row>

                  <v-row align="center" class="mx-0">
                    <div class="my-4 text-subtitle-1">
                      $ • {{ item.price }}.00
                    </div>
                    <v-chip class="mx-3 ">
                      {{ item.category.name  }}
                    </v-chip>
                  </v-row>

                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="deep-purple lighten-2"
                    text
                    @click="Order(item.id)"
                  >
                    Order <v-icon>mdi-cart</v-icon>
                  </v-btn>
                </v-card-actions>
              </v-card>

            </div>
        </v-card-text>
          <v-snackbar
            v-model="message.open"
            :color="message.color"
            variant="tonal"
            :timeout="4000"
          >
              {{ message.text }}
          </v-snackbar>
    </v-card>
</template>

<script>
export default {
    data(){
        return {
            products:{},
            message:{
                open:false,
                color:"",
                text:""
            },
        }
    },
    methods:{
        getProducts(){
            axios.post(`/api/products`).then((res) => {
                this.products = res.data;
            })
        },
        Order(id){
        if(localStorage.getItem('user_id') != null){
          const form = {
            user_id:localStorage.getItem('user_id'),
            product_id:id,
          }
          axios.post(`/api/order`,form).then((res) => {
            if(res.data == true){
              this.message.open = true;
              this.message.color = "success";
              this.message.text = "Your Order Sented!";
            }
          })
        }else {
          this.$route.push(`/login`);
        }
      }
    },
    mounted(){
        this.getProducts();
    }
}
</script>
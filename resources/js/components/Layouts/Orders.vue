<template>
    <v-card class="col overflow-auto py-5 px-5 " height="500">
        <v-card-title >
            <v-row>
                <span class="text-h3  font-weight-bold">
                    Orders {{ orders.length }}
                </span> 
                <v-spacer></v-spacer> 
                <span>total: $ • {{ total }} </span>
            </v-row>
        </v-card-title>
        <v-card-text>
            <div v-show="true" class="row col-12 justify-content-center">
              <v-card class="col-md-3 mx-3 my-5 mx-5 " v-for="(item,i) in orders" :key="i" >
                <span class="d-none"> {{ item.menu }} </span>
                <v-img
                  height="300px" cover
                  :src="`/`+item.product.image"
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
                                        <v-btn flat @click="$emit('ProductReport',item.product.id)" >
                                            Report <v-icon class="ml-2" size="xl-sm">mdi-alert</v-icon>
                                        </v-btn>
                                        
                                    </v-list-item-text>
                                    </v-list-item>

                                    <v-list-item>
                                    <v-list-item-text>
                                        <v-btn   flat @click="$emit('ProductFeedback',item.product.id)" >
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
                      {{ item.product.user.name[0] }} 
                  </v-avatar>
                  <span class="font-weight-bold text-body mx-2 "> {{ item.product.name }}</span>
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
                      $ • {{ item.product.price }}.00
                    </div>
                    <v-chip class="mx-3 ">
                      {{ item.product.category.name  }}
                    </v-chip>
                  </v-row>

                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="red lighten-2"
                    text
                    @click="cancelOrder(item.id,id)"
                  >
                    Cancel <v-icon>mdi-cart-remove</v-icon>
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
            orders:{},
            total:0,
            message:{
                open:false,
                color:"",
                text:""
            },
        }
    },
    methods:{
        getOrders(){
            axios.post(`/api/orders`).then((res) => {
                this.orders = res.data;
                var total = 0 ; 
                this.orders.forEach(item => {
                    total +=  parseInt(item.product.price)
                });
                this.total=  0;
                this.total = total;
            });
        },
        cancelOrder(id,index){
            axios.post(`/api/orders/cancel`,{product_id:id}).then((res) => {
                if(res.data == true) {
                    this.message.open= true;
                    this.message.color = "success";
                    this.message.text = "Done!";
                    this.getOrders();
                }
            })
        }
    },
    mounted(){
        if(localStorage.getItem('user_id') == null){
            this.$route.push(`/login`);
        }
        this.getOrders();
    }
}
</script>
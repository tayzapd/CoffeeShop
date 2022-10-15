<template>
    <v-card v-for="(item,id) in orders" :key="id" class="my-2 py-5">
            <span class="d-none">{{ item.reveal = false }} </span>
           
            <v-card-title class="d-flex flex-row" >
                <v-avatar
                    size="40"
                    color="red"

                >
                    {{ item.user.name[0]  }}
                </v-avatar>
                <span class="font-weight-bold ml-2 ">
                    {{ item.user.name  }}
                </span>

            </v-card-title>
            <v-card-subtitle>
                    Order from <strong> {{ item.user.email }} </strong>
            </v-card-subtitle>
            <v-divider></v-divider>
            <v-card-text>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="item.reveal = !item.reveal" class="text-info">view item</v-btn>
            </v-card-actions>
            <v-fade-transition>
                    <v-card
                        v-show="item.reveal"
                        class="v-card--reveal"
                        style="height: 100%;"
                    >
                        <v-img
                        :src="`/`+item.product.image"
                        height="200px"
                        cover
                        >
                        <v-layout full-height>
                        <v-app-bar
                        density="comfortable"
                        color="rgba(0, 0, 0, 0)"
                        flat   
                        >

                        <v-app-bar-title style="color:white">
                            {{ item.product.name }}
                        </v-app-bar-title>


                        
                        </v-app-bar>
                    </v-layout></v-img>
                    
                        <v-card-title class="d-flex flex-row">

                            <v-avatar
                                size="40"
                                color="pink"
                            >
                                {{ item.user.name[0] }} 
                            </v-avatar>
                            <span class="font-weight-bold text-body mx-2 "> {{ item.product.user.name }}</span>
                            <v-chip class="mx-1">${{ item.product.price }} </v-chip>
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                flat
                                size="small"
                                icon="mdi-close"
                                @click="item.reveal = false"
                            >
                            </v-btn>
                        </v-card-title>

                        
                    </v-card>
            </v-fade-transition>
        </v-card>
</template>


<script>
export default {
    data(){
        return {
            orders:{}
        }
    },
    methods:{
        getOrders(){
            axios.post(`/api/manager/order/get`,{user_id:localStorage.getItem('user_id')}).then((res) => {
                this.orders = res.data;
            });
        }
    },
    mounted(){
        this.getOrders();
    }
}
</script>
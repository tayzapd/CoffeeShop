<template>
    <div class="d-flex flex-row col-12 my-5 ">
        <v-card class="col-md-4  mx-auto h-100 col-sm-12"  >
            <v-sheet
                rounded
                class="mx-auto px-3 py-3 "
                height="100">
                <h3>Manager Dashboard </h3>
                <v-subheader dark inset light> @Manager </v-subheader>
            </v-sheet>
            <!-- Manager Expasion Panel  -->
            <v-expansion-panels>
                <v-expansion-panel
                    v-for="(item,i) in lists"
                    :key="i">
                    <v-expansion-panel-title>
                        <v-icon class="mx-2 ">{{ item.icon }}</v-icon> {{ item.name }} 
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                        <v-chip class="my-1 ml-1" v-for="(link,i) in item.links" :key="i" @click="$router.push(`${link.path}`)">
                        <v-icon class="mx-1">{{ link.icon }}</v-icon> {{ link.name }} 
                        </v-chip>
  
                        
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-card>   

        <v-card class="col-md-8  col-xs-12 mx-5 overflow-auto" height="90vh"  >
            <v-card-title primary-title>
                {{ $route.name }}
            </v-card-title>

            <v-card-text>
            <router-view v-slot="{ Component, route }" height="100vh"  >
                   <v-fade-transition>
                        <component :is="Component" :key="route.path" />
                   </v-fade-transition>
            </router-view>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data(){
        return {
            user:{},
            lists:[
                {
                    name:"Home",
                    icon:"mdi-home",
                    links:[
                        {path:`/`,name:"Home",icon:"mdi-home"},
                        {path:`/manager/`,name:"Dashboard",icon:"mdi-view-dashboard"}
                    ]
                },
                {
                    name:"Role",
                    icon:"mdi-account-group",
                    links:[
                        {path:`/manager/role/manager`,name:"Manager",icon:"mdi-account-tie"},
                        {path:`/manager/role/waiter`,name:"Waiter",icon:"mdi-account"},
                        {path:`/manager/role/customers`,name:"Customers",icon:"mdi-account-supervisor"},
                        {path:`/manager/role/`,name:"Setting",icon:"mdi-cog"}
                    ]
                },
                {
                    name:"Products",
                    icon:"mdi-food-fork-drink",
                    links:[
                        {path:`/manager/categories/`,name:"Categories",icon:"mdi-pasta"},
                        {path:`/manager/products/`,name:"Products",icon:"mdi-package-variant-closed"},
                    ]
                },
                    {
                    name:"Message From Coustumer",
                    icon:"mdi-forum",
                    links:[
                        {path:`/manager/reports`,name:"Reports",icon:"mdi-message-alert"},
                        {path:`/manager/feedbacks`,name:"Feedbacks",icon:"mdi-information"},
                        {path:`/manager/orders`,name:"Orders",icon:"mdi-email-fast"},
                    ]
                },
                
            ],

        }
    },
    methods:{
        getUser(){
            axios.get(`/api/user`).then((res) => {
                this.user = res.data;

            })
        }
    },
    mounted(){
    }
}
</script>
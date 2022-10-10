<template>
    <v-list>
        <v-divider></v-divider>
        <v-list-item>
            <v-list-tile>
                <h5 class="text-h5">Create A New Category
                    <v-btn fab icon flat size="small" @click="create = !create">
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </h5>
                <div class="header-body d-flex justify-center align-center">
                    <v-fade-transition>
                        <v-text-field
                            v-show="create"
                            v-model="name"
                            class="col-8"
                            label="Category Name "
                            variant="solo"
                            single-line
                            size="small"
                            clearable
                            @keyup.enter="Create"
                        ></v-text-field>
                    </v-fade-transition>
                </div>
            </v-list-tile>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item>
            <v-list-tile>
                <h5 class="text-h5">
                    Categories 
                    <v-btn size="small" fab flat icon @click="cate_show = !cate_show ">
                        <v-icon v-if="cate_show == false">mdi-eye</v-icon>
                        <v-icon v-if="cate_show == true">mdi-eye-off</v-icon>
                    </v-btn>
                </h5>
                <v-fade-transition>
                    <div class="container" v-show="cate_show" >
                      <v-timeline class="">
                        <v-timeline-item  size="large" v-for="(item,id) in categories" :key="id">
                        <template v-slot:icon>
                            <v-avatar
                                color="indigo"
                                size="40">
                                <span class="white--text text-h5">{{ item.user.name[0] }}</span>
                            </v-avatar>
                        </template>
                        <template v-slot:opposite>
                            <span>@{{ item.user.name }}</span>
                        </template>
                        <v-card class="elevation-1 rounded-pill col-12" >
                            <span class="d-none">{{ item.show = false }}</span>
                            <span class="d-none">{{ item.menu = false }}</span>
                            <span class="d-none">{{ item.delete = false }}</span>
                            <v-card-text class="d-flex flex-row" @mouseover="item.show = true" @mouseleave="item.show = false" >
                                
                                <span class="font-weight-bold">{{ item.name  }}</span> 
                                <v-spacer></v-spacer>
                                
                                <span> 
                                    <v-menu
                                    v-model="item.menu"
                                    :close-on-content-click="false"
                                    @mouseover="item.show = true"
                                    location="end"
                                    >
                                    <template v-slot:activator="{ props }">
                                        <v-fab-transition>
                                            <v-btn
                                            v-bind="props"
                                                flat
                                                size="xl-small"
                                                bottom
                                                right
                                                absolute
                                                v-show="item.show"
                                            >
                                                <v-icon>mdi-pencil</v-icon>
                                            </v-btn>
                                            
                                        </v-fab-transition>
                                    </template>

                                    <v-card min-width="300">
                                        <v-list>
                                            <v-list-item>
                                                <v-list-item-title class="text-h5">
                                                    Edit Category 
                                                </v-list-item-title>
                                            </v-list-item>
                                        </v-list>

                                        <v-divider></v-divider>

                                        <v-card-text>
                                            <v-text-field
                                            variant="solo"
                                                v-model="item.name"
                                                label="Category Nmae "
                                                single-line
                                            ></v-text-field>
                                        </v-card-text>

                                        <v-card-actions>
                                        <v-spacer></v-spacer>

                                        <v-btn
                                            text
                                            @click="item.menu = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            color="primary"
                                            text
                                            @click="Edit(item.id,item.name)"
                                        >
                                            Save
                                        </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                    </v-menu>
                                    
                                    <v-menu
                                    v-model="item.delete"
                                    :close-on-content-click="false"
                                    @mouseover="item.show = true"
                                    location="end"
                                    >
                                    <template v-slot:activator="{ props }">
                                    <v-fab-transition>
                                        <v-btn
                                            v-bind="props"
                                            flat
                                            size="xl-small"
                                            bottom
                                            right
                                            absolute
                                            v-show="item.show"
                                        >
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                        
                                    </v-fab-transition>
                                    </template>

                                    <v-card min-width="300">
                                        <v-list>
                                            <v-list-item>
                                                <v-list-item-title class="text-h5">
                                                    Delete Category 
                                                </v-list-item-title>
                                            </v-list-item>
                                        </v-list>

                                        <v-divider></v-divider>

                                        <v-card-text>
                                            Are You Seure To Delete 
                                                <span class="font-weight-bold">
                                                    {{ item.name }}    
                                                </span> 
                                            Category
                                        </v-card-text>

                                        <v-divider></v-divider>
                                        <v-card-actions>
                                        <v-spacer></v-spacer>

                                        <v-btn
                                            text
                                            @click="item.menu = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            color="red"
                                            text
                                            @click="Delete(item.id)"
                                        >
                                            Delete
                                        </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                    </v-menu>
                                </span>
                            </v-card-text>
                            
                        </v-card>
                        </v-timeline-item>
                    </v-timeline>
                </div>
                </v-fade-transition>
            </v-list-tile>
        </v-list-item>
        <v-divider></v-divider>
        <v-snackbar
            v-model="message.open"
            :color="message.color"
            variant="tonal"
            :timeout="4000"
        >
            {{ message.text }}
        </v-snackbar>
    </v-list>
</template>

<script>
export default {
    data(){
        return {
            message:{
                open:false,
                color:"",
                text:""
            },
            create:false,
            cate_show:false,
            categories:{},
            user:{},
            data:{
                user_id:localStorage.getItem('user_id'),
            },
            name:'',

        }
    },
    methods:{
        getUser(){
            axios.get(`/api/user`).then((res) => {
                this.user = res.data;
            });
        },
        getCategories(){
            axios.post(`/api/manager/category/get`,this.data).then((res) => {
                this.categories = res.data;
            })
        },
        Create(){
            const data = {
                user_id:localStorage.getItem('user_id'),
                name:this.name

            };
            axios.post(`/api/manager/category/create`,data).then((res) => {
                if(res.data == true){
                    this.message.open = true;
                    this.message.text = "Successfully Created A New Category!";
                    this.message.color = "success";
                    this.getCategories();
                }
            })
        },
        Edit(id,name){
            const data  = {
                id:id,
                name:name,
                user_id:localStorage.getItem('user_id')
            }
            axios.post(`/api/manager/category/edit`,data).then((res) => {
                 if(res.data == true){
                    this.message.open = true;
                    this.message.text = "Successfully Edited Category!";
                    this.message.color = "success";
                    this.getCategories();
                }
            })
        },
        Delete(id){
            const data  = {
                id:id,
                user_id:localStorage.getItem('user_id')
            }
            axios.post(`/api/manager/category/delete`,data).then((res) => {
                 if(res.data == true){
                    this.message.open = true;
                    this.message.text = "Successfully Deleted Category!";
                    this.message.color = "success";
                    this.getCategories();
                }
            })
        }
    },
    mounted(){
        this.getUser();
        this.getCategories();
        
    }
}
</script>

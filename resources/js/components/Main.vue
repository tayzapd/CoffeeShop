<template>
    <v-app>
        <v-toolbar color="black" class="sticky-top" style=" position: sticky"  >
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-divider vertical color="white"></v-divider>
            <v-toolbar-title id="NavHeader" @click="$router.push(`/`)">
                Coffee <span class="text-primary">.Shop</span>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn text class="text-capitalize" @click="$router.push(`/login`)" v-if="token == null">Login</v-btn>
            <v-divider vertical color="white"></v-divider>
            <v-btn text class="text-capitalize"  @click="$router.push(`/register`)" v-if="token == null">Register</v-btn>

          <v-navigation-drawer
            v-model="drawer"
            temporary
        >
            <v-list-item class="my-3" v-if="token != null">
            <v-list-tile avatar >
                <v-avatar
                    color="indigo"
                    size="50">
                    <span class="white--text text-h5">{{ user.name[0] }}</span>
                </v-avatar>
            </v-list-tile >
            <v-list-tile class="mx-2 " avatar >
                {{ user.name }}
            </v-list-tile>
            </v-list-item>

            <v-divider></v-divider>

            <v-list density="compact" nav>
            <v-list-item prepend-icon="mdi-home" title="Home" @click="$router.push(`/`)"></v-list-item>
            <v-list-item prepend-icon="mdi-view-dashboard" title="Manager Dashboard" v-if="role == `manager`" @click="$router.push(`/manager/`)"></v-list-item>
            <v-list-item prepend-icon="mdi-package-variant-closed" title="Products" @click="$router.push(`/products`)"></v-list-item>
            <v-list-item prepend-icon="mdi-cart"  v-if="token != null" title="Orders" @click="$router.push(`/orders`)"></v-list-item>
            <v-list-item prepend-icon="mdi-forum" title="About" @click="$router.push(`/about`)" ></v-list-item>
            </v-list>

            <template v-slot:append v-if="token != null">
            <div class="pa-2">
                <v-btn block  flat @click="Logout" class="text-capitalize">
                Logout <v-icon>mdi-door-open</v-icon>
                </v-btn>
            </div>
            </template>
        </v-navigation-drawer>
           
        </v-toolbar>

      
      <div style="weight:111;height:100vh " @click="drawer = false" 
        :class="$route.name == 'Home' ? ' ':'container d-flex justify-center align-center  '" id="main" >
            <router-view v-slot="{ Component, route }" 
                
                @login="Login" 
                @ProductReport="ProductReport"  @ProductFeedback="ProductFeedback" 
                @CategoryReport="CategoryReport"  @CategoryFeedback="CategoryFeedback" 
            >
                   <v-fade-transition>
                        <component :is="Component" :key="route.path"  />
                   </v-fade-transition>
            </router-view>
      </div>
    

        <!-- Dialog  -->
        <v-dialog
            v-model="form.dialog"
            min-width="500px"
            max-width="800px"
            transition="fade-transition"
        >
            <v-card>
                <v-card-title >
                    {{ form.title }} 
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-textarea
                        counter="200"
                        v-model="form.content"
                        label="Content"
                        ></v-textarea>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="info" @click="this.form.fun(form.item_id,form.content,true)">
                        Submit 
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-snackbar
            v-model="message.open"
            :color="message.color"
            variant="tonal"
            :timeout="4000"
          >
              {{ message.text }}
        </v-snackbar>
    </v-app>
</template>

<script>
    export default {
        data(){
            return {
                role:'',
                drawer:false,
                user:{name:''},
                token:localStorage.getItem('token'),
                form:{
                    dialog:false,
                    item_id:null,
                    content:'',
                    fun:null
                },
                message:{
                    open:false,
                    color:"",
                    text:""
                },
            }
        },
        methods:{
            FullWeight(){
                if($route.name == "Home"){
                    document.querySelector('#main').className = "container-fluid col-12  ";
                }
            },
            Login(token){
                localStorage.setItem('token',token);
                this.token = token;
                axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
                this.User();
            },
            Logout(){
                localStorage.removeItem('token');
                localStorage.removeItem('user_id');
                this.token = null;
                this.role = null;
                axios.defaults.headers['Authorization'] = null;
            },
            User(){
                if(localStorage.getItem('token') != null){
                   axios.get(`/api/user`).then((res) => {
                       this.user = res.data;
                       localStorage.setItem('user_id',this.user.id);
                       this.Check();
                   }) 
                }
            },
            ProductReport(id,content,dialog=false){
                if(dialog == false){
                    this.form.dialog = true;
                    this.form.fun = this.ProductReport;
                    this.form.item_id = id;
                    this.form.title = "Product Report";
                }else {
                    if(localStorage.getItem('token') != null){
                        const form = {
                            user_id:localStorage.getItem("user_id"),
                            item_id:id,
                            content:this.form.content,
                        }
                        axios.post(`/api/product/report`,form).then((res) => {
                            if(res.data == true){
                                this.form.dialog = false;
                                this.form.content = '';
                                this.message.open = true;
                                this.message.color = "success";
                                this.message.text = "Process Successfully!";
                            }
                        })
                    }else {
                        this.$router.push(`/login`);
                    }
                }
            },
            ProductFeedback(id,content,dialog=false){
                if(dialog == false){
                    this.form.dialog = true;
                    this.form.fun = this.ProductFeedback;
                    this.form.item_id = id;
                    this.form.title = "Product Feedback";
                }else {
                    if(localStorage.getItem('token') != null){
                        const form = {
                            user_id:localStorage.getItem("user_id"),
                            item_id:id,
                            content:content,
                        }
                        axios.post(`/api/product/feedback`,form).then((res) => {
                            if(res.data == true){
                                this.form.dialog = false;
                                this.form.content = '';
                                this.message.open = true;
                                this.message.color = "success";
                                this.message.text = "Process Successfully!";
                            }
                        });
                    }else {
                        this.$router.push(`/login`);
                    }
                }
            },
            CategoryReport(id,content,dialog=false){
                if(dialog == false){
                    this.form.dialog = true;
                    this.form.fun = this.CategoryReport;
                    this.form.item_id = id;
                    this.form.title = "Category Report";
                }else {
                    if(localStorage.getItem('token') != null){
                        const form = {
                            user_id:localStorage.getItem("user_id"),
                            item_id:id,
                            content:content,
                        }
                        axios.post(`/api/category/report`,form).then((res) => {
                            if(res.data == true){
                                this.form.dialog = false;
                                this.form.content = '';
                                this.message.open = true;
                                this.message.color = "success";
                                this.message.text = "Process Successfully!";
                            }
                        })
                    }else {
                        this.$router.push(`/login`);
                    }
                }
            },
            CategoryFeedback(id,content,dialog=false){
                if(dialog == false){
                    this.form.dialog = true;
                    this.form.fun = this.CategoryFeedback;
                    this.form.item_id = id;
                    this.form.title = "Category Feedback";
                }else {
                    if(localStorage.getItem('token') != null){
                        const form = {
                            user_id:localStorage.getItem("user_id"),
                            item_id:id,
                            content:content,
                        }
                        axios.post(`/api/category/feedback`,form).then((res) => {
                            if(res.data == true){
                                this.form.dialog = false;
                                this.form.content = '';
                                this.message.open = true;
                                this.message.color = "success";
                                this.message.text = "Process Successfully!";
                            }
                        });
                    }else {
                        this.$router.push(`/login`);
                    }  
                }  
            },
            async Check(){
                var man = await axios.post(`/api/check-manager`,{user_id:localStorage.getItem('user_id')}).then(res => res.data);
                if(man == true) return this.role = "manager";
            },
        },
        mounted() {
           this.User();
           
        }
    }
</script>


<style>
#NavHeader { font-family: Antic; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; }

</style>
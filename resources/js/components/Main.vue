<template>
    <v-app>
        <v-toolbar color="black">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-divider vertical color="white"></v-divider>
            <v-toolbar-title id="NavHeader" @click="$router.push(`/`)">
                Coffee <span class="text-primary">.Shop</span>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn text class="text-capitalize" @click="$router.push(`/login`)" v-if="token == null">Login</v-btn>
            <v-divider vertical color="white"></v-divider>
            <v-btn text class="text-capitalize"  @click="$router.push(`/register`)" v-if="token == null">Register</v-btn>


           
        </v-toolbar>

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
      <v-main style="height: 100vh;weight:100vh " class="container col-md-8 col-sm-12 my-5">
            <router-view v-slot="{ Component, route }" @login="Login" transition="slide-x-transition">
                    <component :is="Component" :key="route.path" />
            </router-view>

      </v-main>
            
    </v-app>
</template>

<script>
    export default {
        data(){
            return {
                role:'',
                drawer:false,
                user:{name:''},
                token:localStorage.getItem('token')
            }
        },
        methods:{
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
<template>
    <div>
        <v-btn class="mx-3 my-3 " tile @click="dialog = !dialog " >
          Add 
          <v-icon class="ml-1">mdi-plus</v-icon>
        </v-btn>
        <!-- Role Create Dialog   -->
          <v-dialog
            v-model="dialog"
            width="500"
            >


            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                Add A New Manager 
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                        <v-autocomplete
                            v-model="form.id"
                            :items="users"
                            item-title="name"
                            item-value="id"
                            dense
                            variant='solo'
                            label="Choice People"
                        ></v-autocomplete>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="primary"
                    text
                    @click="addManager"
                >
                    Create 
                </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
        <v-table
            fixed-header
            height="300px"
        >
            <thead>
            <tr>
                <th class="text-left">
                # ID
                </th>
                <th class="text-left">
                Name 
                </th>

                <th class="text-left">
                Actions  
                </th>


            </tr>
            </thead>
            <tbody>
            <tr
                v-for="item in managers"
                :key="item.name"
            >
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>
      

                    <v-btn size="small"   color="red" @click="delManager(item.id)" >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </td>


            </tr>
            </tbody>
        </v-table>
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
export default {
    data(){
        return {
            dialog:false,
            message:{
                open:false,
                color:"",
                text:""
            },
            items:['1','2','3'],
            form:{
                id:''
            },
            users:{},
            rules: [
                value => !!value || 'Required.',
                value => (value && value.length >= 3) || 'Min 3 characters',
            ],
            managers:{},
            user:{},
        }
    },
    methods:{
        getUser(){
            axios.get(`/api/user`).then((res) => {
                this.user = res.data;
            })
        },
        getManagers(){
            axios.post(`/api/manager/role/get/managers`,{user_id:localStorage.getItem('user_id')}).then((res) => { 
                this.managers = res.data;
            })
        },
        addManager(){
            axios.post(`/api/manager/role/add/manager`,{
                user_id:localStorage.getItem('user_id'),
                id:this.form.id
            }).then((res) => {
                if(res.data == true){
                    this.getManagers();
                    this.dialog = false;
                    this.message.open = true;
                    this.message.color = "success"
                    this.message.text = "Successfully Added Manager!"
                }else {

                }
            })
        },
        delManager(id){
            axios.post(`/api/manager/role/delete/manager`,{
                user_id:localStorage.getItem('user_id'),
                id:id
            }).then((res) => {
                if(res.data == true){
                    this.getManagers();
                    this.dialog = false;
                    this.message.open = true;
                    this.message.color = "success"
                    this.message.text = "Successfully Delete Manager!"
                }else {

                }
            })
        },
        getUsers(){
            axios.post(`/api/manager/role/get/all`,{user_id:localStorage.getItem('user_id')}).then((res) => {
                this.users = res.data;
            })
        }
    },
    mounted(){
        this.getUsers();
        this.getUser();
        this.getManagers();
    }
}
</script>
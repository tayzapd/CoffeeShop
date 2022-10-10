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
                Create A New Role 
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                        <v-text-field
                            clearable
                            :rules='rules'
                            label="Name..."
                            v-model="form.name"
                            single-line
                            variant="solo"
                        ></v-text-field>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="primary"
                    text
                    @click="Create"
                >
                    Create 
                </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>

            <!-- Role Edit Dialog  -->
            <v-dialog
            v-model="editlog"
            width="500"
            >


            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                Edit Role 
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                        <v-text-field
                            clearable
                            :rules='rules'
                            label="Name..."
                            v-model="form.name"
                            single-line
                            variant="solo"
                        ></v-text-field>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="success"
                    text
                    @click="SubmitEdit"
                >
                    Save  
                </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>

            <v-dialog
            v-model="delelog"
            persistent
            max-width="290"
            >

            <v-card>
                <v-card-title class="text-h5">
                Delete Role.
                </v-card-title>
                <v-card-text>
                    Are You Sure To Delete This Role? 
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="green darken-1"
                    text
                    @click="delelog = !delelog"
                >
                    Disagree
                </v-btn>
                <v-btn
                    color="green darken-1"
                    text
                    @click="Delete"
                >
                    Agree
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
            v-for="item in roles"
            :key="item.name"
        >
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>
                <v-btn size="small" class="mr-2"  color="info" @click="Edit(item.id,item.name)">
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>

                <v-btn size="small"   color="red" @click="Delelog(item.id)" >
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
            </td>


        </tr>
        </tbody>
    </v-table>
  </div>
</template>


<script>
export default {
    data(){
        return {
            user:{},
            editlog:false,
            delelog:false,
            dialog:false,
            roles:{},
            rules: [
                value => !!value || 'Required.',
                value => (value && value.length >= 3) || 'Min 3 characters',
            ],
            form:{
                role_id:'',
                user_id:localStorage.getItem('user_id'),
                name:''
            },
            
        }
    },
    methods:{
        async Check(){
            if(localStorage.getItem('token' == null)) return this.$router.push(`/login`);
            var man = await axios.post(`/api/check-manager`,{user_id:localStorage.getItem('user_id')}).then(res => res.data);
            if(man != true) return this.$router.push(`/login`);
        },
        GetRoles(){
            axios.post(`/api/manager/roles`,{user_id:localStorage.getItem('user_id')}).then((res) => {
                this.roles = res.data;
            })
        },
        getUser(){
            axios.get(`/api/user`).then((res) => {
                this.user = res.data;

            })
        },
        Create(){
            this.dialog = false;
            axios.post(`/api/manager/role/create`,this.form).then((res) => {
                if(res.data == true){
                    this.GetRoles();
                    this.form.name = '';
                    this.dialog = false;
                }
            })
        },
        Edit(id,name){
            this.form.role_id = id;
            this.form.name = name;
            this.editlog = true;
        },
        SubmitEdit(){
            axios.post(`/api/manager/role/edit`,this.form).then((res) => {
                if(res.data == true){
                    this.GetRoles();
                    this.form.name = '';
                    this.form.role_id = '';
                    this.editlog = false;
                }
            })
        },
        Delelog(id){
            this.form.role_id = id;
            this.delelog = true;
        },
        Delete(){
            axios.post(`/api/manager/role/delete`,this.form).then((res) => {
                if(res.data == true){
                    this.GetRoles();
                    this.form.role_id = '';
                    this.delelog = false;
                }
            })
        }
    },
    mounted(){
        this.getUser();
        this.Check();
        this.GetRoles();
    }
}
</script>
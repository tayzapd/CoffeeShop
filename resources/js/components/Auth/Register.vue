<template>
    <v-card >
        <v-card-media src="src" height="200px">
        </v-card-media>
        <v-card-title primary-title>
            <div>
                <h3 class="headline mb-0">Register</h3>
            </div>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
            <v-text-field
                name="name"
                label="Name"
                v-model="form.name"
            ></v-text-field>

            <v-text-field
                type="email"
                name="Email"
                label="Email"
                v-model="form.email"
            ></v-text-field>

            <v-text-field
                type="password"
                name="Password"
                label="Password"
                v-model="form.password"
            ></v-text-field>
        </v-card-text>
        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="submit">Submit</v-btn>
        </v-card-actions>
    </v-card>
</template>


<script>
export default {
    data(){
        return {
            form:{
                name:'',
                email:'',
                password:''
            }
        }
    },
    methods:{
        submit(){
            axios.post(`/api/register`,this.form).then((res) => {
                if(res.data == true ){
                    this.$router.push(`/login`)
                }
            })
        }
    }
}
</script>
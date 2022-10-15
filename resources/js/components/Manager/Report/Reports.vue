<template>
    <div>
        <v-card v-for="(item,id) in reports" :key="id" class="my-2 py-5">
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
                <v-spacer></v-spacer>
                <v-btn flat text size="small" class="text-danger"  @click="Remove(item.id)">
                    REMOVE
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                {{ item.content }}
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="item.reveal = !item.reveal" class="text-info">view item</v-btn>
            </v-card-actions>
            <v-fade-transition>
                    <v-card
                        v-if="item.reportable_type.includes('Product') == true"
                        v-show="item.reveal"
                        class="v-card--reveal"
                        style="height: 100%;"
                    >
                        <v-img
                        :src="`/`+item.reportable.image"
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
                            {{ item.reportable.name }}
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
                            <span class="font-weight-bold text-body mx-2 "> {{ item.reportable.user.name }}</span>
                            <v-chip class="mx-1">${{ item.reportable.price }} </v-chip>
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
                    <v-card
                    v-if="item.reportable_type.includes('Category') == true"
                        v-show="item.reveal"
                        class="transition-fade-in-fade-out v-card--reveal"
                        style="height: 50%;"
                    >
                         <v-card-title class="d-flex flex-row">

                            <v-avatar
                                size="40"
                                color="pink"
                            >
                                {{ item.user.name[0] }} 
                            </v-avatar>
                            <span class="font-weight-bold text-body mx-2 "> {{ item.reportable.user.name }}</span>
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
                        <v-card-text >
                        <p class="text-h6 text--primary">
                            <v-chip >
                                {{ item.reportable.name }}
                            </v-chip>
                        </p>
                        <p>

                        </p>
                        </v-card-text>
 
                    </v-card>
            </v-fade-transition>
        </v-card>
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
            reports:{},
            message:{
                open:false,
                color:"",
                text:""
            },
        }
    },
    methods:{
        getReports(){
            axios.post(`/api/manager/report/get`,{user_id:localStorage.getItem('user_id')}).then((res) => {
                this.reports  = res.data;
            });
        },
        Remove(id){
            const form = {
                report_id:id,
                user_id:localStorage.getItem('user_id')
            }
            axios.post(`/api/manager/report/remove`,form).then((res) => {
                if(res.data == true){
                    this.message.open = true;
                    this.message.color = "success";
                    this.message.text = "Successfuly Deleted!";
                    this.getReports();
                }
            })
        }
    },
    mounted(){
        this.getReports();
    }
}
</script>

<style>
.v-card--reveal {
  bottom: 0;
  position: absolute;
  width: 100%;
}
</style>
<template>
    <div>
        <v-card-text>
            {{ reports }}
        </v-card-text>
    </div>
</template>

<script>
export default {
    data(){
        return {
            reports:{},
        }
    },
    methods:{
        getReports(){
            axios.post(`/api/manager/report/get`,{user_id:localStorage.getItem('user_id')}).then((res) => {
                this.reports  = res.data;
            });
        }
    },
    mounted(){
        this.getReports();
    }
}
</script>
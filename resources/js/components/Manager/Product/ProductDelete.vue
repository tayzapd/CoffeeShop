<template>
    <v-dialog
      v-model="dialog"
      persistent
      max-height="500"
      max-width="500"
    >
      <v-card>
        <v-toolbar
        prominent
        >

        <v-toolbar-title>Are You Sure To Delete This Product ? </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon @click="$emit('close')">
            <v-icon>mdi-close</v-icon>
        </v-btn>
        </v-toolbar>                  
        <v-divider></v-divider>
          
        <v-card-text>
            If you deleted! It will be lost and you can't restore that!
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            text
            @click="$emit('delete')"
          >
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>



<script>
export default {
    props:['dialog'],
    data(){
        return {
        }
    }
}
</script>
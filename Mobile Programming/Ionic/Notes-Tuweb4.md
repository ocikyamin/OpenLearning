## Endpoint
```ts
import axios from 'axios'

export default class EndPointAccess{

    theUrl : string
    constructor (url:string){
        this.theUrl = url;
    }


    async getRes() {      
const response = await axios.get(this.theUrl); 
return response; 
} 

}

```

## HomePage.vue
```html

<template>
  <ion-page>
    <ion-header :translucent="true">
      <ion-toolbar>
        <ion-title>MyApp</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true" >
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Blank</ion-title>
        </ion-toolbar>
      </ion-header>

      <div id="container">
       <div>
         <strong>List Data</strong>
       </div>
        <ion-button @click="ambilData">
       <ion-icon :icon="refresh"></ion-icon> Refersh</ion-button>
        <hr>
        <table>
          <tr v-for="user in dataUsers" :key="user.id">
            <td>{{user.body}}</td>
          </tr>
        </table>



          <ion-loading :is-open="isLoading" message="Sedang Memuat Data..." spinner="circles"></ion-loading>

      </div>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import {refresh} from 'ionicons/icons';
import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar, IonItem,IonLabel, IonButton, IonLoading, IonIcon } from '@ionic/vue';
import { defineComponent } from 'vue'; 

import EndPointAccess from '@/Api'; 

let resData: any;  

export default defineComponent({
 name: 'Home', 
 data() { 
   return { 
     dataUsers: [],
     isLoading : false
   } 
 }, 
 methods: { 
   ambilData() {        
    this.isLoading = true;
    
     resData = new EndPointAccess('https://jsonplaceholder.typicode.com/posts/1/comments'); 
     resData.getRes().then((response: any)  =>{
      this.dataUsers = response.data
      console.log(response.data)
     }).finally(()=> {
      this.isLoading = false;
     }); 
  } 
}, 
 components: { 
   IonContent, 
   IonHeader, 
   IonPage, 
   IonTitle, 
   IonToolbar, 
   IonItem,
   IonLabel,
   IonButton,
   IonLoading,
   IonIcon
  }
  

});


</script>

<style scoped>
body {
}
#container {
  text-align: center;
  /* text-align: center;
  
  position: absolute; 
  /* left: 0;
  right: 0;
  top: 50%;
  transform: translateY(-50%); */
  background-color: var(--ion-background-color);

  margin-left: auto;
  margin-right: auto;
}

#container strong {
  font-size: 20px;
  line-height: 26px;
}

#container p {
  font-size: 16px;
  line-height: 22px;
  
  color: #8c8c8c;
  
  margin: 0;
}

#container a {
  text-decoration: none;
}
</style>
```

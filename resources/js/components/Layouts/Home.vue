<template >
    <div  >
        <section class="video-container row">
            <video autoplay loop playsinline muted>
                <source :src="`/sh/video1.mp4`">
            </video>
            <div class="callout">
                <h1 class="header-text" style="font-family: Antic;  font-variant: normal; font-weight: 700; ">Coffee Shop </h1>
            </div>
            <div class="support">
                <a >Browser Support</a><br>
                <a >Need to support IE &amp; Edge?</a>
            </div>
        </section>
        <v-divider></v-divider>
        <div class="row my-5 px-5  d-flex justify-content-center py-5 " id="coffee">
            <div class="col-md-5 mx-5 col-sm-12  ">
                <v-img :src="`/sh/coffee1.jpg`" class="rounded-3    ">

                 </v-img>
            </div>
            <div class="col-md-5 mx-5 col-sm-12 pt-3d coffee-textbox py-5 px-5 rounded-3">
                <h3>Why we shoud drink coffee ?</h3>
                <p class="px-5">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam, necessitatibus nesciunt quod magnam voluptatum doloribus esse assumenda. Temporibus voluptatibus ab suscipit ipsa quos repudiandae velit, harum voluptate. Temporibus, voluptatum quae? <br>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam, necessitatibus nesciunt quod magnam voluptatum doloribus esse assumenda. Temporibus voluptatibus ab suscipit ipsa quos repudiandae velit, harum voluptate. Temporibus, voluptatum quae? <br> <br>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nam, necessitatibus nesciunt quod magnam voluptatum doloribus esse assumenda. Temporibus voluptatibus ab suscipit ipsa quos repudiandae velit, harum voluptate. Temporibus, voluptatum quae? <br>
                </p>
            </div>
        </div>    
        <v-divider></v-divider>
        <div class="d-flex justify-content-center my-5 py-5   " id="product-header">
          <v-fade-transition>
            <div v-show="true">
              <h1 class="text-h2" style="text-decoration-line: underline;text-decoration-color: black; ">Products  </h1>
            </div>
          </v-fade-transition>
          <br><br>

        </div>
        <div class="sm-container d-flex justify-content-center align-item-center h-md-50" id="product">
          <v-slide-y-reverse-transition>
            <div v-show="true" class="row col-12 justify-content-center">
              <v-card class="col-md-3 mx-3 my-5 mx-5 " v-for="(item,i) in products" :key="i" >


                <v-img
                  height="300px" cover
                  :src="`/`+item.image"
                >
                    <v-layout full-height>
                        <v-app-bar
                        density="comfortable"
                        color="rgba(0, 0, 0, 0)"
                        flat
                        theme="white"
                        >


                          <template v-slot:append>
                                <v-menu
                                :close-on-content-click="true"
                                v-model="item.menu"
                                >
                                <template v-slot:activator="{ props }">
                                    <v-btn icon  v-bind="props" color="white">
                                        <v-icon >mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>

                                <v-list class="bg-white">
                                    <v-list-item>
                                    <v-list-item-text>
                                        <v-btn flat @click="$emit('ProductReport',item.id)" >
                                            Report <v-icon class="ml-2" size="xl-sm">mdi-alert</v-icon>
                                        </v-btn>
                                        
                                    </v-list-item-text>
                                    </v-list-item>

                                    <v-list-item>
                                    <v-list-item-text>
                                        <v-btn   flat @click="$emit('ProductFeedback',item.id)" >
                                            Feedback <v-icon class="ml-2" size="xl-sm">mdi-information</v-icon>
                                        </v-btn>
                                    </v-list-item-text>
                                    </v-list-item>

                                </v-list>
                                </v-menu>

                          </template>
                        </v-app-bar>
                    </v-layout>
                </v-img>

                <v-card-title>
                  <v-avatar
                      size="40"
                      color="pink"
                  >
                      {{ item.user.name[0] }} 
                  </v-avatar>
                  <span class="font-weight-bold text-body mx-2 "> {{ item.name }}</span>
                </v-card-title>

                <v-card-text>
                  <v-row
                    align="center"
                    class="mx-0"
                  >
                    <v-rating
                      :value="4.5"
                      color="amber"
                      dense
                      half-increments
                      readonly
                      size="14"
                    ></v-rating>
                  </v-row>

                  <v-row align="center" class="mx-0">
                    <div class="my-4 text-subtitle-1">
                      $ • {{ item.price }}.00
                    </div>
                    <v-chip class="mx-3 ">
                      {{ item.category.name  }}
                    </v-chip>
                  </v-row>

                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="deep-purple lighten-2"
                    text
                    @click="Order(item.id)"
                  >
                    Order <v-icon>mdi-cart</v-icon>
                  </v-btn>
                </v-card-actions>
              </v-card>

            </div>
          </v-slide-y-reverse-transition>
        </div>
        <v-divider></v-divider>
        <div class="d-flex justify-content-center my-5 py-5   " id="product-header">
          <v-fade-transition>
            <div v-show="true">
              <h1 class="text-h2" style="text-decoration-line: underline;text-decoration-color: black; ">Category  </h1>
            </div>
          </v-fade-transition>
          <br><br>

        </div>

        <div class="d-flex justify-content-center align-item-center" id="categories" >
          <v-timeline side="end">
              <v-timeline-item
                fill-dot
                v-for="item in categories" :key="item.id"
                class="white--text mb-12"
                dot-color="orange"
                size="large"
              >
                <template v-slot:icon>
                  <span class="font-weight-bold">{{ item.user.name[0]  }}  </span>
                </template>
                <v-card class="rounded-5">
                  <v-card-text>
                    {{ item.name  }}
                  </v-card-text>
                </v-card>
              </v-timeline-item>
          </v-timeline>
        </div>
        <v-divider></v-divider>
          <div class="d-flex justify-content-center my-5 py-5   " id="product-header">
          <v-fade-transition>
            <div v-show="true">
              <h1 class="text-h2" style="text-decoration-line: underline;text-decoration-color: black; ">Popular   </h1>
            </div>
          </v-fade-transition>
          <br><br>

        </div>
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div :class="id == 0 ? 'carousel-item active' : 'carousel-item '" v-for="(item,id) in images" :key="id">
              <v-img height="500" class="d-block w-100" cover :src="item.image" ></v-img>
            </div>

          </div>
        </div>
        <v-divider></v-divider>
        <!-- servies  -->
        <div id="service" cluass="container ml-4 mt-5 my-5 d-flex justify-content-center py-5 my-5 ">
          <!-- Title  -->
          <h3 class=" col d-flex justify-content-center text-h3 my-5 ">Services</h3>
          <!-- row box  -->
          <div class="my-3 row justify-content-center align-items-center mx-5 ">
            <!-- .......... -->
            <v-card class="col-md-5 col-sm-12 px-5 py-5 mx-2 mb-2 rounded-5 justify-content-center">
              <h2 class="col justify-content-center d-flex">
                Dilivery 
              </h2>
              <p >
                While there are national delivery services, such as USPS, FedEx and UPS, people often need packages delivered to nearby locations in a shorter timeframe than these services are able to provide. 
              </p>
            </v-card>


            <v-card class="col-md-5 col-sm-12 px-5 py-5 mx-2 mb-2  rounded-5 justify-content-center">
              <h2 class="col justify-content-center d-flex" >
            Secure Payment
              </h2>
              <p >
                While there are national delivery services, such as USPS, FedEx and UPS, people often need packages delivered to nearby locations in a shorter timeframe than these services are able to provide. 
              </p>
            </v-card>


            <v-card class="col-md-5 col-sm-12 px-5 py-5 mx-2 mt-3  rounded-5 justify-content-center">
              <h2 class="col justify-content-center d-flex" >
                Best Shipping 
              </h2>
              <p >
                While there are national delivery services, such as USPS, FedEx and UPS, people often need packages delivered to nearby locations in a shorter timeframe than these services are able to provide. 
              </p>
            </v-card>

          </div>
        <!-- rowbox end -->
        </div>
        <v-divider></v-divider>
          <v-footer class="bg-black">
            <v-row justify="center" no-gutters>
              <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatem officia exercitationem ullam error quam quis atque dicta? Quidem et consequatur beatae inventore unde eius aliquam. Veniam iusto et reiciendis animi.
              </p>
              <v-col class="text-center mt-4" cols="12">
                {{ new Date().getFullYear() }} — <strong>CoffeeSHop</strong>
              </v-col>
            </v-row>
          </v-footer>
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
        products:{},
        categories:{},
        images:{},
        message:{
            open:false,
            color:"",
            text:""
        },

      }
    },
    methods:{
      getHomeData(){
        axios.post(`/api/home-data`)
        .then(res => {
          this.products = res.data.products;
          this.categories = res.data.categories;
          this.images = res.data.images;
        })
        
      },
      Order(id){
        if(localStorage.getItem('user_id') != null){
          const form = {
            user_id:localStorage.getItem('user_id'),
            product_id:id,
          }
          axios.post(`/api/order`,form).then((res) => {
            if(res.data == true){
              this.message.open = true;
              this.message.color = "success";
              this.message.text = "Your Order Sented!";
            }
          })
        }else {
          this.$route.push(`/login`);
        }
      }
    },
    mounted(){
        ScrollReveal().reveal('#coffee',{ delay:200,});
        ScrollReveal().reveal('#product-header',{ delay:200,});
        ScrollReveal().reveal('#product',{ delay:200,});
        ScrollReveal().reveal('#category',{ delay:200,});
        ScrollReveal().reveal('#categories',{ delay:200,});
        ScrollReveal().reveal('#service',{ delay:200,});
        this.getHomeData();
    }
}
</script>


<style lang="scss">
#product  {
  font-family: Antic; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px;
}
.video-container {
  height: 70vh;
  position: relative;
  overflow: hidden;
  @media(min-width: 600px) {
    height: 70vh;
  }
}

video {
  object-fit: cover;
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
}

.header-text {
  color:white;
  text-transform: uppercase;
  font-weight: 900;
  margin: 0 0 1rem;
  padding: 0;
  line-height: 1;
  font-family: Futura, Helvetica, sans-serif;
  font-size: 5vw;
  @media (max-width: 400px) {
    font-size: 22px;
  }
  @media (min-width: 1200px) {
    font-size: 75px;
  }
}
.coffee_1 {
    position: relative;
  width: 50%;
}
.coffee1 {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.coffee_1:hover .image {
  opacity: 0.3;
}

.coffee-textbox{

	/*start ------------*/
	width: [object Object]px; 
	height: [object Object]px; 
	background: #F8F8F8; 
	border: solid #BDBDBD 0; 
	box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.5)  ; 
	-webkit-box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.5)  ; 
	-moz-box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.5)  ; 
}
.callout {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  height: 100%;
  text-align: center;
  position: relative;
  z-index: 10;
  font-family: Antic; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px;
}

.support,.callout {
  position: fixed;
  bottom: 60px;
  right: 20px;
  text-transform: uppercase;
  font-size: 9px;
  letter-spacing: 1px;
  text-align: right;
  position: relative;
  z-index: 10;
  a,.header-text {
    color: white;
    text-decoration: none;
    position: relative;
    display: inline-block;
    margin-top: 10px;
    &:before {
      display: block;
      position: absolute;
      content: '';
      bottom: -2px;
      width: 0;
      height: 1px;
      background-color: rgba(white, .3);
      transition: .3s;
      
    }
    &:hover:before {
      width: 100%;
    }
  }
}


</style>
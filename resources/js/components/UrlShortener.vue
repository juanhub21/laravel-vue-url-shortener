<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shortner">
                    <div class="section-heading text-center text-info">
                        <h1>URL Shortener</h1>
                        <br>
                        <br>
                        <div>
                            <form action="" class="form">
                                <div class="input-group">
                                    <input type="text" id="p1" placeholder="Put Url here"
                                     v-model="url" class="form-control
                                    addUrlInput">
                                </div>
                                <br>
                                <div>
                                    <button class="btn btn-dark"
                                    v-on:click.prevent='shortenUrl'>
                                        Process Url
                                    </button>
                                    <button class="btn btn-dark"
                                    v-on:click.prevent='trackClicks'>
                                    trackUrl Clicks
                                    </button>
                                </div>
                            </form>
                            <br>
                            <p v-if="!urlNotFound" class="alert alert-danger">
                                Url is not Valid
                            </p>
                            <div>
                                Total clicks of this url : {{totalClicks}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props:['AuthorizedUser'],
        data(){
            return {
                url:null,
                urlNotFound: true,
                totalClicks: 0,
                response:null,
            }
        },
        methods:{
            shortenUrl(){
                let self = this;
                let newUrl = self.url;
                let newArray = newUrl.split('//');
                let counter = 0;
                let resultNewUrl = Math.round((Math.pow(36,8) - Math.random() * Math.pow(36, 8))).toString(36).slice(1);


                for(let i = 0; i < newArray.length; i++){
                    if(newArray[i] == 'http:' || newArray[i] == 'https:'){
                        counter++;
                    }


                    if(counter == 0){
                        let newArrayOne = newUrl.split('.');
                        if(newArrayOne[i] == 'www'){
                            counter++;
                        }


                        let newArrayTwo = newUrl.indexOf('.com');
                        if(newArrayTwo >= 0){
                            counter++;
                        }
                    }


                    if(counter ==0){
                        self.urlNotFound = false;
                    }else{
                        let currentUrl = window.location.href+'yt/'+resultNewUrl;

                        axios.post('/url/shorten',{
                            url: newUrl,
                            shortlink: currentUrl
                        }).then(function(response){
                            self.response = response.data;
                            $("#p1").val(self.response);

                            console.log('url::::',self.response);
                        });
                    }
                }
            },
            trackClicks(){
                this.response = $("#p1").val()
                const url = this.response.split('/');
                axios.get('/clicks/' + url[url.length -1])
                .then((response) => {
                    this.totalClicks = response.data;
                    console.log('response', response.data)
                })
            }
        }
    }
</script>
<style scoped>
    .copyLink{
        display:none;
    }


    #clipBoard{
        display:block;
        margin-top: 28px;
        background-color: #03cbf8;
        color:#fff;
        font-weight: 900;
        font-size:17px;
    }


    #clipBoard:hover{
        background-color:#333;
    }


    #clipBoard:visited, #clipBoard:active, #clipBoard:focus{
        background-color:green;
        color:#333;
    }


</style>

<template>
    <div>

        <i @click="startRecognition()" class="fa fa-microphone"></i>

    </div>
</template>
<script>
    export default {
        props: ["voice_lang"],
        data() {
            return {

                lang: this.voice_lang,
                runtimeTranscription: '',
                transcription: [],
                recognition: null,
                word: 'Click on Mic to begin search',

            }
        },
        methods: {
            showAlert() {
                this.$swal({
                    showConfirmButton : false,
                    html : 
                        '<div class="mb-5"><div class="circle_ripple"></div>'+
                        '<div class="circle_ripple-2"></div>'+
                        '<div class="circle">'+
                            '<div class="circle-2">'+
                                '<i class="fa fa-microphone"></i>'+
                            '</div>'+
                        '</div>'+
                        '<div class="progress blue">'+
                            '<span class="progress-left">'+
                                '<span class="progress-bar"></span>'+
                            '</span>'+
                            '<span class="progress-right">'+
                                '<span class="progress-bar"></span>'+
                            '</span>'+
                        '</div></div>'+
                        '<p class="mt-6">'+this.word+'</p>'
                });
            },
            startRecognition() {
                this.word = 'Listening...';
                this.showAlert();
                this.checkApi();
                this.recognition.start();
            },
            stopRecognition() {
                this.recognition.stop();
                this.$swal.close();
                this.recognition = null;
            },
            checkApi() {

                window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

                if (!SpeechRecognition && "development" !== 'production') {
                    throw new Error('Speech Recognition does not exist on this browser. Use Chrome or Firefox');
                }
                if (!SpeechRecognition) {
                    console.log("No Speech Recognition");
                    return;
                }

                this.recognition = new SpeechRecognition();

                this.recognition.lang = this.lang;
                this.recognition.interimResults = true;
                this.recognition.addEventListener('result', event => {
                    const text = Array.from(event.results).map(result => result[0]).map(result => result
                        .transcript).join('');
                    this.runtimeTranscription = text;

                });
                this.recognition.addEventListener('end', () => {
                    if (this.runtimeTranscription !== '') {

                        this.transcription.push(this.runtimeTranscription);

                        this.word = this.runtimeTranscription;

                        this.$swal.close();

                        $("#v_search").autocomplete("search", this.word);

                        this.stopRecognition();     

                    } else {


                        this.word = 'Please try again !';
                        this.$swal.close();
                        this.stopRecognition();

                    }
                    this.runtimeTranscription = '';
                });
                this.recognition.onresult = function (event) {
                    var color = event.results[0][0].transcript;
                    // console.log(color);
                }
            }
        }
    }
</script>
<style>
    
    .circle_ripple {
        height: 50px;
        width: 50px;
        background: #36B37E;
        border-radius: 50%;
        -webkit-animation-name: ripple 2s infinite;
        animation: ripple 2s infinite;
        position: absolute;
        left: 0;
        right: 0;
        margin: 0 auto;
        top: 35px;
        z-index: 0
    }

    .circle_ripple-2 {
        height: 50px;
        width: 50px;
        background: #36B37E;
        border-radius: 50%;
        -webkit-animation-name: ripple 2s infinite;
        animation: ripple-2 2s infinite;
        position: absolute;
        left: 0;
        right: 0;
        margin: 0 auto;
        top: 35px;
    }

    @keyframes ripple {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(2);
            opacity: 0.3;
        }

        100% {
            transform: scale(1);

        }
    }

    @keyframes ripple-2 {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(2.5);
            opacity: 0.3;
        }

        100% {
            transform: scale(1);
        }
    }


    .circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #EAEAEA;
        position: absolute;
        left: 0;
        right: 0;
        margin: 0 auto;
        top: 30px;

    }

    .circle-2 {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #ffffff;
        position: absolute;
        left: 5px;
        top: 5px;
        box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.16);
        z-index: 2;
    }

    .circle-2 .fa {
        font-size: 20px;
        color: #A7A7A7;
        position: absolute;
        left: 18px;
        top: 17px
    }


    .progress {
        width: 60px;
        height: 60px;
        left: 0;
        right: 0;
        margin: 0 auto;
        top: 30px;
        background: none;
        box-shadow: none;
        position: absolute;
        z-index: 1;
    }

    .progress:after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 5px solid #e7e7e7;
        position: absolute;
        top: 0;
        left: 0;
    }

    .progress>span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .progress .progress-left {
        left: 0;
    }

    .progress .progress-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 5px;
        border-style: solid;
        position: absolute;
        top: 0;
    }

    .progress .progress-left .progress-bar {
        left: 100%;
        border-top-right-radius: 80px;
        border-bottom-right-radius: 80px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }

    .progress .progress-right {
        right: 0;
    }

    .progress .progress-right .progress-bar {
        left: -100%;
        border-top-left-radius: 80px;
        border-bottom-left-radius: 80px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
        animation: loading-1 1.8s linear forwards;
    }

    .progress .progress-value {
        width: 90%;
        height: 90%;
        border-radius: 50%;
        background: transparent;
        font-size: 24px;
        color: #fff;
        line-height: 135px;
        text-align: center;
        position: absolute;
        top: 5%;
        left: 5%;
    }

    .progress.blue .progress-bar {
        border-color: #36B37E;
    }

    .progress.blue .progress-left .progress-bar {
        animation: loading-1 5s linear forwards 1.8s;
    }

    @keyframes loading-1 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }
    }

    @keyframes loading-2 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(144deg);
            transform: rotate(144deg);
        }
    }

    @keyframes loading-3 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }
    }

    @keyframes loading-4 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(36deg);
            transform: rotate(36deg);
        }
    }

    @keyframes loading-5 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(126deg);
            transform: rotate(126deg);
        }
    }

    @media only screen and (max-width: 990px) {
        .progress {
            margin-bottom: 20px;
        }
    }

    .mt-6{
        margin-top: 6rem!important;
    }
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
        <div v-dragscroll.x class="big-box grab-bing "><img src="https://donmbelembe.github.io/vue-dragscroll/assets/image.jpg"></div>
        </div>
</template>

<script>
    import Vue from 'vue'
    import VueDragscroll from 'vue-dragscroll'
    Vue.use(VueDragscroll)
    export default {
        mounted() {
            console.log('Component mounted.')
        },
    }
</script>
<style>
    .big-box {
    overflow: scroll;
    width:500px;
}
.grab-bing {
    cursor: -webkit-grab;
    cursor: -moz-grab;
    cursor: -o-grab;
    cursor: grab;
}
.oh {
    overflow: hidden;
}

</style>
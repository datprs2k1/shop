<template>
    <footer id="footer" class="footer color-bg">
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div
                        class="col-xs-12 col-sm-6 col-md-3"
                        v-for="author in authors"
                        :key="author.name"
                    >
                        <div class="module-heading">
                            <h4 class="module-title">{{ author.name }}</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class="toggle-footer">
                                <li class="media">
                                    <div class="pull-left">
                                        <span class="icon fa-stack fa-lg">
                                            <i
                                                class="fa fa-map-marker fa-stack-1x fa-inverse"
                                            ></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <p>
                                            {{ author.address }}
                                        </p>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="pull-left">
                                        <span class="icon fa-stack fa-lg">
                                            <i
                                                class="fa fa-mobile fa-stack-1x fa-inverse"
                                            ></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <p>
                                            <a :href="`tel:${author.phone}`">{{
                                                author.email
                                            }}</a>
                                        </p>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="pull-left">
                                        <span class="icon fa-stack fa-lg">
                                            <i
                                                class="fa fa-envelope fa-stack-1x fa-inverse"
                                            ></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <span
                                            ><a
                                                :href="`mailto:${author.email}`"
                                                >{{ author.email }}</a
                                            ></span
                                        >
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from "@vue/reactivity";

const authors = ref([
    {
        name: "Ho??ng Ti???n ?????t",
        address: "54 Tri???u Kh??c - Thanh Xu??n - H?? N???i",
        phone: "0393509701",
        email: "datprs@gmail.com",
    },
    {
        name: "Nguy???n Th??? V??n",
        address: "54 Tri???u Kh??c - Thanh Xu??n - H?? N???i",
        phone: "0981786469",
        email: "nguyenthevan207@gmail.com",
    },
    {
        name: "Nguy???n H???u B???c",
        address: "54 Tri???u Kh??c - Thanh Xu??n - H?? N???i",
        phone: "0961995302",
        email: "bacvipdaik3@gmail.com",
    },
    {
        name: "????? Th??? H???ng",
        address: "54 Tri???u Kh??c - Thanh Xu??n - H?? N???i",
        phone: "0373216543",
        email: "dothihang@gmail.com",
    },
]);
</script>

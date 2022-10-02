<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="pushmenu"
                    href="#"
                    role="button"
                    @click="toggle"
                    ><i class="fas fa-bars"></i
                ></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link
            :to="{
                name: 'admin.dashboard',
            }"
            class="brand-link"
        >
            <!-- <img
                src="/images/logo-utt.png"
                alt="UTT Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: 0.9"
            /> -->
            <span class="brand-text font-weight-light">SHOP</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input
                        class="form-control form-control-sidebar"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    />
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
                    <li
                        v-for="(item, index) in menu"
                        :key="index"
                        class="nav-item"
                    >
                        <router-link
                            :to="{
                                name: `${item.link}`,
                            }"
                            class="nav-link"
                        >
                            <i :class="`${item.icon}`"></i>
                            <p>
                                {{ item.name }}

                                <i class="fas fa-angle-left right"></i>

                                <!-- <span class="badge badge-info right">6</span> -->
                            </p>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script setup>
const menu = [
    {
        name: "Quản lý danh mục",
        icon: "nav-icon fas fa-warehouse",
        link: "admin.category",
    },
];

const toggle = () => {
    const element = document.querySelector(".sidebar-mini");
    if (!element.classList.contains("sidebar-collapse")) {
        element.classList.add("sidebar-collapse");
    } else {
        element.classList.remove("sidebar-collapse");
    }
};
</script>

<style>
.collapsed > .when-open {
    display: none;
}
:not(.collapsed) > .when-closed {
    display: none;
}
</style>

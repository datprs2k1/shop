<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-bar-chart"></i>
                        Thống kê 7 ngày gần đây
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ 1 }}</h3>
                                    <p>Số hoá đơn đã tạo</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer"
                                    >More info
                                    <i class="fas fa-arrow-circle-right"></i
                                ></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ 1 }}</h3>
                                    <p>Số hoá đơn đã duyệt</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer"
                                    >More info
                                    <i class="fas fa-arrow-circle-right"></i
                                ></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ 1 }}</h3>
                                    <p>Khách hàng mới</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer"
                                    >More info
                                    <i class="fas fa-arrow-circle-right"></i
                                ></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ 1 }}</h3>
                                    <p>Doanh thu</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer"
                                    >More info
                                    <i class="fas fa-arrow-circle-right"></i
                                ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Doanh thu 30 ngày gần đây
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            data-card-widget="collapse"
                                            title="Collapse"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body" id="doanhthu30ngay">
                            <div class="tab-content p-0">
                                <div
                                    class="chart tab-pane active"
                                    id="revenue-chart"
                                    style="height: 500px"
                                >
                                    <Line
                                        :chart-data="month"
                                        :chart-options="optional"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Doanh thu 12 tháng gần đây
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            data-card-widget="collapse"
                                            title="Collapse"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body" id="doanhthu12thang">
                            <div class="tab-content p-0">
                                <div
                                    class="chart tab-pane active"
                                    id="revenue-chart"
                                    style="height: 500px"
                                >
                                    <Bar
                                        :chart-data="month"
                                        :chart-options="optional"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-5 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Số lượng sản phẩm đã bán
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            data-card-widget="collapse"
                                            title="Collapse"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body" id="sanpham">
                            <div class="tab-content p-0">
                                <div
                                    class="chart tab-pane active"
                                    id="revenue-chart"
                                    style="height: 500px"
                                >
                                    <Pie
                                        :chart-data="product"
                                        :chart-options="optional"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</template>
<script setup>
import { Bar, Line, Pie } from "vue-chartjs";

import { useReportStore } from "@/stores/report";
import { onBeforeMount } from "@vue/runtime-core";
import { storeToRefs } from "pinia";

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement,
    BarElement,
    ArcElement,
} from "chart.js";
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement,
    BarElement,
    ArcElement
);

const reportStore = useReportStore();

const { month, year, product } = storeToRefs(reportStore);

const { getMonthReport, getYearReport, getProductReport } = reportStore;

const optional = {
    responsive: true,
    maintainAspectRatio: false,
};

onBeforeMount(async () => {
    await getMonthReport();
    await getYearReport();
    await getProductReport();
});
</script>

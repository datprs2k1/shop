<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function doanhthutrong30ngay()
    {

        $start = Carbon::now()->subDay(31)->format('Y-m-d');
        $end = Carbon::now()->addDay(1)->format('Y-m-d');


        $doanhthu = Order::select(
            DB::raw('sum(total) as doanhthu'),
            DB::raw("DATE_FORMAT(created_at,'%d-%m') as day")
        )
            ->whereBetween('created_at', [
                $start,
                $end
            ])
            ->where('status', '1')
            ->groupBy('day')
            ->get();

        $doanhthu30ngay = [];
        for ($i = 29; $i >= 0; $i--) {
            $key = Carbon::now()->subDays($i)->format('d-m');
            $doanhthu30ngay[$key] = 0;
        }

        foreach ($doanhthu as $item) {
            $doanhthu30ngay[$item->day] = $item->doanhthu;
        }

        return response()->json([
            'labels' => array_keys($doanhthu30ngay),
            'datasets' => [[
                'label' => 'Doanh Thu (VND)',
                'backgroundColor' => 'rgb(54, 162, 235)',
                'borderColor' => 'rgb(54, 162, 235)',
                'data' => array_values($doanhthu30ngay)
            ]]
        ]);
    }

    public function doanhthutrong12thang()
    {
        $start = Carbon::now()->subMonth(11)->format('Y-m-d');
        $end = Carbon::now()->addDay(1)->format('Y-m-d');

        $doanhthu = Order::select(
            DB::raw('sum(total) as doanhthu'),
            DB::raw("DATE_FORMAT(created_at,'%m-%Y') as month")
        )
            ->whereBetween('created_at', [
                $start,
                $end
            ])
            ->where('status', '1')
            ->groupBy('month')
            ->get();

        $doanhthu12thang = [];
        for ($i = 11; $i >= 0; $i--) {
            $key = Carbon::now()->subMonth($i)->format('m-Y');
            $doanhthu12thang[$key] = 0;
        }

        foreach ($doanhthu as $item) {
            $doanhthu12thang[$item->month] = $item->doanhthu;
        }

        return response()->json([
            'labels' => array_keys($doanhthu12thang),
            'datasets' => [[
                'data' => array_values($doanhthu12thang)
            ]]
        ], 200);
    }

    public function sanpham()
    {
        $sanpham = Product::select('ten_san_pham')->withCount(['orders' => function ($query) {
            $query->where('status', '1');
        }], 'id')->get();

        $san_pham = [];

        foreach ($sanpham as $item) {
            $san_pham[$item->ten_san_pham] = $item->hoa_don_count;
        }
        return response()->json($san_pham);
    }
}

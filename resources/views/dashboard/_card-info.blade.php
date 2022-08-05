<div class="row">
    <div class="col-md-12">
        <h1 class="page-title">Dashboard</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
        <div class="dash-widget">
            <span class="dash-widget-bg2"><i class="fa fa-money"></i></span>
            <div class="dash-widget-info text-right">
                <h3>{{ $reinburst_pending }}</h3>
                <span class="widget-title2">Reinburst <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
        <div class="dash-widget">
            <span class="dash-widget-bg3"><i class="fa fa-user-o" aria-hidden="true"></i></span>
            <div class="dash-widget-info text-right">
                <h3>{{ $customer }}</h3>
                <span class="widget-title3">Customer <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">
        <div class="dash-widget">
            <span class="dash-widget-bg4"><i class="fa fa-archive" aria-hidden="true"></i></span>
            <div class="dash-widget-info text-right">
                <h3>{{$warehouse}}</h3>
                <span class="widget-title4">Warehouse <i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>
</div>
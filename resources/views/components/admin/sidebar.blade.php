<ul>
    <li class="menu-title">Main</li>
    <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
        <a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
    </li>
    @can('product-access')
    <li class="{{ request()->is('admin/pembatalans*') ? 'active' : '' }}">
        <a href="{{ route('admin.pembatalans.index') }}"><i class="fa fa-building"></i> <span>Canceling</span></a>
    </li>
    @endcan
    @role('super-admin')
    <li class="submenu">
        <a href="#" class=""><i class="fa fa-cog"></i> <span> Master </span> <span class="menu-arrow"></span></a>
        <ul style="display: none;">
            <li class="submenu">
                <a href="#" class=""><i class="fa fa-shopping-bag"></i> <span> Master Barang </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    @can('product-access')
                    <li class="{{ request()->is('admin/product*') ? 'active' : '' }}">
                        <a href="{{ route('admin.product.index') }}"><span>Barang</span></a>
                    </li>
                    @endcan
                    @can('product-access')
                    <li class="{{ request()->is('admin/kategori*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kategori.index') }}"><span>Kategori Barang</span></a>
                    </li>
                    @endcan
                    @can('product-access')
                    <li class="{{ request()->is('admin/satuan*') ? 'active' : '' }}">
                        <a href="{{ route('admin.satuan.index') }}"><span>Satuan Barang</span></a>
                    </li>
                    @endcan

                </ul>
            </li>
            @can('product-access')
            <li class="{{ request()->is('admin/unit*') ? 'active' : '' }}">
                <a href="{{ route('admin.unit.index') }}"><i class="fa fa-building"></i> <span>Unit Rumah</span></a>
            </li>
            @endcan
            @can('supplier-access')
            <li class="{{ request()->is('admin/supplier*') ? 'active' : '' }}">
                <a href="{{ route('admin.supplier.index') }}"><i class="fa fa-user-o"></i> <span>Vendor</span></a>
            </li>
            @endcan
            
          
            {{-- @can('product-access')
            <li class="{{ request()->is('admin/report*') ? 'active' : '' }}">
                <a href="{{ route('admin.report.barang') }}"><i class="fa fa-archive"></i> <span>In Out</span></a>
            </li>
            @endcan --}}
            @can('product-access')
            <li class="{{ request()->is('admin/warehouse*') ? 'active' : '' }}">
                <a href="{{ route('admin.warehouse.index') }}"><i class="fa fa-archive"></i> <span>Warehouse</span></a>
            </li>
            @endcan
            @can('product-access')
            <li class="{{ request()->is('admin/reinburst*') ? 'active' : '' }}">
                <a href="{{ route('admin.reinburst.index') }}"><i class="fa-solid fa-hand-holding-dollar"></i> <span>Reinburst</span></a>
            </li>
            @endcan
            @can('product-access')
            <li class="{{ request()->is('admin/customer*') ? 'active' : '' }}">
                <a href="{{ route('admin.customer.index') }}"><i class="fa fa-user-o"></i> <span>Customer</span></a>
            </li>
            @endcan
         
        </ul>
    </li>
    @endrole
   
</ul>
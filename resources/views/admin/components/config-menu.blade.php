@if ($menu)
    <div class="d-inline-block dropdown">
        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="btn-shadow dropdown-toggle btn btn-primary">
            <span class="btn-icon-wrapper pr-2 opacity-7">
                <i class="fa fa-cog fa-w-20"></i>
            </span>
        </button>
        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
            <ul class="nav flex-column">
                {!! $menu !!}
            </ul>
        </div>
    </div>
@endif

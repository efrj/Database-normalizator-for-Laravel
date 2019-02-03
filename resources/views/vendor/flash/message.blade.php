@if ( session()->has('flash_notification.message') )
    @if ( session('flash_notification.level') == 'success' )
        <div class="alert alert-success dark alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-check-circle pr10"></i>
            <strong>{{ trans('flash.flash_success') }}</strong> {{ session('flash_notification.message') }}
        </div>
    @endif

    @if ( session('flash_notification.level') == 'info' )
        <div class="alert alert-primary dark alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-info-circle pr10"></i>
            <strong>{{ trans('flash.flash_info') }}</strong> {{ session('flash_notification.message') }}
        </div>
    @endif

    @if ( session('flash_notification.level') == 'warning' )
        <div class="alert alert-alert dark alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-info-circle pr10"></i>
            <strong>{{ trans('flash.flash_warning') }}</strong> {{ session('flash_notification.message') }}
        </div>
    @endif

    @if ( session('flash_notification.level') == 'danger' )
        <div class="alert alert-danger dark alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-info-circle pr10"></i>
            <strong>{{ trans('flash.flash_danger') }}</strong> {{ session('flash_notification.message') }}
        </div>
    @endif
@endif

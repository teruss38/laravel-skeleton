<ul class="settings-menu" role="menu" style="margin-bottom: 16px;">
    <li class="settings-menu-item menu-item-profile @if (request()->route()->getName() == 'settings.profile') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.profile')}}" @if (request()->route()->getName() == 'settings.profile') aria-current="page" class="active" @endif><span>个人信息</span></a>
    </li>
    <li class="settings-menu-item menu-item-account @if (request()->route()->getName() == 'settings.account') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.account')}}" @if (request()->route()->getName() == 'settings.account') aria-current="page" class="active" @endif><span>帐户管理</span></a>
    </li>

    <li class="settings-menu-item menu-item-safety @if (request()->route()->getName() == 'settings.login-histories') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.login-histories')}}" @if (request()->route()->getName() == 'settings.login-histories') aria-current="page" class="active" @endif><span>帐户安全</span></a>
    </li>

    <li class="settings-menu-item menu-item-settle @if (request()->route()->getName() == 'settings.settle') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.settle')}}" @if (request()->route()->getName() == 'settings.settle') aria-current="page" class="active" @endif><span>提现账户</span></a>
    </li>

    @if(settings('wallet.enable'))
    <li class="settings-menu-item menu-item-balance @if (request()->route()->getName() == 'settings.balance') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.balance')}}" @if (request()->route()->getName() == 'settings.balance') aria-current="page" class="active" @endif><span>余额管理</span></a>
    </li>
    @endif

    <li class="settings-menu-item menu-item-coin @if (request()->route()->getName() == 'settings.integral') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.integral')}}" @if (request()->route()->getName() == 'settings.integral') aria-current="page" class="active" @endif><span>积分管理</span></a>
    </li>

    <li class="settings-menu-item menu-item-token @if (request()->route()->getName() == 'settings.tokens') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.tokens')}}" @if (request()->route()->getName() == 'settings.tokens') aria-current="page" class="active" @endif><span>Token</span></a>
    </li>

    <li class="settings-menu-item menu-item-application @if (request()->route()->getName() == 'settings.applications') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.applications')}}" @if (request()->route()->getName() == 'settings.applications') aria-current="page" class="active" @endif><span>OAuth 应用</span></a>
    </li>

    <li class="settings-menu-item menu-item-authorization @if (request()->route()->getName() == 'settings.authorization') settings-menu-item-selected @endif" role="menuitem">
        <a href="{{route('settings.authorization')}}" @if (request()->route()->getName() == 'settings.authorization') aria-current="page" class="active" @endif><span>授权</span></a>
    </li>
</ul>

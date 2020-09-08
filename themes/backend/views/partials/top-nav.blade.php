<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="push-menu" role="button" style="margin: 0;">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">



            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>
                       {{ $currentUser->name }}

                        <i class="caret"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">
                        <img class="img-circle" alt="User Image" />
                        <p>
                            {{ $currentUser->name }}
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ route('admin.auth.users.edit', ['user' => $currentUser->id]) }}" class="btn btn-default btn-flat">
                                 {{trans('backend::profile.label.profile')}}
                            </a>
                        </div>
                        <div class="pull-right">

                            <a  class="btn btn-danger btn-flat" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('admin-logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</nav>


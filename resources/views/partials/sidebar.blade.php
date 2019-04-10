<!-- Sidebar -->
<aside class="main-sidebar fixed offcanvas shadow">
    <section class="sidebar">
        <div class="mt-3 mb-3 ml-3">
            <h5 class="s-18 has-icon">Admin Panel</h5>
        </div>
        <div class="relative">
            <a data-toggle="collapse" href="#userSettingsCollapse" role="button" aria-expanded="false"
               aria-controls="userSettingsCollapse"
               class="btn-fab btn-fab-sm fab-right fab-top btn-primary shadow1 collapsed">
                <i class="icon icon-cogs"></i>
            </a>
            @php
                $user = Auth::user();
            @endphp
            <div class="user-panel light p-3 mb-2">
                <div>
                    <div class="float-left image">
                        <img class="user_avatar" src="{{ $user->profile->avatar }}" alt="{{ $user->profile->name }}">
                    </div>
                    <div class="float-left info">
                        <h6 class="font-weight-light mt-2 mb-1">{{ strtok($user->profile->name, " ") }}</h6>
                        <span>{{ $user->username }}</span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="multi-collapse collapse" id="userSettingsCollapse" style="">
                    <div class="list-group mt-3 shadow">
                        <a href="{{ route('profile', Auth::user()->username ) }}"
                           class="list-group-item list-group-item-action">
                            <i class="mr-2 icon-umbrella text-blue"></i>Profile
                        </a>
                        <a href="{{ route('edit-password', Auth::user()->username ) }}"
                           class="list-group-item list-group-item-action"><i class="mr-2 icon-security text-purple"></i>Change
                            Password</a>
                    </div>
                </div>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ setActive('dashboard') }}"><a href="{{ route('dashboard') }}">
                    <i class="icon icon-dashboard2 s-18 text-yellow"></i>Dashboard
                </a>
            </li>
            <li class="{{ setActive('posts.index') }}"><a href="{{ route('posts.index') }}"><i
                        class="icon icon-document-list s-18 brown-text"></i>Posts</a></li>
            <li class="{{ setActive('categories.index') }}"><a href="{{ route('categories.index') }}"><i
                        class="icon icon-list s-18 "></i>Category</a></li>
            <li class="{{ setActive('tags.index') }}"><a href="{{ route('tags.index') }}"><i
                        class="icon icon-tag s-18"></i>Tags</a></li>
            <li class="{{ setActive(['galleries.index']) }}"><a href="{{ route('galleries.index') }}"><i
                        class="icon icon-image s-18"></i>Gallery</a></li>
            @can('admin')
                <li class="header">
                    <strong>Super Admin</strong>
                </li>
                <li class="{{ setActive('pages.index') }}"><a href="{{ route('pages.index') }}"><i
                            class="icon icon-pages s-18"></i>Pages</a></li>
                <li class="{{ setActive('announcements.index') }}"><a href="{{ route('announcements.index') }}"><i
                            class="icon icon-announcement s-18"></i>Pengumuman</a></li>
                <li class="{{ setActive('users.index') }}">
                    <a href="{{ route('users.index') }}">
                        <i class="icon icon-account_circle s-18 text-green"></i>User
                    </a>
                </li>
                <li class="{{ setActive('karya.request') }}"><a href="{{ route('karya.request') }}"><i
                            class="icon icon-document-list s-18 text-danger"></i><span>Request Karya
                        Siswa </span><span
                            class="badge r-3 badge-success pull-right">{{ countRequestKarya() }}</span></a></li>
            @endcan
            <li class="header">
                <strong>Akun</strong>
            </li>
            <li><a href="{{route('logout')}}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="icon icon-exit_to_app s-18"></i>Logout</a>
                <form id="logout-form" action="{{route('logout')}}" method="POST" style="display:none;">
                    @csrf
                </form>
            </li>


        </ul>
    </section>
</aside>
<!--Sidebar End-->

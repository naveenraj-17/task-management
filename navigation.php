<header>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="background: #dddddd;">
        <div class="container"><a class="navbar-brand" href="index.php">Tasks</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mr-auto">
                    <?if(isset($_SESSION['is_admin'])):?>
                    <li class="nav-item"><a class="nav-link" href="tasks.php">Tasks</a></li>
                    <li class="nav-item"><a class="nav-link" href="employee.php">Employees</a></li>
                    <?else:?>
                    <li class="nav-item"><a class="nav-link" href="employee-tasks.php">My Tasks</a></li>
                    <?endif;?>
                </ul>
                <?if(isset($_SESSION['is_login'])):?>
                    <span class="navbar-text actions"><a class="login" href="#">Hi, <?=(isset($_SESSION['employee_name']))?$_SESSION['employee_name']:"Admin"?></a><a class="btn btn-light action-button" role="button" href="logout.php">Logout</a></span>
                <?else:?>
                <span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="login.php">Login</a></span>
                <?endif;?>
            </div>
        </div>
    </nav>
</header>


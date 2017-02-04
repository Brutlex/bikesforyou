<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" id ="logo" href="../home">BikesForYou</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">


            <ul class="nav navbar-nav navbar-right">

                <li><a href="../home">HOME</a></li>
                <li><a href="../profile"><span class="glyphicon glyphicon-user"></span><?php echo $row['userName']; ?></a></li>
                <li><a href="../post"">POST</a></li>
                <li><a href="../about">ABOUT</a></li>
                <li><a href="../logout"">LOG OUT</a></li>

            </ul>
        </div>
    </div>
</nav>
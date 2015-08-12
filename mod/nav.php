  <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="http://10.65.10.218/siborder" class="navbar-brand"><i class="fa fa-bolt"></i><strong>iBorder</strong></a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="fa fa-home"></i> DASHBOARD <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="index.php">TSEL - Node B</a></li>
                <li><a href="tsel.non.nodeb.php">TSEL - Non Node B</a></li>
                <li><a href="olo.php">OLO</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="fa fa-wifi"></i> DEPLOYMENT NODE B <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="onair.rollout.php">Roll Out</a></li>
                <li><a href="onair.modernisation.php">Modernisation</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="fa fa-rocket"></i> ON GOING <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="ogp.rollout.php">TSEL - Roll Out</a></li>
                <li><a href="ogp.modernisation.php">TSEL - Modernisation</a></li>
                <li><a href="ogp.non.nodeb.php">TSEL - non Node B</a></li>
                <li><a href="ogp.olo.php">OLO</a></li>
              </ul>
            </li>
            <?php if($_SESSION['privilege']!='guest') { ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes"><i class="fa fa-plus"></i> INPUT ORDER <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="input.tsel.oa.php">TSEL (On Air)</a></li>
                <li><a href="input.tsel.ro.ogp.php">TSEL - Roll Out (On Going)</a></li>
                <li><a href="input.tsel.mo.ogp.php">TSEL - Modernisation (On Going)</a></li>
                <li><a href="input.non.nodeb.ogp.php">TSEL - Non Node B (On Going)</a></li>
                <li><a href="input.olo.ogp.php">OLO (On Going)</a></li>
              </ul>
            </li>
            <?php } ?>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> LOGOUT</a></li>
          </ul>
        </div>
      </div>
    </div>
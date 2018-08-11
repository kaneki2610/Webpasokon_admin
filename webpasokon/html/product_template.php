<!DOCTYPE html>
<html>

<head>

    <?php 
    session_start();
    include("header.html");
   ?>

</head>
<body class="flat-blue">
    <div class="app-container">
        <div class="row content-container">
            <nav id="navbar" class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-expand-toggle">
                            <i class="fa fa-bars icon"></i>
                        </button>
                        <ol class="breadcrumb navbar-breadcrumb">
                            <li>
                                 <p class="username"><?php echo $_SESSION["name"] ?></p>
                            </li>
                            <li class="active"></li>
                        </ol>
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-th icon"></i>
                        </button>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>
                  
                       
                        <li class="dropdown profile">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                
                                <li>
                                    <div class="profile-info">
                                        <h4 class="username"><?php echo $_SESSION["name"] ?></h4>
                                        <p><?php echo $_SESSION["email"] ?></p>
                                        <div class="btn-group margin-bottom-2x" role="group">
                                            <button type="button" class="btn btn-default"><i class="fa fa-user"></i> Profile</button>
                                            <a href="logout.php"><button type="button" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</button></a>
                                      
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <?php 
                include("siderbar.html");
            ?>

            <div class="container-fluid">
                <div class="side-body">
                   <?php 
                       
                        $fun=$_GET["page"];
                       
                        switch ($fun) {
                            
                            case 'category':
                               include("page_product2/category.php");
                               break;
                            case 'product':
                                include("page_product2/product.php");
                               break;
                            case 'bill':
                                include("page_product2/bill.php");
                               break;
                          case 'account':
                                if($_SESSION["Customer_id"]==1)
                                {
                                    include("page_product2/account.php");
                                }
                                else{
                                    echo "<h4 >Bạn không có quyền vào trang này.Vi không phải là quản li!</h4>";
                                }
                                
                               break;
                        }
                   ?>
                </div>
            </div>
        </div>
       
    <div>
    
    <?php 
        include("footer.html");
    ?>

</body>

</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Login to admin</title>
        <link rel="stylesheet" href="../css/bootstrap.css" />
    </head>
    <body>
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <form action="login-action.php" method="post" class="form-horizontal">
            <fieldset class="">
                <legend>Enter Credential</legend>
                    <div class="form-group">
                        <label for="username" class="col-sm-3 control-label">Username: </label>
                        <div class="col-sm-9">
                        <input type="text" name="username" id="username" value="" class="form-control" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        
                        <label for="password" class="col-sm-3 control-label">Password: </label>
                        <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" id="password" value="" />
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="remember" class="col-sm-3 control-label">
                         Remember me
                        </label>
                        <div class="col-sm-9">
                            <input type="checkbox" name="remember" id="remember" value="1" />
                        </div>
                    </div>
                        
            </fieldset>
            <div class="form-group text-right">
                <input type="submit" class="btn btn-primary" value="Submit" /> <input class="btn btn-default" type="reset" value="Reset" />
            </div>
        </form>
            </div>
        </div>
    </body>
</html>

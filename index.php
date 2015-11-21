<!DOCTYPE html>
<html>
    <head>
        <title>Geovent</title>
        <style type="text/css">
            body {
                margin: 0px;
                overflow: hidden;
            }
            h1 {
                position: absolute;
                left: 70px;
            }
            #logIn {
                position: absolute;
                right: 10px;
            }
            form {
                display: flex;  
            }
            h3 {
                text-align: center;
            }
            #placeholder {
                width: 10px;
            }
            header {
                display: block;
                background-color: brown;
                width: 100%;
                height: 90px;
            }
            #signIn {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header>
        <h1>Geovent</h1>
        <div id="logIn">
            <form>
                <div>
                    <br>
                    Username<br>
                    <input type="text" name="usrn">
                </div>
                <div id="placeholder"></div>
                <div>
                    <br>
                    Password<br>
                    <input type="text" name="pwd">
                </div>
            </form>
        </div>
        </header>
        <div id="signIn">
            <h2>Sign In:</h2><br><br>
            <form>
                <input type="text" name="fName" placeholder="First name">
                <input type="text" name="lName" placeholder="Last name">
            </form>
        </div>
    </body>
</html>

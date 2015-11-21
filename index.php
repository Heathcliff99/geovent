<!DOCTYPE html>
<html>
    <meta http-equiv="refresh" content="1" > 
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
                margin-top: 28px;
            }
            #logIn {
                display: flex; 
            }
            form[action="logIn.php"]{
                position: absolute;
                right: 35px;
            }
            form[action="logIn.php"] input[type="submit"]{
                width: 60px;
                display: block;
                margin-left: auto ;
                margin-right: auto ;
            }
            h3 {
                text-align: center;
            }
            .placeholder {
                width: 10px;
            }
            header {
                color: #66CCFF;
                display: block;
                background-color: #993300;
                width: 100%;
                height: 110px;
            }
            #signUp {
                text-align: center;
                /*background-color: green;*/
                width: 600px;
                margin-left: auto ;
                margin-right: auto ;
            }
            #signUp form {
                /*background-color: red;*/
                width: 100%;
            }
            #signUp form div {
                display: inline;
                /*background-color: blue;*/
                width: 400px;
                margin-left: auto ;
                margin-right: auto ;
            }
            #email {
                width: 315px;
            }
            input {
                border-radius: 5px;
                border-color: gray;
                
            }
        </style>
    </head>
    <body>
        <header>
        <h1>Geovent</h1>
            <form action="logIn.php">
                <div id="logIn">
                    <div>
                        <br>
                        Username<br>
                        <input type="text" name="usrn">
                    </div>
                    <div class="placeholder"></div>
                    <div>
                        <br>
                        Password<br>
                        <input type="text" name="pwd">
                    </div>
                </div><br>
                <input type="submit" value="Log in">
            </form>
        </header>
        <div id="signUp">
            <br><br><br><br><br><br>
            <h2>Sign up:</h2><br><br>
            <form action="signUp.php">
                <div>
                    <input type="text" name="fName" placeholder="First name">
                    &nbsp;
                    <input type="text" name="lName" placeholder="Last name"><br><br>
                    <input id="email" type="email" name="email" placeholder="Email"><br><br>
                    <input type="password" name="pw" placeholder="Password">
                    &nbsp;
                    <input type="password" name="pw2" placeholder="Re-enter password"><br><br>
                    <input type="submit" value="Sign up">
                </div>
            </form>
        </div>
    </body>
</html>
